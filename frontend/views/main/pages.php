<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
$this->title=$seo->map_title;

$this->registerMetaTag([ 
    'name'=>'description', 
    'content'=>$seo->map_desc
]); 
$this->registerMetaTag([ 
    'name'=>'keywords', 
    'content'=>$seo->map_keys
]);
$imgPath=Yii::$app->params['imgPath'];
?>
<div class="container" style="padding-bottom: 45px;">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h1 class="raitingTitle"><?=$seo->map_h1;?></h1> 
        </div>
        <?php foreach($pages as $art){?>
        <div class="col-sm-12 col-xs-12">
            <div class="panel panel-info">
              <div class="panel-heading">
                <h3 class="panel-title"><a href="<?=Url::toRoute(['main/page', 'alias'=>$art->alias]);?>"><?=$art->h1;?></a></h3>
              </div>
              <div class="panel-body">
                <?=$art->preview_text;?>
              </div>
            </div>
        </div>
        <?php }?>
    </div>
</div>
