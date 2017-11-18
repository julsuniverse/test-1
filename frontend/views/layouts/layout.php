<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\MyAsset;
use common\widgets\Alert;
use common\models\Theme;
use common\models\Banner;

MyAsset::register($this);
$imgPath=Yii::$app->params['imgPath'];
$theme=Theme::find()->select(['logo_big','logo_small','footer_links', 'footer_links2', 'metrics'])->where(['id'=>1])->one();
$banners=Banner::findBanners();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
    
      ga('create', 'UA-81824028-1', 'auto');
      ga('send', 'pageview');
    
    </script>
    <?= $theme->metrics;?>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<nav class="navbar navbar-default topmenu">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header menuhead">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <?php if(Url::to('')=="/main/index" || Url::to('')=="/"){?>
      <a class="navbar-brand logo logoBig" href="<?=Url::toRoute(['main/index']);?>"><img src="<?= $imgPath;?><?=$theme->logo_big;?>" alt="seostars" /></a>
      <?php }else {?>
      <a class="navbar-brand logo logoSmallOther logoBig" href="<?=Url::toRoute(['main/index']);?>"><img src="<?= $imgPath;?><?=$theme->logo_small;?>" alt="seostars" /></a>
      <?php }?>
      <a class="navbar-brand logo logoSmall" href="<?=Url::toRoute(['main/index']);?>"><img src="<?= $imgPath;?><?=$theme->logo_small;?>" alt="seostars" /></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse menuItems" id="bs-example-navbar-collapse-2">
      <ul class="nav navbar-nav navbar-right links">
        <li><a <?php if(strripos(Url::to(''), "raiting")!==false) echo 'class="activelink"';?> href="<?=Url::toRoute(['main/raiting']);?>">Компании</a></li>
        <li><a <?php if(strripos(Url::to(''), "top-seo-education")!==false) echo 'class="activelink"';?> href="<?=Url::toRoute(['main/page', 'alias'=>'top-seo-education']);?>">Обучение</a></li>
        <li><a <?php if(strripos(Url::to(''), "service")!==false) echo 'class="activelink"';?> href="<?=Url::toRoute(['service/services']);?>">Сервисы</a></li>
        <li><a <?php if(strripos(Url::to(''), "person")!==false) echo 'class="activelink"';?> href="<?=Url::toRoute(['person/persons']);?>">Персоны</a></li>
        <li><a <?php if(strripos(Url::to(''), "conference")!==false) echo 'class="activelink"';?> href="<?=Url::toRoute(['conference/conferences']);?>">Конференции</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<?php if(Url::to('')!='/'){?>
<div class="container">
    <div class="row">
        <div class="col-md-9"><?= $content ;?></div>
        <div class="col-md-3 rightbdiv">
            <?php if($count=count($banners)){
            foreach($banners as $banner){?>
            <a target="_blank" href="<?=$banner->href;?>"><img src="/frontend/web/mt/img/<?=$banner->photo;?>"/></a>
            <?php }}?>
        </div>
    </div>
</div>
<?php } else echo $content; ?>

<footer class="footer">
    <div class="container-fluid">
        <div class="row bottomMenu"> 
            <div class="col-sm-4 col-xs-12"> 
                <?=$theme->footer_links;?>
            </div> 
            <div class="col-sm-5 col-xs-12 cenlinks"> 
                <?=$theme->footer_links2;?>
            </div> 
            <div class="col-sm-2 col-xs-12"> 
                <li><a <?php if(Url::to('')=="/main/index" || Url::to('')=="/") echo 'class="activelink"';?> href="<?=Url::toRoute(['main/index']);?>">Главная</a></li><br />
                <a href="<?=Url::toRoute(['main/pages']);?>">Карта сайта</a> <br />
                <a href="<?=Url::toRoute(['main/contact']);?>">Контакты</a> <br />
                <li><a <?php if(strripos(Url::to(''), "about")!==false) echo 'class="activelink"';?> href="<?=Url::toRoute(['main/about']);?>">О сайте</a></li><br />
            </div> 
            <div class="col-sm-1">
                <a href="https://www.facebook.com/SEO-Stars-TOP-336355266796266/"><img style="width: 65px;" src="/frontend/web/mt/img/facebookbottom.png" /></a>
            </div>
        </div>
    </div>
</footer>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter38821510 = new Ya.Metrika({
                    id:38821510,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/38821510" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
