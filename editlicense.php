<?php 
if (empty($HTTP_POST_VARS['Submit']))
{
?>
<html>
<head>
<title>Edit License</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function askDelete(lid)
{
	if (confirm("are you sure to delete this license?"))
	{
		location.href="license_delete.php?lid=" + lid;
	}
}
</script>
</head>
<body>
<h3><a href="managewizard.php">Main menu</a></h3>
<h3>Manage Licenses</h3>
<p></p>
<form name="data" method="post" action="editlicense.php">
<table align="center" cellspacing="0" cellpading="2" border="2" bordercolor="#003366" bgcolor="#666666">
<tr>
<th bgcolor="#0066CC"></th>
<th bgcolor="#0066CC">License ID</th>
<th bgcolor="#0066CC">License Text</th>
<th bgcolor="#0066CC">License Code</th>
</tr>
<?php
$link = mysql_connect('localhost', 'wizard', 'g10gg') or die('could not connect to sql server');
mysql_select_db("wizard", $link);
$query = "select * from licenses";
$result = mysql_query($query, $link) or die("could not execute query $query");
while ($row = mysql_fetch_array($result))
{
	?>
	<tr>
	<th bgcolor="#ffffff">[<a href="editcriteria.php?lid=<?php printf($row['licenseid']);?>">Edit Criteria</a>][<a href="#" onClick="askDelete(<?php printf($row['licenseid']);?>)">Delete</a>]</td>
	<th bgcolor="#ffffff"><?php printf($row['licenseid']);?></td>
	<th bgcolor="#ffffff"><input type="text" name="<?php printf($row['licenseid']);?>" value="<?php printf($row['licensetext']);?>"></td>
	<th bgcolor="#ffffff"><?php printf($row['licensecode']);?></td>
	</tr>
<?php
}
?>
<tr>
<td align="center" colspan="4" bgcolor="#ffffff"><input type="button" onclick="javascript:document.location='addnewli.php'" name="addnew" value="Add New License"><input type="submit" value="Update" name="Submit"></td></tr>
</table>
</body></html>
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
	$query2 = "select * from licenses";
	$result2 = mysql_query($query2, $link) or die("could not execute query $query2");
	while($row2 = mysql_fetch_array($result2))
	{
		$query3 = "update licenses set licensetext = '".$$row2['licenseid']."' where licenseid = ".$row2['licenseid'];
		$result3 = mysql_query($query3, $link) or die("could not execute query $query3");
	}
header("Location: editlicense.php");
}
?>
