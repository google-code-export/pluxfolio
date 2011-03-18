<?php

/**
 * Edition d'un commentaire
 *
 * @package PLX
 * @author	Stephane F et Florent MONTHEL
 **/

include('prepend.php');

# On édite, supprime ou valide notre commentaire
if(!empty($_POST)) {
	if(isset($_POST['delete'])) { # Suppression, on redirige
		header('Location: commentaires.php?del='.$_POST['comId'].'&hash='.$_SESSION['hash']);
		exit;
	}
	if(isset($_POST['mod'])) { # Modération ou validation
		$msg = $plxAdmin->modCommentaire($_POST['comId']);
		header('Location: commentaire.php?c='.$_POST['comId'].'&msg='.urlencode($msg));
		exit;
	}
	$msg = $plxAdmin->editCommentaire(plxUtils::unSlash($_POST),$_POST['comId']);
	header('Location: commentaire.php?c='.$_POST['comId'].'&msg='.urlencode($msg));
	exit;
}

# Variable non initialisée
if(empty($_GET['c'])) {
	header('Location: commentaires.php');
	exit;
}

# On va récupérer les infos sur le commentaire
$plxAdmin->getCommentaires('/^'.$_GET['c'].'.xml$/',0,1);
if(!$plxAdmin->plxGlob_coms->count OR !$plxAdmin->plxRecord_coms->size) { # Commentaire inexistant
	$msg = 'Le commentaire demand&eacute; n\'existe pas ou n\'existe plus !';
	header('Location: commentaires.php?msg='.urlencode($msg));
	exit;
}

# On inclut le header
include('top.php');
?>

<h2>Edition d'un commentaire</h2>

<ul>
	<li>Auteur : <?php echo $plxAdmin->plxRecord_coms->f('author'); ?></li>
	<li>Date : <?php echo plxUtils::dateIsoToHum($plxAdmin->plxRecord_coms->f('date')).' &agrave; '. plxUtils::heureIsoToHum($plxAdmin->plxRecord_coms->f('date')); ?></li>
	<li>Ip : <?php echo $plxAdmin->plxRecord_coms->f('ip'); ?></li>
	<li>Site : <?php echo '<a href="'.$plxAdmin->plxRecord_coms->f('site').'">'.$plxAdmin->plxRecord_coms->f('site').'</a>'; ?></li>
	<li>E-mail : <?php echo $plxAdmin->plxRecord_coms->f('mail'); ?></li>
	<li>Statut : <?php echo (preg_match('/^_/',$_GET['c']))?'hors ligne':'en ligne'; ?>
</ul>

<form action="commentaire.php" method="post" id="change-com-content">
	<fieldset>
		<?php plxUtils::printInput('comId',$_GET['c'],'hidden'); ?>
		<p class="field"><label>Commentaire&nbsp;:</label></p>
		<?php plxUtils::printArea('content',$plxAdmin->plxRecord_coms->f('content'), 60, 7); ?>
		<p>
			<input type="submit" name="update" value="Mettre &agrave; jour" /> 
			<?php if(preg_match('/^_/',$_GET['c'])) { ?>
				<input type="submit" name="mod" value="Valider la publication" /> 
			<?php } else { ?>
				<input type="submit" name="mod" value="Mettre hors ligne" /> 
			<?php } ?>
			<input type="submit" name="delete" value="Supprimer" onclick="Check=confirm('Supprimer ce commentaire ?');if(Check==false) return false;"/>
		</p>
	</fieldset>
</form>

<?php
# On inclut le footer
include('foot.php');
?>