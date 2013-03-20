
<?php
/**
 * Copyright 2011 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */


include '../src/facebook.php';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '350219158397808',
  'secret' => '2231cf66c52a7f3d75d2f60ad374327f',
));

// Get User ID
$user = $facebook->getUser();
//echo $user;
// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.


if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $loginUrl = $facebook->getLoginUrl();
}


?>


<style type="text/css">
* {
	margin: 0;
	padding: 0;
}

#container, #search-box {
font-family: "Trebuchet MS", Helvetica, Sans-Serif;
	font-size: 14px;
	width: 200px;
	padding: 2px;
	margin: 20px;
}


#container {
	margin: 22px 0 0 18px;
}

#submit {
	padding: 2px;
	margin: 20px;
	margin-left: 230px;
}
</style>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">

<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.6.0/build/cssgrids/grids-min.css" />
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<style media="screen" type="text/css">
<!--
/*  body und schrift deffinitionen */
html {
padding:0px;
margin:0px;
}
body {
background-color: #e1ddd9;
font-size: 12px;
font-family: Verdana, Arial, SunSans-Regular, Sans-Serif;
color:#564b47;
padding:0px;
margin:0px;
}
a {
color: #ff66cc;
font-size: 11px;
background-color:transparent;
text-decoration: none;
}
pre {
color: #564b47;
font-size: 11px;
background-color: #e1ddd9;
font-family: Courier, Monaco, Monospace;
}
p,h1, h3, pre {
padding: 5px 15px;
margin: 0px;
}
h3 {
font-size: 13px;
text-transform:uppercase;
color: #564b47;
background-color: transparent;
}
/*  positioning-layers dynamisch */
#logo {
position: absolute;
right: 2%;
width: 96%;
text-align: right;
top: 20px;
}
#left {
	position: absolute;
	left: 22px;
	width: 206px;
	top: 265px;
	background-color: #ffffff;
	height: 261px;
}
#middleleft {
	position: absolute;
	left: 275px;
	width: 221px;
	top: 271px;
	background-color: #ffffff;
	height: 244px;
}
#middleright {
	position: absolute;
	left: 559px;
	width: 212px;
	top: 276px;
	background-color: #ffffff;
	overflow: auto;
	height: 306px;
}
#right {
	position: absolute;
	left: 851px;
	width: 18%;
	top: 283px;
	background-color: #ffffff;
	overflow: auto;
}
#right, #middleright, #middleleft, #left {
border: 1px solid #564b47;
padding:0px;
margin:0px;
}
-->
</style>
<link type="text/css" rel="stylesheet" href="http://yui.yahooapis.com/2.6.0/build/autocomplete/assets/skins/sam/autocomplete.css">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>YUI AutoComplete</title>

<style type="text/css">
* {
	margin: 0;
	padding: 0;
}

#container, #search-box {
	font-family: "Trebuchet MS", Helvetica, Sans-Serif;
	font-size: 14px;
	width: 200px;
	padding: 2px;
	margin: 20px;
}

#container {
	margin: 22px 0 0 18px;
}

#submit {
	padding: 2px;
	margin: 20px;
	margin-left: 230px;
}
</style>
</head>

<body class="yui-skin-sam">
<form id="search-form" action="gui.php" method="get">
	<input type="text" id="search-box" name="search-box" />
	<input type="submit" value="Search!" id="submit" name="submit" />
</form>
<div id="container"></div>
<p align="center">
  <?

$access_t = $facebook->getAccessToken();


$fql="select name,uid from user where uid in 

(select uid2 from friend where 

uid1='$user')";
//echo $fql;
$friends = $facebook->api(array('method' => 

'fql.query', 'query' => $fql, 

'access_token' => $access_t));

for($i=0;$i<count($friends);$i++){
$friendscopy[$i]=$friends[$i]['name'];
$friendsids[$i]=$friends[$i]['uid'];
}


?>
  <script type="text/javascript" src="http://yui.yahooapis.com/2.6.0/build/yahoo-dom-event/yahoo-dom-event.js"></script>
  <script type="text/javascript" src="http://yui.yahooapis.com/2.6.0/build/datasource/datasource-min.js"></script>
  <script type="text/javascript" src="http://yui.yahooapis.com/2.6.0/build/animation/animation-min.js"></script>
  <script type="text/javascript" src="http://yui.yahooapis.com/2.6.0/build/autocomplete/autocomplete-min.js"></script>
  <script type="text/javascript">
<?php $j=0;?>
var i=0;
var friends =new Array(<?php
    for($j=0;$j<count($friendscopy);$j++){
		if($j!=0){
			echo ",";
		}
	   echo "\"$friendscopy[$j]\""; 
	}
	?>
);


	
var countries = new Array("United States", "Canada", "Mexico", "Russia", "India", "China", "Mongolia", "Romania", "Morocco");
var myDataSource = new YAHOO.util.LocalDataSource(friends);
var myAC = new YAHOO.widget.AutoComplete("search-box", "container", myDataSource);
  </script>
  <?

echo 'UID of Friend: ';
if(isset($_GET['search-box'])){
	//echo $_GET['search-box'];
	for($i=0;$i<count($friends);$i++){
		//echo $friends[$i]['name'];
		if(strcmp($friends[$i]['name'],$_GET['search-box'])==0){
			echo $friendsids[$i]."<br>";
			$uid=$friendsids[$i];
		}
	
	}
}
?>
  <?

echo 'Name: '.$_GET['search-box'];

?>
  <?

$fql="select pic_small from user where uid=".$uid;
$photo = $facebook->api(array('method' => 'fql.query', 'query' => $fql, 'access_token' => $access_t));

//var_dump($photo);
echo "<br><img src=".$photo[0]['pic_small']."></img>";

$fql="select online_presence from user where uid=".$uid;
$photo = $facebook->api(array('method' => 'fql.query', 'query' => $fql, 'access_token' => $access_t));

//var_dump($photo);
echo "<br>Online Presence:".$photo[0]['online_presence'];




?>
</p>
<div id="left">
  <h3 align="center">Emotional changes</h3>
  <div align="center">
    <pre>&nbsp;






    </pre>
  </div>
  <h3 align="center">&nbsp;</h3>
  <h3 align="center">&nbsp;</h3>
  <h3 align="center"><br />
    <br />
    <br />
  </h3>
</div>
<div id="middleleft">
  <h3 align="center">location anD TRAVELS</h3>
  <div align="center">
    <pre>&nbsp;







    </pre>
  </div>
  <p align="center">&nbsp;</p>
  <p align="center">&nbsp;</p>
  <p align="center">&nbsp;</p>
  <p align="center">&nbsp;</p>
  <p align="center">&nbsp;</p>
  <div align="center"><br />
    <br />
  </div>
</div>
<div id="middleright">
  <h3 align="center">PROFESSIONAL LIFE</h3>
  <div align="center">
    <pre>&nbsp;





    </pre>
  </div>
  <h3 align="center">&nbsp;</h3>
  <p align="center">&nbsp;</p>
  <p align="center">&nbsp;</p>
  <div align="center">
    <pre>&nbsp;





    </pre>
  </div>
  <h3 align="center">&nbsp;</h3>
  <p align="center">&nbsp;</p>
  <div align="center">
    <pre>&nbsp;



    </pre>
    <br />
    <br />
  </div>
</div>
<div id="right">
  <h3 align="center">Recent tweets</h3>
  <div align="center">
    <?php
echo "<br><br>";
$username="rameshsrivats"; // set user name
$format="json"; // set format
$tweet=json_decode(file_get_contents("http:/"."/api.twitter.com/1/statuses/user_timeline/$username.$format"));

for($i=0;$i<5;$i++){
$theTweet = ($tweet[$i]->text);

echo  "<h5 align=\"center\">".$theTweet."</h3><br>" ;
}

?>
  </div>
  <h3 align="center">&nbsp;</h3>
  <h3 align="center">&nbsp;</h3>
  <h3 align="center"><br />
    <br />
  </h3>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

</body>

</html>
