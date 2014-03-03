<?php echo $map['js']; ?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        $('#show-btn').click(showBtnAction);
        
//        initialize(new google.maps.LatLng(-25.363882, 131.044922));
    });
    
    var $namaKapal = "";
    
    function showBtnAction(){
        //$namaKapal = $('#pilih-nama-kapal').val();
        $namaKapal = $('#pilih-nama-kapal :selected').text();
        $('#nama-kapal').html($namaKapal);
        $('#parent-map1').show();
        initialize(new google.maps.LatLng(-25.363882, 131.044922));
        return false;
    }
    
    var map;
    var marker;
            
    function initialize(location) {
        var mapOptions = {
            zoom: 4,
//                    center: new google.maps.LatLng(-25.363882, 131.044922)
            center: location
        };

        map = new google.maps.Map(document.getElementById('map1'), mapOptions);

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
    
    function directLocation(lat, lng){
//                var latlon2 = new google.maps.LatLng(44.959944, 26.0186218);
        var latlon2 = new google.maps.LatLng(lat, lng);
        marker.setMap(null);
        marker = new google.maps.Marker({  
                    position: latlon2,  
                    map: map,  
//                    icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|FF0000|000000' 
                    });
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
        <legend>Pilih Kapal</legend>
        <table>
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
            <center><h3 id="nama-kapal">Titanic</h3></center>
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
        <button id="show-btn" type="submit" class="btn btn-primary">
            <i class="icon icon-search"></i> Show
        </button>
<!--        <button type="submit" name="batal" value="batal" class="btn btn-danger">
            <i class="icon icon-stop"></i> Batal
        </button>-->
    </fieldset>
    <?php echo form_close(); ?>
</div>