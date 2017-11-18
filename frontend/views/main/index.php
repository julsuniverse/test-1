<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
$this->title=$seo->main_title;

$this->registerMetaTag([ 
    'name'=>'description', 
    'content'=>$seo->main_desc
]); 
$this->registerMetaTag([ 
    'name'=>'keywords', 
    'content'=>$seo->main_keys
]);
$imgPath=Yii::$app->params['imgPath'];
?>

<div class="container-fluid logodblock">
    <div class="row">
        <div class="col-md-12">
            <h2>Рейтинг SEO компаниий</h2>
        </div>
        <div class="col-sm-4 nomarginbl" style="padding-left: 28px;">
            <div class="lbdivimg">
                <a href="<?=Url::toRoute(['main/company', 'alias'=>$bestcompanies[0]['alias']]);?>">
                    <img src="/frontend/web/mt/img/<?=$bestcompanies[0]['logo'];?>" alt="<?=$bestcompanies[0]['name'];?>"/>
                </a>
            </div>
        </div>
        <div class="col-sm-4 nomarginbl">
        <?php for($i=1; $i<=4; $i++){?>
            <div class="lbdivimg2">
                <a href="<?=Url::toRoute(['main/company', 'alias'=>$bestcompanies[$i]['alias']]);?>">
                    <img src="/frontend/web/mt/img/<?=$bestcompanies[$i]['logo'];?>" alt="<?=$bestcompanies[$i]['name'];?>"/>
                </a>
            </div>
        <?php if($i==2){?><div class="clear"></div> <?php }?>
        <?php }?>
        </div>
        <div class="col-sm-4 nomarginbl" style="padding-right: 28px;">
        <?php for($i=5; $i<=13; $i++){?>
            <div class="lbdivimg3">
                <a href="<?=Url::toRoute(['main/company', 'alias'=>$bestcompanies[$i]['alias']]);?>">
                    <img src="/frontend/web/mt/img/<?=$bestcompanies[$i]['logo'];?>" alt="<?=$bestcompanies[$i]['name'];?>"/>
                </a>
            </div>
        <?php if($i==7 || $i==10){?><div class="clear"></div> <?php }?>
        <?php }?>
        </div>
    </div>

</div>

<div class="container-fluid logodblock">
    <div class="row">
        <div class="col-md-12">
            <h2>Рейтинг компаний по обучению SEO</h2>
        </div>
        <div class="col-sm-4 nomarginbl" style="padding-left: 28px;">
            <div class="lbdivimg">
                <a href="<?=Url::toRoute(['main/company', 'alias'=>$bestedcompanies[0]['alias']]);?>">
                    <img src="/frontend/web/mt/img/<?=$bestedcompanies[0]['logo'];?>" alt="<?=$bestedcompanies[0]['name'];?>"/>
                </a>
            </div>
        </div>
        <div class="col-sm-4 nomarginbl">
        <?php for($i=1; $i<=4; $i++){?>
            <div class="lbdivimg2">
                <a href="<?=Url::toRoute(['main/company', 'alias'=>$bestedcompanies[$i]['alias']]);?>">
                    <img src="/frontend/web/mt/img/<?=$bestedcompanies[$i]['logo'];?>" alt="<?=$bestedcompanies[$i]['name'];?>"/>
                </a>
            </div>
        <?php if($i==2){?><div class="clear"></div> <?php }?>
        <?php }?>
        </div>
        <div class="col-sm-4 nomarginbl" style="padding-right: 28px;">
        <?php for($i=5; $i<=13; $i++){?>
            <div class="lbdivimg3">
                <a href="<?=Url::toRoute(['main/company', 'alias'=>$bestedcompanies[$i]['alias']]);?>">
                    <img src="/frontend/web/mt/img/<?=$bestedcompanies[$i]['logo'];?>" alt="<?=$bestedcompanies[$i]['name'];?>"/>
                </a>
            </div>
        <?php if($i==7 || $i==10){?><div class="clear"></div> <?php }?>
        <?php }?>
        </div>
    </div>

</div>

<div class="container main">
    <div class="row">
        <div id="forDrop" >
            <div class="dropdown selectTable">
                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <span id="main_butt_text"><?=$mp->title1;?></span>
                    <img src="<?= $imgPath;?>dropdown.png" alt="&#9660;"/>
                    <!--
<span class="mycaret"></span>
-->
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li><span class="open_table1"><?=$mp->title1;?></span></li>
                    <li><span class="open_table2"><?=$mp->title2;?></span></li>
                    <li><span class="open_table3"><?=$mp->title3;?></span></li>
                    <li><span class="open_table4"><?=$mp->title4;?></span></li>
                </ul>
            </div>    
        </div>

        <div class="col-md-6 nopadding table1">
            <table class="table table-striped raiting">
            <caption><?=$mp->title1;?></caption>
                <thead>
                    <tr>
                        <th>Место</th>
                        <th>Название</th>
                        <th>Рейтинг</th>
                        <th>Отзывы</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach($city1 as $city){?>
                    <tr>
                        <td><?=$i;?></td>
                        <td><a href="<?=Url::toRoute(['main/company','alias'=>$city['alias']]);?>"><?=$city['name'];?></a></td>
                        <td><?=$city['raiting'];?></td>
                        <td><?=$city['reviews'];?></td>
                    </tr>
                    <?php $i++; }?>
                </tbody>
            </table>
        </div>
        <div class="col-md-6 nopadding table2">
            <table class="table table-striped raiting">
            <caption><?=$mp->title2;?></caption>
                <thead>
                    <tr>
                        <th>Место</th>
                        <th>Название</th>
                        <th>Рейтинг</th>
                        <th>Отзывы</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach($city2 as $city){?>
                    <tr>
                        <td><?=$i;?></td>
                        <td><a href="<?=Url::toRoute(['main/company','alias'=>$city['alias']]);?>"><?=$city['name'];?></a></td>
                        <td><?=$city['raiting'];?></td>
                        <td><?=$city['reviews'];?></td>
                    </tr>
                    <?php $i++; }?>
                </tbody>
            </table>
        </div>
        <div class="clear"></div>
        <div class="col-md-6 nopadding">
            <table class="table table-striped raiting table3">
            <caption><?=$mp->title3;?></caption>
                <thead>
                    <tr>
                        <th>Место</th>
                        <th>Название</th>
                        <th>Рейтинг</th>
                        <th>Отзывы</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach($top as $t){?>
                    <tr>
                        <td><?=$i;?></td>
                        <td><a href="<?=Url::toRoute(['main/company','alias'=>$t['alias']]);?>"><?=$t['name'];?></a></td>
                        <td><?=$t['raiting'];?></td>
                        <td><?=$t['reviews'];?></td>
                    </tr>
                    <?php $i++; }?>
                </tbody>
            </table>
        </div>
        <div class="col-md-6 nopadding">
            <table class="table table-striped raiting table4">
            <caption><?=$mp->title4;?></caption>
                <thead>
                    <tr>
                        <th>Место</th>
                        <th>Название</th>
                        <th>Рейтинг</th>
                        <th>Отзывы</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach($whorst as $w){?>
                    <tr>
                        <td><?=$i;?></td>
                        <td><a href="<?=Url::toRoute(['main/company','alias'=>$w['alias']]);?>"><?=$w['name'];?></a></td>
                        <td><?=$w['raiting'];?></td>
                        <td><?=$w['reviews'];?></td>
                    </tr>
                    <?php $i++; }?>
                </tbody>
            </table>
        </div>

        <div class="col-md-12">
            <div class="strip"></div>
        </div>
    </div>
    <?php if($seo->main_text){?>
    <div class="row">
        <div class="col-sm-12 col-xs-12" style="margin-bottom: 35px;">
            <?=$seo->main_text;?>
        </div>
    </div>
    <?php }?>
    <?php if($lastcomments){?>
    <div class="row comments">
        <div class="col-md-12">
            <h2>Последние отзывы</h2>
        </div>
        <?php foreach($lastcomments as $com){?>
        <div class="col-md-12 col-sm-12 col-xs-12 oneComment">
            <a class="ablockhover" href="<?=$com->gisturl;?>">
                <img src="<?php if(strpos($com->user->username, "fb")!==false) echo "http://graph.facebook.com/".substr($com->user->username, 6)."/picture?type=large"; else echo $com->user->photo;?>" alt="<?=$com->user->name;?>" class="img-circle"/>
                <span style="color:#999;font-size:14px;float: right;"><?=date("d.m.Y",$com->date)?></span>
                <p class="commentName"><?=$com->user->name;?>
                    <span>Отзывы о <?=$com->gistname;?></span>
                </p>
                <p class="commentText"><?=$com->text;?></p>
            </a>   
        </div>
        <?php }?>


    </div>
    <?php }?>
        <div class="clearfix"></div>
</div>
