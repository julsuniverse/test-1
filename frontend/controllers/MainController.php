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
use common\models\Company;
use common\models\Review;
use common\models\Pages;
use common\models\Mainpage;
use yii\helpers\Json;
use frontend\components\Wall;
use frontend\components\WallFB;

class MainController extends MyController
{
    public $layout = "layout";    

    public function beforeAction($action)
    {            
        if ($action->id == 'company') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $company=new Company();
        $mp=Mainpage::findOne(['id'=>1]);
        return $this->render('index',[
            'seo'=>Theme::findOne(['id'=>1]),
            'city1'=>$company->getTableMain($mp->regions1, $mp->tags1, $mp->limit1, $mp->sort1),
            'city2'=>$company->getTableMain($mp->regions2, $mp->tags2, $mp->limit2, $mp->sort2),
            'top'=>$company->getTableMain($mp->regions3, $mp->tags3, $mp->limit3, $mp->sort3),
            'whorst'=>$company->getTableMain($mp->regions4, $mp->tags4, $mp->limit4, $mp->sort4),
            'lastcomments'=>(new Review())->getLast(),
            'mp'=>$mp,
            'bestcompanies'=>Company::findBestCompanies(),
            'bestedcompanies'=>Company::findBestEDCompanies()
        ]);
    }
    public function actionPages()
    {
        $pages=(new Pages())->getAll();
        return $this->render('pages',[
            'seo'=>Theme::findOne(['id'=>1]),
            'pages'=>$pages
        ]);
    }
    public function actionPage($alias)
    {
        $page=(new Pages())->getOneinAlias($alias);
        if($page->add_table)
            $comp=(new Company())->getTableFromPage($page);
        return $this->render('page',[
            'page'=>$page,
            'comp'=>$comp
        ]);
    }
    public function actionRaiting()
    {
        $comp=(new Company())->getAll();
        return $this->render('raiting',[
            'comp'=>$comp,
            'seo'=>Theme::findOne(['id'=>1])
        ]);
    }

    public function actionCompany($alias, $uforom=false, $sort=false, $sort_desc=false)
    {
        $company=(new Company(true))->getCompany($alias);
        if($company->name)
        {
            $vkauth = new VkAuth($alias, 'company');
            $vkhref=$vkauth->getHref();
            $fbauth = new FbAuth($alias, 'company');
            $fbhref=$fbauth->getHref();
            if($company->vk_group) {$wall=(new Wall($company->vk_group))->getWall();}
            else if($company->fb_group && !$company->vk_group) {$fb_wall=(new WallFB($company->fb_group))->getWall();}
            $model=new ReviewForm();
            $model->star=3;
            if ($model->load(Yii::$app->request->post()) && $model->validate()) 
            {
                if ($model->saveReview($company->id))
                {
                    $model=new ReviewForm();
                    $model->star=3;
                }
            }
            if (isset($_GET['code']) && isset($_GET['ufrom']) && $_GET['ufrom']=="vk") {
                $userInfo=$vkauth->loginUser($_GET['code']);
                if($userInfo)
                    $this->redirect(['company', 'alias'=>$alias, '#'=>'add-review']);
            }
            if (isset($_GET['code']) && isset($_GET['ufrom']) && $_GET['ufrom']=="fb") {
                $userInfo=$fbauth->loginUser($_GET['code']);
                if($userInfo)
                    $this->redirect(['company', 'alias'=>$alias, '#'=>'add-review']);
            }
            if(isset($_GET['anonim']))
            {
                Yii::$app->user->login(User::findByUsername('anonim'));
                $this->redirect(['company', 'alias'=>$alias,'#'=>'add-review']);
            }
            return $this->render('company',
            [
                'company'=>$company,
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
                'comments'=>Review::getAllComments($company->id, 'company_id', $sort, $sort_desc)
            ]);
        }
        else $this->redirect(['index']);
    }
    public function actionPlus($id)
    {
        if(Yii::$app->user->identity->id && Yii::$app->user->identity->id!=11)
        {
            $review=Review::findOne(['id'=>$id]);
            $users=$review->user_ids_like;
            $likes=$review->likes;
            if(!strripos($users, Yii::$app->user->identity->id.""))
            {
                $likes++;
                $review->likes=$likes;
                $review->user_ids_like=$review->user_ids_like.",".Yii::$app->user->identity->id;
                $review->save();
                echo Json::encode(['likes'=>$likes]);
            }
            else echo Json::encode(['likes'=>$likes]);
        }
        else
            echo Json::encode(['likes'=>"no"]);  
    }
    public function actionMinus($id)
    {
        if(Yii::$app->user->identity->id  && Yii::$app->user->identity->id!=11)
        {
            $review=Review::findOne(['id'=>$id]);
            $users=$review->user_ids_dislike;
            $likes=$review->likes;
            if(!strripos($users, Yii::$app->user->identity->id.""))
            {
                $likes--;
                $review->likes=$likes;
                $review->user_disids_like=$review->user_ids_dislike.",".Yii::$app->user->identity->id;
                $review->save();
                echo Json::encode(['likes'=>$likes]);
            }
            else echo Json::encode(['likes'=>$likes]);
        }
        else
            echo Json::encode(['likes'=>"no"]);  
    }
    public function actionAbout()
    {
        return $this->render('about',[
            'theme'=>Theme::findOne(['id'=>1])
        ]);
    }
    public function actionContact()
    {
        return $this->render('contact',[
            'theme'=>Theme::findOne(['id'=>1])
        ]);
    }
    public function actionGetraiting($id)
    {
        $company=Company::find()->select(['raiting', 'reviews'])->where(['id'=>$id])->one();
        echo Json::encode(['raiting'=>$company->raiting, 'reviews'=>$company->reviews]);
    }

    public function actionLogout($alias)
    {
        Yii::$app->user->logout();
        
        return $this->redirect(['company', 'alias'=>$alias, '#'=>'add-review']);
        //return $this->redirect(Yii::$app->request->referrer);
    }

}