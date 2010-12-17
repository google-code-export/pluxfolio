<?php

/**
 * Edition des paramètres avancés
 *
 * @package PLX
 * @author	Florent MONTHEL
 **/

include('prepend.php');

# On édite la configuration
if(!empty($_POST)) {
	$msg = $plxAdmin->editConfiguration($plxAdmin->aConf,plxUtils::unSlash($_POST));
	header('Location: parametres_avances.php?msg='.urlencode($msg));
	exit;
}

# On inclut le header
include('top.php');
?>

<h2>Архитектура движка</h2>

<form action="parametres_avances.php" method="post" id="change-cf-file">
	<fieldset class="withlabel">
		<legend>Конфигурация путей до папок и файлов архитектуры движка :</legend>
		<p class="field"><label>Папка для сохранения картинок:</label></p>
		<?php plxUtils::printInput('images', $plxAdmin->aConf['images']); ?>
		<p class="field"><label>Папка для сохранения файлов:</label></p>
		<?php plxUtils::printInput('documents', $plxAdmin->aConf['documents']); ?>
		<p class="field"><label>Папка для хранения новостей:</label></p>
		<?php plxUtils::printInput('racine_articles', $plxAdmin->aConf['racine_articles']); ?>
		<p class="field"><label>Папка для хранения страниц сайта:</label></p>
		<?php plxUtils::printInput('racine_statiques', $plxAdmin->aConf['racine_statiques']); ?>
		<p class="field"><label>Категории новостей пишутся в документ:</label></p>
		<?php plxUtils::printInput('categories', $plxAdmin->aConf['categories']); ?>
		<p class="field"><label>Названия страниц сайта пишутся в документ:</label></p>
		<?php plxUtils::printInput('statiques', $plxAdmin->aConf['statiques']); ?>
		<p class="field"><label>Пароли и явки сохраняются в документ:</label></p>
		<?php plxUtils::printInput('passwords', $plxAdmin->aConf['passwords']); ?>
	</fieldset>
	<p><input type="submit" value="Изменить архитектуру движка" /></p>
</form>

<?php
# On inclut le footer
include('foot.php');
?>