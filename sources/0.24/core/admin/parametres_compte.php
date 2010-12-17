<?php

/**
 * Edition du compte rédacteur
 *
 * @package PLX
 * @author	Florent MONTHEL
 **/

include('prepend.php');

# On édite la configuration
if(!empty($_POST)) {
	$msg = $plxAdmin->editRedacteur(plxUtils::unSlash($_POST));
	header('Location: parametres_compte.php?msg='.urlencode($msg));
	exit;
}

# On inclut le header
include('top.php');
?>

<h2>Изменение данных пользователя</h2>

<form action="parametres_compte.php" method="post" id="change-cf-file">
	<fieldset class="withlabel">
		<legend>Администратор сайта :</legend>	
		<p class="field"><label>Логин администратора сайта:</label></p>
		<?php plxUtils::printInput('login', htmlspecialchars($_SESSION['author'],ENT_QUOTES,PLX_CHARSET)); ?>
		<p class="field"><label>Пароль:</label></p>
		<?php plxUtils::printInput('pwd','','password'); ?>
		<p class="field"><label>Подтвердить пароль:</label></p>
		<?php plxUtils::printInput('pwd2','','password');?>
	</fieldset>
	<p><input type="submit" value="Изменить администратора сайта" /></p>
</form>

<?php
# On inclut le footer
include('foot.php');
?>