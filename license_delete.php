<?php
$link = mysql_connect('localhost', 'wizard', 'g10gg') or die('could not connect to sql server');
mysql_select_db("wizard", $link);
$query = "delete from table licenses where licenseid = ".$_GET['lid'];
$result = mysql_query($query, $link) or die("could not execute query $query");
$query = "delete from table licensecode where licenseid = ".$_GET['lid'];
$result = mysql_query($query, $link) or die("could not execute query $query");
header("Location: editlicense.php");
?>
