<?php

if (version_compare(phpversion(), "5.3.0", ">=")  == 1)
  error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
else
  error_reporting(E_ALL & ~E_NOTICE); 

require_once('classes/CMySQL.php');

//using database as source of data
        $sRequest = "SELECT `name`,`id` FROM `building_names` ORDER BY `id`";
        $aItemInfo = $GLOBALS['MySQL']->getAll($sRequest);
        
	   
		foreach ($aItemInfo as $aValues) {
            echo "{ text: '". $aValues[name]."' , url: 'info.php?=".$aValues[id]. "' } ," ;
			
		}
		
		

?>