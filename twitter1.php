
<?php
$pagetitle = "Pull Twitter Hashtags";
//require 'header.inc';
session_start();
print_r($_SESSION);
function getTweets($hash_tag) {

    $url = 'http://search.twitter.com/search.atom?q='.urlencode($hash_tag) ;
    echo "<p>Connecting to <strong>$url</strong> ...</p>";
    $ch = curl_init($url);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $xml = curl_exec ($ch);
    curl_close ($ch);

    //If you want to see the response from Twitter, uncomment this next part out:
    //echo "<p>Response:</p>";
    //echo "<pre>".htmlspecialchars($xml)."</pre>";

    $affected = 0;
    $twelement = new SimpleXMLElement($xml);
    foreach ($twelement->entry as $entry) {
        $text = trim($entry->title);
        $author = trim($entry->author->name);
        $time = strtotime($entry->published);
        $id = $entry->id;
	echo "<p>Tweet from ".$author.": <strong>".$text."</strong>  <em>Posted ".date('n/j/y g:i a',$time)."</em></p>";
     }

    return true ;
}
$tweet = "#".$_GET['hashtags'];
getTweets($tweet);
$user=$_SESSION['user'];
$tag=$_GET['hashtags'];
echo $user;
echo "<br>";
echo "<form method='post' action='redirect.php?user=$user&tag=$tag' >";
echo "<input type='radio' name='subscribe' value='Yes' />Yes<br>";
echo "<input type='radio' name='subscribe' value='No' />No<br>";
//echo "<input type='text' name='subscribe' /> Yes / No <br>";
echo "<input type='submit' name='Submit' />";

//require 'footer.inc';
?>
