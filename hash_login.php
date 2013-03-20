<html>
<head></head>
<body>
<?php
 	session_start();	
	//$_SESSION['user'] = "VJ_Keswani";
	echo "<form method='get' action='twitter.php'>
	<input type='text' name='hashtags' />
	<input type='submit' value='Submit' />";
	$fb_id = "vijay.keswani.35";
	echo "<a href='fb_friends.php?fb_id=$fb_id'>See subscribed tags of your friends </a>";
?>
</body>
</html>
