<?php

/**
 * Classe plxUtils rassemblant les fonctions utiles à Pluxml
 *
 * @package PLX
 * @author	Florent MONTHEL et Stephane F
 **/
class plxUtils {

	function get_kf($days)
	{
	if ($days<10) $kf=1;
		elseif ($days<20) $kf=0.9;
		elseif ($days<30) $kf=0.8;
		elseif ($days<40) $kf=0.7;
		elseif ($days<50) $kf=0.6;
		elseif ($days<60) $kf=0.5;
		elseif ($days<70) $kf=0.4;
		elseif ($days<80) $kf=0.3;
		elseif ($days<90) $kf=0.2;
		else $kf = 0.1;
	return $kf;
	}

	function getCalendar($key, $value) {

		$aMonth = array(
			'01' => 'Янв',
			'02' => 'Фев',
			'03' => 'Мар',
			'04' => 'Апр',
			'05' => 'Мая',
			'06' => 'Июн',
			'07' => 'Июл',
			'08' => 'Авг',
			'09' => 'Сен',
			'10' => 'Окт',
			'11' => 'Ноя',
			'12' => 'Дек');	
		$aDay = array(
			'1' => 'Пнд',
			'2' => 'Вто',
			'3' => 'Сре',
			'4' => 'Чтв',
			'5' => 'Птн',
			'6' => 'Суб',
			'0' => 'Вск');
	
		switch ($key) {
			case 'day':
				return "<b>" .$aDay[ $value ] . "</b>"; break;
			case 'month':
				return $aMonth[ $value ]; break;
		}
	}

	function getGets() {

		if(!empty($_GET)) {
			$a = array_keys($_GET);
			return $a[0];
		}
		return false;
	}

	function unSlash($content) {

		if(get_magic_quotes_gpc() == 1) {
			if(is_array($content)) { # On traite un tableau
				while(list($k,$v) = each($content)) # On parcourt le tableau
					$new_content[ $k ] = stripslashes($v);
			} else { # On traite une chaine
				$new_content = stripslashes($content);
			}
			# On retourne le tableau modifie
			return $new_content;
		} else {
			return $content;
		}
	}

	function microtime() {

		$t = explode(' ',microtime());
		return $t[0]+$t[1];
	}

	function dateToIso($date,$delta) {

		return substr($date,0,4).'-'.
		substr($date,4,2).'-'.
		substr($date,6,2).'T'.
		substr($date,8,2).':'.
		substr($date,10,2).':00'.$delta;
	}

	function timestampToIso($timestamp,$delta) {

		return date('Y-m-d\TH:i:s',$timestamp).$delta;
	}

	function dateIsoToHum($date) {

		# On decoupe notre date
		$year = substr($date, 0, 4);
		$month = substr($date, 5, 2);
		$day = substr($date, 8, 2);
		$day_num = date('w',mktime(0,0,0,$month,$day,$year));
		# On genere nos tableaux de traduction

		# On retourne notre date au format humain
		return plxUtils::getCalendar('',$day_num).' '.$day.' '.plxUtils::getCalendar('month', $month).' '.$year;
	}

	function heureIsoToHum($date) {

		# On retourne l'heure au format 12:55
		return substr($date,11,2).':'.substr($date,14,2);
	}

	function checkMail($mail) {

		# On verifie le mail via une expression reguliere
		if(preg_match('/^[-+.\w]{1,64}@[-.\w]{1,64}\.[-.\w]{2,6}$/i',$mail))
			return true;
		else
			return false;
	}

	function checkSite($site) {

		# On verifie le site via une expression reguliere
		if(preg_match('/^http(s)?:\/\/[-.\w]{1,64}\.[-.\w]{2,6}$/i',$site))
			return true;
		else
			return false;
	}

	function getIp() {

		return  $_SERVER['REMOTE_ADDR'];
	}

	function dateIso2Admin($date) {

		preg_match('/([0-9]{4})-([0-9]{2})-([0-9]{2})T([0-9:]{8})((\+|-)[0-9:]{5})/',$date,$capture);
		return array ('year' => $capture[1],'month' => $capture[2],'day' => $capture[3],'time' => substr($capture[4],0,5),'delta' => $capture[5]);
	}

	function printSelect($name, $array, $selected='', $readonly=false, $class='') {

		if($readonly)
			echo '<select id="id_'.$name.'" name="'.$name.'" disabled="disabled" class="readonly">'."\n";
		else
			echo '<select id="id_'.$name.'" name="'.$name.'" class="'.$class.'">'."\n";			
		foreach($array as $a => $b) {
			if(is_array($b)) {
				echo '<optgroup label="'.$a.'">'."\n";
				foreach($b as $c=>$d) {
					if($c == $selected)
						echo "\t".'<option value="'.$c.'" selected="selected">'.$d.'</option>'."\n";
					else
						echo "\t".'<option value="'.$c.'">'.$d.'</option>'."\n";
				}
				echo '</optgroup>'."\n";
			} else {
				if($a == $selected)
					echo "\t".'<option value="'.$a.'" selected="selected">'.$b.'</option>'."\n";
				else
					echo "\t".'<option value="'.$a.'">'.$b.'</option>'."\n";
			}
		}
		echo '</select>'."\n";
	}

	function printInput($name, $value='', $type='text', $size='50-255', $readonly=false, $class='') {

		$size = explode('-',$size);
		if($readonly)
			echo '<input id="id_'.$name.'" name="'.$name.'" type="'.$type.'" class="'.$class.'" value="'.$value.'" size="'.$size[0].'" maxlength="'.$size[1].'" class="readonly" readonly="readonly" />'."\n";
		else
			echo '<input id="id_'.$name.'" name="'.$name.'" type="'.$type.'" class="'.$class.'" value="'.$value.'" size="'.$size[0].'" maxlength="'.$size[1].'" />'."\n";	
	}

	function printArea($name, $value='', $cols='', $rows='', $readonly=false, $class='') {

		if($readonly)
			echo '<textarea id="id_'.$name.'" name="'.$name.'" class="readonly" cols="'.$cols.'" rows="'.$rows.'" readonly="readonly">'.$value.'</textarea>'."\n";
		else
			echo '<textarea id="id_'.$name.'" name="'.$name.'" class="'.$class.'" cols="'.$cols.'" rows="'.$rows.'">'.$value.'</textarea>'."\n";
	}

	function testWrite($file) {

		if(is_writable($file))
			echo $file.' доступен и открыт для записи';
		else
			echo '<strong>'.$file.' n\'est pas accessible en &eacute;criture</strong>';
	}

	function removeAccents($str,$charset='utf-8') {

		$str = plxUtils::imTranslite($str);
	    $str = htmlentities($str, ENT_NOQUOTES, $charset);
	    $str = preg_replace('#\&([A-za-z])(?:acute|cedil|circ|grave|ring|tilde|uml|uro)\;#', '\1', $str);
	    $str = preg_replace('#\&([A-za-z]{2})(?:lig)\;#', '\1', $str); # pour les ligatures e.g. '&oelig;'
	    $str = preg_replace('#\&[^;]+\;#', '', $str); # supprime les autres caractères    
	    return $str;
	}
	
//костыль;(	
function imTranslite($str)
{
	static $tbl= array(
		'а'=>'a', 'б'=>'b', 'в'=>'v', 'г'=>'g', 'д'=>'d', 'е'=>'e', 'ж'=>'g', 'з'=>'z',
		'и'=>'i', 'й'=>'y', 'к'=>'k', 'л'=>'l', 'м'=>'m', 'н'=>'n', 'о'=>'o', 'п'=>'p',
		'р'=>'r', 'с'=>'s', 'т'=>'t', 'у'=>'u', 'ф'=>'f', 'ы'=>'i', 'э'=>'e', 'А'=>'A',
		'Б'=>'B', 'В'=>'V', 'Г'=>'G', 'Д'=>'D', 'Е'=>'E', 'Ж'=>'G', 'З'=>'Z', 'И'=>'I',
		'Й'=>'Y', 'К'=>'K', 'Л'=>'L', 'М'=>'M', 'Н'=>'N', 'О'=>'O', 'П'=>'P', 'Р'=>'R',
		'С'=>'S', 'Т'=>'T', 'У'=>'U', 'Ф'=>'F', 'Ы'=>'I', 'Э'=>'E', 'ё'=>"yo", 'х'=>"h",
		'ц'=>"ts", 'ч'=>"ch", 'ш'=>"sh", 'щ'=>"shch", 'ъ'=>"", 'ь'=>"", 'ю'=>"yu", 'я'=>"ya",
		'Ё'=>"YO", 'Х'=>"H", 'Ц'=>"TS", 'Ч'=>"CH", 'Ш'=>"SH", 'Щ'=>"SHCH", 'Ъ'=>"", 'Ь'=>"",
		'Ю'=>"YU", 'Я'=>"YA"
	);

return strtr($str, $tbl);
}
	function title2url($str) {

		$str = strtolower(plxUtils::removeAccents($str,PLX_CHARSET));
		$str = preg_replace('/[^[:alnum:]]+/',' ',$str);
		return strtr(trim($str), ' ', '-');
	}

	function title2filename($str) {

		$str = strtolower(plxUtils::removeAccents($str,PLX_CHARSET));
		$str = preg_replace('/[^[:alnum:]|.|_]+/',' ',$str);
		return strtr(trim($str), ' ', '-');
	}

	function formatRelatif($num, $lenght) {

		$fnum = str_pad(abs($num), $lenght, '0', STR_PAD_LEFT);
		if($num > -1)
			return '+'.$fnum;
		else
			return '-'.$fnum;
	}

	function write($xml, $filename) {

		if(file_exists($filename)) {
			$f = fopen($filename.'.tmp', 'w'); # On ouvre le fichier temporaire
			fwrite($f, trim($xml)); # On écrit
			fclose($f); # On ferme
			unlink($filename);
			rename($filename.'.tmp', $filename); # On renomme le fichier temporaire avec le nom de l'ancien
		} else {
			$f = fopen($filename, 'w'); # On ouvre le fichier
			fwrite($f, trim($xml)); # On écrit
			fclose($f); # On ferme
		}
		# On place les bons droits
		@chmod($filename,0644);
		# On vérifie le résultat
		if(file_exists($filename) AND !file_exists($filename.'.tmp'))
			return true;
		else
			return false;
	}

	function makeThumb($filename, $filename_out, $width, $height, $quality) {

		# Informations sur l'image
		list($width_orig,$height_orig,$type) = getimagesize($filename);
		
		# Calcul du ratio
		$ratio_w = $width / $width_orig;
		$ratio_h = $height / $height_orig;
		if($ratio_w < $ratio_h AND $ratio_w < 1) {
			$width = $ratio_w * $width_orig;
			$height = $ratio_w * $height_orig;
		} elseif($ratio_h < 1) {
			$width = $ratio_h * $width_orig;
			$height = $ratio_h * $height_orig;
		} else {
			$width = $width_orig;
			$height = $height_orig;
		}
		
		# Création de l'image
		$image_p = imagecreatetruecolor($width,$height);
		if($type == 2)
			$image = imagecreatefromjpeg($filename);
		elseif($type == 3)
			$image = imagecreatefrompng($filename);
		elseif($type == 1)
			$image = imagecreatefromgif($filename);	
		imagecopyresized($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
		if($type == 2)
			imagejpeg($image_p, $filename_out, $quality);
		elseif($type == 3)
			imagepng($image_p, $filename_out);
		elseif ($type==1) imagegif($image_p, $filename_out);	
	}

	function showMsg($msg) {

		echo '<p class="msg"><strong>'.$msg.'</strong></p>';
	}

	function getRacine() {

		$doc = str_replace('install.php', '', $_SERVER['SCRIPT_NAME']);
		return trim('http://'.$_SERVER['HTTP_HOST'].$doc);
	}

	function charAleatoire($taille='10') {

		$string = '';	 
		$chaine = 'abcdefghijklmnpqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';	 
		mt_srand((float)microtime()*1000000);	 
		for($i=0; $i<$taille; $i++)
			$string .= $chaine[ mt_rand()%strlen($chaine) ];	 
		return $string;	 
	}

	function strCut($str='', $len=25) {

		return strlen($str) > $len ? substr($str, 0, $len-3).'...' : $str;
	}

	function getSousNav() {

		$file = split('[/]',$_SERVER['SCRIPT_NAME']);
		$script = array_pop($file);
		$template = split('[_.]',$script);
		if(file_exists('sous_navigation/'.$template[0].'.php'))
			return 'sous_navigation/'.$template[0].'.php';
		if(file_exists('sous_navigation/'.$template[0].'s.php'))
			return 'sous_navigation/'.$template[0].'s.php';
	}

}
?>