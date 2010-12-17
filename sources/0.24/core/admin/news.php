<?php

/**
 * Listing des articles
 *
 * @package PLX
 * @author	Stephane F et Florent MONTHEL
 **/

include('prepend.php');

# On a une suppression d'article
if(!empty($_GET['del']) AND isset($_GET['hash']) AND $_GET['hash'] == $_SESSION['hash']) {
	$msg = $plxAdmin->delArticle($_GET['del']);
	header('Location: ./news.php?&msg='.urlencode($msg));
	exit;
}

# Check des variables GET pour la recherche
$_GET['catId'] = (!empty($_GET['catId']))?plxUtils::unSlash(trim($_GET['catId'])):'';
$_GET['artTitle'] = (!empty($_GET['artTitle']))?plxUtils::unSlash(trim($_GET['artTitle'])):'';
# On génère notre motif de recherche
if($_GET['catId'] != '')
	$motif = '/^[0-9]{4}.'.$_GET['catId'].'.([0-9]{12}).(.*)'.plxUtils::title2filename($_GET['artTitle']).'(.*).xml$/';
else
	$motif = '/^[0-9]{4}.([0-9]{3}|home|draft).([0-9]{12}).(.*)'.plxUtils::title2filename($_GET['artTitle']).'(.*).xml$/';

# Traitement
$plxAdmin->prechauffage('admin', $motif, $plxAdmin->aConf['bypage_admin']);
$plxAdmin->getPage(); # Recuperation de la page
$plxAdmin->getFiles('all'); # Recuperation des fichiers
$plxAdmin->getArticles(); # Recuperation des articles

# Génération de notre tableau des catégories
if($plxAdmin->aCats) {
	foreach($plxAdmin->aCats as $k=>$v)
		$aCat[$k] = htmlspecialchars($v['name'],ENT_QUOTES,PLX_CHARSET);
	$aAllCat['Cat&eacute;gories'] = $aCat;
}
$aAllCat['Emplacements sp&eacute;cifiques']['home'] = 'актуальное';
$aAllCat['Emplacements sp&eacute;cifiques']['draft'] = 'драфты';
$aAllCat['Emplacements sp&eacute;cifiques'][''] = 'все статьи';	

# On inclut le header
include('top.php');
?>

<h2>Список новостных статей</h2>

<form action="./" method="get" id="selection">
	<fieldset class="withlabel">
		<legend>Фильтровать список :</legend>
		<p class="center">Название новости: <?php plxUtils::printInput('artTitle',htmlspecialchars($_GET['artTitle'],ENT_QUOTES,PLX_CHARSET),'text','30-50'); ?> 
		В категории: <?php plxUtils::printSelect('catId', $aAllCat, $_GET['catId']); ?> 
		<input type="submit" value="Выборка" /></p>
	</fieldset>
</form>

<table cellspacing="0">
<thead>
	<tr>
		<th class="tc1">Дата</th>
		<th class="tc2">Название</th>
		<th class="tc1">Категория</th>
		<!--<th class="tc1">Автор</th>-->			
		<th class="tc1">Действия</th>
	</tr>
</thead>
<tbody>

<?php
# On va lister les articles
if($plxAdmin->plxGlob_arts->count AND $plxAdmin->plxRecord_arts->size) { # On a des articles
	while ($plxAdmin->plxRecord_arts->loop()) { # Pour chaque article
		# Date
		$year = substr($plxAdmin->plxRecord_arts->f('date'), 0, 4);
		$month = substr($plxAdmin->plxRecord_arts->f('date'), 5, 2);
		$day = substr($plxAdmin->plxRecord_arts->f('date'), 8, 2);
		$publi = ($plxAdmin->plxRecord_arts->f('date') > plxUtils::timestampToIso(time(),$plxAdmin->aConf['delta']))?false:true;
		# Catégorie
		if($plxAdmin->plxRecord_arts->f('categorie') == 'home')
			$catName = 'Page d\'accueil';
		elseif($plxAdmin->plxRecord_arts->f('categorie') == 'draft')
			$catName = 'Brouillons';
		elseif(!isset($plxAdmin->aCats[ $plxAdmin->plxRecord_arts->f('categorie') ]))
			$catName = 'Non class&eacute;';
		else
			$catName = htmlspecialchars($plxAdmin->aCats[$plxAdmin->plxRecord_arts->f('categorie')]['name'],ENT_QUOTES,PLX_CHARSET);
		# On affiche la ligne
		echo '<tr class="line-'.($plxAdmin->plxRecord_arts->i%2).'">';
		echo '<td class="tc1">&nbsp;'.$day.'/'.$month.'/'.$year.'</td>';	
		echo '<td class="tc2">&nbsp;<a href="article.php?a='.$plxAdmin->plxRecord_arts->f('numero').'" title="Заголовок новости">'.plxUtils::strCut(htmlspecialchars($plxAdmin->plxRecord_arts->f('title'),ENT_QUOTES,PLX_CHARSET),60).'</a></td>';
		echo '<td class="tc1">&nbsp;'.$catName.'</td>';
		//echo '<td class="tc1">&nbsp;'.htmlspecialchars($plxAdmin->plxRecord_arts->f('author'),ENT_QUOTES,PLX_CHARSET).'</td>';
		echo '<td class="tc1">&nbsp;';
		if($publi) # Si l'article est publié
			echo '<a href="'.PLX_ROOT.'?article'.intval($plxAdmin->plxRecord_arts->f('numero')).'/'.$plxAdmin->plxRecord_arts->f('url').'" title="Просмотреть новость">Посмотреть</a> - ';
		echo '<a href="article.php?a='.$plxAdmin->plxRecord_arts->f('numero').'" title="Изменить новость">Изменить</a> - ';
echo '<a href="news.php?del='.$plxAdmin->plxRecord_arts->f('numero').'&amp;hash='.$_SESSION['hash'].'" onclick="Check=confirm(\'удалить запись ?\');if(Check==false) return false;" title="Удаление новости">Удалить</a></td></tr>';

	}
} else { # Pas d'article
	echo '<tr><td colspan="6" class="center">На сайте нет ничего новенького. Ай-яй-яй.</td></tr>';
}
?>

</tbody>
</table>

<div id="pagination">
<?php # Affichage de la pagination
if($plxAdmin->plxGlob_arts->count) { # Si on a des articles (hors page)
	# Calcul des pages
	$prev_page = $plxAdmin->page - 1;
	$next_page = $plxAdmin->page + 1;
	$last_page = ceil($plxAdmin->plxGlob_arts->count/$plxAdmin->bypage);
	# Generation des URLs
	$p_url = './?page'.$prev_page.'&amp;catId='.urlencode($_GET['catId']).'&amp;artTitle='.urlencode($_GET['artTitle']); # Page precedente
	$n_url = './?page'.$next_page.'&amp;catId='.urlencode($_GET['catId']).'&amp;artTitle='.urlencode($_GET['artTitle']); # Page suivante
	$l_url = './?page'.$last_page.'&amp;catId='.urlencode($_GET['catId']).'&amp;artTitle='.urlencode($_GET['artTitle']); # Derniere page
	$f_url = './?catId='.urlencode($_GET['catId']).'&amp;artTitle='.urlencode($_GET['artTitle']); # Premiere page
	# On effectue l'affichage
	if($plxAdmin->page > 2) # Si la page active > 2 on affiche un lien 1ere page
		echo '<a href="'.$f_url.'" title="Aller à la premi&egrave;re page">&lt;&lt;</a> | ';
	if($plxAdmin->page > 1) # Si la page active > 1 on affiche un lien page precedente
		echo '<a href="'.$p_url.'" title="Page pr&eacute;c&eacute;dente">&lt; pr&eacute;c&eacute;dente</a> | ';
	# Affichage de la page courante
	echo 'Страница '.$plxAdmin->page.' из '.$last_page;
	if($plxAdmin->page < $last_page) # Si la page active < derniere page on affiche un lien page suivante
		echo ' | <a href="'.$n_url.'" title="Page suivante">suivante &gt;</a>';
	if(($plxAdmin->page + 1) < $last_page) # Si la page active++ < derniere page on affiche un lien derniere page
		echo ' | <a href="'.$l_url.'" title="Aller à la derni&egrave;re page">&gt;&gt;</a>';
} ?>
</div>

<?php
# On inclut le footer
include('foot.php');
?>
