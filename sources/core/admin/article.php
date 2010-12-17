<?php

/**
 * Edition d'un article
 *
 * @package PLX
 * @author	Stephane F et Florent MONTHEL
 **/

include('prepend.php');
include('wysiwyg.php');

# On édite notre article
if(!empty($_POST)) { # Création, mise à jour, suppression ou aperçu
	$_POST = plxUtils::unSlash($_POST);
	if(trim($_POST['title']) == '') $_POST['title'] = 'Nouvel article'; # Si titre vide ;)
	if(isset($_POST['delete'])) { # Suppression, on redirige
		header('Location: ./?del='.$_POST['artId'].'&hash='.$_SESSION['hash']);
		exit;
	}
	if(!isset($_POST['preview'])) { # Mode création ou maj
		$msg = $plxAdmin->editArticle($_POST,$_POST['artId']);
		header('Location: article.php?a='.$_POST['artId'].'&msg='.urlencode($msg));
		exit;
	} else { # Mode preview
		$artId = $_POST['artId'];
		$title = trim($_POST['title']);
		$author = $_POST['author'];
		$catId = $_POST['catId'];
		$date['day'] = $_POST['day'];
		$date['month'] = $_POST['month'];
		$date['year'] = $_POST['year'];
		$date['time'] = $_POST['time'];
		$chapo = trim($_POST['chapo']);
		$content =  trim($_POST['content']);
		$url = $_POST['url'];
		$adres = $_POST['adres'];
		$allow_com = $_POST['allow_com'];
		$title_page = 'Предпросмотр новости';
	}
} elseif(!empty($_GET['a'])) { # On n'a rien validé, c'est pour l'édition d'un article
	# On va rechercher notre article
	if(($aFile = $plxAdmin->plxGlob_arts->query('/^'.$_GET['a'].'.(.+).xml$/','','sort',0,1)) == false) { # Article inexistant
		$msg = 'L\'article demand&eacute; n\'existe pas ou n\'existe plus !';
		header('Location: ./?msg='.urlencode($msg));
		exit;
	}
	# On parse et alimente nos variables
	$result = $plxAdmin->parseArticle(PLX_ROOT.$plxAdmin->aConf['racine_articles'].$aFile['0']);
	$title = trim($result['title']);
	$chapo = trim($result['chapo']);
	$content =  trim($result['content']);
	$author = $result['author'];
	$url = $result['url'];
	$adres = $result['adres'];	
	$date = plxUtils::dateIso2Admin($result['date']);
	$catId = $result['categorie'];	
	$artId = $result['numero'];
	$allow_com = $result['allow_com'];
	$title_page = 'Редактировать новость';
} else { # On a rien validé, c'est pour la création d'un article
	$title = 'Новая статья';
	$chapo = $url = '';
	$content = '';
	$author = $_SESSION['author'];
	$date = array ('year' => date('Y'),'month' => date('m'),'day' => date('d'),'time' => date('H:i'));
	$catId = '';
	$artId = '0000';
	$allow_com = $plxAdmin->aConf['allow_com'];
	$title_page = 'Чиркануть новость';
}

# Génération de notre tableau des catégories
if($plxAdmin->aCats) {
	foreach($plxAdmin->aCats as $k=>$v)
		$aCat[$k] = htmlspecialchars($v['name'],ENT_QUOTES,PLX_CHARSET);
	$aAllCat['Категории'] = $aCat;
}
$aAllCat['Особые категории']['home'] = 'Актуальное';
$aAllCat['Особые категории']['draft'] = 'Драфты';

# On inclut le header
include('top.php');
?>

<h2><?php echo $title_page; ?></h2>

<?php # On a un aperçu
if(isset($_POST['preview'])) {
	# On remplace les chemins des images et documents (pas au même niveau)
	$_chapo = str_replace('src="'.$plxAdmin->aConf['images'],'src="'.PLX_ROOT.$plxAdmin->aConf['images'],$chapo);
	$_chapo = str_replace('href="./?telechargement/','href="'.PLX_ROOT.'?telechargement/',$_chapo);
	$_content = str_replace('src="'.$plxAdmin->aConf['images'],'src="'.PLX_ROOT.$plxAdmin->aConf['images'],$content);
	$_content = str_replace('href="./?telechargement/','href="'.PLX_ROOT.'?telechargement/',$_content);
	echo '<div id="preview"><blockquote><h3>'.htmlspecialchars($title,ENT_QUOTES,PLX_CHARSET).'</h3>'.$_chapo.'<br />'.$_content.'</blockquote></div>';
}
?>

<form action="article.php" method="post" id="change-art-content">
	<fieldset>
		<?php plxUtils::printInput('artId',$artId,'hidden'); ?>
		<?php plxUtils::printInput('author',htmlspecialchars($author,ENT_QUOTES,PLX_CHARSET),'hidden'); ?>
		<p class="field">
			<label>Заголовок:</label>
			<?php plxUtils::printInput('title',htmlspecialchars($title,ENT_QUOTES,PLX_CHARSET),'text','50-255'); ?> как <strong><?php echo $author; ?></strong>
		</p>
		<p class="field">
			<label>Категория:</label>
			<?php plxUtils::printSelect('catId',$aAllCat,$catId); ?>
		</p>
		<?php if ($plxAdmin->aConf['admin_conf']==0) { ?>
		<p class="field"><label>Затравка (необязательно):</label></p>
		<?php plxUtils::printArea('chapo',htmlspecialchars($chapo,ENT_QUOTES,PLX_CHARSET),60,4); ?>
		<?php }; ?>
		<p class="field"><label>Текст новости: (HTML тэги уместны)</label></p>
		<?php if ($plxAdmin->aConf['wysiwyg']==1) echo $wysiwyg_panel; ?>
		<?php plxUtils::printArea('content',htmlspecialchars($content,ENT_QUOTES,PLX_CHARSET),60,20); ?>
		<?php if ($plxAdmin->aConf['admin_conf']==0) { ?>
		 	<p class="field"><label>Дата:</label></p>
			<?php plxUtils::printInput('day',$date['day'],'text','2-2'); ?>
			<?php plxUtils::printInput('month',$date['month'],'text','2-2'); ?>
			<?php plxUtils::printInput('year',$date['year'],'text','4-4'); ?>
			<?php plxUtils::printInput('time',$date['time'],'text','5-5'); ?>
			<a href="javascript:void(0)" onclick="dateNow(); return false;">текущий момент</a>
		<p class="field">
			<label>Ссылка на сайт о котором идёт речь (для новостей о новых сайтах) — необязательно:</label></p>
			<?php plxUtils::printInput('adres', $adres); ?>
		<p class="field">
			<label>Alias новости — <b>только</b> латиница:</label></p>
			<?php plxUtils::printInput('url', $url); ?>
		<?php }; ?>
		<p class="field">
			<input type="submit" name="preview" value="Предпросмотр"/>
			<input type="submit" name="update" value="Опубликовать"/>
			<input type="submit" name="delete" value="Удалить" onclick="Check=confirm('Отменить запись ?');if(Check==false) return false;"/>
		</p>
	</fieldset>
</form>

<?php
# On inclut le footer
include('foot.php');
?>
