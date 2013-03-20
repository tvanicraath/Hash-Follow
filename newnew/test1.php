<?php
$pagetitle = "Pull Twitter Hashtags";
#require 'header.inc';

function getTweets($hash_tag,$page,$rpp,$result_type) {

    $url = 'http://search.twitter.com/search.atom?q='.urlencode($hash_tag).'&rpp='.$rpp.'&page='.$page.'&result_type='.$result_type;
 //   echo "<p>Connecting to <strong>$url</strong> ...</p>";
    $ch = curl_init($url);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $xml = curl_exec ($ch);
    curl_close ($ch);

    //If you want to see the response from Twitter, uncomment this next part out:
   // echo "<p>Response:</p>";
    //echo "<pre>".htmlspecialchars($xml)."</pre>";
	if($result_type == 'recent')
	{
	echo "<strong>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspLatest Tweets<br><hr></strong>";
	}
	echo "<ul>";
    $affected = 0;
    $twelement = new SimpleXMLElement($xml);
    foreach ($twelement->entry as $entry) {
        $text = trim($entry->title);
        $author = trim($entry->author->name);
        $time = strtotime($entry->published) + 12600;
		
        echo "<li><p>".$author.":<br> <strong>".$text."</strong>  <em><br>Posted ".date('j M, Y g:i a',$time)."</em></p></li>";
    }
	echo "</ul>";

    return true ;
}
$result_type = $_GET["result_type"];
$rpp = $_GET["rpp"];
$page = $_GET["page"];
getTweets('#modihangout OR #india',$page,$rpp,$result_type);

echo "<hr /><p>This page is an example for the article <a href=\"http://www.inkplant.com/code/get-twitter-posts-by-hashtag.php\">Get All Twitter Posts of a Specific Hashtag in PHP</a>.</p>" ;

#require 'footer.inc';
?>