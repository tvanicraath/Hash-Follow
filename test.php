<?php
$pagetitle = "Pull Twitter Hashtags";
#require 'header.inc';
$type = $_GET["type"];
function getTweets($hash_tag,$page) {

    $url = 'http://search.twitter.com/search.atom?q='.urlencode($hash_tag);
    echo "<p>Connecting to <strong>$url</strong> ...</p>";
    $ch = curl_init($url);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $xml = curl_exec ($ch);
    curl_close ($ch);

    //If you want to see the response from Twitter, uncomment this next part out:
   // echo "<p>Response:</p>";
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
$i=1;
for($i=1;$i<4;$i++)
{
getTweets('#modihangout','$i');
}
echo "<hr /><p>This page is an example for the article <a href=\"http://www.inkplant.com/code/get-twitter-posts-by-hashtag.php\">Get All Twitter Posts of a Specific Hashtag in PHP</a>.</p>" ;

#require 'footer.inc';
?>