<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
$this->title=$seo->service_title;

$this->registerMetaTag([ 
    'name'=>'description', 
    'content'=>$seo->service_desc
]); 
$this->registerMetaTag([ 
    'name'=>'keywords', 
    'content'=>$seo->service_keys
]);
$imgPath=Yii::$app->params['imgPath'];
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h1 class="raitingTitle"><?=$seo->service_h1;?> </h1> 
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
            <table class="table table-striped raiting">
                <thead>
                    <tr>
                        <th>Место</th>
                        <th class="sorokclass">Название</th>
                        <th>Теги</th>
                        <th>Рейтинг</th>
                        <th>Отзывы</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach($service as $c){?>
                    <tr>
                        <td><?=$i;?></td>
                        <td><a href="<?=Url::toRoute(['service/service','alias'=>$c['alias']]);?>"><?=$c['name'];?></a></td>
                        <td><?=$c['tags'];?></td>
                        <td><?=$c['raiting'];?></td>
                        <td><?=$c['reviews'];?></td>
                    </tr>
                    <?php $i++; }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
