<?php
require("head.php");

/*set varibles from form */

$searchterm = $_POST['searchterm'];
$i = 0;

trim ($searchterm);

/*check if search term was entered*/

if (!$searchterm){

        echo 'Please enter a search term.';

}

else {

require_once('classes/CMySQL.php');

//using database as source of data
        $sRequest = "SELECT `name`,`id` FROM `building_names` WHERE `name` LIKE '%{$searchterm}%' ORDER BY `id`";
        $aItemInfo = $GLOBALS['MySQL']->getAll($sRequest);
		
        foreach ($aItemInfo as $aValues) {
            $i = $i + 1 ;
        }

		if ($i <= 10)
		{
			foreach ($aItemInfo as $aValues) {
            	echo "<a href='info.php?id=".$aValues['id']."'>".$aValues['name'] . "</a><br/>";
       		 }
		}
		
		else {
			echo 'Too much data, please try searching with more letters' ; 
		}
		
}
require("foot.php");
?>