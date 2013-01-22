<?
	$link = mysql_connect ("localhost", "root", "") or die ("Could not connect");
    $base=mysql_select_db ("hotel");
	mysql_query("SET NAMES utf-8");
	require_once("inc/functions.php");
?>