/*
 * GMapEZ -- Turn specially-marked HTML into Google Maps
 * Copyright (C) July 2005 by Chris Houser <chouser@bluweb.com>
 *
 * This code is licensed under the GNU General Public License (GPL)
 *
 * If you use this code on a web page, please include on that page a
 * link to http://bluweb.com/chouser/gmapez/ -- this is a request, not
 * a requirement.  Thanks.
 */
(function(){
  var link = document.createElement('link');
  link.type = 'text/css';
  link.rel = 'stylesheet';
  link.href = 'http://bluweb.com/chouser/gmapez/gmapez.css';
  document.getElementsByTagName('head')[0].appendChild( link );

  function loadfunc() {

    if( ! window.GIcon ) {
      _apiHash = undefined;
      GMapsNamespace();
    }

    function GSmallMapTypeControl() {
      GMapTypeControl.call( this, true );
    }
    GSmallMapTypeControl.prototype = new GMapTypeControl();
    GSmallMapTypeControl.prototype.constructor = GSmallMapTypeControl;
    window.GSmallMapTypeControl = GSmallMapTypeControl;

    var CtrlTable = {
      'GLargeMapControl': true,
      'GSmallMapControl': true,
      'GSmallZoomControl': true,
      'GSmallMapTypeControl': true,
      'GMapTypeControl': true,
      'GScaleControl': true
    };

    var MapTypeTable = {
      'G_MAP_TYPE' : true,
      'G_SATELLITE_TYPE' : true,
      'G_HYBRID_TYPE' : true
    };

    var idmarkers = {};
    function markerForUrl( url ) {
      var matcha = /#(.*)/.exec( url );
      if( matcha )
        return idmarkers[ matcha[ 1 ] ];
      else
        return null;
    }

    var defaultMarker = new GMarker();

    var divs = document.getElementsByTagName( 'div' );
    for( var i = 0; i < divs.length; ++i ) {
      var div = divs[ i ];
      var classes = {};
      var classlist = div.className.split(' ');
      for( var j = 0; j < classlist.length; ++j ) {
        classes[ classlist[ j ] ] = true;
      }
      if( 'GMapEZ' in classes ) {
        var divDom = div.cloneNode( true );
        div.innerHTML = '';
        div.style.visibility = 'visible';

        var map = new GMap( div );
        var centered = false;

        for( var ctrl in CtrlTable ) {
          if( ctrl in classes ) {
            map.addControl( new window[ ctrl ]() );
          }
        }

        var marker = undefined;
        var minX = undefined;
        var maxX = undefined;
        var minY = undefined;
        var maxY = undefined;
        var mapType = undefined;
        var openThisMarker = undefined;
        var markerToOpen = undefined;
        var pointCount = 0;
        var extent = new Object();
        var explicitExtent = false;
        for( var node = divDom.firstChild; node; node = node.nextSibling ) {
          if( node.nodeName == 'A' ) {
            var textContent = node.innerHTML.replace( /<[^>]*>/g, '' );
            openThisMarker = /\bOPEN\b/.exec( textContent );
            textContent = textContent.replace( /\bOPEN\b/, '' );
            textContent = textContent.replace( /^\s*/, '' );
            textContent = textContent.replace( /\s*$/, '' );
            if( textContent == 'EXTENT' )
              explicitExtent = true; // this stays true for this whole map

            var matchll = /\Wll=([-.\d]*),([-.\d]*)/.exec( node.href );
            if( matchll ) {
              ++pointCount;
              var x = parseFloat( matchll[2] );
              var y = parseFloat( matchll[1] );
              var point = new GPoint( x, y );

              if( textContent == 'EXTENT' ) {
                extent.center = point;
              }
              else {
                if( minX == undefined || x < minX ) minX = x;
                if( maxX == undefined || x > maxX ) maxX = x;
                if( minY == undefined || y < minY ) minY = y;
                if( maxY == undefined || y > maxY ) maxY = y;

                var icon = defaultMarker.icon;
                if( /^[A-J]$/.exec( textContent ) ) {
                  icon = new GIcon( defaultMarker.icon );
                  icon.image =
                    'http://maps.google.com/mapfiles/marker'+textContent+'.png';
                }
                marker = new GMarker( point, icon );
                map.centerAndZoom( point, 4 ); // why do I need this?
                map.addOverlay( marker );

                idmarkers[ node.id || node.name ] = marker;
              }
            }

            if( pointCount == 1 || textContent == 'EXTENT' ) {
              var matchspn = /\Wspn=([-.\d]*),([-.\d]*)/.exec( node.href );
              if( matchspn ) {
                extent.span = new Object();
                extent.span.width  = parseFloat( matchspn[2] );
                extent.span.height = parseFloat( matchspn[1] );
              }

              var matchtype = /\Wt=(.)/.exec( node.href );
              if( matchtype ) {
                switch( matchtype[1] ) {
                  case 'k': mapType = G_SATELLITE_TYPE; break;
                  case 'h': mapType = G_HYBRID_TYPE; break;
                }
              }
            }
          }
          else if( node.nodeName == 'DIV' ) {
            (function(){
              var localMarker = marker;
              var width = div.offsetWidth * 2 / 3;
              var html = node.outerHTML;
              if( ! html ) {
                html = '<div';
                var attrs = node.attributes;
                for( var j = 0; j < attrs.length; ++j )
                  html += ' ' + attrs[j].name + '="' + attrs[j].value + '"';
                html += '>' + node.innerHTML + '</div>';
              }
              var fullhtml = '<div style="max-width: ' + width + 'px">' +
                  html + '</div>';
              marker.doOpen = function() {
                localMarker.openInfoWindowHtml( fullhtml );
              }
              GEvent.addListener( marker, 'click', marker.doOpen );
              if( openThisMarker )
                markerToOpen = marker;
            })();
          }
        }

        if( ! extent.center ) {
          if( minX == undefined ) {
            map.centerAndZoom( new GPoint(-85.130310, 41.075210), 7 );
          }
          else {
            extent.center = new GPoint( (minX + maxX)/2, (minY + maxY)/2 );
            if( ! explicitExtent && pointCount != 1 ) {
              extent.span = new Object();
              extent.span.width  = maxX - minX;
              extent.span.height = maxY - minY;
            }
          }
        }

        for( typeName in MapTypeTable ) {
          if( typeName in classes ) {
            mapType = window[ typeName ];
            explicitExtent = true;
            break;
          }
        }

        if( pointCount == 1 || explicitExtent ) {
          if( mapType )
            map.setMapType( mapType );
        }

        if( extent.span ) {
          var zoomLevel = map.spec.getLowestZoomLevel(
              extent.center, extent.span, map.viewSize );
          map.centerAndZoom( extent.center, zoomLevel );
        }

        if( markerToOpen )
          markerToOpen.doOpen();
      }
    }

    var anchors = document.getElementsByTagName( 'a' );
    for( var i = 0; i < anchors.length; ++i ) {
      var marker = markerForUrl( anchors[ i ].href );
      if( marker )
        GEvent.bindDom( anchors[ i ], "click", marker, marker.doOpen );
    }

    var marker = markerForUrl( document.location );
    if( marker )
      marker.doOpen();
  }

  function addOnLoad( func ) {
    if( window.onload ) {
      var oldfunc = window.onload;
      window.onload = function() { oldfunc(); func(); }
    }
    else {
      window.onload = func;
    }
  }
  window.addOnLoad = addOnLoad;

  addOnLoad( loadfunc );
})();

