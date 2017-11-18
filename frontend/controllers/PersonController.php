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
use common\models\Person;
use common\models\Review;
use common\models\Pages;
use common\models\Mainpage;
use yii\helpers\Json;
use frontend\components\Wall;
use frontend\components\WallFB;


class PersonController extends MyController
{
    public function actionPersons()
    {
        $person=Person::getAll();
        return $this->render('persons',[
            'person'=>$person,
            'seo'=>Theme::findOne(['id'=>1])
        ]);
    }

    public function actionPerson($alias, $uforom=false, $sort=false, $sort_desc=false)
    {
        $person=Person::getperson($alias);
        if($person->name)
        {
            $vkauth = new VkAuth($alias, 'person');
            $vkhref=$vkauth->getHref();
            $fbauth = new FbAuth($alias, 'person');
            $fbhref=$fbauth->getHref();
            if($person->vk_group) {$wall=(new Wall($person->vk_group, true))->getUserWall();}

            $model=new ReviewForm();
            $model->star=3;
            if ($model->load(Yii::$app->request->post()) && $model->validate()) 
            {
                if ($model->savePersonReview($person->id))
                {
                    $model=new ReviewForm();
                    $model->star=3;
                }
            }
            if (isset($_GET['code']) && isset($_GET['ufrom']) && $_GET['ufrom']=="vk") {
                $userInfo=$vkauth->loginUser($_GET['code']);
                if($userInfo)
                    $this->redirect(['person', 'alias'=>$alias, '#'=>'add-review']);
            }
            if (isset($_GET['code']) && isset($_GET['ufrom']) && $_GET['ufrom']=="fb") {
                $userInfo=$fbauth->loginUser($_GET['code']);
                if($userInfo)
                    $this->redirect(['person', 'alias'=>$alias, '#'=>'add-review']);
            }
            if(isset($_GET['anonim']))
            {
                Yii::$app->user->login(User::findByUsername('anonim'));
                $this->redirect(['person', 'alias'=>$alias,'#'=>'add-review']);
            }
            return $this->render('person',
            [
                'person'=>$person,
                'vkhref'=>$vkhref,
                'fbhref'=>$fbhref,
                'userInfo'=>$userInfo,
                'model'=>$model,
                'sort'=>$sort,
                'sort_desc'=>$sort_desc,
                'alias'=>$alias,
                'wall'=>$wall,
                'wall_cach'=>Theme::find()->select('wall_cach')->where(['id'=>1])->one(),
                'comments'=>Review::getAllComments($person->id, 'person_id', $sort, $sort_desc)
            ]);
        }
        else $this->redirect(['main/index']);
    }
    
    public function actionGetraiting($id)
    {
        $person=Person::find()->select(['raiting', 'reviews'])->where(['id'=>$id])->one();
        echo Json::encode(['raiting'=>$person->raiting, 'reviews'=>$person->reviews]);
    }
    public function actionLogout($alias)
    {
        Yii::$app->user->logout();
        
        return $this->redirect(['person', 'alias'=>$alias, '#'=>'add-review']);
        //return $this->redirect(Yii::$app->request->referrer);
    }

}
