<?php
# ------------------ BEGIN LICENSE BLOCK ------------------
#
# This file is part of Pluxml.
#
# Copyright (c) 2008 Florent MONTHEL and contributors
# Copyright (c) 2006-2008 Anthony GUERIN
# Licensed under the GPL license.
# See http://www.gnu.org/licenses/gpl.html
#
# ------------------- END LICENSE BLOCK -------------------

# Configuration avançée #
define('PLX_ROOT', './');
define('PLX_CORE', PLX_ROOT.'core/');
define('PLX_CONF', PLX_ROOT.'data/configuration/parametres.xml');

# On verifie que Pluxml est installé
if(!file_exists(PLX_CONF)) {
	header('Location: '.PLX_ROOT.'install.php');
	exit;
}

# On inclut les librairies nécessaires
include_once(PLX_ROOT.'config.php');
include_once(PLX_CORE.'lib/class.plx.utils.php');
include_once(PLX_CORE.'lib/class.plx.glob.php');
include_once(PLX_CORE.'lib/class.plx.record.php');
include_once(PLX_CORE.'lib/class.plx.motor.php');
include_once(PLX_CORE.'lib/class.plx.feed.php');

# Creation de l'objet principal et lancement du traitement
$plxFeed = & new plxFeed(PLX_CONF);
$plxFeed->prechauffage();
$plxFeed->demarrage();
?>