<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<title><?php echo $plxAdmin->aConf['title']; ?> - Administration</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="admin.css" media="screen" />
<script type="text/javascript" src="../lib/functions.js"></script>
<script type="text/javascript" src="/js/wysiwyg.js"></script>
</head>

<body id="<?php $self = basename($_SERVER['PHP_SELF']); echo substr($self,0,-4); ?>">
<div id="main">

	<div id="header"><h1><?php echo $plxAdmin->aConf['title']; ?> - Админка</h1>
		<p>Вы вошли как <strong><?php echo (!empty($_SESSION['author']))?htmlspecialchars($_SESSION['author'],ENT_QUOTES,PLX_CHARSET):'invit&eacute;'; ?></strong> :: <a href="auth.php?d=1" title="закончить работу администратора" id="logout">Выйти</a></p>
	</div>

	<div id="navigation">
		<ul>
        <li><a href="index.php" id="link_galerie" title="операции с галереями портфельных материалов">Галереи</a></li>
		<li><a href="article.php" id="link_article-new" title="чиркануть новость">Чиркануть новость</a></li>
		<li><a href="news.php" id="link_articles" title="операции над новостями">Новости</a></li>
		<li><a href="statiques.php" id="link_statiques" title="операции над страницами">Статичные страницы</a></li>
		<li><a href="categories.php" id="link_categories" title="категории новостей">Категории новостей</a></li>
		<li><a href="parametres_base.php" id="link_config" title="конфигурировать pluxfolio">Настройки</a></li>
		<li><a href="images.php" id="link_images" title="закачать картинки на сайт">Картинки</a></li>
		<li><a href="documents.php" id="link_docs" title="закачать файлы на сайт">Файлы</a></li>
		<li style="position:absolute; left:5%; top:20px;"><a href="<?php echo PLX_ROOT; ?>" class="back" title="вернуться на сайт">Вернуться на сайт</a></li>
		</ul>
	</div>

<?php if(file_exists(plxUtils::getSousNav())) : ?>
	<div id="sous_navigation"><?php include(plxUtils::getSousNav()); ?></div>
<?php endif; ?>

<?php (!empty($_GET['msg']))?plxUtils::showMsg(plxUtils::unSlash(urldecode(trim($_GET['msg'])))):''; ?>
