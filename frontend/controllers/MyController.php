<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\Review;
use yii\helpers\Json;


class MyController extends \yii\web\Controller
{
    public $layout = "layout";    

    public function beforeAction($action)
    {            
        if ($action->id == 'person' || $action->id == 'company') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
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

}
