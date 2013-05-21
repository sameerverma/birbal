<?php
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
$aid = $HTTP_GET_VARS['aid'];
$link = mysql_connect('localhost', 'wizard', 'g10gg') or die('could not connect to sql server');
mysql_select_db("wizard", $link);
$query = "delete from attributes where attributeid = ".$HTTP_GET_VARS['aid'];
$result = mysql_query($query, $link) or die("could not execute query $query");
$query2 = "select * from licensecode";
$result2 = mysql_query($query2, $link) or die("could not execute query $query2");
while($row2=mysql_fetch_array($result2))
{
	$atts = calcode2($row2['licensecode']);
	if (array_search($aid, $atts) !== false)
	{
		$newcode = $row2['licensecode'] - pow(2, $aid);
		$query3 = "update licensecode set licensecode = ".$newcode." where id = ".$row2['id'];
		$result3 = mysql_query($query3, $link) or die("could not execute query $query3");
	}
}
header("Location: editattributes.php");
?>
