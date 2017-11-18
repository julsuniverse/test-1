<?php
use yii\helpers\Url;
$this->title=$theme->contact_us_title;

$this->registerMetaTag([ 
    'name'=>'description', 
    'content'=>$theme->contact_us_desc
]); 
$this->registerMetaTag([ 
    'name'=>'keywords', 
    'content'=>$theme->contact_us_keys
]);
$imgPath=Yii::$app->params['imgPath'];
?>
<div class="container" >
    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <?=$theme->contact_us;?>
        </div>
    </div>
</div>