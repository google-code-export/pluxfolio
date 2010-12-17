<ul>
	<li><a href="parametres_base.php" id="link_config" title="Modifier la configuration de base de votre Pluxml">Базовые настройки</a></li>
	<li><a href="parametres_affichage.php" id="link_config" title="Modifier les options d'affichage de votre Pluxml">Настройки контента</a></li>
	<li><a href="parametres_compte.php" id="link_user" title="Modifier le compte r&eacute;dacteur de votre Pluxml">Настройки пользователя</a></li>
	<li><a href="parametres_admin.php" id="link_config" title="Modifier le compte r&eacute;dacteur de votre Pluxml">Настройки админки</a></li>
	<?php if ($plxAdmin->aConf['admin_conf']==0) echo '<li><a href="parametres_avances.php" id="link_config" title="Modifier la configuration avanc&eacute;e de votre Pluxml">Архитектура движка</a></li>
	<li><a href="parametres_infos.php" id="link_info" title="Avoir des informations sur votre Pluxml">Информация</a></li>'; ?>
</ul>
