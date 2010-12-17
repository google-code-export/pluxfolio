<?php

/**
 * Edition des pages galerie
 *
 * @package PLX
 * @author	Stephane F et Florent MONTHEL
 **/

include('prepend.php');

# On édite les pages galerie
if(!empty($_POST)) {
	$msg = $plxAdmin->editGalerie(plxUtils::unSlash($_POST));
	header('Location: galerie.php?msg='.urlencode($msg));
	exit;
}

# On inclut le header	
include('top.php');
?>

<h2>Галереи — страницы с портфельными материалами</h2>
<form action="galerie.php" method="post" id="change-galerie-file">
	<fieldset>
		<table>
			<tr>
				<td><strong>ID</strong>&nbsp;:</td>
				<td><strong>Название</strong>&nbsp;:</td>
				<td><strong>URL</strong>&nbsp;:</td>
				<td><strong>Активна</strong>&nbsp;:</td>
				<td><strong>Порядок</strong>&nbsp;:</td>
				<td>&nbsp;</td>
			</tr>
		<?php
		# Initialisation de l'ordre
		$num = 0;
		# Si on a des pages galerie
		if($plxAdmin->aGals) {
			foreach($plxAdmin->aGals as $k=>$v) { # Pour chaque page galeria
				echo '<tr><td><label>№ '.$k.'</label></td><td>';
				plxUtils::printInput($k, htmlspecialchars($v['name'],ENT_QUOTES,PLX_CHARSET), 'text', '25-50');
				echo '</td><td>';
				plxUtils::printInput($k.'_url', $v['url'], 'text', '25-50');
				echo '</td><td>';
				plxUtils::printSelect($k.'_active', array('1'=>'Да','0'=>'Нет'), $v['active']);
				echo '</td><td>';	
				plxUtils::printInput($k.'_ordre', ++$num, 'text', '3-3');
				echo '</td><td>';
				echo '<a href="galeria.php?p='.$k.'" title="изменить галерею">Изменить галерею</a>';
				echo '</td></tr>';
			}
			# On récupère le dernier identifiant
			$a = array_keys($plxAdmin->aGals);
			rsort($a);	
		} else {
			$a['0'] = 0;
		}
		?>
		<tr>
		<td>Новая галерея</td><td>
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

<div class="help"><h3>Важное замечание </h3>
<p>У каждой галереи есть 2 параметра, <b>Название</b> и <b>URL</b>. Название задаёт текст ссылки в главном меню,  заголовок над контентом и тайтл страницы в коде, а URL — адрес (точнее alias) страницы  в браузере. При создании новой галереи в названии должна быть только латиница и/или цифры, при изменении — можно заменить латиницу на кириллицу. В поле URL кирилилца неприемлема.  </p>
<h3>Алгоритм создания галерей простой: <span style="color:#FF0000">New!</span></h3>
<ol>
  <li>создаёте новую галерею с названием латиницей (и/или цифрами) без пробелов;</li>
  <li>идёте в раздел <b>Картинки</b>, выбираете в выпадающем списке вашу галерею (по параметру URL), кладёте в новую папку ваши работы (джипеги, гифы и пнг) оригинального размера (без превьюшек) — также можно делать тоже самое через FTP (папка /album/Ваша галерея;</li>
  <li>открываете в браузере ваш сайт, переходите на страницу новой  галереи — создаются превьюшки для ваших макетов, обновляется счётчик  ваших работ (в шапке) — на лету и очень автома<strong>г</strong>ически.</li>  
  <li>при желании меняете название галереи на кириллическое.</li>
</ol>
<h3>Чтобы вывести галерею на главной странице сайта <span style="color:#FF0000">New!</span></h3>
<p>на странице Настройки — Настройки контента сверху есть выпадающий список: Выводить на главной. В нём выводятся все имеющиеся галереи (по названию). Если выбрать галерею, текущий индекс станет страницей Новости (пункт меню Новости).</p>
<h3>Чтобы изменить галерею</h3>
<p>просто нажмите Изменить галерею справа от параметров существующей галереи. Вы попадете на страницу изменения контентной части галереи — сопроводительного текста и графики для галереи. Сама галерея находится в папке /album/галерея/, названия картинок берутся из имён файлов, так что удаление файлов влечёт изменение самой галереи (её «галерейной» части). Все настройки для галерей находятся в папке шаблона сайта в файле galeria.php</p>
<h3>Чтобы удалить галерею</h3>
<p>просто очистите название существующей галереи и нажмите <b>Сохранить изменения</b></p>

</div>


<?php
# On inclut le footer
include('foot.php');
?>