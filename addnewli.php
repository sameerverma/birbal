<?php
function calcode($postvars)
{
	foreach($postvars as $key=>$val)
	{
	    $$key = $val;
	}
	$link = mysql_connect('localhost', 'wizard', 'g10gg') or die('could not connect to sql server');
	mysql_select_db("wizard", $link);
	$query = "select * from attributes";
	$result = mysql_query($query, $link) or die("could not execute query $query");
	$code = 0;
	while ($row = mysql_fetch_array($result))
	{
		$aid = $row['attributeid'];
		if (isset($$aid)) {$code += pow(2, $aid);}
	}
	return $code;
}
if (empty($_POST['Submit']))
{
$link = mysql_connect('localhost', 'wizard', 'g10gg') or die('could not connect to sql server');
mysql_select_db("wizard", $link);
$query2 = "select * from attributes";
$result2 = mysql_query($query2, $link) or die("could not execute query $query2");
?>
<h3>Add new license</h3>
<form name="data" method="post" action="addnewli.php">
<p align="center">
<table align="center" border="0" cellspacing="0" cellpadding="0">
<tr>
<td align="right" bgcolor="#DDDDDD">License Text:</td>
<td align="left" bgcolor="#FFFFFF"><input type="text" name="licensetext">
</tr>
</table>
</p>
<h3>Please choose the attributes associated with this license from the following table:</h3>
<table align="center" border="0" cellpadding="0" cellspacing="0">
			<tr><td align="left"><strong>Attributes</strong></td>
			                                                                                
			<td align="left"><strong>Check</strong></td>
			
			<tr><td align="left"><hr size=1 align=left width=100% style='border: dotted;'></td></tr>
<?php 
$g = 0;
while($row2 = mysql_fetch_array($result2))
{
	$aid = $row2['attributeid'];			?>
<tr><td align="left" valign="bottom" width="550" bgcolor="<?php if ($g%2 == 0){ printf("#CCCCCC");} else {printf("#FFFFFF");}?>"><ul><li><?php printf($row2['attributetext']);?></li></ul></td><td align="center" valign="top" bgcolor="<?php if ($g%2 == 0){ printf("#CCCCCC");} else {printf("#FFFFFF");}?>"><input type="checkbox" name="<?php printf($aid);?>" value="1"></td>
			</tr>
<?php $g++; }
?>
<tr>
<td align="center" colspan="2"><input type="submit" name="Submit" value="Submit">
</td></tr></table>
</form>
<?php
}
else
{
	$code = calcode($_POST);
	$link = mysql_connect('localhost', 'wizard', 'g10gg') or die('could not connect to sql server');
	mysql_select_db("wizard", $link);
	$query = "insert into licenses (licensetext, licensecode) values ('".$_POST['licensetext']."', ".$code.")";
	$result = mysql_query($query, $link) or die("could not execute query $query");
	?>
	<h3 align="center">Insert successful!</h3>
	<h3 align="center">Please click <a href="managewizard.php">here</a> to go back to the main menu</h3> 
<?php
}
?>
