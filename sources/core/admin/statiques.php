<?php

/**
 * Edition des pages statiques
 *
 * @package PLX
 * @author	Stephane F et Florent MONTHEL
 **/

include('prepend.php');

# On édite les pages statiques
if(!empty($_POST)) {
	$msg = $plxAdmin->editStatiques(plxUtils::unSlash($_POST));
	header('Location: statiques.php?msg='.urlencode($msg));
	exit;
}

# On inclut le header	
include('top.php');
?>

<h2>Создание и изменение статичных страниц</h2>
<form action="statiques.php" method="post" id="change-static-file">
	<fieldset>
		<table>
			<tr>
				<td><strong>ID</strong>&nbsp;:</td>
				<td><strong>Заголовок</strong>&nbsp;:</td>
				<td><strong>URL</strong>&nbsp;:</td>
				<td><strong>Активна</strong>&nbsp;:</td>
				<td><strong>Порядок</strong>&nbsp;:</td>
				<td>&nbsp;</td>
			</tr>
		<?php
		# Initialisation de l'ordre
		$num = 0;
		# Si on a des pages statiques
		if($plxAdmin->aStats) {
			foreach($plxAdmin->aStats as $k=>$v) { # Pour chaque page statique
				echo '<tr><td><label>№ '.$k.'</label></td><td>';
				plxUtils::printInput($k, htmlspecialchars($v['name'],ENT_QUOTES,PLX_CHARSET), 'text', '25-50');
				echo '</td><td>';
				plxUtils::printInput($k.'_url', $v['url'], 'text', '25-50');
				echo '</td><td>';
				plxUtils::printSelect($k.'_active', array('1'=>'Да','0'=>'Нет'), $v['active']);
				echo '</td><td>';	
				plxUtils::printInput($k.'_ordre', ++$num, 'text', '3-3');
				echo '</td><td>';
				echo '<a href="statique.php?p='.$k.'" title="изменить страницу">Изменить страницу</a>';
				echo '</td></tr>';
			}
			# On récupère le dernier identifiant
			$a = array_keys($plxAdmin->aStats);
			rsort($a);	
		} else {
			$a['0'] = 0;
		}
		?>
		<tr>
		<td>Новая страница</td><td>
		<?php
		plxUtils::printInput(str_pad($a['0']+1, 3, '0', STR_PAD_LEFT), '', 'text', '25-50');
		echo '</td><td></td><td>';
		plxUtils::printSelect(str_pad($a['0']+1, 3, '0', STR_PAD_LEFT).'_active', array('1'=>'Да','0'=>'Нет'), '1');
		echo '</td><td>';
		plxUtils::printInput(str_pad($a['0']+1, 3, '0', STR_PAD_LEFT).'_ordre', ++$num, 'text', '3-3');
		echo '</td></tr>';
		?>
		</table>
		<p><input type="submit" value="Сохранить изменения" /></p>
	</fieldset>
</form>

<?php if ($plxAdmin->aConf['admin_conf']==0) { ?>

<div class="help">
	<h3>Создание страниц </h3>
	  <p>Чтобы создать   новую страницу впишите название в пустое поле напротив ID «Новая страница». <br />
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
