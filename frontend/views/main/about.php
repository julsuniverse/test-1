<?php
use yii\helpers\Url;
$this->title=$theme->about_title;

$this->registerMetaTag([ 
    'name'=>'description', 
    'content'=>$theme->about_desc
]); 
$this->registerMetaTag([ 
    'name'=>'keywords', 
    'content'=>$theme->about_keys
]);
$imgPath=Yii::$app->params['imgPath'];
?>
<div class="container" >
    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <?=$theme->about_text;?>
        </div>
    </div>
</div>