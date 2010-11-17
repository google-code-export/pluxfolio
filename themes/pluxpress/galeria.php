<?
$relative = $_SERVER['QUERY_STRING'];
$cutted = substr($relative,9);

$relative = $plxMotor->get;
$cutted = $plxMotor->aGals[$plxMotor->cible]['url'];

$files_path="./album/" . $cutted . "/"; // The key to galerie logic - it points to the folder which name should match the title of the galerie page
$full_server="./album/" . $cutted . "/"; 
$show_files=array("jpg","gif","png"); // only show these types of files.
$ignore_word="-hide"; //Hide files with this string in the name. Example, mypicture-hide.jpg will not be shown.
$thumb_width = $plxMotor->twidth; // Width of the thumb
$thumb_height = $plxMotor->theight; // Height of the thumb
$thumb_offset = $plxMotor->toffset; // Offset of thumb
$auto_thumb="1"; //Automatically create thumb's of gif and jpg images? 1=yes, 0=no.
$jpg_quality="80"; // JPG thumb quality, does not work for png or gif. 0 to 100.
$supress_error="0"; //Suppress errors if thumb creation fails.  1=hide errors, 0=show errors.
$time_sec=time();

?>
<?php include('header.php'); ?>
<div id="informer">
	<div id="galeria_title"><?php $plxShow->galTitle(); ?></div>
</div>
<div id="page">
	<div id="content_galeria">
<?
If(!$ignore_word) {
	$ignore_word=microtime();
}

//A bit tricky, but all in all it works, returns the filename without the extension!

function file_name($key) {
	$key=strrev(substr(strstr(strrev($key), "."), 1));
	return($key);
}
//Lets get the file extension.

function file_ext($key) { 
	$key=strtolower(substr(strrchr($key, "."), 1));
	$key=str_replace("jpeg", "jpg", $key);
    return($key); 
}

//Get the current album.

$album=stripslashes(str_replace(".","",$_GET['album'])); //Great security here.. Disallows going up the dir tree.

//Lil bit of security, not much but it may stop some kids from messing!

If(!is_dir($files_path.$album)) {
	$album="";
}

//We don't want ugly _'s or -'s to display with the file or folder names do we? No! So, lets take them out.

$find=array("_","-");
$replace=array(" "," ");

$count=@count($folder);

for($i=0;$i<$count;$i++) {
	If($folder[$i]) {
		
		$path.=$folder[$i]."/";

	}
}

Echo($nav);

//Lets get some images!!

$dir=@opendir($full_server.$album);

//Loop through them all ;).

while($file=@readdir($dir)) {

	//Don't display the stupid directory tree files.

	If($file!= "." AND $file!= "..") {

		//If it's a directory, show the folder image with a link to the new album

		If(is_dir($full_server.$album.$file)) {

		// Else, the file is not a directory, so it must be an image.

		} Else {
			
			$file_ext=".".file_ext($file);
			$file_name=file_name($file);
			$display_name=str_replace($find,$replace,$file_name);

			//Hide the thumb files from displaying as regular files and disallow any file types that are not allowed.

			If((!eregi(".tb",$file)) && (in_array(file_ext($file),$show_files))) {

				//If the file has the ignore word in it, do not show the file.

				If(!eregi($ignore_word,$file)) {
					
					//If a thumb file dosen't exists, then try and make one.
					
					If($auto_thumb) {
						If(!file_exists($full_server.$file.'.tb')) {
						plxUtils::makeThumb($full_server.$file, $full_server.$file.'.tb',$thumb_width,$thumb_height,$jpg_quality,$thumb_offset);	
						}
					}

					//Now, if there is a thumb file, display the thumb, else display the full images but smaller :(.
					If(file_exists($full_server.$file.".tb")) {
						$thumb = $file.'.tb';
					} Else {
						$thumb=$file;
					}

					//Make the html
$remove="";

//Высчитываем прозрачность
$time_file=filemtime($full_server.$thumb); 
$days = (($time_sec-$time_file)/864000);
$kf = plxUtils::get_kf($days);
//такой страшный код, зато для всех браузеров ;(
$opacity = 'filter:alpha(opacity='.($kf*100).'); -moz-opacity: '.$kf.'; -khtml-opacity: '.$kf.'; opacity: '.$kf.';';

					$rel = 'rel="lightbox"';
					if ($plxShow->plxMotor->images_sets==1) $rel = 'rel="lightbox[images]"'; 

					//Parsing filename for name and description
					if (strpos($file_name, '!') == true) {
					  $file = explode("!", $file_name);
					  $file0 = $file[0];
					  $file1 = $file[1];
					  $filename = str_replace("_", " ", $file0);
					  $file_description = str_replace("_", " ", $file1);
					}
					else {
					  $file_description = $filename = str_replace("_", " ", $file_name);
					}

					//Checking for freshness 2592000 - month in unix time
					
					if ($plxShow->plxMotor->freshness==1) {
					$fresh_label = '';
					$currentdate = date("U");
					$filedate = date ("U ", filemtime($files_path.$album.$file_name.$file_ext));
					if ($filedate >= $currentdate-$plxShow->plxMotor->freshnesstime) $fresh_label = '<div class="freshlabel"></div>';
					}

						$images .= "<div class=\"framer ".$file0."\">".$fresh_label."<a class=\"galimage\" style=\"background:url(".$full_server.$thumb.") no-repeat center; width:".$thumb_width."px; height:".$thumb_height."px;".$opacity."\"  href=\"".$files_path.$album.$file_name.$file_ext."\" ".$rel." title=\"".$file_description."\"></a>".$filename."</div>\n";
						
					$k++;
					
				
				}
			}
		}
	}
}
@closedir($dir);

If($images) {
	echo "<div>";
	Echo($images);	
	echo "</div>";
} Else {


}
?><div id="galeria_info"><?php $plxShow->visualis(); ?></div>
	</div>

</div>
<?php include('footer.php'); # On insere le footer ?>
