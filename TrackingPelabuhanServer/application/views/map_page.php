<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Map</title>
        <?php echo $map['js']; ?>
    </head>
    <body onload="initialize(new google.maps.LatLng(-25.363882, 131.044922));">
        <?php //echo $map['html']; ?>
        <script type="text/javascript" >
            var map;
            var marker;
            
            function initialize(location) {
                var mapOptions = {
                    zoom: 4,
//                    center: new google.maps.LatLng(-25.363882, 131.044922)
                    center: location
                };
            
                map = new google.maps.Map(document.getElementById('map'), mapOptions);

                marker = new google.maps.Marker({
                  position: map.getCenter(),
                  map: map,
                  title: 'Click to zoom'
                });

                google.maps.event.addListener(map, 'center_changed', function() {
                  // 3 seconds after the center of the map has changed, pan back to the
                  // marker.
                  window.setTimeout(function() {
                    map.panTo(marker.getPosition());
                  }, 3000);
                });

                google.maps.event.addListener(marker, 'click', function() {
                  map.setZoom(8);
                  map.setCenter(marker.getPosition());
                });
            }
        </script>
        <div id="map" style="width: 100%; height: 450px;"></div>
        <br/>
        <script type="text/javascript">
            var x = 44.959944, y = 26.0186218;
            function createMarker(){
                x++; y++;
//                var latlon2 = new google.maps.LatLng(44.959944, 26.0186218);
                var latlon2 = new google.maps.LatLng(x, y);
                marker.setMap(null);
                marker = new google.maps.Marker({  
                            position: latlon2,  
                            map: map,  
//                            icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|FF0000|000000' 
                            });
                map.setCenter(latlon2);
                return false;
            }
        </script>
        <button id="btn-create" onclick="return createMarker();">Create Marker</button>
    </body>
</html>
