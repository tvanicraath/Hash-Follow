<!DOCTYPE HTML>
<?php
$page=1;
?>

<html>

<head>
  <title>CSS3_three</title>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <!-- modernizr enables HTML5 elements and feature detects -->
  <script type="text/javascript" src="js/modernizr-1.5.min.js"></script>
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.5.1.min.js"> </script>
<script>
  //function updateShouts(){
    // Assuming we have #shoutbox
    //$('#sidebar_container').load('test1.php?page=1&rpp=10');
//}
//setInterval( "updateShouts()", 10000 );
  </script>
  

<script>

//function updateShouts(){    
//$('#sidebar_container').load('test1.php?page=1&rpp=3');
//}; 
//setInterval(updateShouts, 5000 );

</script>
  
  
  <?php
  //function loadlatest(){
		/*$page1 = 1;
          
			$a = '$.get("test1.php?rpp=15&page=';
			$a2 = '", function (data){';
    $b = ' $("#sidebar_container").append(data)';
    $c = '});';
	echo ('<script>'.$a.$page1.$a2.$b.$c.'</script>');
			$page1=$page1+1;
			//if($page<=3) loadmore();
			}
			*/
			//$('#result').load('ajax/test.html');
			/*function updateShouts(){
    // Assuming we have #shoutbox
    $('#shoutbox').load('latestShouts.php');
}
setInterval( "updateShouts()", 10000 );*/
  ?>
  
  <?php
  function loadmore(){}
		/*global $page;
          
			$a = '$.get("test1.php?rpp=100&page=';
			$a2 = '", function (data){';
    $b = ' $("#content_item").append(data)';
    $c = '});';
	echo ('<script>'.$a.$page.$a2.$b.$c.'</script>');*/
  ?>
  
  
</head>

<body>
  <div id="main">
    <header>
      <div id="logo">
        <!-- class="logo_colour", allows you to change the colour of the text -->
        <h1><a href="index.html">CSS<span class="logo_colour">3</span>_three</a></h1>
      </div>
      <nav>
        <ul class="sf-menu" id="nav">
          <li><a href="index.html">Home</a></li>
          <li><a href="examples.html">Examples</a></li>
          <li><a href="page.html">A Page</a></li>
          <li><a href="another_page.html">Another Page</a></li>
          
          <li><a href="contact.php">Contact Us</a></li>
        </ul>
      </nav>
    </header>
    <div id="site_content">
      
		<?php include("sidebar.php");?>

     
      <div id="content">
        <ul class="slideshow">
          <li class="show"><img width="706" height="270" src="images/1.jpg" alt="image one" /></li>
          <li><img width="706" height="270" src="images/2.jpg" alt="image two" /></li>
          <li><img width="706" height="270" src="images/3.jpg" alt="image three" /></li>
        </ul>
        <div id="content_item">
        
		
		</div>
      </div>
    </div>
    <footer>
      <p><a href="index.html">Home</a> | <a href="examples.html">Examples</a> | <a href="page.html">A Page</a> | <a href="another_page.html">Another Page</a> | <a href="contact.php">Contact Us</a></p>
      <p>Copyright &copy; CSS3_three | <a href="http://www.css3templates.co.uk">design from css3templates.co.uk</a></p>
    </footer>
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
