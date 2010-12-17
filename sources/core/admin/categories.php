<?php

/**
 * Edition des catégories
 *
 * @package PLX
 * @author	Stephane F et Florent MONTHEL
 **/

include('prepend.php');

# On édite les catégories
if(!empty($_POST)) {
	$msg = $plxAdmin->editCategories(plxUtils::unSlash($_POST));
	header('Location: categories.php?msg='.urlencode($msg));
	exit;
}

# Tableau du tri
$aTri = array('desc'=>'по убыванию', 'asc'=>'по возрастанию');

# On inclut le header	
include('top.php');
?>

<h2>Создание и изменение категорий новостей</h2>
<form action="categories.php" method="post" id="change-cat-file">
	<fieldset>
		<table>
			<tr>
				<td><strong>ID</strong>&nbsp;:</td>
				<td><strong>Название категории</strong>&nbsp;:</td>
				<td><strong>URL</strong>&nbsp;:</td>
				<td><strong>Сортировка</strong>&nbsp;:</td>
				<td><strong>Новостей на страницу</strong>&nbsp;:</td>				
				<td><strong>Порядок сортировки</strong>&nbsp;:</td>
			</tr>
		<?php
		# Initialisation de l'ordre
		$num = 0;
		# Si on a des catégories
		if($plxAdmin->aCats) {
			foreach($plxAdmin->aCats as $k=>$v) { # Pour chaque catégorie
				echo '<tr><td><label>№ '.$k.'</label></td><td>';		
				plxUtils::printInput($k, htmlspecialchars($v['name'],ENT_QUOTES,PLX_CHARSET), 'text', '20-50');
				echo '</td><td>';
				plxUtils::printInput($k.'_url', $v['url'], 'text', '20-50');
				echo '</td><td>';	
				plxUtils::printSelect($k.'_tri', $aTri, $v['tri']);
				echo '</td><td>';
				plxUtils::printInput($k.'_bypage', $v['bypage'], 'text', '4-3');
				echo '</td><td>';
				plxUtils::printInput($k.'_ordre', ++$num, 'text', '3-3');
				echo '</td></tr>';
			}
			# On récupère le dernier identifiant
			$a = array_keys($plxAdmin->aCats);
			rsort($a);	
		} else {
			$a['0'] = 0;
		}
		?>
		<tr>
		<td>Новая категория</td><td>
		<?php
		plxUtils::printInput(str_pad($a['0']+1, 3, "0", STR_PAD_LEFT), '', 'text', '20-50');
		echo '</td><td></td><td>';
		plxUtils::printSelect(str_pad($a['0']+1, 3, "0", STR_PAD_LEFT).'_tri', $aTri, $plxAdmin->aConf['tri']);
		echo '</td><td>';
		plxUtils::printInput(str_pad($a['0']+1, 3, "0", STR_PAD_LEFT).'_bypage', $plxAdmin->aConf['bypage'], 'text', '4-3');
		echo '</td><td>';
		plxUtils::printInput(str_pad($a['0']+1, 3, "0", STR_PAD_LEFT).'_ordre', ++$num, 'text', '3-3');
		echo '</td></tr>';
		?>
		</table>
		<p><input type="submit" value="Сохранить изменения" /></p>
	</fieldset>
</form>

<?php if ($plxAdmin->aConf['admin_conf']==0) { ?>

<div class="help">
	<h3>Создание категорий </h3>
	  <p>Чтобы создать   новую категорию впишите название в пустое поле напротив ID «Новая категория». <br />
	  <br />
	  <b>Важное замечание</b>: при создании в названии может быть только латиница, при редактировании можно заменить название на кириллическое, а URL (точнее alias) всегда должен содержать только латиницу и цифры.<br />
	  <br />
	  На сайте отображаются страницы только в активном состоянии</p>
	  <p>После того, как cтраница создана, вы можете изменить её исходный код, нажав на кнопку «Изменить страницу».  </p>
	  <h3>Изменение страницы</h3>
	  <p>Просто   отредактируйте название и URL и нажмите кнопку «Сохранить изменения».</p>
	  <h3>Удаление страниц</h3>
	  <p>Просто оставьте пустым поле с названием страницы. </p>
</div>

<?php }; ?>

<?php
# On inclut le footer
include('foot.php');
?>
