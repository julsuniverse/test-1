<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\rating\StarRating;
use common\models\Review;
use yii\widgets\Pjax;
use yii\web\View;
$this->title = $person->seo_title;
$this->registerMetaTag([ 
    'name'=>'description', 
    'content'=>$person->seo_desc
]); 
$this->registerMetaTag([ 
    'name'=>'keywords', 
    'content'=>$person->seo_keys
]);
$imgPath=Yii::$app->params['imgPath'];
?>
<div class="container">
    <div class="row info">
        <div class="col-md-6 col-sm-12 left_bl_table">
        <h1 class="titleOne"><?=$person->name;?></h1>
        <div class="infoPhotoTop"><img src="<?= $imgPath;?><?=$person->logo;?>" alt="<?=$person->name;?>"/></div>
        <?php Pjax::begin(['id' => 'my-pjax-table', 'timeout' => 500000]);?>
            <table id="pjax-table" class="table table-striped raiting one_comp_rait strip_reverse" data-gisp="person">
                <tbody>
                    <tr>
                        <th>Компания</th>
                        <td><a data-pjax="0" href="<?=Url::toRoute(['main/company', 'alias'=>$person->company->alias]);?>"><?=$person->company->name;?></a></td>
                    </tr>
                    <tr>
                        <th>Сервис</th>
                        <td><a data-pjax="0" href="<?=Url::toRoute(['service/service', 'alias'=>$person->service->alias]);?>"><?=$person->service->name;?></a></td>
                    </tr>
                    <tr>
                        <th>Конференции</th>
                        <td><?=$person->conferences_string;?></td>
                    </tr>
                    <tr>
                        <th>Рейтинг</th>
                        <td id="tablerait" data-id="<?=$person->id;?>"><?=$person->raiting;?></td>
                    </tr>
                    <tr>
                        <th>Отзывы</th>
                        <td id="tablerev"><?=$person->reviews;?></td>
                    </tr>
                    <tr>
                        <th>VK</th>
                        <td><a  target="_blank" href="<?=$person->vk_group;?>"><?=$person->vk_group;?></a></td>
                    </tr>
                    <tr>
                        <th>FB</th>
                        <td><a  target="_blank" href="<?=$person->fb_group;?>"><?=$person->fb_group;?></a></td>
                    </tr>
                </tbody>
            </table>
           <?php Pjax::end();?> 
        </div>
        <div class="col-md-6 col-sm-12 infoPhoto"><img src="<?= $imgPath;?><?=$person->logo;?>" alt="<?=$person->name;?>"/></div>
        
    </div>
    <!--<div class="row"><div class="col-md-6 col-sm-12"><div class="strip"></div></div></div>-->
    <div class="row infoText">
        <div class="col-md-12 col-sm-12">
        <h2 class="infoTitle">О персоне</h2>
            <?=$person->about;?>	
        </div>
    </div>
    <div class="row"><div class="col-md-12"><div class="strip"></div></div></div>
</div>

<?php Pjax::begin(['id' => 'my-pjax', 'timeout' => 500000]);?>
<div class="container container-reviews">
    <?php Pjax::begin(['id' => 'pjax-reviews', 'timeout' => 500000]);?>
    <div  style="margin:0;" class="row" id="sortreviews">
        <div class="col-xs-12 col-sm-12 col-md-3"><h2 class="infoTitle">Отзывы о <?=$person->name;?></h2></div>
        <?php if(isset($comments[0])){?>
        <div  class="col-xs-12 col-sm-12 col-md-9 sort">
            <div class="row">
                <div class="col-lg-4 col-sm-4 sortTitle">Сортировать по:</div>
                <?php if($sort=='popular' && !$sort_desc){?>
                <div class="col-lg-3 col-sm-3"><a href="<?=Url::toRoute(['person/person','alias'=>$alias, 'sort'=>'popular', 'sort_desc'=>'desc']);?>" <?php if($sort=="popular") echo 'class="active"';?>>Популярность</a></div>
                <?php } else {?>
                <div class="col-lg-3 col-sm-3"><a href="<?=Url::toRoute(['person/person','alias'=>$alias, 'sort'=>'popular']);?>" <?php if($sort=="popular") echo 'class="active"';?>>Популярность<?php if($sort_desc && $sort=="popular"){?><span class="glyphicon glyphicon-sort" aria-hidden="true"></span><?php }?></div>
                <?php }?>
                <?php if(!$sort && !$sort_desc){?>
                <div class="col-lg-2 col-sm-1" style="text-align: center;"><a href="<?=Url::toRoute(['person/person','alias'=>$alias, 'sort_desc'=>'desc']);?>" <?php if(!$sort) echo 'class="active"';?>>Дата</a></div>
                <?php } else {?>
                <div class="col-lg-2 col-sm-1" style="text-align: center;"><a href="<?=Url::toRoute(['person/person','alias'=>$alias]);?>" <?php if(!$sort) echo 'class="active"';?>>Дата<?php if($sort_desc && !$sort){?><span class="glyphicon glyphicon-sort" aria-hidden="true"></span><?php }?></a></div>
                <?php }?>
                <?php if($sort=='bad-good' && !$sort_desc){?>
                <div class="col-lg-3 col-sm-4"><a href="<?=Url::toRoute(['person/person','alias'=>$alias, 'sort'=>'bad-good', 'sort_desc'=>'desc']);?>" <?php if($sort=="bad-good") echo 'class="active"';?>>Негатив/Позитив</a></div>    
                <?php } else {?>
                <div class="col-lg-3 col-sm-4"><a href="<?=Url::toRoute(['person/person','alias'=>$alias, 'sort'=>'bad-good']);?>" <?php if($sort=="bad-good") echo 'class="active"';?>>Негатив/Позитив<?php if($sort_desc && $sort=="bad-good"){?><span class="glyphicon glyphicon-sort" aria-hidden="true"></span><?php }?></a></div>    
                <?php }?>
            </div>
                
        </div>
        <div class="col-sm-12 col-xs-12 mobsort">
            <div class="dropsort"><span>Сортировать по:</span>
                <div class="dropdown">
                  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <?php
                        if(!$sort)
                            echo "Дата";
                        if($sort=="bad-good")
                            echo "Негатив/Позитив";
                        if($sort=="popular") 
                            echo "Популярность";               
                    ?>
                     <img src="<?= $imgPath;?>dropdown.png" alt="&#9660;"/>
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li><a href="<?=Url::toRoute(['person/person','alias'=>$alias, 'sort'=>'popular']);?>" <?php if($sort=="popular") echo 'class="active"';?>>Популярность</a></li>
                    <li><a href="<?=Url::toRoute(['person/person','alias'=>$alias]);?>" <?php if(!$sort) echo 'class="active"';?>>Дата</a></li>
                    <li><a href="<?=Url::toRoute(['person/person','alias'=>$alias, 'sort'=>'bad-good']);?>" <?php if($sort=="bad-good") echo 'class="active"';?>>Негатив/Позитив</a></li>
                  </ul>
                </div>
            </div>
        </div>
        <?php } else {?>
        <div class="col-xs-12 col-sm-12 col-md-9"><div style="margin-top:40px;" class="alert alert-warning" role="alert">Отзывов пока что нет.</div></div>
        <?php } ?>
    </div>
    <?php 
    foreach($comments as $com){ ?>
    <div class="review" style="background: <?=$com->color;?>; <?php if($com->strip){?>border-top: 10px solid <?=$com->strip;?>;<?php }?>">
        <img src="<?php if(strpos($com->user->username, "fb")!==false) echo "http://graph.facebook.com/".substr($com->user->username, 6)."/picture?type=large"; else echo $com->user->photo;?>" alt="<?=$com->user->name;?>"/>
        <div class="name"><a target="_blank" href="<?=$com->user->user_href;?>"><?=$com->user->name;?></a></div>
        <div class="stars">
            <?=StarRating::widget([
                'name' => 'rating_35',
                'value' => $com->stars,
                'pluginOptions' => [
                    'size'=>'xs',
                    'displayOnly' => true,
                    'showClear' => false,
                    'showCaption' => false,]
            ]);?>
        </div>
        <p><?=$com->text;?></p>
        <div class="clear"></div>
        <div class="date">
            <?=date("d:m:Y",$com->date)?>
        </div>
        <div class="likes">
            <span class="title">рейтинг отзыва </span><span onclick="likecomm(<?=$com->id;?>)" class="glyphicon glyphicon-triangle-top like_plus" aria-hidden="true"></span><span class="count_likes count_likes<?=$com->id;?>"> <?=$com->likes;?> </span><span onclick="dislikecomm(<?=$com->id;?>)" class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
        </div>
        <div class="clear"></div>
    </div>
    <?php }?>
    <?php Pjax::end();?>
    <hr />
    <div class="add_comment" id="add-review">
        <?php if(Yii::$app->user->isGuest){?>
        <p class="add_title add_title_sec">Оставьте свой отзыв!</p><br /><p class="add_title">Войти через:<br class="mobbr"/> <a href="<?=$fbhref;?>" class="fb"><img src="/frontend/web/mt/img/rfb.png"/></a><a href="<?=$vkhref?>" class="vk"><img src="/frontend/web/mt/img/rvk.png"/></a><a href="<?=Url::to(['person/person', 'alias'=>$person->alias, 'anonim'=>1]);?>" class="anonim" data-pjax='false' >Анонимно</a></p>
        <?php } else {?>
        <?php if(Yii::$app->user->identity->id!=11) echo Html::a('Выйти', Url::to(['person/logout', 'alias'=>$alias], true), ['data-pjax'=>0]);
        else {?> <p class="add_title">Войти через:<br class="mobbr"/> <a href="<?=$fbhref;?>" class="fb"><img src="/frontend/web/mt/img/rfb.png"/></a><a href="<?=$vkhref?>" class="vk"><img src="/frontend/web/mt/img/rvk.png"/></a></p> <?php }?>        
        <h4>Добавить отзыв</h4>
        <?php $f=ActiveForm::begin(['options'=>['data-pjax'=>true]]);?>
            <div class="row">
                <div class="col-md-7">
                    <?=$f->field($model, 'text')->textArea(['placeholder'=>'Напишите здесь Ваше мнение о персоне...', 'class'=>'review_text'])->label('');?>
                </div>
                <div class="col-md-5">
                    <div class="star_input row">
                        <div class="col-sm-5 col-xs-5 review_mark">
                            <span>Ваша оценка:</span>
                        </div>
                        <div class="col-sm-7 col-xs-7">
                             <?=$f->field($model, 'star')->widget(StarRating::classname(), [
                                'pluginOptions' => [
                                    'size'=>'xs',
                                    'step'=>1,
                                    'showClear' => false,
                                    'showCaption' => false,
                                ]
                            ])->label('');?>
                        </div>
                    </div>
                    <div class="rew_bott">
                        <div class="review_button">
                            <?= Html::submitButton('Добавить', ['name' => 'add-button']) ?>
                        </div>
                    </div>
                    
                </div>
            </div>
        <?php ActiveForm::end();?>
        <?php }?>
    </div>
</div>
<?php Pjax::end();?>
<div class="container">
    <div class="row">
        <div class="col-md-12 beforenews">
        </div>
    </div>
</div>
<?php if($wall || $fb_wall){
    if ($this->beginCache($person->id."personwall", ['duration' => $wall_cach])) {?>
<?php 
function to_link($string){ 
    return preg_replace("~(http|https|ftp|ftps)://(.*?)(\s|\n|[,.?!](\s|\n)|$)~", '<a target="_blank" rel="nofollow" href="$1://$2">$1://$2</a>$3',$string); 
} 
?>
<?php if($wall){?>
<div class="container wall">
    <hr />
    <div class="row">
        <h2>Новости от <?=$person->name;?></h2>
        <?php 
          for ($i = 1; $i < count($wall); $i++) 
          {?>
        <div class="col-sm-6 col-xs-12">
            <div class="panel panel-info">
              <div class="panel-body">
                <div class="wall_text">
                    <?=to_link($wall[$i]->text);?>
                </div>
                <div class="row photos">
                    <?php 
                        $imgs=$wall[$i]->attachments;
                        $arr=[];
                        for($j=0;$j<count($imgs);$j++){
                            if($imgs[$j]->photo->src) $arr[]='<img src="'.$imgs[$j]->photo->src_big.'" alt="'.$i.$j.'"/>';
                       }
                        $col=count($arr);
                        if($col>=4) $col=3; else if($col==1) $col=12; else if ($col==3) $col=4; else if ($col==2) $col=6;
                        for($j=0;$j<count($arr);$j++){?>
                        <div class="col-md-<?=$col;?>">
                            <?=$arr[$j];?>
                        </div>
                        <?php }?>
                </div>
              </div>
              <div class="panel-footer">
                <?=date("d.m.Y",$wall[$i]->date);?>
              </div>
            </div>
        </div>
        <?php }?>
    </div>
</div>
<?php }?>
<?php 
$this->endCache();}
}?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Ошибка</h4>
      </div>
      <div class="modal-body">
        <p style="text-align: center;">Что бы оценить отзыв, нужно авторизоваться</p>
      </div>
    </div>
  </div>
</div>