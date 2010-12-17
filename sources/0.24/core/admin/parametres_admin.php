<?php

/**
 * Edition des paramètres de base
 *
 * @package PLX
 * @author	Florent MONTHEL
 **/

include('prepend.php');

# On édite la configuration
if(!empty($_POST)) {
	$msg = $plxAdmin->editConfiguration($plxAdmin->aConf,plxUtils::unSlash($_POST));
	header('Location: parametres_admin.php?msg='.urlencode($msg));
	exit;
}

# Tableau du delta
for($i=-12;$i < 14; $i++)
	$delta[ plxUtils::formatRelatif($i,2).':00' ] = plxUtils::formatRelatif($i,2).':00';

# On inclut le header
include('top.php');

# WYSIWYG
$wysiwyg[0] = 'Нет, спасибо';
$wysiwyg[1] = 'Будьте любезны';


$admin_conf[0] = 'Расширенный';
$admin_conf[1] = 'Упрощенный';

?>

<h2>Изменение настроек админки</h2>

<form action="parametres_admin.php" method="post" id="change-cf-file">
	<fieldset class="withlabel">
		<legend>Настройки админки:</legend>	
		<p class="field"><label>Режим админки:</label></p>
		<?php plxUtils::printSelect('admin_conf', $admin_conf, $plxAdmin->aConf['admin_conf']); ?>
		<p class="field"><label>Показывать панельку инструментов у полей новостей и страниц?</label></p>
		<?php plxUtils::printSelect('wysiwyg', $wysiwyg, $plxAdmin->aConf['wysiwyg']); ?>
	</fieldset>
	<p><input type="submit" value="Изменить настройки админки" /></p>
</form>

<?php
# On inclut le footer
include('foot.php');
?>
