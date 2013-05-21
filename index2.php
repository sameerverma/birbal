<?php
foreach($_POST as $key=>$val)
{
    $$key = $val;
}
$link = mysql_connect('localhost', 'wizard', 'g10gg') or die('could not connect to sql server');
mysql_select_db("wizard", $link);
if (!empty($_POST['Submit']))
{
		$count2 = 0;
		$changed = false;
		while (($count2 < $count) && ($changed == false))
		{
			$count2++;
			if ((!isset($${"aid_$count2"}) && (${"avalue_$count2"} == 1)) || (isset($${"aid_$count2"}) && (${"avalue_$count2"} == 0) && (!isset($new)))) {$changed = true;}	
		}
		if ($changed === true) {$count = $count2;} 
		$aid = ${"aid_$count2"};
		$query2 = "select * from attributes where attributeid = $aid";
		$result2 = mysql_query($query2, $link) or die("Could not execute query $query2");
		$row2 = mysql_fetch_array($result2);
		if (isset($$aid)) {$nqid = $row2['nextqid1']; ${"avalue_$count2"} = 1;} else {$nqid = $row2['nextqid2']; ${"avalue_$count2"} = 0;}?>
		<div align="center">
  			<form name="form1" method="post" action="index.php">
			<table align="center" border="0" cellpadding="0" cellspacing="0">
			<tr>
			  <td align="left" ><strong>Attributes</strong></td>
			  <td align="center"><strong>Check</strong></td>
			<tr><td align="left" colspan="2"><hr size=1 align=left width=100% style='border: dotted;'></td></tr>
		<?php for ($t = 1; $t <= $count; $t++)
		{
			$query = "select * from attributes where attributeid = '${"aid_$t"}'";
			$result = mysql_query($query, $link) or die("could not execute query $query");
			$row = mysql_fetch_array($result);?>
			<tr><td align="left" valign="bottom" width="300" bgcolor="#EEEEEE"><ul><li><?php printf($row['attributetext']);?></li></ul></td><td align="center" valign="top" bgcolor="#999999"><input type="checkbox" name="<?php printf($row['attributeid']);?>" value="1" <?php if(${"avalue_$t"} == 1){printf("checked");}?>></td>
			<input type="hidden" name="<?php printf("aid_".$t);?>" value="<?php printf(${"aid_$t"});?>">
			<input type="hidden" name="<?php printf("avalue_".$t);?>" value="<?php printf(${"avalue_$t"});?>">
			</tr><?php
		}
		 
		if ($nqid != 0)
		{
			$count += 1;
			$query = "select * from attributes where attributeid = '$nqid'";
			$result = mysql_query($query, $link) or die("could not execute query $query");
			$row = mysql_fetch_array($result);
			?>
			<tr><td align="left" valign="bottom" width="300" bgcolor="#EEEEEE"><ul><li><?php printf($row['attributetext']);?></li></ul></td><td align="center" valign="top" bgcolor="#999999"><input type="checkbox" name="<?php printf($row['attributeid']);?>" value="1"></td></tr>
			<input type="hidden" name="<?php printf("aid_".$count);?>" value="<?php printf($row['attributeid']);?>">
			<?php 
			$value = "Next";?>
			<tr><td colspan="2" align="center"><input type="submit" name="Submit" value="<?php printf($value);?>">
		<?php 
			
			
	 	}
		else
		{
			if (isset($$aid)) {$lid = $row2['licenseid1'];} else {$lid = $row2['licenseid2'];}
			$query5 = "select * from licenses where licenseid = $lid";
			$result5 = mysql_query($query5, $link) or die("could not execute query $query5");
			$row5 = mysql_fetch_array($result5);?><?php
			mysql_close($link);
			$value = "Correct";?>
			<input type="hidden" name="finish" value="1"><tr><td colspan="2" align="center"><input type="submit" name="submit2" value="Reset">
		
		
		</td>
		</table>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<table bgcolor="#00FFFF" border="0" cellpadding="0" cellspacing="0" align="center" height="100" width="500">
		<tr><th>Use the <?php printf($row5['licensetext']);?> license.</th></tr>
		</table>
		<?php }?>
		<input type="hidden" name="count" value="<?php printf($count);?>">
		  </form>
</div>
<?php 
}
else
{
	$count = 1;
	$query4 = "select * from attributes where attributetype = 1";
	$result4 = mysql_query($query4, $link) or die("could not execute query $query4");
	$row4 = mysql_fetch_array($result4);
	$aid = $row4['attributeid'];
	?>
	<div align="center">
	<form name="form1" method="post" action="index.php">
			<table align="center" border="0" cellpadding="0" cellspacing="0">
			<tr><td align="left"><strong>Attribute</strong></td>
			                                                                                
			<td align="left"><strong>Check</strong></td>
			
			<tr><td align="left"><hr size=1 align=left width=100% style='border: dotted;'></td></tr>
			<tr><td align="left" valign="bottom" width="300" bgcolor="#EEEEEE"><ul><li><?php printf($row4['attributetext']);?></li></ul></td><td align="center" valign="top" bgcolor="#999999"><input type="checkbox" name="<?php printf($aid);?>" value="1"></td>
			</tr>
			<tr><td colspan="2" align="center"><input type="hidden" name="new" value="1"><input type="hidden" name="count" value="<?php printf($count);?>"><input type="hidden" name="<?php printf("aid_".$count);?>" value="<?php printf($aid);?>"><input type="submit" name="Submit" value="Next"></td>
		</table>   	        
	</form>
</div>
<?php
mysql_close($link);
}?>
