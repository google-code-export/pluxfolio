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
	$plxAdmin->editConfiguration($plxAdmin->aConf,plxUtils::unSlash($_POST));
	header('Location: parametres_affichage.php');
	exit;
}

# On inclut le header
include('top.php');

# On récupère les templates
$tpl = new plxGlob(PLX_ROOT.'themes', true);
$a_style = $tpl->query('/[a-z0-9-_]+/');
foreach($a_style as $k=>$v)
	$b_style[ $v ] = $v;

# Tableau du tri
$aTri = array('desc'=>$ADM_sortby_desc, 'asc'=>$ADM_sortby_asc);

//Список страницы для главной
$arr_index[0] = $SITE_headermenu_firstnews;
foreach ($plxAdmin->aGals as $key=>$val)
	$arr_index[$key] = $val['name'];

//Выбор вывода категорий
$categ[0] = $ADM_contentsettings_catliststatic;
$categ[1] = $ADM_contentsettings_catlistcollapsable;

//Показывать или нет счетчик работ
$counter[0] = $ADM_no;
$counter[1] = $ADM_yes;

//Свежесть картинок
$freshtime[604800] = $ADM_week;
$freshtime[1296000] = $ADM_fifteendays;
$freshtime[2592000] = $ADM_month;
?>

<h2><?php echo $ADM_contentsettings_title; ?></h2>

<form action="parametres_affichage.php" method="post" id="change-cf-file">
	<fieldset class="withlabel">
		<legend><?php echo $ADM_contentsettings_legend; ?>:</legend>
		<p class="field"><label><?php echo $ADM_contentsettings_frontdisplay; ?>:</label></p>
		<?php plxUtils::printSelect('index_get', $arr_index, $plxAdmin->aConf['index_get']); ?>
		<p class="field"><label><?php echo $ADM_contentsettings_sitetemplate; ?>:</label></p>
		<?php plxUtils::printSelect('style', $b_style, $plxAdmin->aConf['style']); ?>
		<p class="field"><label><?php echo $ADM_contentsettings_articlesort; ?>:</label></p>
		<?php plxUtils::printSelect('tri', $aTri, $plxAdmin->aConf['tri']); ?>
		<p class="field"><label><?php echo $ADM_contentsettings_catlistcollapse; ?>:</label></p>
		<?php plxUtils::printSelect('categ_get', $categ, $plxAdmin->aConf['categ_get']); ?>
		<p class="field"><label><?php echo $ADM_contentsettings_displaycounter; ?>?</label></p>
		<?php plxUtils::printSelect('counter_enabled', $counter, $plxAdmin->aConf['counter_enabled']); ?>
		<p class="field"><label><?php echo $ADM_contentsettings_enableimgsets; ?>?</label></p>
		<?php plxUtils::printSelect('images_sets', $counter, $plxAdmin->aConf['images_sets']); ?>
		<p class="field"><label><?php echo $ADM_contentsettings_enablefreshness; ?>?</label></p>
		<?php plxUtils::printSelect('freshness', $counter, $plxAdmin->aConf['freshness']); ?>
		<?php if ($plxAdmin->aConf['freshness']==1) { ?>		
		<p class="field"><label><?php echo $ADM_contentsettings_freshnesstime; ?>:</label></p>
		<?php plxUtils::printSelect('freshnesstime', $freshtime, $plxAdmin->aConf['freshnesstime']); ?>
		<?php }; ?>
		<p class="field"><label><?php echo $ADM_twitter_translation; ?>:</label></p>
		<?php plxUtils::printInput('twitter', $plxAdmin->aConf['twitter'], 'text', '10-255'); echo '<i>'.$ADM_twitter_translationhelp.'</i>'; ?>
		<p class="field"><label><?php echo $ADM_contentsettings_articlesperpage; ?>:</label></p>
		<?php plxUtils::printInput('bypage', $plxAdmin->aConf['bypage'], 'text', '10-10'); ?>
		<?php if ($plxAdmin->aConf['admin_conf']==0) { ?>
		<p class="field"><label><?php echo $ADM_contentsettings_articlesperadminpage; ?>:</label></p>
		<?php plxUtils::printInput('bypage_admin', $plxAdmin->aConf['bypage_admin'], 'text', '10-10'); ?>
		<p class="field"><label><?php echo $ADM_contentsettings_articlesperatom; ?>:</label></p>
		<?php plxUtils::printInput('bypage_feed', $plxAdmin->aConf['bypage_feed'], 'text', '10-10'); ?>
		<p class="field"><label><?php echo $ADM_contentsettings_thumbssizes; ?>:</label></p>
		<?php echo $ADM_contentsettings_thumbwidth; ?><?php plxUtils::printInput('twidth', $plxAdmin->twidth, $type='text', $size='10-4'); ?>
		<?php echo $ADM_contentsettings_thumbheight; ?><?php plxUtils::printInput('theight', $plxAdmin->theight, $type='text', $size='10-4'); ?>
		<?php }; ?>
		
	</fieldset>
	<p><input type="submit" value="<?php echo $ADM_savechanges; ?>" /></p>
</form>

<?php
# On inclut le footer
include('foot.php');
?>
