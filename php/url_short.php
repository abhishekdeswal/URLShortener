<?php

//function to map the id of the URL in the table to the short url
function convert_url($id)
{
	$digits = array();
	while ($id>0) {
		$remainder = $id%62;
		array_push($digits, $remainder);
		$id = floor($id/62);
	}
	$digits = array_reverse($digits);
	$values = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	$shorturl = '';
	foreach ($digits as $value) {
		$shorturl .= strval($values[$value-1]);
	}
	return $shorturl;
}
//function to insert the new URL in the table
function insertInTable($original_url)
{
	mysql_connect('localhost','root','');
	mysql_select_db('url_short');
	$query = "INSERT INTO  `url_short`.`url_map` (`id` ,`original`)VALUES (NULL ,  '".$original_url."');";
	mysql_query($query);
	$query = "SELECT id FROM url_map WHERE original='".$original_url."';";
	//$query = "SELECT COUNT(*) FROM url_map";
	$id = mysql_fetch_assoc(mysql_query($query))['id'];
	echo 'The shortened URL is : localhost/short/'.convert_url($id);
}

if(isset($_POST['original_url'])) {
	if (!empty($_POST['original_url'])) {
		$original_url = $_POST['original_url'];
		insertInTable($original_url);

	} else {
		echo "Please enter a valid URL";
	}
}

?>
<html>

<head>
	<title>My URL Shortener</title>
	<link rel="stylesheet" type="text/css" href="main.css">
</head>

<body>
	<h1>URL Shortener</h1><hr>
	<form action="url_short.php" method="POST">
		Type the URL to be shortened here:
		<input type="text" name="original_url" class="input"><br><br>
		<input type="submit" value="Shorten It" class="bSubmit"><br>
	</form>
</body>

</html>