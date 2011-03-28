<?php

/**
 * Edition du code source d'une page statique
 *
 * @package PLX
 * @author	Stephane F. et Florent MONTHEL
 **/
 
include('prepend.php');
include('wysiwyg.php');

# On édite la page statique
if(!empty($_POST) AND isset($plxAdmin->aStats[ $_POST['id'] ])) {
	$plxAdmin->editFileStatique(plxUtils::unSlash($_POST));
	header('Location: statique.php?p='.$_POST['id']);
	exit;
} elseif(!empty($_GET['p'])) { # On affiche le contenu de la page
	$id = $_GET['p'];
	if(!isset($plxAdmin->aStats[ $id ])) {
		header('Location: statiques.php');
		exit;
	}
	# On récupère le contenu
	$content = trim($plxAdmin->getFileStatique($id));
	$title = $plxAdmin->aStats[ $id ]['name'];
	$url = $plxAdmin->aStats[ $id ]['url'];
} else { # Sinon, on redirige
	header('Location: statiques.php');
	exit;
}

# On inclut le header
include('top.php');
?>

<h2><?php echo $ADM_staticedit_title; ?> "<?php echo htmlspecialchars($title,ENT_QUOTES,PLX_CHARSET); ?>"</h2>

<p><a href="<?php echo PLX_ROOT; ?>?static<?php echo intval($id); ?>/<?php echo $url; ?>"><?php echo $ADM_newarticle_preview; ?> «<?php echo htmlspecialchars($title,ENT_QUOTES,PLX_CHARSET); ?>»</a></p>

<form action="statique.php" method="post" id="change-static-content">
	<fieldset>
		<?php plxUtils::printInput('id', $id, 'hidden');?>
		<p class="field"><label><?php echo $ADM_pagesourcecode; ?>:</label></p>
		<?php if ($plxAdmin->aConf['wysiwyg']==1) echo $wysiwyg_panel; ?>
		<?php plxUtils::printArea('content', htmlspecialchars($content,ENT_QUOTES,PLX_CHARSET),60,20) ?>
    	<p><input type="submit" value="<?php echo $ADM_savechanges; ?>"/></p>
	</fieldset>
</form>

<div class="help">
<?php echo $ADM_galedit_help; ?>
</div>

<?php
# On inclut le footer
include('foot.php');
?>
