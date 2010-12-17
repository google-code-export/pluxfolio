<?php

/**
 * Edition du code source d'une page galeria
 *
 * @package PLX
 * @author	Stephane F. et Florent MONTHEL
 **/
 
include('prepend.php');
include('wysiwyg.php');

# On édite la page galeria
if(!empty($_POST) AND isset($plxAdmin->aGals[ $_POST['id'] ])) {
	$msg = $plxAdmin->editFileGaleria(plxUtils::unSlash($_POST));
	header('Location: galeria.php?p='.$_POST['id'].'&msg='.urlencode($msg).'');
	exit;
} elseif(!empty($_GET['p'])) { # On affiche le contenu de la page
	$id = $_GET['p'];
	if(!isset($plxAdmin->aGals[ $id ])) {
		$msg = 'Cette page galeria n\'existe pas ou n\'existe plus !';
		header('Location: galerie.php?msg='.urlencode($msg));
		exit;
	}
	# On récupère le contenu
	$content = trim($plxAdmin->getFileGaleria($id));
	$title = $plxAdmin->aGals[ $id ]['name'];
	$url = $plxAdmin->aGals[ $id ]['url'];
} else { # Sinon, on redirige
	header('Location: galerie.php');
	exit;
}

# On inclut le header
include('top.php');
?>

<h2>Изменение контентной части галереи «<?php echo htmlspecialchars($title,ENT_QUOTES,PLX_CHARSET); ?>»</h2>

<p><a href="<?php echo PLX_ROOT; ?>?galeria<?php echo intval($id); ?>/<?php echo $url; ?>">Просмотр галереи «<?php echo htmlspecialchars($title,ENT_QUOTES,PLX_CHARSET); ?>» на сайте</a></p>

<form action="galeria.php" method="post" id="change-gallery-content">
	<fieldset>
		<?php plxUtils::printInput('id', $id, 'hidden');?>
		<p class="field"><label>Код галереи:</label></p>
		<?php if ($plxAdmin->aConf['wysiwyg']==1) echo $wysiwyg_panel; ?>
		<?php plxUtils::printArea('content', htmlspecialchars($content,ENT_QUOTES,PLX_CHARSET),60,20) ?>
    	<p><input type="submit" value="Сохранить изменения"/></p>
	</fieldset>
</form>

<div class="help">
<h3>Какой язык программирования используется? </h3>
<p>Вы   можете использовать любой скриптовый язык или язык разметки (PHP, JavaScript, XHTML и т.д.) .. </p>
<h3>Об исходном коде</h3>
<p>Исходный код интерпретируется при загрузке страницы. Заголовки отправляются браузером в последнюю очередь. Поэтому можно играться с cookies, сессиями и т.д.</p>
</div>

<?php
# On inclut le footer
include('foot.php');
?>
