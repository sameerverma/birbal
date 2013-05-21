<html>
<head>
<title>Edit Attributes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function askDelete(aid)
{
	if (confirm("are you sure to delete this attribute?"))
	{
		location.href="att_delete.php?aid=" + aid;
	}
}
</script>
</head>
<body>
<?php if (empty($HTTP_POST_VARS['Submit']))
{
?>
<h3><a href="managewizard.php">Main menu</a></h3>
<h3>Manage Attributes</h3>
<p></p>
<form name="data" method="post" action="editattributes.php">
<table align="center" cellspacing="0" cellpading="2" border="2" bordercolor="#003366" bgcolor="#666666">
<tr>
<th bgcolor="#ffffff"></th>
<th bgcolor="#0066CC">Attribute ID</th>
<th bgcolor="#0066CC">Attribute Text</th>
</tr>
<?php
$link = mysql_connect('localhost', 'wizard', 'g10gg') or die('could not connect to sql server');
mysql_select_db("wizard", $link);
$query = "select * from attributes";
$result = mysql_query($query, $link) or die("could not execute query $query");
while ($row = mysql_fetch_array($result))
{
	?>
	<tr>
	<th bgcolor="#ffffff">[<a href="#" onClick="askDelete(<?php printf($row['attributeid']);?>)">Delete</a>]</td>
	<th bgcolor="#ffffff"><?php printf($row['attributeid']);?></td>
	<th bgcolor="#ffffff"><input type="text" name="<?php printf($row['attributeid']);?>" value="<?php printf($row['attributetext']);?>" size='100'></td>
	</tr>
<?php
}
?>
<tr>
<td align="center" colspan="4" bgcolor="#ffffff"><input type="button" onclick="javascript:document.location='addnewatt.php'" name="addnew" value="Add New Attribute"><input type="submit" value="Update" name="Submit"></td></tr>
</table>
<?php
}
else
{
	foreach($HTTP_POST_VARS as $key=>$val)
	{
	    $$key = $val;
	}
	$link = mysql_connect('localhost', 'wizard', 'g10gg') or die('could not connect to sql server');
	mysql_select_db("wizard", $link);
	$query2 = "select * from attributes";
	$result2 = mysql_query($query2, $link) or die("could not execute query $query2");
	while($row2 = mysql_fetch_array($result2))
	{
		$query3 = "update attributes set attributetext = '".$$row2['attributeid']."' where licenseid = ".$row2['licenseid'];
		$result3 = mysql_query($query3, $link) or die("could not execute query $query3");
	}
?>
<h3 align="center">The attributes table has been successfully updated!</h3>
<h3 align="center">click <a href="managewizard.php">Here</a> to go back to the main menu</h2>
<?php }
?>
</body></html>