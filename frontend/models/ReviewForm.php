<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Review;
use yii\helpers\Html;
use common\models\Company;
use common\models\Person;
use common\models\Conference;
use common\models\Service;

class ReviewForm extends Model
{
    public $text;
    public $star;


    public function rules()
    {
        return [
            [['text', 'star'], 'required'],
            ['text', 'string'],
            ['star', 'integer'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'star' => 'Оценка',
            'text' => 'Текст комментария',
        ];
    }
    public function getCount($count)
    {
        $arr=[0=>-2, 1=>-2, 2=>-1, 3=>1, 4=>2, 5=>3];
        return $arr[$count];

    }
    public function getBall()
    {
        $count=100;
        $friends=Yii::$app->user->identity->friends;
        if($friends<=10)
            $count-=30;
        else if(($friends>10 && $friends<=24) || ($friends>2000 && $friends<=5000))
            $count-=20;
        else if($friends>24 && $friends<=50 || ($friends>=1000 && $friends<=2000))
            $count-=10;
            
        $photos = Yii::$app->user->identity->photos;
        
        if($photos <= 10 || ($photos >= 1000 && $photos < 3000))
            $count -= 10;
        else if($photos > 10 && $photos < 30)
            $count -= 5;
        else if($photos >= 3000 && $photos < 8000)
            $count -= 15;        
        
        $audios = Yii::$app->user->identity->audios;
        if($audios <= 10)
            $count -= 10; 
        else if(($audios > 10 && $audios < 30) || ($audios >= 2000 && $audios < 3000))
            $count -= 5;
        else if($audios > 3000 && $audios < 10000)
            $count -= 15;
        
        $followers = Yii::$app->user->identity->followers;
        
        if($followers <= 10)
            $count -= 30;
        else if(($followers >= 11 && $followers < 24) || ($followers >= 2000 && $followers < 5000))
            $count -= 20;
        else if(($followers >= 25 && $followers < 45) || ($followers >= 1300 && $followers))
            $count -= 10;
            
        return $count;
    }
    public function saveReview($id)
    {
        $review = new Review();
        $review->text=Html::encode($this->text);
        $review->stars=Html::encode($this->star);
        $count=$this->getCount($review->stars);
        $review->user_id=Yii::$app->user->identity->id;
        $review->company_id=$id;
        $review->date=date('U');
        $review->likes=0;
        if(Yii::$app->user->identity->user_id && Yii::$app->user->identity->user_id{0}!="f")
            $review->ball=$this->getBall();
        $review->save();
        $comp=Company::findOne(['id'=>$id]);
        $comp->reviews=$comp->reviews+1;
        $comp->raiting=$comp->raiting+$count;
        return $comp->save();
    }
    public function savePersonReview($id)
    {
        $review = new Review();
        $review->text=Html::encode($this->text);
        $review->stars=Html::encode($this->star);
        $count=$this->getCount($review->stars);
        $review->user_id=Yii::$app->user->identity->id;
        $review->person_id=$id;
        $review->date=date('U');
        $review->likes=0;
        if(Yii::$app->user->identity->user_id && Yii::$app->user->identity->user_id{0}!="f")
            $review->ball=$this->getBall();
        $review->save();
        $comp=Person::findOne(['id'=>$id]);
        $comp->reviews=$comp->reviews+1;
        $comp->raiting=$comp->raiting+$count;
        return $comp->save();
    }
    public function saveServiceReview($id)
    {
        $review = new Review();
        $review->text=Html::encode($this->text);
        $review->stars=Html::encode($this->star);
        $count=$this->getCount($review->stars);
        $review->user_id=Yii::$app->user->identity->id;
        $review->service_id=$id;
        $review->date=date('U');
        $review->likes=0;
        if(Yii::$app->user->identity->user_id && Yii::$app->user->identity->user_id{0}!="f")
            $review->ball=$this->getBall();
        $review->save();
        $comp=Service::findOne(['id'=>$id]);
        $comp->reviews=$comp->reviews+1;
        $comp->raiting=$comp->raiting+$count;
        return $comp->save();
    }
    public function saveConferenceReview($id, $gist)
    {
        $review = new Review();
        $review->text=Html::encode($this->text);
        $review->stars=Html::encode($this->star);
        $count=$this->getCount($review->stars);
        $review->user_id=Yii::$app->user->identity->id;
        $review[$gist]=$id;
        $review->date=date('U');
        $review->likes=0;
        if(Yii::$app->user->identity->user_id && Yii::$app->user->identity->user_id{0}!="f")
            $review->ball=$this->getBall();
        $review->save();
        if($gist=='conference_id')
            $comp=Conference::findOne(['id'=>$id]);
        $comp->reviews=$comp->reviews+1;
        $comp->raiting=$comp->raiting+$count;
        return $comp->save();
    }
}
