<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
$this->title=$seo->raiting_title;

$this->registerMetaTag([ 
    'name'=>'description', 
    'content'=>$seo->raiting_desc
]); 
$this->registerMetaTag([ 
    'name'=>'keywords', 
    'content'=>$seo->raiting_keys
]);
$imgPath=Yii::$app->params['imgPath'];
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h1 class="raitingTitle"><?=$seo->raiting_h1;?> </h1> 
            <?php /*
            <h3 id="choose">Выбрать город:</h3> 
            <ul class="city">
                <?php foreach($regions as $reg){?>
                <li><a href="<?=Url::toRoute(['main/raiting', 'alias'=>$reg->alias]);?>" <?php if($reg->alias==$alias || (!$alias && $reg->name=='Москва')){ echo "class='cityActive'";}?>><?=$reg->name;?></a></li>
                <?php }?>
                <!--<li><a href="" class="cityActive">Ивано-Франковск</a></li>-->
            </ul>
            <?php */?>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
            <table class="table table-striped raiting">
                <thead>
                    <tr>
                        <th>Место</th>
                        <th>Название</th>
                        <th>Регион</th>
                        <th class="litnon">Рейтинг</th>
                        <th>Отзывы</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach($comp as $c){?>
                    <tr>
                        <td><?=$i;?></td>
                        <td><a href="<?=Url::toRoute(['main/company','alias'=>$c['alias']]);?>"><?=$c['name'];?></a></td>
                        <td class="litnon"><?=$c['regions'];?></td>
                        <td><?=$c['raiting'];?></td>
                        <td><?=$c['reviews'];?></td>
                    </tr>
                    <?php $i++; }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
