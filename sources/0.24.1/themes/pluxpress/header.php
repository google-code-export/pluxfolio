<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<title><?php $plxShow->pageTitle(); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="<?php $plxShow->template(); ?>/style.css" media="screen" />
	<link rel="alternate" type="application/atom+xml" title="Atom articles" href="./feed.php?atom" />
	<link rel="alternate" type="application/rss+xml" title="Rss articles" href="./feed.php?rss" />
	<link rel="alternate" type="application/atom+xml" title="Atom commentaires" href="./feed.php?atom/commentaires" />
	<link rel="alternate" type="application/rss+xml" title="Rss commentaires" href="./feed.php?rss/commentaires" />
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
   
<style>
#top {background: transparent url('<?php $plxShow->template(); ?>/img/header-bg.png') repeat-x;}	
</style>

<script type="text/javascript" src="js/prototype.lite.js"></script>
<script type="text/javascript" src="js/moo.fx.js"></script>
<script type="text/javascript" src="js/litebox-1.0.js"></script>
<?php if ($plxShow->plxMotor->categ_get==1) echo '<script type="text/javascript" src="js/collapse.js"></script>';?>
</head>
<? $bodyid = substr($_SERVER['QUERY_STRING'],11);  ?>
<body id="<?php echo $bodyid; 
if (empty($bodyid)) { echo 'homini'; } ?>" onload="initLightbox(); <?php if ($plxShow->plxMotor->categ_get==1) echo 'hideDiv(\'catlist\');';?>">
<div id="top">
  <div id="toper">
	<div id="header">
        <h1><?php $plxShow->mainTitle('link'); ?></h1> <span><?php $plxShow->subTitle(); ?></span>
	<p><?php if ($plxShow->plxMotor->counter_enabled==1) include ("scan.php");?></p>
	</div>	
	<div id="menu"><ul><?php if ($plxShow->plxMotor->index_get==0) $plxShow->staticList('Главная'); else $plxShow->staticList('Новости');?></ul></div>
</div>		
</div>
