<?php

$url = $_GET['url'];

function converturl($url)
{
	$values = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	$id = 0;
	for ($i=0; $i < strlen($url); $i++) { 
		$id= $id*62 + strpos($values,$url[$i])+1;
	}
	return $id;
}
 $id = converturl($url);

mysql_connect('localhost','root','');
mysql_select_db('url_short');
$query = "SELECT original FROM url_map WHERE id=".$id;
$newURL = mysql_fetch_array(mysql_query($query))['original'];
header('Location: http://'.$newURL);
?>