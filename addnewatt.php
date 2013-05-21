<?php
foreach($_POST as $var)
{
	printf($var."<br>");
}
if (empty($_POST['Submit']))
{
?>
<h3>Add new attribute</h3>
<form name="data2" method="post" action="addnewatt.php">
<table align="center" cellspacing="0" cellpadding="0" border="0">
<tr>
<td bgcolor="#DDDDDD" align="right">Attribute Text</td>
<td bgcolor="#FFFFFF" align="left"><input type="text" name="att" size="100"></td></tr>
<tr><td colspan="2" align="center"><input type="submit" name="Submit" value="Submit"></td></tr></table>
</form>
<?php
}
else
{
	pintf("shut!");
	$link = mysql_connect('localhost', 'wizard', 'g10gg') or die('could not connect to sql server');
	mysql_select_db("wizard", $link);
	$query = "insert into attributes (attributetext) values ('".$_POST['att']."')";
	$result = mysql_query($query, $link) or die("could not execute query $query");
?>
<h3 align="center">Insert successful!</h3>
<h3 align="center">click <a href="managewizard.php">Here</a> to go back to the main menu</h2>
<?php
}
?>
