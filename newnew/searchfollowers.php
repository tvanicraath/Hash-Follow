<?php
$follower_url = "http://api.twitter.com/1/statuses/followers/VJ_Keswani.xml";
 
$twFriends = curl_init();
 
curl_setopt($twFriends, CURLOPT_URL, $follower_url);
curl_setopt($twFriends, CURLOPT_RETURNTRANSFER, TRUE);
$twiFriends = curl_exec($twFriends);
$response = new SimpleXMLElement($twiFriends);
 
foreach($response->user as $friends){ 
$thumb = $friends->profile_image_url;
$url = $friends->screen_name;
$name = $friends->name;
 
 
?>
 
 
 
<a title="<?php echo $name;?>" href="http://www.twitter.com/<?php echo $url;?>"><img class="photo-img" src="<?php echo $thumb?>" border="0" alt="" width="40" /></a>
<?php
} 
 
?>