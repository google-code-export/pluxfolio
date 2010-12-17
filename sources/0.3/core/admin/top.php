<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>

<?php include('../lang/'.$plxAdmin->aConf['site_lang'].'.php'); ?>

<title><?php echo $plxAdmin->aConf['title']; ?> - <?php echo $ADM_title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="admin.css" media="screen" />
<script type="text/javascript" src="../lib/functions.js"></script>
<script type="text/javascript" src="/js/wysiwyg.js"></script>

</head>

<body id="<?php $self = basename($_SERVER['PHP_SELF']); echo substr($self,0,-4); ?>">
<div id="main">

	<div id="header"><h1><?php echo $plxAdmin->aConf['title']; ?> - <?php echo $ADM_title; ?></h1>
		<p><?php echo $ADM_authorized_as; ?> <strong><?php echo (!empty($_SESSION['author']))?htmlspecialchars($_SESSION['author'],ENT_QUOTES,PLX_CHARSET):'invit&eacute;'; ?></strong> :: <a href="auth.php?d=1" title="закончить работу администратора" id="logout"><?php echo $ADM_logout; ?></a></p>
	</div>

	<div id="navigation">
		<ul>
		<li><a href="index.php" id="link_control" title="операции с галереями портфельных материалов"><?php echo $ADM_top_gallery_title; ?></a></li>
		<li><a href="article.php" id="link_article-new" title="чиркануть новость"><?php echo $ADM_top_postarticle_title; ?></a></li>
		<li><a href="news.php" id="link_articles" title="операции над новостями"><?php echo $ADM_top_articles_title; ?></a></li>
		<li><a href="statiques.php" id="link_statiques" title="операции над страницами"><?php echo $ADM_top_staticpages_title; ?></a></li>
		<li><a href="categories.php" id="link_categories" title="категории новостей"><?php echo $ADM_top_articlescategories_title; ?></a></li>
		<li><a href="parametres_base.php" id="link_config" title="конфигурировать pluxfolio"><?php echo $ADM_top_settings_title; ?></a></li>
		<li><a href="images.php" id="link_images" title="закачать картинки на сайт"><?php echo $ADM_top_pictures_title; ?></a></li>
		<li><a href="documents.php" id="link_docs" title="закачать файлы на сайт"><?php echo $ADM_top_files_title; ?></a></li>
		<li style="position:absolute; left:5%; top:20px;"><a href="<?php echo PLX_ROOT; ?>" class="back" title="вернуться на сайт"><?php echo $ADM_top_backtosite_title; ?></a></li>
		</ul>
	</div>

<?php if(file_exists(plxUtils::getSousNav())) : ?>
	<div id="sous_navigation"><?php include(plxUtils::getSousNav()); ?></div>
<?php endif; ?>

<?php (!empty($_GET['msg']))?plxUtils::showMsg(plxUtils::unSlash(urldecode(trim($_GET['msg'])))):''; ?>
