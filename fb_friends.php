<?php 
include '../src/facebook.php';
session_start();
$user=$_SESSION['user'];
$conn=mysql_connect("localhost","root","keswani");
mysql_select_db("twitter",$conn);
$sql = "select * from users where twitter_id='$user'";
$res=mysql_query($sql);
$r=mysql_fetch_array($res);
$username=$r['facebook_id'];
// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '350219158397808',
  'secret' => '2231cf66c52a7f3d75d2f60ad374327f',
));
//echo "hi";
 $access_t = $facebook->getAccessToken();
$fql="select username from user where uid in (select uid2 from friend where uid1 in (select uid from user where username='$username'))";

$friend = $facebook->api(array('method' => 'fql.query', 'query' => $fql, 'access_token' => $access_t));
$i=0;
//echo "hi";
//var_dump($friend);

while($friend[$i]!=NULL)
{
	//echo $friend[$i]['username']."<br>";
	$fb_id=$friend[$i]['username'];
	$query="select * from users where facebook_id='$fb_id'";
	//echo $query."<br>";
	
	$result=mysql_query($query);
	if($r=mysql_fetch_array($result))
	{
		//echo "*";	
		//$r=mysql_fetch_array($result);
		echo "<h2>$fb_id is subscribed to : <br></h2>";
		$tid=$r['twitter_id'];
		$sql = "select * from $tid where subscribe='Yes'";
		//echo $sql;
		$res = mysql_query($sql);
		while($row=mysql_fetch_array($res))
		{
			//echo "hi";
			$hash_tag=$row['hashtags'];
			$href='http://search.twitter.com/search.atom?q='.urlencode($hash_tag);
			echo "<h2><a href=$href >".$hash_tag." </a><br></h2>";
		}
		echo "<br>";
			
	}
	$i++;
}
	
