<html>
<head>

</head>
<body>
<style type="text/css">
body
{
	background-image : url("images/pattern.png");
}
</style>
<body>
<?php
session_start();
$user=$_SESSION['user'];
$tag=$_GET['tag'];
//$subscribe=$_POST['subscribe'];
$conn = mysql_connect("localhost","root","keswani");
mysql_select_db("twitter",$conn);
if($_GET['order']=='subscribe_new')
{
$query="insert into $user values ('$tag', 'Yes')";
//echo $query;
//echo $query;
mysql_query($query);
//mysql_close($conn);
}
if($_GET['order']=='resubscribe')
{
$query="update $user set subscribe='Yes' where hashtags='$tag'";
//echo $query;
//echo $query;
mysql_query($query);
//mysql_close($conn);
}
else if($_GET['order']=='unsubscribe')
{
	$query="update $user set subscribe='No' where hashtags='$tag'";
	//echo $query;
	mysql_query($query);
}
//header("Location : twitter.php?hashtags=$tag");	
 echo "<META HTTP-EQUIV='Refresh' Content='0; URL=twitter.php?hashtags=$tag'>";

?>
</body>
