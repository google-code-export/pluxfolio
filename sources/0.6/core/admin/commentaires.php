<?php

/**
 * Listing des commentaires
 *
 * @package PLX
 * @author	Stephane F et Florent MONTHEL
 **/

include('prepend.php');

# On supprime notre commentaire
if(!empty($_GET['del']) AND isset($_GET['hash']) AND $_GET['hash'] == $_SESSION['hash']) {
	$msg = $plxAdmin->delCommentaire($_GET['del']);
	header('Location: commentaires.php?'.(isset($_GET['a'])?'a='.$_GET['a'].'&':'').'msg='.urlencode($msg));
	exit;
}
# On modère ou valide notre commentaire
if(!empty($_GET['mod']) AND isset($_GET['hash']) AND $_GET['hash'] == $_SESSION['hash']) {
	$msg = $plxAdmin->modCommentaire($_GET['mod']);
	header('Location: commentaires.php?'.(isset($_GET['a'])?'a='.$_GET['a'].'&':'').'msg='.urlencode($msg));
	exit;
}
# Commentaires d'un article, on check
if(!empty($_GET['a'])) {
	# Infos sur notre article
	$globArt = $plxAdmin->plxGlob_arts->query('/^'.$_GET['a'].'.(.*).xml$/','','sort',0,1);
	if(!$plxAdmin->plxGlob_arts->count) { # Article inexistant 
		$msg = 'L\'article demand&eacute n\'existe pas ou n\'existe plus';
		header('Location: ./?msg='.urlencode($msg));
		exit;
	}
	$aArt = $plxAdmin->parseArticle(PLX_ROOT.$plxAdmin->aConf['racine_articles'].$globArt['0']);
	$portee = 'article "'.plxUtils::strCut($aArt['title'],60).'"';
	$artId = $_GET['a'];
} else { # Commentaires globaux
	$portee = 'site entier';
	$artId = '[0-9]{4}';
}

# On inclut le header
include('top.php');
?>
	
<h2>Liste des commentaires en attente de validation (<?php echo $portee; ?>)</h2>

<table>
<thead>
	<tr>
		<th width="110">Date</th>
		<th width="100">Auteur</th>
		<th>Message</th>
		<th width="60">IP</th>		
		<th width="150">Action</th>
	</tr>
</thead>
<tbody>
	
<?php
# On va récupérer les commentaires en modération
$plxAdmin->getCommentaires('/^_'.$artId.'.(.*).xml$/','rsort',0,false,'all');
if($plxAdmin->plxGlob_coms->count AND $plxAdmin->plxRecord_coms->size) { # On a des commentaires
	while($plxAdmin->plxRecord_coms->loop()) { # On boucle
		$year = substr($plxAdmin->plxRecord_coms->f('date'),0,4);
		$month = substr($plxAdmin->plxRecord_coms->f('date'),5,2);
		$day = substr($plxAdmin->plxRecord_coms->f('date'),8,2);
		$time = substr($plxAdmin->plxRecord_coms->f('date'),11,8);
		$id = '_'.$plxAdmin->plxRecord_coms->f('article').'.'.$plxAdmin->plxRecord_coms->f('numero');
		# On génère notre ligne
		echo '<tr class="line-'.($plxAdmin->plxRecord_coms->i%2).'">';
		echo '<td>&nbsp;'.$day.'/'.$month.'/'.$year.' '.$time.'</td>';
		echo '<td>&nbsp;'.plxUtils::strCut($plxAdmin->plxRecord_coms->f('author'),15).'</td>';
		echo '<td>&nbsp;<a href="commentaire.php?c='.$id.'" title="Editer ce commentaire">'.plxUtils::strCut($plxAdmin->plxRecord_coms->f('content'),60).'</a></td>';
		echo '<td>&nbsp;'.$plxAdmin->plxRecord_coms->f('ip').'</td>';
		echo '<td> ';
		echo '<a href="commentaire.php?c='.$id.'" title="&Eacute;diter ce commentaire">&Eacute;diter</a> - ';
		if(!empty($_GET['a'])) { # Pour un article précis
			echo '<a href="commentaires.php?a='.$artId.'&mod='.$id.'&hash='.$_SESSION['hash'].'" title="Valider la publication de ce commentaire">Valider</a> - ';
			echo '<a href="commentaires.php?a='.$artId.'&del='.$id.'&hash='.$_SESSION['hash'].'" title="Supprimer ce commentaire" onclick="Check=confirm(\'Supprimer ce commentaire ?\');if(Check==false) return false;">Supprimer</a> ';
		} else {
			echo '<a href="commentaires.php?mod='.$id.'&hash='.$_SESSION['hash'].'" title="Valider la publication de ce commentaire">Valider</a> - ';
			echo '<a href="commentaires.php?del='.$id.'&hash='.$_SESSION['hash'].'" title="Supprimer ce commentaire" onclick="Check=confirm(\'Supprimer ce commentaire ?\');if(Check==false) return false;">Supprimer</a> ';
		}
		echo '</td></tr>';
	}
} else { # Pas de commentaires
	echo '<tr><td colspan="5" class="center">Aucun commentaire</td></tr>';
}
?>
</table>

<h2>Liste des commentaires publi&eacute;s (<?php echo $portee; ?>)</h2>

<table>
<thead>
	<tr>
		<th width="110">Date</th>
		<th width="100">Auteur</th>
		<th>Message</th>
		<th width="60">IP</th>		
		<th width="150">Action</th>
	</tr>
</thead>
<tbody>

<?php
# On va récupérer les commentaires publiés pour cette page
$plxAdmin->plxGlob_coms->count = NULL;
$plxAdmin->plxRecord_coms = NULL;
$plxAdmin->getPage();
$start = $plxAdmin->aConf['bypage_admin_coms']*($plxAdmin->page-1);
$plxAdmin->getCommentaires('/^'.$artId.'.(.*).xml$/','rsort',$start,$plxAdmin->aConf['bypage_admin_coms'],'all');
if($plxAdmin->plxGlob_coms->count AND $plxAdmin->plxRecord_coms->size) { # On a des commentaires
	while($plxAdmin->plxRecord_coms->loop()) { # On boucle
		$year = substr($plxAdmin->plxRecord_coms->f('date'),0,4);
		$month = substr($plxAdmin->plxRecord_coms->f('date'),5,2);
		$day = substr($plxAdmin->plxRecord_coms->f('date'),8,2);
		$time = substr($plxAdmin->plxRecord_coms->f('date'),11,8);
		$id = $plxAdmin->plxRecord_coms->f('article').'.'.$plxAdmin->plxRecord_coms->f('numero');
		# On génère notre ligne
		echo '<tr class="line-'.($plxAdmin->plxRecord_coms->i%2).'">';
		echo '<td>&nbsp;'.$day.'/'.$month.'/'.$year.' '.$time.'</td>';
		echo '<td>&nbsp;'.plxUtils::strCut($plxAdmin->plxRecord_coms->f('author'),15).'</td>';
		echo '<td>&nbsp;<a href="commentaire.php?c='.$id.'" title="&Eacute;diter ce commentaire">'.plxUtils::strCut($plxAdmin->plxRecord_coms->f('content'),60).'</a></td>';
		echo '<td>&nbsp;'.$plxAdmin->plxRecord_coms->f('ip').'</td>';
		echo '<td> ';
		echo '<a href="commentaire.php?c='.$id.'" title="&Eacute;diter ce commentaire">&Eacute;diter</a> - ';
		if(!empty($_GET['a'])) { # Pour un article précis
			echo '<a href="commentaires.php?a='.$artId.'&mod='.$id.'&hash='.$_SESSION['hash'].'" title="Mettre hors ligne ce commentaire">Mod&eacute;rer</a> - ';
			echo '<a href="commentaires.php?a='.$artId.'&del='.$id.'&hash='.$_SESSION['hash'].'" title="Supprimer ce commentaire" onclick="Check=confirm(\'Supprimer ce commentaire ?\');if(Check==false) return false;">Supprimer</a> ';
		} else {
			echo '<a href="commentaires.php?mod='.$id.'&hash='.$_SESSION['hash'].'" title="Mettre hors ligne ce commentaire">Mod&eacute;rer</a> - ';
			echo '<a href="commentaires.php?del='.$id.'&hash='.$_SESSION['hash'].'" title="Supprimer ce commentaire" onclick="Check=confirm(\'Supprimer ce commentaire ?\');if(Check==false) return false;">Supprimer</a> ';
		}
		echo '</td></tr>';
	}
} else { # Pas de commentaires
	echo '<tr><td colspan="5" class="center">Aucun commentaire</td></tr>';
}
?>
</table>

<div id="pagination">
<?php # Affichage de la pagination
if($plxAdmin->plxGlob_coms->count) { # Si on a des commentaires (hors page)
	# Calcul des pages
	$prev_page = $plxAdmin->page - 1;
	$next_page = $plxAdmin->page + 1;
	$last_page = ceil($plxAdmin->plxGlob_coms->count/$plxAdmin->aConf['bypage_admin_coms']);
	# Generation des URLs
	$p_url = 'commentaires.php?page'.$prev_page.(isset($_GET['a'])?'&amp;a='.$_GET['a']:''); # Page precedente
	$n_url = 'commentaires.php?page'.$next_page.(isset($_GET['a'])?'&amp;a='.$_GET['a']:''); # Page suivante
	$l_url = 'commentaires.php?page'.$last_page.(isset($_GET['a'])?'&amp;a='.$_GET['a']:''); # Derniere page
	$f_url = 'commentaires.php'.(isset($_GET['a'])?'?a='.$_GET['a']:''); # Premiere page
	# On effectue l'affichage
	if($plxAdmin->page > 2) # Si la page active > 2 on affiche un lien 1ere page
		echo '<a href="'.$f_url.'" title="Aller à la premi&egrave;re page">&lt;&lt;</a> | ';
	if($plxAdmin->page > 1) # Si la page active > 1 on affiche un lien page precedente
		echo '<a href="'.$p_url.'" title="Page pr&eacute;c&eacute;dente">&lt; pr&eacute;c&eacute;dente</a> | ';
	# Affichage de la page courante
	echo 'page '.$plxAdmin->page.' sur '.$last_page;
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