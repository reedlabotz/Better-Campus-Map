<?php
$host = 'dcs-projects.cs.illinois.edu';
$user = 'labotz1_cs465';
$password = 'cs465';
$dbconn = mysql_connect($host, $user, $password) or die ('Could not connect to database: ' . mysql_error());
mysql_select_db('labotz1_cs465');
?>