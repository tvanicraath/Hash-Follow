<html>
<head>
<script src="http://yui.yahooapis.com/3.6.0/build/yui/yui-min.js"></script>
 <meta name="gmapkey" content="AIzaSyDncLs3cFFZoiClpesY5uWDbK7YCJVPjx0" />
    <script
      src="http://gmapez.n01se.net/gmapez-2.js"
      type="text/javascript"></script>
</head>
<body>
<div id="main">
hello
</div>
</body>

<script>
var minyear=2010;
var maxyear=2012;
var test=0;
var map="http://maps.googleapis.com/maps/api/staticmap?size=600x300&maptype=roadmap";
var vijaymap='<div class="GMapEZ" style="width: 600px; height: 300px;">';
YUI().use('node', 'yql', function(Y) {
    
    var res = Y.one('#main');
	Y.YQL('SELECT * FROM flickr.people.publicphotos WHERE user_id="36385235@N08" AND extras="url_sq" and api_key="0382341b074f344bd4c3c89eb6829173"', function (getphoto) {
	var el=Y.Node.create('<div class="mod"></div>');
	el.set('innerHTML' + '<h2> photos id </h2><hr><br>');
	for(i=0;i<20;i++) {
	var photoid = getphoto.query.results.photo[i].id; 
		Y.YQL('select * from flickr.photos.info where photo_id="' + photoid + '" and api_key="0382341b074f344bd4c3c89eb6829173"', function (getlocation) {
		
		var userlocation = getlocation.query.results.photo.location.locality.content;
		var usercountry =  getlocation.query.results.photo.location.country.content;
		var userdate = getlocation.query.results.photo.dates.taken;
		var useryear = parseInt(userdate, 10);
		var userwoeid = getlocation.query.results.photo.location.woeid;
		var latitude = getlocation.query.results.photo.location.latitude;
		var longitude = getlocation.query.results.photo.location.longitude;  
test++;
if(useryear >= minyear && useryear <= maxyear) {
vijaymap += '<a href="http://maps.google.com/maps?ll=' + latitude + ',' + longitude + '&amp;spn=0.006130,0.009795&amp;t=k&amp;hl=en"> </a>';
 
map += '&markers=label:S%7C' + latitude + ',' + longitude;
el.append('location' + userlocation + ',' + usercountry + 'date-' + userdate );
}
else {
el.append('.');
}
		});
		}
	function f(){
	vijaymap += '</div>';
        map += '&sensor=true&key=AIzaSyDncLs3cFFZoiClpesY5uWDbK7YCJVPjx0';
	el.append('<hr><img src="' + map + '" />' );
	el.append('<hr>' + vijaymap);
	setTimeout(yo, 5000);
        }

       setTimeout(f,15000);
	el.append('taest' + test);
	res.setHTML(el);
	});
		
    });

</script>
<script>
function yo(){
alert('yo world!');
}
</script>
</html>
