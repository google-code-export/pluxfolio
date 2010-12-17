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

# On inclut le header
include('top.php');
?>

<h2>Информация касающаяся работы движка</h2>

<p>В случае неисправности здесь можно посмотреть кое-что, что может пролить свет на причины оной. :)</p>

<ul>
	<li><strong>Версия движка : <?php echo $plxAdmin->version; ?> (кодировка <?php echo PLX_CHARSET; ?>)</strong></li>
	<li><?php plxUtils::testWrite(PLX_CONF); ?></li>
	<li><?php plxUtils::testWrite(PLX_ROOT.$plxAdmin->aConf['categories']); ?></li>
	<li><?php plxUtils::testWrite(PLX_ROOT.$plxAdmin->aConf['statiques']); ?></li>
	<li><?php plxUtils::testWrite(PLX_ROOT.$plxAdmin->aConf['passwords']); ?></li>
	<li><?php plxUtils::testWrite(PLX_ROOT.$plxAdmin->aConf['racine_articles']); ?></li>
	<li><?php plxUtils::testWrite(PLX_ROOT.$plxAdmin->aConf['racine_statiques']); ?></li>
	<li>Кол-во категорий : <?php echo count($plxAdmin->aCats); ?></li>
	<li>Кол-во страниц : <?php echo count($plxAdmin->aStats); ?></li>
	<li>Вы вошли в админку как : <?php echo $_SESSION['author']; ?></li>
</ul>

<ul>
	<li>Ваша версия PHP : <?php echo phpversion(); ?></li>
	<li>Настройки "magic quotes" : <?php echo get_magic_quotes_gpc(); ?></li>
</ul>

<?php
# On inclut le footer
include('foot.php');
?>