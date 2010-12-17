<?php

/**
 * Edition des paramètres d'affichage
 *
 * @package PLX
 * @author	Florent MONTHEL
 **/

include('prepend.php');

# On édite la configuration
if(!empty($_POST)) {
	$msg = $plxAdmin->editConfiguration($plxAdmin->aConf,plxUtils::unSlash($_POST));
	header('Location: parametres_affichage.php?msg='.urlencode($msg));
	exit;
}

# On récupère les templates
$tpl = new plxGlob(PLX_ROOT.'themes', true);
$a_style = $tpl->query('/[a-z0-9-_]+/');
foreach($a_style as $k=>$v)
	$b_style[ $v ] = $v;

# Tableau du tri
$aTri = array('desc'=>'по убыванию', 'asc'=>'по возрастанию');

//Список страницы для главной
$arr_index[0] = 'Новости';
foreach ($plxAdmin->aGals as $key=>$val)
	$arr_index[$key] = $val['name'];

//Выбор вывода категорий
$categ[0] = 'Статичным';
$categ[1] = 'Скрываемым';

# On inclut le header
include('top.php');
?>

<h2>Изменение настроек вывода контента</h2>

<form action="parametres_affichage.php" method="post" id="change-cf-file">
	<fieldset class="withlabel">
		<legend>Визуализация контента :</legend>
		<p class="field"><label>Выводить на главной:</label></p>
		<?php plxUtils::printSelect('index_get', $arr_index, $plxAdmin->aConf['index_get']); ?>
		<p class="field"><label>Шаблон сайта:</label></p>
		<?php plxUtils::printSelect('style', $b_style, $plxAdmin->aConf['style']); ?>
		<p class="field"><label>Порядок вывода новостей :</label></p>
		<?php plxUtils::printSelect('tri', $aTri, $plxAdmin->aConf['tri']); ?>
		<p class="field"><label>Выводить список категорий сайта:</label></p>
		<?php plxUtils::printSelect('categ_get', $categ, $plxAdmin->aConf['categ_get']); ?>
		<p class="field"><label>Кол-во новостей на странице:</label></p>
		<?php plxUtils::printInput('bypage', $plxAdmin->aConf['bypage'], 'text', '10-10'); ?>
		<?php if ($plxAdmin->aConf['admin_conf']==0) { ?>
		<p class="field"><label>Кол-во новостей на странице в админке:</label></p>
		<?php plxUtils::printInput('bypage_admin', $plxAdmin->aConf['bypage_admin'], 'text', '10-10'); ?>
		<p class="field"><label>Кол-во новостей при выводе в режиме Атом:</label></p>
		<?php plxUtils::printInput('bypage_feed', $plxAdmin->aConf['bypage_feed'], 'text', '10-10'); ?>
		<p class="field"><label>Размеры миниатюр:</label></p>
		Ширина<?php plxUtils::printInput('twidth', $plxAdmin->twidth, $type='text', $size='10-4'); ?>
		Высота<?php plxUtils::printInput('theight', $plxAdmin->theight, $type='text', $size='10-4'); ?>
		<?php }; ?>
		
	</fieldset>
	<p><input type="submit" value="Изменить настройки контента" /></p>
</form>

<?php
# On inclut le footer
include('foot.php');
?>
