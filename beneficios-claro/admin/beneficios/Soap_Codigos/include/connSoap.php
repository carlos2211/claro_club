<?php
	
$db_host="localhost";
$db_user="mediacon_cluser";
$db_pass="e68c58fed5";
$db_name="claro_club";

$link = mysql_connect($db_host,$db_user,$db_pass);
mysql_select_db($db_name);
mysql_query("SET NAMES 'UTF8'");

?>