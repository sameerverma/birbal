<?php
function finddepth($aid, $link)
{
	$query = "select * from attributes where attributeid = $aid";
	$result = mysql_query($query, $link) or die("could not execute query $query");
	$row = mysql_fetch_array($result);
	if (($row['nextqid1'] == 0) && ($row['nextqid2'] == 0)) {$depth = 1;}
	elseif (($row['nextqid1'] == 0) && ($row['nextqid2'] > 0)) {$depth = finddepth($row['nextqid2'], $link);}
	elseif (($row['nextqid1'] > 0) && ($row['nextqid2'] == 0)) {$depth = finddepth($row['nextqid1'], $link);}
	else 
	{
	$depth1 = finddepth($row['nextqid1'], $link); 
	$depth2 = finddepth($row['nextqid2'], $link);
	if ($depth1 >= $depth2) {$depth = $depth1;} else {$depth = $depth2;}
	}
	return $depth+1;
}

function gettree($level, $link)
{
	if ($level == 1)
	{
		$query = "select * from attributes where attributetype = 1";
		$result = mysql_query($query, $link) or die("could not execute query $query");
		$row = mysql_fetch_array($result);
		$trees[0]['value'] = $row['attributeid'];
		$trees[0]['type']= 0;
	}
	else
	{
		$tree = gettree($level - 1, $link);
		for($i=0; $i<count($tree); $i++)
		{
			if (($tree[$i]['value']!= 0) && ($tree[$i]['type'] != 1))
			{
				$t = $tree[$i]['value'];
				$query = "select * from attributes where attributeid = $t";
				$result = mysql_query($query, $link) or die("could not execute query $query");
				$row = mysql_fetch_array($result);
				if($row['nextqid1'] != 0) {$trees[$i*2]['value'] = $row['nextqid1'];$trees[$i*2]['type']=0;} else {$trees[$i*2]['value'] = $row['licenseid1'];$trees[$i*2]['type']=1;}
				if($row['nextqid2'] != 0) {$trees[$i*2+1]['value'] = $row['nextqid2'];$trees[$i*2+1]['type']=0;} else {$trees[$i*2+1]['value'] = $row['licenseid2'];$trees[$i*2+1]['type']=1;}
			}
			else
			{
				$trees[$i*2]['value'] = 0;
				$trees[$i*2+1]['value'] = 0;
			}			
		}
	}
	return $trees;
}
	
		
	
	
	
$link = mysql_connect('localhost', 'wizard', 'g10gg') or die('could not connect to sql server');
mysql_select_db("wizard", $link);
$query2 = "select * from attributes where attributetype = 1";
$result2= mysql_query($query2, $link) or die("could not execute query $query");
$row2 = mysql_fetch_array($result2);
$adepth = finddepth($row2['attributeid'], $link);
?>
<p><strong>Attributes Management </strong></p>
<table align="center" border="2" cellpadding="5" cellspacing="5" bgcolor="#3399FF" bgcolor="">
<?php 
for($i = 1; $i <= $adepth; $i++)
{
if (($i % 2 ) == 0) {$bgcolor = "#336699";} else {$bgcolor = "#3366CC";}
	?><tr bgcolor="<?php printf($bgcolor);?>"><?php
	$trees = gettree($i, $link);
	foreach($trees as $tre)
	{
		if (($tre['type'] == 0) && ($tre['value'] != 0)) 
		{
			$num = pow(2, $adepth - $i + 1);
			$val = $tre['value'];
			$query = "select * from attributes where attributeid = $val";
			$result = mysql_query($query, $link) or die("could not execute query $query");
			$row = mysql_fetch_array($result);
			?><td align="center" colspan="<?php printf($num);?>"><?php printf($row['attributetext']);?></td>
		<?php
		}
		elseif (($tre['type'] != 0) && ($tre['value'] != 0))
		{
			$num = pow(2, $adepth - $i + 1);
			$val = $tre['value'];
			$query = "select * from licenses where licenseid = $val";
			$result = mysql_query($query, $link) or die("could not execute query $query");
			$row = mysql_fetch_array($result);
			?><td align="center" colspan="<?php printf($num);?>"><?php printf($row['licensetext']);?></td>
		<?php 
		}
		else
		{
			$num = pow(2, $adepth - $i + 1);?>
			<td align="center" colspan="<?php printf($num);?>"></td>
		<?php 
		}?>
		
<?php } ?>
</tr>
<?php } ?>
</table>
