<?php echo $map['js']; ?>
<script type="text/javascript" src="js/comet.js"></script>
<script type="text/javascript" src="js/kapal.js"></script>
<script type="text/javascript">
    var comet = new Comet('rest/getKordinatKapal/Titanic', function (response){
        alert(response);
    });
    
    jQuery(document).ready(function () {
        $('#show-btn').click(showBtnAction);
        showBtnAction();
//        comet.connect();
//        initialize(new google.maps.LatLng(-25.363882, 131.044922));
    });
    
    var $namaKapal = "";
    var $kapals;
    var $marker = [];
    var $status = [];
    
    function showBtnAction(){
        comet.disconnect();
        //$namaKapal = $('#pilih-nama-kapal').val();
        $namaKapal = $('#pilih-nama-kapal :selected').text();
        
        $.ajax({
            type : 'get',
            //url : 'rest/getKordinatKapal/'+$namaKapal,
            url : 'rest/getAllKordinatKapal/',
            dataType : 'json',
            success : function(response, status, xhr) {
                $kapals = Kapal.getArrayKapal(response);
                initializeMap(response);

//                if(response.hasOwnProperty('status')){
//                    //alert(response.fullMessage);
//                    initializeMapAndComet(null, null);
//                } else {
//                    //alert(response.lat);
//                    initializeMapAndComet(response.lat, response.lng);
//                }
            },
            complete : function(response) {
                
            },
            error: function(xhr, status, errorMsg){
                alert(errorMsg);
            }
        });
        
        return false;
    }

    function initializeMap(response) {
        $('#parent-map1').show();
        initialize(new google.maps.LatLng(25.363882, 431.044922), false);

        //Generate Marker
        for (var i=0; i<response.length; i++) {
            $status.push(response[i].status);

            if (response[i].lat != null && response[i].lng != null) {
                var marker = getNewMarker(new google.maps.LatLng(response[i].lat, response[i].lng), response[i].namakapal, i);
                $marker.push(marker);
            } else {
                $marker.push(null);
            }
        }
        
        comet = null;
        comet = new Comet('rest/getKordinatKapal3?json='+jQuery.toJSON($kapals), function (response){
            try{
                for (var i=0; i<response.length; i++) {
                    var index = jQuery.inArray(response[i].namakapal, $kapals);
                    if(index != -1) {
                        if($marker[index] != null) {
                            $marker[index].setMap(null);
                            $marker[index] = getNewMarker(new google.maps.LatLng(response[i].lat, response[i].lng), response[i].namakapal, index);
                        } else {
                            $marker[index] = getNewMarker(new google.maps.LatLng(response[i].lat, response[i].lng), response[i].namakapal, index);
                        }
                    }
                }
                //alert(jQuery.toJSON(response));
            } catch (e){
                alert(e);
            }
        });
        comet.connect();
    }
    
    /*function initializeMapAndComet(lat, lng) {
        $('#nama-kapal').html($namaKapal);
        $('#parent-map1').show();
        if(lat===null & lng===null)
            initialize(new google.maps.LatLng(25.363882, 431.044922), false);
        else {
            //alert('ada'+lat+' '+lng);
            initialize(new google.maps.LatLng(lat, lng), true);
        }
        comet = null;
        comet = new Comet('rest/getKordinatKapal2/'+$namaKapal, function (response){
            try{
                var lat = response.lat;
                var lng = response.lng;
                directLocation(lat, lng);
            } catch (e){
                alert(e);
            }
        });
        comet.connect();
    }*/
    
    var map;
    var marker;
            
    function initialize(location, withMarker) {
        var useMarker = true;
        useMarker = withMarker;
        //if(!useMarker) alert('not');
        
        var mapOptions = {
            zoom: useMarker ? 4 : 2,
//                    center: new google.maps.LatLng(-25.363882, 131.044922)
            center: location
        };

        map = new google.maps.Map(document.getElementById('map1'), mapOptions);
        
        if(useMarker){
        
        marker = getNewMarker(location);
//        marker = new google.maps.Marker({
//          position: map.getCenter(),
//          map: map,
//          title: 'Click to zoom'
//        });

        google.maps.event.addListener(map, 'center_changed', function() {
          // 3 seconds after the center of the map has changed, pan back to the
          // marker.
          window.setTimeout(function() {
            map.panTo(marker.getPosition());
          }, 3000);
        });
        
        }
    }
    
    function getNewMarker(location, title, indexStatus) {
        stat = $status[indexStatus];

        var iconUrl = '<?=base_url(). 'css/images/kapal-green.png'?>';

        if (stat == 'o') {
            iconUrl = '<?=base_url(). 'css/images/kapal-blue.png'?>';
        }
        if (stat == 'l') {
            iconUrl = '<?=base_url(). 'css/images/kapal-red.png'?>';
        }
        if (stat == 'a') {
            iconUrl = '<?=base_url(). 'css/images/kapal-yellow.png'?>';
        }

        var marker = new google.maps.Marker({
          position: location,
          map: map,
          title: (title==undefined) ? 'Click to zoom':title,
          icon: iconUrl
        });
        
        google.maps.event.addListener(marker, 'click', function() {
          map.setZoom(8);
          map.setCenter(marker.getPosition());
        });
        
        return marker;
    }
    
    function directLocation(lat, lng){
//                var latlon2 = new google.maps.LatLng(44.959944, 26.0186218);
        var latlon2 = new google.maps.LatLng(lat, lng);
        if(marker!=null) {
            marker.setMap(null);
            marker = getNewMarker(latlon2);
        }
        else {
            marker = getNewMarker(latlon2);
            google.maps.event.addListener(map, 'center_changed', function() {
                // 3 seconds after the center of the map has changed, pan back to the
                // marker.
                window.setTimeout(function() {
                  map.panTo(marker.getPosition());
                }, 3000);
            });
        }
        
//        marker = new google.maps.Marker({  
//                    position: latlon2,  
//                    map: map,
////                    icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|FF0000|000000' 
//                    });
        map.setCenter(latlon2);
        return false;
    }
</script>
<div id="main_content">
    <span class="emb_left"></span>
    <span class="emb_right"></span>
    <span class="emb_botleft"></span>
    <span class="emb_botright"></span>
    <span class="emb_footrpt"></span>
    <h2><?php echo 'Lokasi Kapal'; ?></h2>
    
    <?php echo form_open('home/submitKapal', array('class'=>'formfield')); ?>
    <input type="hidden" name="id" value="<?php //echo $id; ?>"/>
    <input type="hidden" name="proses" value="<?php //echo (isset($create))?'create':'update';?>"/>
    <fieldset>
        <legend style="display: none;">Pilih Kapal</legend>
        <table style="display: none;">
            <tr class="odd">
                <td class="first">
                    <label>Nama Kapal</label>
                </td>
                <td class="last">:
                    <!--<input type="email" name="kodekapal" value="" />-->
                    <select id="pilih-nama-kapal" name="namakapal" >
                        <?php foreach($kapals as $kapal) : ?>
                        <option value="<?=$kapal->kode_kapal?>" ><?=$kapal->nama_kapal?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
        </table><br/>
        <div id="parent-map1" style="display: none;">
            <center style="display: none;" ><h3 id="nama-kapal">Titanic</h3></center>
            <div id="map1" style="width: 100%; height: 450px;"></div>
            <br/>
        </div>
        <div id="parent-map2" style="display: none;">
            <div id="map2" style="width: 100%; height: 450px;"></div>
            <br/>
        </div>
        <?php if($error!=null) {?>
        <div id="pesanerror" style="width: 100%;"><?php echo ''.$error; ?></div><br/>
        <?php } ?>
        <button id="show-btn" type="submit" class="btn btn-primary" style="display: none;">
            <i class="icon icon-search"></i> Show
        </button>
<!--        <button type="submit" name="batal" value="batal" class="btn btn-danger">
            <i class="icon icon-stop"></i> Batal
        </button>-->
    </fieldset>
    <?php echo form_close(); ?>
</div>