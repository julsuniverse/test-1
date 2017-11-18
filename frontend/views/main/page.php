<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
$this->title=$page->seo_title;

$this->registerMetaTag([ 
    'name'=>'description', 
    'content'=>$page->seo_desc
]); 
$this->registerMetaTag([ 
    'name'=>'keywords', 
    'content'=>$page->seo_keys
]);
?>
<div class="container" style="padding-bottom: 45px;">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h1 class="raitingTitle"><?=$page->h1;?></h1> 
            <?php if($page->h2){?><h2 id="choose"><?=$page->h2;?></h2><?php }?> 
        </div>
        <?php if($page->editor_pos=="top" && $page->editor){?>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <?=$page->editor;?> 
            </div>
        <?php }?>
        <?php if($page->add_table==1){?>
        <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
            <table class="table table-striped raiting">
                <thead>
                    <tr>
                        <th>Место</th>
                        <th>Название</th>
                        <th>Рейтинг</th>
                        <th>Отзывы</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach($comp as $c){?>
                    <tr>
                        <td><?=$i;?></td>
                        <td><a href="<?=Url::toRoute(['main/company','alias'=>$c['alias']]);?>"><?=$c['name'];?></a></td>
                        <td><?=$c['raiting'];?></td>
                        <td><?=$c['reviews'];?></td>
                    </tr>
                    <?php $i++; }?>
                </tbody>
            </table>
        </div>
        <?php }?>
        <?php if($page->editor_pos=="bottom" && $page->editor){?>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <?=$page->editor;?> 
            </div>
        <?php }?>
    </div>
</div>
