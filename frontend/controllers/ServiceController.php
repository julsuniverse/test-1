<?php

namespace frontend\controllers;

use Yii;
use frontend\components\VkAuth;
use frontend\components\FbAuth;
use frontend\models\ReviewForm;
use common\models\User;
use common\models\Theme;
use common\models\Region;
use common\models\Tag;
use common\models\Service;
use common\models\Review;
use common\models\Pages;
use common\models\Mainpage;
use yii\helpers\Json;
use frontend\components\Wall;
use frontend\components\WallFB;


class ServiceController extends MyController
{
    public function actionServices()
    {
        $service=Service::getAll();
        return $this->render('services',[
            'service'=>$service,
            'seo'=>Theme::findOne(['id'=>1])
        ]);
    }

    public function actionService($alias, $uforom=false, $sort=false, $sort_desc=false)
    {
        $service=Service::getService($alias);
        if($service->name)
        {
            $vkauth = new VkAuth($alias, 'service');
            $vkhref=$vkauth->getHref();
            $fbauth = new FbAuth($alias, 'service');
            $fbhref=$fbauth->getHref();
            if($service->vk_group) {$wall=(new Wall($service->vk_group))->getWall();}
            else if($service->fb_group && !$service->vk_group) {$fb_wall=(new WallFB($service->fb_group))->getWall();}
            
            $model=new ReviewForm();
            $model->star=3;
            if ($model->load(Yii::$app->request->post()) && $model->validate()) 
            {
                if ($model->saveServiceReview($service->id))
                {
                    $model=new ReviewForm();
                    $model->star=3;
                }
            }
            if (isset($_GET['code']) && isset($_GET['ufrom']) && $_GET['ufrom']=="vk") {
                $userInfo=$vkauth->loginUser($_GET['code']);
                if($userInfo)
                    $this->redirect(['service', 'alias'=>$alias, '#'=>'add-review']);
            }
            if (isset($_GET['code']) && isset($_GET['ufrom']) && $_GET['ufrom']=="fb") {
                $userInfo=$fbauth->loginUser($_GET['code']);
                if($userInfo)
                    $this->redirect(['service', 'alias'=>$alias, '#'=>'add-review']);
            }
            if(isset($_GET['anonim']))
            {
                Yii::$app->user->login(User::findByUsername('anonim'));
                $this->redirect(['service', 'alias'=>$alias,'#'=>'add-review']);
            }
            return $this->render('service',
            [
                'service'=>$service,
                'vkhref'=>$vkhref,
                'fbhref'=>$fbhref,
                'userInfo'=>$userInfo,
                'model'=>$model,
                'sort'=>$sort,
                'sort_desc'=>$sort_desc,
                'alias'=>$alias,
                'wall'=>$wall,
                'fb_wall'=>$fb_wall,
                'wall_cach'=>Theme::find()->select('wall_cach')->where(['id'=>1])->one(),
                'comments'=>Review::getAllComments($service->id, 'service_id', $sort, $sort_desc)
            ]);
        }
        else $this->redirect(['main/index']);
    }
    
    public function actionGetraiting($id)
    {
        $service=Service::find()->select(['raiting', 'reviews'])->where(['id'=>$id])->one();
        echo Json::encode(['raiting'=>$service->raiting, 'reviews'=>$service->reviews]);
    }
    public function actionLogout($alias)
    {
        Yii::$app->user->logout();
        
        return $this->redirect(['service', 'alias'=>$alias, '#'=>'add-review']);
        //return $this->redirect(Yii::$app->request->referrer);
    }

}
