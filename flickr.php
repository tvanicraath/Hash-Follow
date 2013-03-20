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
var user_id='36385235@N08';
var currentlocation = "kanpur";
var global=0;
var num=0;
var numf=0;
var numi=0;
var homecountry="";
var minyear=2010;
var maxyear=2012;
var test=0;
var map="http://maps.googleapis.com/maps/api/staticmap?size=600x300&maptype=roadmap";

YUI().use('node', 'yql', function(Y) {

Y.YQL('select * from geo.places(1) where text="' + currentlocation + '"' , function(weather) {
        var woeid = weather.query.results.place.woeid;
	var homecountry = weather.query.results.place.country.content;
       Y.YQL('select * from weather.forecast where woeid=' + woeid, function(weather2) {
        var text = weather2.query.results.channel.item.forecast[0].text;
        alert(text);
});
});

    
    var res = Y.one('#main');
	Y.YQL('SELECT * FROM flickr.people.publicphotos WHERE user_id="' + user_id + '" AND extras="url_sq" and api_key="0382341b074f344bd4c3c89eb6829173"', function (getphoto) {
	var el=Y.Node.create('<div class="mod"></div>');
	el.set('innerHTML' + '<h2> photos id </h2><hr><br>');
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
el.append('location' + userlocation + ',' + usercountry + 'date-' + userdate );
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
	if(numf>=3){
	alert('now frequent traveller');
	}
	else if (numf>=1){
	alert('now moderate travellet');
	}
	else {
	alert('now home loving');
	}
if(numi>=3){
        alert('initially frequent traveller');
        }
        else if (numi>=1){
        alert('initially moderate travellet');
        }
        else {
        alert('initially home loving');
        }   
	if(global==1) {
	alert('global traveller');
	}            
}

       setTimeout(f,30000);
	res.setHTML(el);
	});
    });

</script>
</html>
