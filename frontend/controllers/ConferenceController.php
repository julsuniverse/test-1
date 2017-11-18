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
use common\models\Conference;
use common\models\Review;
use common\models\Pages;
use common\models\Mainpage;
use yii\helpers\Json;
use frontend\components\Wall;
use frontend\components\WallFB;


class ConferenceController extends MyController
{
    public function actionConferences()
    {
        $conference=Conference::getAll();
        return $this->render('conferences',[
            'conference'=>$conference,
            'seo'=>Theme::findOne(['id'=>1])
        ]);
    }

    public function actionConference($alias, $uforom=false, $sort=false, $sort_desc=false)
    {
        $conference=Conference::getConference($alias);
        if($conference->name)
        {
            $vkauth = new VkAuth($alias, 'conference');
            $vkhref=$vkauth->getHref();
            $fbauth = new FbAuth($alias, 'conference');
            $fbhref=$fbauth->getHref();
            if($conference->vk_group) {$wall=(new Wall($conference->vk_group))->getWall();}
            else if($conference->fb_group && !$conference->vk_group) {$fb_wall=(new WallFB($conference->fb_group))->getWall();}
            
            $model=new ReviewForm();
            $model->star=3;
            if ($model->load(Yii::$app->request->post()) && $model->validate()) 
            {
                if ($model->saveConferenceReview($conference->id, 'conference_id'))
                {
                    $model=new ReviewForm();
                    $model->star=3;
                }
            }
            if (isset($_GET['code']) && isset($_GET['ufrom']) && $_GET['ufrom']=="vk") {
                $userInfo=$vkauth->loginUser($_GET['code']);
                if($userInfo)
                    $this->redirect(['conference', 'alias'=>$alias, '#'=>'add-review']);
            }
            if (isset($_GET['code']) && isset($_GET['ufrom']) && $_GET['ufrom']=="fb") {
                $userInfo=$fbauth->loginUser($_GET['code']);
                if($userInfo)
                    $this->redirect(['conference', 'alias'=>$alias, '#'=>'add-review']);
            }
            if(isset($_GET['anonim']))
            {
                Yii::$app->user->login(User::findByUsername('anonim'));
                $this->redirect(['conference', 'alias'=>$alias,'#'=>'add-review']);
            }
            return $this->render('conference',
            [
                'conference'=>$conference,
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
                'comments'=>Review::getAllComments($conference->id, 'conference_id', $sort, $sort_desc)
            ]);
        }
        else $this->redirect(['main/index']);
    }
    
    public function actionGetraiting($id)
    {
        $conference=Conference::find()->select(['raiting', 'reviews'])->where(['id'=>$id])->one();
        echo Json::encode(['raiting'=>$conference->raiting, 'reviews'=>$conference->reviews]);
    }
    public function actionLogout($alias)
    {
        Yii::$app->user->logout();
        
        return $this->redirect(['conference', 'alias'=>$alias, '#'=>'add-review']);
    }

}
