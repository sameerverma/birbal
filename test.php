<?php
printf("submit = ".$HTTP_GET_VARS['Submit']);
foreach($HTTP_GET_VARS as $key=>$val)
{
	printf($key." = ".$val."<br>");
}
?>
<html>
<body>
<form name="test" method="get" action="test.php">
<input type="hidden" name="a1" value="1">
<input type="hidden" name="a2" value="2">
<input type="submit" name="Submit" value="Submit">
</form>
</body>
</html>	