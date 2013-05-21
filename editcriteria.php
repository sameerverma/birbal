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
function calcode2($num)
{
	$result = $num - pow(2, floor(log(2, $num)));
	if ($result == 0)
	{
		$att[log(2, $num)] = log(2, $num);

	}
	else
	{
		$att = calcode2($result);
		$att[floor(log(2, $num))] = floor(log(2, $num));
		
	}
	return $att;
}
if(empty($_POST['Submit']))
{
	$link = mysql_connect('localhost', 'wizard', 'g10gg') or die('could not connect to sql server');
	mysql_select_db("wizard", $link);
	$query = "select * from licenses where licenseid = ".$_GET['lid'];
	$result = mysql_query($query, $link) or die("could not execute query $query");
	$row = mysql_fetch_array($result);
?>
<h3>Edit Criteria</h3>
<form name="data" method="post" action="editcriteria.php">
<h3>Please choose the attributes associated with this license from the following table:</h3>
<table align="center" border="0" cellpadding="0" cellspacing="0">
			<tr><td align="left"><strong>Attributes</strong></td>
			                                                                                
			<td align="left"><strong>Check</strong></td>
			
			<tr><td align="left"><hr size=1 align=left width=100% style='border: dotted;'></td></tr>
<?php
$atts = calcode2($row['licensecode']);
$query2 = "select * from attributes";
$result2 = mysql_query($query2, $link) or die("could not execute query $query2");
$g = 0;
while($row2 = mysql_fetch_array($result2))
{
	$aid = $row2['attributeid'];			?>
<tr><td align="left" valign="bottom" width="550" bgcolor="<?php if ($g%2 == 0){ printf("#CCCCCC");} else {printf("#FFFFFF");}?>"><ul><li><?php printf($row2['attributetext']);?></li></ul></td><td align="center" valign="top" bgcolor="<?php if ($g%2 == 0){ printf("#CCCCCC");} else {printf("#FFFFFF");}?>"><input type="checkbox" name="<?php printf($aid);?>" value="1"
<?php if (!empty($atts[$aid])) {printf("checked");}?>></td>
			</tr>
<?php $g++; }
?>
<tr>
<td align="center" colspan="2"><input type="submit" name="Submit" value="Submit">
</td></tr></table>
<input type="hidden" name="lid" value="<?php printf($_GET['lid']);?>">
</form>
<?php
}
else
{
$code = calcode($_POST);
$link = mysql_connect('localhost', 'wizard', 'g10gg') or die('could not connect to sql server');
mysql_select_db("wizard", $link);
$query = "update licenses set licensecode = ".$code." where licenseid = ".$_POST['lid'];
$result = mysql_query($query, $link) or die("could not execute query $query");
?>
<h3 align="center">Update successful!</h3>
<h3 align="center">Please click <a href="managewizard.php">here</a> to go back to the main menu</h3>
<?php
}
?>
