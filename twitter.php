<!DOCTYPE HTML>
<?php
session_start();
//print_r($_SESSION);
if(!isset($_SESSION))
	header("Location : login.php/");
$page=1;
?>

<html>

<head>
  <title>#Follow</title>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <!-- modernizr enables HTML5 elements and feature detects -->
  <script type="text/javascript" src="js/modernizr-1.5.min.js"></script>
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.5.1.min.js"> </script>
  <?php
  function loadmore(){
		global $page;
          
			$a = '$.get("test1.php?page=';
			$a2 = '", function (data){';
    $b = ' $("#content_item").append(data)';
    $c = '});';
	echo ('<script>'.$a.$page.$a2.$b.$c.'</script>');
			$page=$page+1;
			if($page<=3) loadmore();
			}
$user=$_SESSION['user'];
$conn=mysql_connect("localhost","root","keswani");
mysql_select_db("twitter",$conn);
$sql = "select * from users where twitter_id='$user'";
$res=mysql_query($sql);
$r=mysql_fetch_array($res);
$username=$r['facebook_id'];
  
?>
  
</head>

<body>
  <div id="main">
    <header>
      <div id="logo">
        <!-- class="logo_colour", allows you to change the colour of the text -->
        <h1><a href="index.php"><span class="logo_colour">#</span>_Follow</a></h1>
      </div>
      <nav>
        <ul class="sf-menu" id="nav">
          <li><a href="index.php">Home</a></li>
          <li><a href="fb_tweets.php">Friends #hashtags</a></li>
          <li><a href="logout.php">Logout</a></li>
          
          <li><a href="about.php">About</a></li>
        </ul>
      </nav>
    </header>
    <div id="site_content">
     <!-- <div id="sidebar_container">
        <div class="sidebar">
          <h1>Latest News</h1>
          <h2>New Website Launched</h2>
          <p>We've redesigned our own website. Take a look around and let us know what you think.</p>
        </div>
        <div class="sidebar">
          <h1>Special Offers</h1>
          <h2>10% Discount</h2>
          <p>For the month of February 2012, we are offering a 10% discount for all new visitors.</p>
        </div>
        <div class="sidebar">
          <h1>Contact Us</h1>
          <p>We'd love to hear from you. Call us, <a href="#">email us</a> or complete our <a href="contact.php">contact form</a>.</p>
        </div>
      </div>-->
	<?php include("sidebar.php"); ?>
      <div id="content">
        <ul>
          <li><img width="650" height="270" src="images/1.jpg" alt="image one" /></li>
         <!--<li><img width="706" height="270" src="images/2.jpg" alt="image two" /></li>-->
         <!--<li><img width="650" height="270" src="images/3.jpg" alt="image three" /></li>-->
        </ul>
        <div id="content_item">
          <h1></h1>
		<p>
	<?php
	
	$hash=$_GET['hashtags'];
	$user=$_SESSION['user'];
	$sql = "select * from $user where hashtags='$hash'";
	//echo $sql;
	$res=mysql_query($sql);
	$r=mysql_fetch_array($res);
	if($r!=NULL)
	{
		//echo "hiii";
		//$r=mysql_fetch_array($res);
		//print_r($r);
		if($r['subscribe']=='Yes')
			echo "<h2> You are subscribed to this hashtag. <a href='redirect.php?order=unsubscribe&tag=$hash' >Unsubscribe</a><br>";
		else
			echo "<h2> You are not subscribed to this hashtag. <a href='redirect.php?order=resubscribe&tag=$hash' >Subscribe</a><br>";
	}
	else{
		//echo "hi";
		echo "<h2> You are not subscribed to this hashtag. <a href='redirect.php?order=subscribe_new&tag=$hash' >Subscribe</a><br>"; 
	}

	?>
	<h1>Search Results :</h1>
<?php
	function getTweets($hash_tag,$page,$rpp) {

    $url = 'http://search.twitter.com/search.atom?q='.urlencode($hash_tag).'&rpp='.$rpp.'&page='.$page;
    //echo "<p>Connecting to <strong>$url</strong> ...</p>";
    $ch = curl_init($url);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $xml = curl_exec ($ch);
    curl_close ($ch);

    //If you want to see the response from Twitter, uncomment this next part out:
   // echo "<p>Response:</p>";
    //echo "<pre>".htmlspecialchars($xml)."</pre>";
	echo "<ul>";
    $affected = 0;
    $twelement = new SimpleXMLElement($xml);
    foreach ($twelement->entry as $entry) {
        $text = trim($entry->title);
        $author = trim($entry->author->name);
        $time = strtotime($entry->published) + 12600;
        $id = $entry->id;
	$i=0;
	while($text[$i+4]!=NULL)
	{
		if($text[$i]=='h'&&$text[$i+1]=='t'&&$text[$i+2]=='t'&&$text[$i+3]=='p')
		{	
			$j=$i;
			//$text1="<a href='
			//$k=9;
			/*while(1)
			{
				if($text[$j]==' ')
					break;
				//$text1.=$text[$j];
				echo $text[$j];
				$j++;
				//$k++;
			}*/
			//$text2=substr($text,$i,$j-$i);
			//echo $text2."<br>".$j."<br>".$i;
			//$text1="<a href='".$text2."' >";
		
		$len=strlen($text);
		$temp1=substr($text,0,$i-1);
		$temp2=substr($text,$i,$j-1);
		$temp3=substr($text,$j,$len);
		//$text=$temp1.$text1.$temp2." </a>".$temp3;
		
		}
		$i++;
	}
				
        echo "<li><p>".$author."<br> <strong>".$text."</strong>  <em><br>Posted ".date('j M, Y g:i a',$time)."</em></p></li>";
    }
	echo "</ul>";

    return true ;
}
$hash=$_GET['hashtags'];
$hash="#".$hash;
//$page=$_GET['page'];
//$rpp=$_GET['rpp'];
getTweets($hash,5,100);	
?>

	</p>
	</div>
    </div>
    </div>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
  </div>
  <!-- javascript at the bottom for fast page loading -->
  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="js/jquery.easing-sooper.js"></script>
  <script type="text/javascript" src="js/jquery.sooperfish.js"></script>
  <script type="text/javascript" src="js/image_fade.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('ul.sf-menu').sooperfish();
    });
  </script>
</body>
</html>
