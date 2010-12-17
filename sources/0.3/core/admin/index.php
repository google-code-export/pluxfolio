<?php

/**
 * Edition des pages galerie
 *
 * @package PLX
 * @author	Stephane F et Florent MONTHEL
 **/

include('prepend.php');

# On édite les pages galerie
if(!empty($_POST)) {
	$msg = $plxAdmin->editGalerie(plxUtils::unSlash($_POST));
	header('Location: galerie.php?msg='.urlencode($msg));
	exit;
}

# On inclut le header	
include('top.php');
?>

<h2><?php echo $ADM_gal_title; ?></h2>
<form action="galerie.php" method="post" id="change-galerie-file">
	<fieldset>
		<table>
			<tr>
				<td><strong>ID</strong>&nbsp;:</td>
				<td><strong><?php echo $ADM_gal_galname; ?></strong>&nbsp;:</td>
				<td><strong>URL</strong>&nbsp;:</td>
				<td><strong><?php echo $ADM_gal_isactive; ?></strong>&nbsp;:</td>
				<td><strong><?php echo $ADM_gal_order; ?></strong>&nbsp;:</td>
				<td>&nbsp;</td>
			</tr>
		<?php
		# Initialisation de l'ordre
		$num = 0;
		# Si on a des pages galerie
		if($plxAdmin->aGals) {
			foreach($plxAdmin->aGals as $k=>$v) { # Pour chaque page galeria
				echo '<tr><td><label>№ '.$k.'</label></td><td>';
				plxUtils::printInput($k, htmlspecialchars($v['name'],ENT_QUOTES,PLX_CHARSET), 'text', '25-50');
				echo '</td><td>';
				plxUtils::printInput($k.'_url', $v['url'], 'text', '25-50');
				echo '</td><td>';
				plxUtils::printSelect($k.'_active', array('1'=>$ADM_yes,'0'=>$ADM_no), $v['active']);
				echo '</td><td>';	
				plxUtils::printInput($k.'_ordre', ++$num, 'text', '3-3');
				echo '</td><td>';
				echo '<a href="galeria.php?p='.$k.'" title="изменить галерею">'.$ADM_gal_editgallery.'</a>';
				echo '</td></tr>';
			}
			# On récupère le dernier identifiant
			$a = array_keys($plxAdmin->aGals);
			rsort($a);	
		} else {
			$a['0'] = 0;
		}
		?>
		<tr>
		<td><?php echo $ADM_gal_newgallery; ?></td><td>
		<?php
		plxUtils::printInput(str_pad($a['0']+1, 3, '0', STR_PAD_LEFT), '', 'text', '25-50');
		echo '</td><td></td><td>';
		plxUtils::printSelect(str_pad($a['0']+1, 3, '0', STR_PAD_LEFT).'_active', array('1'=>$ADM_yes,'0'=>$ADM_no), '1');
		echo '</td><td>';
		plxUtils::printInput(str_pad($a['0']+1, 3, '0', STR_PAD_LEFT).'_ordre', ++$num, 'text', '3-3');
		echo '</td></tr>';
		?>
		</table>
		<p><input type="submit" value="<?php echo $ADM_savechanges; ?>" /></p>
	</fieldset>
</form>

<?php if ($plxAdmin->aConf['admin_conf']==0) { ?>
<div class="help">
<?php echo $ADM_gal_help; ?>
</div>
<?php }; ?>

<?php
# On inclut le footer
include('foot.php');
?>
