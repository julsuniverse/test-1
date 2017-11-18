<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
$this->title=$seo->person_tilte;

$this->registerMetaTag([ 
    'name'=>'description', 
    'content'=>$seo->person_desc
]); 
$this->registerMetaTag([ 
    'name'=>'keywords', 
    'content'=>$seo->person_keys
]);
$imgPath=Yii::$app->params['imgPath'];
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h1 class="raitingTitle"><?=$seo->person_h1;?> </h1> 
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
            <table class="table table-striped raiting">
                <thead>
                    <tr>
                        <th>Место</th>
                        <th>Название</th>
                        <th class="litnon">Компания</th>
                        <th>Рейтинг</th>
                        <th>Отзывы</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach($person as $c){?>
                    <tr>
                        <td><?=$i;?></td>
                        <td><a href="<?=Url::toRoute(['person/person','alias'=>$c->alias]);?>"><?=$c->name;?></a></td>
                        <td class="litnon"><a href="<?=Url::toRoute(['main/company', 'alias'=>$c->company->alias]);?>"><?=$c->company->name;?></a></td>
                        <td><?=$c->raiting;?></td>
                        <td><?=$c->reviews;?></td>
                    </tr>
                    <?php $i++; }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
