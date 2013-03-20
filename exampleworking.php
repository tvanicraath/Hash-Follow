hi

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
//echo "hi";
// Get User ID
$user = $facebook->getUser();
echo $user;
// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.
//echo "hi";
if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}
//echo "hi";
// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $loginUrl = $facebook->getLoginUrl();
}

// This call will always work since we are fetching public data.
$naitik = $facebook->api('/naitik');
echo "hi";
?>


<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title>php-sdk</title>
    <style>
      body {
        font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
      }
      h1 a {
        text-decoration: none;
        color: #3b5998;
      }
      h1 a:hover {
        text-decoration: underline;
      }
    </style>
<script src="http://yui.yahooapis.com/3.6.0/build/yui/yui-min.js"></script>
 <meta name="gmapkey" content="AIzaSyDncLs3cFFZoiClpesY5uWDbK7YCJVPjx0" />
    <script src="http://gmapez.n01se.net/gmapez-2.js" type="text/javascript"></script>


  </head>
  <body>
    <h1>php-sdk</h1>

    <?php if ($user): ?>
      <a href="<?php echo $logoutUrl; ?>">Logout</a>
    <?php else: ?>
      <div>
        Login using OAuth 2.0 handled by the PHP SDK:
        <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
      </div>
    <?php endif ?>

    <h3>PHP Session</h3>
    <pre><?//php print_r($_SESSION); ?></pre>

    <?php if ($user): ?>
      <h3>You</h3>
      <img src="https://graph.facebook.com/<?php echo $user; ?>/picture">

      <h3>Your User Object (/me)</h3>
      <pre><?php //print_r($user_profile); ?></pre>
    <?php else: ?>
      <strong><em>You are not Connected.</em></strong>
    <?php endif ?>

    <br><br>
    <?php 
//echo "hi";
//$enc = urlencode("select uid2 from friend where uid1='100002347693290'");
//$contents = file_get_contents("https://api.facebook.com/method/fql.query?query=$enc");
//echo $contents;
	//$uid = 1445571277;
	//$uid = 666799185;
	$uid = 100002347693290;
	//$uid = 100001484125148;
	//$uid = 100002417112761;
	$access_t = $facebook->getAccessToken();
        //$access_t = 'AAACEdEose0cBANWC9WyL6yU3IblaC3WZAkobSYSlcUqXVeZCDm1RfYMrFRWHpTjqyW0gkxob7YtmI90K8qnzFentEtfPaZBKCZAGJxdZBcXAI6W9WvFyV';
	//$fql = "SELECT place_id, message FROM status WHERE uid = '$uid'";
	//echo $fql;
        //$params = array('method' => 'fql.query', 'query' => "SELECT message FROM status WHERE uid = $user", 'access_token' => $access_t);
        //$res = $facebook->api($params);
	
        //var_dump($result);
        /*echo "<br><br>";
	$status = $facebook->api(array('method' => 'fql.query', 'query' => $fql, 'access_token' => $access_t));
        //var_dump($result);
	echo "<br><br>";
	$i=0;
	while($status[$i]!=NULL)
	{
		print_r($status[$i]['message']);
		echo "<br>";
		$i++;
	}
	*/
	//$result = json_decode($result);
	//print_r($result);
	
$fql = "SELECT status_id, message FROM status WHERE uid = '$uid' LIMIT 50";
        echo $fql;
        //$params = array('method' => 'fql.query', 'query' => "SELECT message FROM status WHERE uid = $user", 'access_token' => $access_t);
        //$res = $facebook->api($params);

        //var_dump($result);
        echo "<br><br>";
        $status = $facebook->api(array('method' => 'fql.query', 'query' => $fql, 'access_token' => $access_t));
        //var_dump($result);
        echo "<br><br>";
        $i=0;
        while($status[$i]!=NULL)
        {
                print_r($status[$i]['message']);
                $stat = $status[$i]['status_id'];
                $fql2 = "SELECT user_id FROM like WHERE post_id ='$stat'";
		echo $fql2;
                $like = $facebook->api(array('method' => 'fql.query', 'query' => $fql2, 'access_token' => $access_t));
                $count = count($like);
		$max=0;
                if($max<$count)
                {
                        $max=$count;
                        $maxstr=$status[$i]['message'];
                }
                echo "<br>";
                $i++;
        }
        echo "<strong> MAX LIKES".$maxstr."</strong><br>";





 //Working
	echo "<br><br>";
        $fql = "SELECT relationship_status FROM user WHERE uid = '$uid'";
        echo $fql;

        
        $rel_status = $facebook->api(array('method' => 'fql.query', 'query' => $fql, 'access_token' => $access_t));
        echo "<br>";
        $i=0;
        //while($rel_status[$i]!=NULL)
        //{
                if($rel_status[0]['relationship_status'])
			echo "<strong>Relationship Status : ".$rel_status[0]['relationship_status']."</strong><br>";
                echo "<br>";
         //       $i++;
        //}
	echo "<br><br>";
        /*$fql = "SELECT name from friendlist where uid1 in (SELECT significant_other_id FROM user WHERE uid = '$uid')";
        echo $fql;

        echo "<br>";
        $sig_other_id = $facebook->api(array('method' => 'fql.query', 'query' => $fql, 'access_token' => $access_t));
        
        $i=0;
		if($sig_other_id[0]['significant_other_id'])
                	echo "<strong> Significant person : ".$sig_other_id[0]['significant_other_id']."</strong>";
		else
			echo "None";
		echo "<br>";
	*/

	echo "<br><br>";
        $fql = "SELECT current_location FROM user WHERE uid = '$uid'";
        echo $fql;

        echo "<br>";
        $curr_loc = $facebook->api(array('method' => 'fql.query', 'query' => $fql, 'access_token' => $access_t));
       	//var_dump($curr_loc); 
        $i=0;
                if($curr_loc[0]['current_location'])
                        echo "<strong>Currently living in ".$curr_loc[0]['current_location']['city']."</strong>";
                else
                        echo "None";
                echo "<br>";
	
/*
	echo "<br><br>";
        $fql = "SELECT interests FROM user WHERE uid = '$uid'";
        echo $fql;

        echo "<br>";
        $interests = $facebook->api(array('method' => 'fql.query', 'query' => $fql, 'access_token' => $access_t));

        $i=0;
                //if($curr_loc[0]['interests'])
                  //      print_r($curr_loc[0]['current_location']);
                //else
                  //      echo "None";

		var_dump($interests);
                echo "<br>";
*/
	$year = 1;
	echo "<br><br>";
        $fql = "SELECT aid FROM album WHERE owner = '$uid' and name = 'Profile Pictures'";
        echo $fql;

        echo "<br>";
        $paid = $facebook->api(array('method' => 'fql.query', 'query' => $fql, 'access_token' => $access_t));
	var_dump($paid);
	$aid = $paid[0]['aid'];
        $i=0;
	$fql = "SELECT src, created FROM photo WHERE aid='$aid'";
	echo $fql;

        echo "<br>";
        $pic = $facebook->api(array('method' => 'fql.query', 'query' => $fql, 'access_token' => $access_t));
	//var_dump($pic);
	$curr_year = date('Y');
                echo "Now".$curr_year."<br>";
	$flag=0;
	while($pic[$i]!=NULL)
	{
		$past_year = $pic[$i]['created']/(365*24*3600) + 1970;
		$past_year = (int)$past_year;
		echo $past_year."<br>";
		
		if($past_year == ($curr_year-$year) && $flag==0)
		{	//	echo '<hr><img src="' + $pic[$i]['src'] + '" /><br>';
		?>
		<img src="<?php echo $pic[$i]['src']; ?> ">
		

		
	<?php	$flag=1;
		}
		$i++;
	}
	
	$fql = "SELECT url FROM profile_pic WHERE id=$uid AND width=250 AND height=150";
        echo $fql;

        echo "<br>";
        $pro_pic = $facebook->api(array('method' => 'fql.query', 'query' => $fql, 'access_token' => $access_t));
	//var_dump($pro_pic);?>         
	<img src="<?php echo $pro_pic[0]['url']; ?> ">
       <?php
	//if($curr_loc[0]['interests'])
                  //      print_r($curr_loc[0]['current_location']);
                //else
                  //      echo "None";
	/*while($photos[$i]!=NULL)
        {
                print_r($photos[$i]['pid']);
                echo "<br>";
		$pid=$photos[$i]['pid'];
		$fql2 = "SELECT created, src FROM photo WHERE pid='$pid'";
		//echo $fql2;
		$date_place = $facebook->api(array('method' => 'fql.query', 'query' => $fql2, 'access_token' => $access_t));
                $datetime = date('c',$date_place[0]['created']);
		echo $datetime."<br>";
		$past_year = $date_place[0]['created']/(365*24*360) + 1970;
		if($past_year == ($curr_year - $year))
			echo "SRC  :".$date_place[0]['src']."<br>";
		//$place_id = $date_place[0]['place_id'];
		//$fql3 = "SELECT name FROM place WHERE page_id='$place_id'";
                
                //$date_place = $facebook->api(array('method' => 'fql.query', 'query' => $fql3, 'access_token' => $access_t));
		//var_dump($date_place);
		//echo $date_place[0]['name']."<br>";
		$i++;
        }
                //var_dump($photos);
  	          echo "<br>";
	*/	/*$curr_year = date('Y');
		echo $curr_year."<br>";
		$past_year = $curr_year -$year;
		$past_year = ($past_year-1970)*365*24*3600;
		$fql = "SELECT src FROM photo WHERE created= $past_year"; 		
		echo $fql;
		$src = $facebook->api(array('method' => 'fql.query', 'query' => $fql2, 'access_token' => $access_t));	
		while($src==NULL)
		{
			$past_year = $past_year + 24*3600;
			$fql = "SELECT src FROM photo WHERE created= $past_year";
                	echo $fql;
                	$src = $facebook->api(array('method' => 'fql.query', 'query' => $fql2, 'access_token' => $access_t));
		}
	//$created_date = date('c',$created_time);
	//echo $created_date;
	
	*/
	 echo "<br><br>";
        $fql = "SELECT education FROM user WHERE uid = '$uid'";
        //echo $fql;

        echo "<br>";
        $edu = $facebook->api(array('method' => 'fql.query', 'query' => $fql, 'access_token' => $access_t));

        $i=0;

                //var_dump($edu);
                echo "<br>";
		while($edu[0]['education'][$i]!=NULL)
		{
			//echo $edu[0]['education'][$i]['classes'][0]['name'];
			//echo " - ".$edu[0]['education'][$i]['school']['name'];
			echo"<br>";
			$i++;
			for($k=4;$k<8;$k++)
				$grad[$k-4]=$edu[0]['education'][$i]['classes'][0]['name'][$k];
			if((int)$grad)
			{
				$grad1=(int)$grad;
				$j=$i;
			}
		}
		//var_dump($edu);
		echo $j;
		echo "<strong>Graduated from ".$edu[0]['education'][$j]['school']['name']." in ".$grad."</strong><br>";
		

	echo "<br><br>";
        $fql = "SELECT work FROM user WHERE uid = '$uid'";
       // echo $fql;

        echo "<br>";
        $work = $facebook->api(array('method' => 'fql.query', 'query' => $fql, 'access_token' => $access_t));

        $i=0;

                 // var_dump($work);
                // echo "<br>";
                while($work[0]['work'][$i]!=NULL)
                {
                         //echo $work[0]['work'][$i]['employer']['name'];

                         //echo " - ".$work[0]['work'][$i]['position']['name'];
                         //echo "<br>";
			 //echo " From ".$work[0]['work'][$i]['start_date'];
			 //echo "    To : ".$work[0]['work'][$i]['end_date'];
			 
			 //echo "<br>";
			$max1=0;
			$max2=0;
			/*if(($work[0]['work'][$i]['start_date'][3]>$max1&&$work[0]['work'][$i]['start_date'][2]>=$max2)||($work[0]['work'][$i]['start_date'][3]<$max1&&$work[0]['work'][$i]['start_date'][2]>$max2))
			{
				$max1=$work[0]['work'][$i]['start_date'][3];
				$max2=$work[0]['work'][$i]['start_date'][2];
				$j=$i;
			}*/
                        $i++;
                }
		echo "<strong>Changed Work to ".$work[0]['work'][0]['position']['name']." , ". $work[0]['work'][0]['employer']['name']." on ".$work[0]['work'][0]['start_date']."</strong>";		
	

	$keyword = array("birthday","Birthday","bday","marriage","Marraige","MARRAIGE","married life","Married Life","tie the knot","Promotion","promotion","appointment","graduation","Graduation","passing");

		
	echo "<br><br>";
        $fql = "SELECT message, created_time FROM stream WHERE source_id = $uid and created_time < 1262196000 LIMIT 100";
        //echo $fql;

        echo "<br>";
        $post = $facebook->api(array('method' => 'fql.query', 'query' => $fql, 'access_token' => $access_t));
	$j=0;	
        $i=0;
	$c=0;
                //if($curr_loc[0]['interests'])
                  //      print_r($curr_loc[0]['current_location']);
                //else
                  //      echo "None";

                //var_dump($post);
		$count=0;
		$flag=0;
                while($keyword[$j]!=NULL)
                {
		if($j%3==0)
			$count=0;
		$i=0;
		while($post[$i]!=NULL)
		{	
			
			//while($keyword[$j]!=NULL)
			//{
			if(strstr($post[$i]['message'],$keyword[$j]))
			{	
				//echo $post[$i]['message']."<br>";
				$count++;
			}
			//$j++;
			//}
			$i++;
		} 
		echo "<br><br>";
		if($count>10)
		{
			//echo "hi";
			$time=$post[$i-1]['created_time'];
			//echo $time."<br>";
			 $time1=$time / (365*24*3600)+1970;
			//echo $time1."<br>";
			
			//echo $time."<br>";
			$created = date("D, d M Y", $time);
			//echo $time."<br>";
			if($flag==0)
			{
				echo "<strong>".$keyword[$j]." - ".$created."</strong><br>";
				$flag=1;
			}
			if($j%3==0)
				$flag=0;
		}
		$j++;
		}
	echo "<br>";
	// STATUSES SORTED BY KEYWORDS
		
	echo "<br><br>";
        $fql = "SELECT coords FROM location_post WHERE $uid in tagged_uids";
        //echo $fql;

        echo "<br>";
        $loc_post = $facebook->api(array('method' => 'fql.query', 'query' => $fql, 'access_token' => $access_t));

        $i=0;
                /*if($curr_loc[0]['current_location'])
                        print_r($curr_loc[0]['current_location']);
                else
                        echo "None";
                */
	//	var_dump($loc_post);
		echo "<br>";
		 $rachitlat = array();
                $rachitlong = array();
        
	for($i=0;$loc_post[$i]!=NULL;$i=$i+1)
        {
        $rachitlat[$i]=$loc_post[$i]['coords']['latitude'];
        $rachitlong[$i]=$loc_post[$i]['coords']['longitude'];
        }
        echo "<br><hr>";
        Print_r($rachit);
        echo "<br>";
        $count=0;


		
?>
<div id="flickr">
hello this is flickr
</div>
</body>
<script>

var user_id='36385235@N08';
var currentlocation = "<?php echo $curr_loc[0]['current_location']['city']; ?>";
var global=0;
var num=0;
var numf=0;
var numi=0;
var homecountry="";
var minyear=2010;
var maxyear=2012;
var test=0;
var map="http://maps.googleapis.com/maps/api/staticmap?size=600x300&maptype=roadmap";
var weather = "";
function flickr() {
var count=<?php echo $i; ?>;
if(count > 20) {
count = 20;
}

for(i=0;i<count;i++){
map += '&markers=label:S%7C' + <?php echo $rachitlat[$count]; ?>  + ',' + <?php echo $rachitlong[$count]; $count=$count+1; ?>;
}

YUI().use('node', 'yql', function(Y) {

Y.YQL('select * from geo.places(1) where text="' + currentlocation + '"' , function(weather) {
        var woeid = weather.query.results.place.woeid;
        var homecountry = weather.query.results.place.country.content;
       Y.YQL('select * from weather.forecast where woeid=' + woeid, function(weather2) {
        var text = weather2.query.results.channel.item.forecast[0].text;
        weather = text;
	alert(weather);
});
});

var res = Y.one('#flickr');
        Y.YQL('SELECT * FROM flickr.people.publicphotos WHERE user_id="' + user_id + '" AND extras="url_sq" and api_key="0382341b074f344bd4c3c89eb6829173"', function (getphoto) {
        var el=Y.Node.create('<div class="mod"></div>');
        el.set('innerHTML' + '<h2> photos id </h2><hr><br>' + weather);
        var total = getphoto.query.count;
        if(total > 30) {
        total=30;
        }

        for(i=0;i<total;i++) {
        var photoid = getphoto.query.results.photo[i].id; 
                Y.YQL('select * from flickr.photos.info where photo_id="' + photoid + '" and api_key="0382341b074f344bd4c3c89eb6829173"', function (getlocation) {
                
                var userlocation = getlocation.query.results.photo.location.locality.content;
                var usercountry =  getlocation.query.results.photo.location.country.content;
                if(usercountry != homecountry) {
                global=1;
                }
                var userdate = getlocation.query.results.photo.dates.taken;
                var useryear = parseInt(userdate, 10);
                var userwoeid = getlocation.query.results.photo.location.woeid;
                var latitude = getlocation.query.results.photo.location.latitude;
                var longitude = getlocation.query.results.photo.location.longitude;  
test++;
if(useryear == maxyear)
{
numf++;
}
if(useryear == minyear)
{
numi++;
}
if(useryear >= minyear && useryear <= maxyear && num<=40 ) {
map += '&markers=label:S%7C' + latitude + ',' + longitude;
//el.append('location' + userlocation + ',' + usercountry + 'date-' + userdate );
num++;
}
                });
                }
        function f(){
        map += '&sensor=true&key=AIzaSyDncLs3cFFZoiClpesY5uWDbK7YCJVPjx0';
        el.append('<hr><img src="' + map + '" />' );
        var dd = new Date();
        var nd = dd.getMonth();
        numf=numf/nd;
        numi=numi/12;
	//el.append(weather);
        if(numf>=3){
        el.append('now frequent traveller');
        }
        else if (numf>=1){
        el.append('now moderate travellet');
        }
        else {
        el.append('now home loving');
        }
if(numi>=3){
        el.append('initially frequent traveller');
        }
        else if (numi>=1){
        el.append('initially moderate travellet');
        }
        else {
        el.append('initially home loving');
        }   
        if(global==1) {
        el.append('global traveller');
	alert(user_id);
        }            
}

       setTimeout(f,30000);
        res.setHTML(el);
        });
    });



}
</script>

<script>
setTimeout(flickr(), 25000);
</script>

</body>
</html>
