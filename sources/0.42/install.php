<?php


define('PLX_ROOT', './');
define('PLX_CORE', PLX_ROOT.'core/');
define('PLX_CONF', PLX_ROOT.'data/configuration/parametres.xml');

# On verifie que Pluxml n'est pas déjà installé
if(file_exists(PLX_CONF)) {
	header('Content-Type: text/plain charset=UTF-8');
	echo 'You have everything installed already!';
	exit;
}

# On inclut les librairies nécessaires
include_once(PLX_ROOT.'config.php');
include_once(PLX_CORE.'lib/class.plx.utils.php');
	
# Configuration de base
$f = file(PLX_ROOT.'version');
$version = $f['0'];
$config = array('title'=>'Project title', 
				'description'=>'and it\'s subtitle',
				'racine'=>plxUtils::getRacine(), 
				'intro'=>'This is a very important block, which can help users to understand that it is a John Doe\'s site.',
				'delta'=>'+03:00', 
				'style'=>'pluxpress', 
				'bypage'=>5,
				'bypage_admin'=>10, 
				'bypage_feed'=>10, 
				'tri'=>'date-desc',
				'categ_get'=>'0',
				'images'=>'data/images/', 
				'documents'=>'data/documents/', 
				'racine_articles'=>'data/articles/',
				'gallery'=>'data/galerie/',
				'racine_statiques'=>'data/statiques/',
				'galerie'=>'data/configuration/galerie.xml', 
				'statiques'=>'data/configuration/statiques.xml', 
				'categories'=>'data/configuration/categories.xml', 
				'passwords'=>'data/configuration/passwords.xml',
				'wysiwyg'=>'0',
				'admin_conf'=>'0',
				'counter_enabled'=>'0',
				'site_lang' => 'EN_us',
				'postas' => '0',
				'images_sets' => '0',
				'freshness' => '0',
				'freshnesstime' => '604800',
				'maintence' => '0'
				);

function install($content, $config) {

	# Echappement des caractères
	$content = plxUtils::unSlash($content);
	# Tableau des clés à mettre sous chaîne cdata
	$aCdata = array('title','description','intro','racine');
	
	# Création du fichier de configuration
	$xml = '<?xml version="1.0" encoding="'.PLX_CHARSET.'"?>'."\n";
	$xml .= '<document>'."\n";
	foreach($config as $k=>$v) {
		if(in_array($k,$aCdata))
			$xml .= "\t<parametre name=\"$k\"><![CDATA[".$v."]]></parametre>\n";
		else
			$xml .= "\t<parametre name=\"$k\">".$v."</parametre>\n";
	}
	$xml .= '</document>';
	plxUtils::write($xml,PLX_CONF);
	
	# Création du fichier de mot de passe
	$xml = '<?xml version="1.0" encoding="'.PLX_CHARSET.'"?>'."\n";
	$xml .= '<document>'."\n";
	$xml .= "\t".'<user login="'.trim($content['name']).'" >'.md5(trim($content['pwd'])).'</user>'."\n";
	$xml .= '</document>';
	plxUtils::write($xml,PLX_ROOT.$config['passwords']);
	
}

if(!empty($_POST['name']) AND !empty($_POST['pwd']) AND $_POST['pwd'] == $_POST['pwd2'] ) {
	install($_POST, $config);
	header('Location: '.plxUtils::getRacine());
	exit;
}
?>
<?php header('Content-Type: text/html; charset='.PLX_CHARSET); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo strtolower(PLX_CHARSET) ?>" />
<title>Pluxfolio installation</title>
<link rel="stylesheet" type="text/css" href="core/admin/admin.css" media="screen" />
</head>

<body id="install">
<div><h2>Pluxfolio installation</h2>
<ul>
	<li>Engine version : <b><?php echo $version; ?></b></li>
	<li><?php plxUtils::testWrite(dirname(PLX_CONF)); ?></li>
	<li><?php plxUtils::testWrite(PLX_ROOT.$config['racine_articles']); ?></li>
	<li><?php plxUtils::testWrite(PLX_ROOT.$config['racine_statiques']); ?></li>
	<li><?php plxUtils::testWrite(PLX_ROOT.$config['gallery']); ?></li>
	<li>Your РНР version: <?php echo phpversion(); ?></li>
	<li>"Magic quotes" settings: <?php echo get_magic_quotes_gpc(); ?></li>
</ul>
<h3>Creating a hero</h3>
<form action="install.php" method="post">
	<fieldset>
		<p class="field"><label>Admin login:</label></p>
		<?php plxUtils::printInput('name', '', 'text', '20-255') ?>
		<p class="field"><label>Password:</label></p>
		<?php plxUtils::printInput('pwd', '', 'password', '20-255') ?>
		<p class="field"><label>Password confirmation:</label></p>
		<?php plxUtils::printInput('pwd2', '', 'password', '20-255') ?>
		<?php plxUtils::printInput('version', $version, 'hidden') ?>
		<p><input type="image" src="images/create.jpg" class="create"  /></p>
	</fieldset>
</form>
</div>
</body>
</html>
