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

<h2><?php echo $ADM_galedit_title; ?> «<?php echo htmlspecialchars($title,ENT_QUOTES,PLX_CHARSET); ?>»</h2>

<p><a href="<?php echo PLX_ROOT; ?>?galeria<?php echo intval($id); ?>/<?php echo $url; ?>"><?php echo $ADM_preview;?> «<?php echo htmlspecialchars($title,ENT_QUOTES,PLX_CHARSET); ?>»</a></p>

<form action="galeria.php" method="post" id="change-gallery-content">
	<fieldset>
		<?php plxUtils::printInput('id', $id, 'hidden');?>
		<p class="field"><label><?php echo $ADM_galsourcecode; ?></label></p>
		<?php if ($plxAdmin->aConf['wysiwyg']==1) echo $wysiwyg_panel; ?>
		<?php plxUtils::printArea('content', htmlspecialchars($content,ENT_QUOTES,PLX_CHARSET),60,20) ?>
    	<p><input type="submit" value="<?php echo $ADM_savechanges; ?>"/></p>
	</fieldset>
</form>

<div class="help">
<?php echo $ADM_galedit_help;?>
</div>

<?php
# On inclut le footer
include('foot.php');
?>
