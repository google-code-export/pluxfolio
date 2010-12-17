<?php

/**
 * Page pour vérifier la version officielle
 *
 * @package PLX
 * @author	Florent MONTHEL
 **/

include('prepend.php');

# Contrôle du hash
if(isset($_GET['hash']) AND $_GET['hash'] == $_SESSION['hash'])
	$_GET['msg'] = $plxAdmin->checkMaj().' - <a href="parametres_base.php" title="Retour &agrave; la configuration de base">retour</a>';
else
	$_GET['msg'] = 'Variable de s&eacute;curit&eacute; invalide !';

# Inclusion du header et du footer
include('top.php');
include('foot.php');
?>