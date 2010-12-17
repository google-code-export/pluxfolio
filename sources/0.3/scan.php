<?php

function werks($base,$ext, &$count=0, &$data=array()) { 
  $array = array_diff(scandir($base), array('.', '..')); 
  foreach($array as $value) : 
    if (is_dir($base.$value)) :
      $data = werks($base.$value.'/',$ext,$count, $data);      
    elseif (is_file($base.$value)) :   
    if (ereg($ext, $value)){     
      $data[] = $base.$value; 
      $count++;
    }     
    endif;
    endforeach; 
  return $data; 
}

echo '<b>'.count(werks(dirname(__FILE__).'/album/',".tb")).'</b>';

/*function GetWordForm($n) {
       $forms=array($SITE_scan_work, $SITE_scan_works, $SITE_scan_moreworks); 
	//$forms=array('работа', 'работы', 'работ');
       if ($n>0) {
         $n = abs($n) % 100;
         $n1 = $n % 10;
         if ($n > 10 && $n < 20) return $forms[2];
         if ($n1 > 1 && $n1 < 5) return $forms[1];
         if ($n1 == 1) return $forms[0];
       }
        return $forms[2];
      }

echo 'Кстати, <b>'.$works_counter.'</b> '.GetWordForm($works_counter).' в портфеле.'; */

?>
