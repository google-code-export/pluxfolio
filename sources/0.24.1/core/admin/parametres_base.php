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
	header('Location: parametres_base.php?msg='.urlencode($msg));
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

?>

<h2>Изменение базовых настроек</h2>

<form action="parametres_base.php" method="post" id="change-cf-file">
	<fieldset class="withlabel">
		<legend>Базовые настройки :</legend>	
		<p class="field"><label>Название сайта</label></p>
		<?php plxUtils::printInput('title', htmlspecialchars($plxAdmin->aConf['title'],ENT_QUOTES,PLX_CHARSET)); ?>
		<p class="field"><label>Описание сайта</label></p>
		<?php plxUtils::printInput('description', htmlspecialchars($plxAdmin->aConf['description'],ENT_QUOTES,PLX_CHARSET)); ?>
		<p class="field"><label>Краткое определение — что такое ваш сайт</label></p>
		<?php plxUtils::printArea('intro', htmlspecialchars($plxAdmin->aConf['intro'],ENT_QUOTES,PLX_CHARSET)); ?>
		<?php if ($plxAdmin->aConf['admin_conf']==0) { ?>
		<p class="field"><label>Точный адрес сайта (ex : http://test1.ru/portfolio)&nbsp;:</label></p>
		<?php plxUtils::printInput('racine', $plxAdmin->aConf['racine']);?>
		<p class="field"><label>Часовой пояс (по Гринвичу)</label></p>
		<?php plxUtils::printSelect('delta', $delta, $plxAdmin->aConf['delta']); ?>
		<?php }; ?>
	</fieldset>
	<p><input type="submit" value="Изменить базовые настройки" /></p>
</form>

<?php
# On inclut le footer
include('foot.php');
?>
