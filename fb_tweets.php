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
  <title># Follow</title>
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
      <!--<div id="sidebar_container">
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
          <!--<li><img width="706" height="270" src="images/2.jpg" alt="image two" /></li>
          <li><img width="706" height="270" src="images/3.jpg" alt="image three" /></li>
        --></ul>
        <div id="content_item">
		<p>
	<?php include("fb_friends.php"); ?>

	</p>
	</div>
      </div>
    </div>
<!--    <footer>
      <p><a href="index.html">Home</a> | <a href="examples.html">Examples</a> | <a href="page.html">A Page</a> | <a href="another_page.html">Another Page</a> | <a href="contact.php">Contact Us</a></p>
      <p>Copyright &copy; CSS3_three | <a href="http://www.css3templates.co.uk">design from css3templates.co.uk</a></p>
    </footer>-->
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
