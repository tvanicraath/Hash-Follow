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
$conn=mysql_connect("localhost","root","keswani");
mysql_select_db("twitter",$conn);
$user=$_POST['user'];
$passwd=$_POST['password'];
$sql = "select * from users where twitter_id='$user' and password='$passwd'";
$res=mysql_query($sql);
$r=mysql_fetch_array($res);
if($r)
{
	$_SESSION['user']=$_POST['user'];
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">'; 
	//header("Location : home.php/");
}
else
{
	$fb=$_POST['fb'];
	$email=$_POST['email'];
	$query="insert into users values ('$user', '$email', '$fb', '$passwd')";
	$query2="create table $user (hashtags varchar(20), subscribe varchar(5))";
	mysql_query($query);
	echo $query;
	mysql_query($query2);
	echo "Username and password created for give input";
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=login.php">'; 
}
?>
</body>
