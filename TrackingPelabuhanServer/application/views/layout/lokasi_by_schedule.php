<?php echo $map['js']; ?>
<script type="text/javascript" src="js/comet.js"></script>
<script type="text/javascript" src="js/kapal.js"></script>
<script type="text/javascript">
    /*var comet = new Comet('rest/getKordinatKapal/Titanic', function (response){
        alert(response);
    });*/

    jQuery(document).ready(function () {
        $('#show-btn').click(showBtnAction);
        showBtnAction();
//        comet.connect();
//        initialize(new google.maps.LatLng(-25.363882, 131.044922));

        $("#filter-combo").change(function(){
            var val = this.value;

            if ('all' == val) {
                for (i=0; i<$marker.length; i++) {
                    $marker[i].setVisible(true);
                    $rutePaths[i].setVisible(true);
                }
            }
            else if ('stil' == val) {
                for (i=0; i<$marker.length; i++) {
                    if ('a' == $status[i]) {
                        $marker[i].setVisible(true);
                        $rutePaths[i].setVisible(true);
                    }
                    else if ('l' == $status[i]) {
                        $marker[i].setVisible(false);
                        $rutePaths[i].setVisible(false);
                    }
                }
            }
            else if ('late' == val) {
                for (i=0; i<$marker.length; i++) {
                    if ('a' == $status[i]) {
                        $marker[i].setVisible(false);
                        $rutePaths[i].setVisible(false);
                    }
                    else if ('l' == $status[i]) {
                        $marker[i].setVisible(true);
                        $rutePaths[i].setVisible(true);
                    }
                }
            }
        });
    });

    var $baseUrl = '<?= base_url() ?>'

    var $kapals;
    var $marker = [];
    var $rutePaths = [];
    var $scheduleId = [];
    var $status = [];

    function showBtnAction() {
        $.ajax({
            type : 'get',
            url : 'rest/getKapalWithAktifSchedule/',
            dataType : 'json',
            success : function(response, status, xhr) {

                $kapals = Kapal.getArrayKapal2(response);
                initializeMap(response);

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
            var obj = response[i];
            var kordinat = [];

            var lastK = {lat: null, lng: null}

            for (var j=0; j<obj.lokasi.length; j++) {
                if (j == obj.lokasi.length - 1) { //last kordinat
                    lastK.lat = obj.lokasi[j].lat;
                    lastK.lng = obj.lokasi[j].lng;
                }

                kordinat.push({
                    lat: parseFloat(obj.lokasi[j].lat),
                    lng: parseFloat(obj.lokasi[j].lng)
                });
            }

            var rutePath = new google.maps.Polyline({
                path: kordinat,
                geodesic: true,
                strokeColor: '#0000FF',
                strokeOpacity: 1.0,
                strokeWeight: 1
            });

            rutePath.setMap(map);
            $rutePaths.push(rutePath);

            if (lastK.lat != null && lastK.lng != null) {
                var marker = getNewMarker(new google.maps.LatLng(lastK.lat, lastK.lng), obj.kapal.nama_kapal);
                $marker.push(marker);
            } else {
                $marker.push(null);
            }

            $scheduleId.push(obj.kapal.schedule_id);
            $status.push('a'); //active/dalam perjalanan
        }

        /* create polyline */
        /*var flightPlanCoordinates = [
         {lat: 37.772, lng: -122.214},
         {lat: 21.291, lng: -157.821},
         {lat: -18.142, lng: 178.431},
         {lat: -27.467, lng: 153.027}
         ];
         var flightPath = new google.maps.Polyline({
         path: flightPlanCoordinates,
         geodesic: true,
         strokeColor: '#FF0000',
         strokeOpacity: 1.0,
         strokeWeight: 2
         });

         flightPath.setMap(map);*/
        /* end create polyline */

        comet = null;
        comet = new Comet('rest/getKordinatKapal3?json='+jQuery.toJSON($kapals), function (response){
            try {
                for (var i=0; i<response.length; i++) {
                    var index = jQuery.inArray(response[i].namakapal, $kapals);
                    if (index != -1) {
                        if ($marker[index] != null) {
                            $marker[index].setMap(null);
                            $marker[index] = getNewMarker(new google.maps.LatLng(response[i].lat, response[i].lng), response[i].namakapal);
                        } else {
                            $marker[index] = getNewMarker(new google.maps.LatLng(response[i].lat, response[i].lng), response[i].namakapal);
                        }

                        //update polyline
                        var path = $rutePaths[index].getPath();
                        path.push(new google.maps.LatLng(response[i].lat, response[i].lng));
                        $rutePaths[index].setPath(path);
                    }
                }
                //alert(jQuery.toJSON(response));
            } catch (e) {
                alert(e);
            }
        });
        comet.connect();

        cekSchedule(); // cek late schedule
    }

    var map;
    var marker;

    function initialize(location, withMarker) {
        var useMarker = true;
        useMarker = withMarker;

        var mapOptions = {
            zoom: useMarker ? 4 : 2,
//                    center: new google.maps.LatLng(-25.363882, 131.044922)
            center: location
        };

        map = new google.maps.Map(document.getElementById('map1'), mapOptions);

        if (useMarker) {

            marker = getNewMarker(location);

            google.maps.event.addListener(map, 'center_changed', function() {
                // 3 seconds after the center of the map has changed, pan back to the
                // marker.
                window.setTimeout(function() {
                    map.panTo(marker.getPosition());
                }, 3000);
            });

        }
    }

    function getNewMarker(location, title) {
        var marker = new google.maps.Marker({
            position: location,
            map: map,
            title: (title==undefined) ? 'Click to zoom':title,
            icon: '<?=base_url(). 'css/images/kapal-blue.png'?>'
        });

        google.maps.event.addListener(marker, 'click', function() {
            map.setZoom(8);
            map.setCenter(marker.getPosition());
        });

        return marker;
    }

    function cekSchedule() {
        $.ajax({
            type : 'get',
            url : 'rest/cekLateSchedule2/',
            dataType : 'json',
            data : {'json' : jQuery.toJSON($scheduleId)},
            success : function(response, status, xhr) {
                //alert(jQuery.toJSON(response));
                for (var i=0; i<response.length; i++) {
                    var obj = response[i];

                    if (obj.late == 't') {
                        var index = jQuery.inArray(obj.id, $scheduleId);
                        if (index != -1) {
                            $marker[index].setIcon($baseUrl + "css/images/kapal-red.png");
                            $rutePaths[index].setOptions({strokeColor: 'red'});
                            $status[index] = 'l'; // late/terlambat
                        }
                    }
                }
            },
            complete : function(response) {
                // call again after 60 seconds
                setTimeout(function(){ cekSchedule(); }, 60000);
            },
            error: function(xhr, status, errorMsg){
                alert(errorMsg);
            }
        });
    }
</script>
<div id="main_content">
    <span class="emb_left"></span>
    <span class="emb_right"></span>
    <span class="emb_botleft"></span>
    <span class="emb_botright"></span>
    <span class="emb_footrpt"></span>
    <h2><?php echo 'Lokasi Kapal Berdasarkan Jadwal'; ?></h2>

    <?php echo form_open('home/submitKapal', array('class'=>'formfield')); ?>
    <input type="hidden" name="id" value="<?php //echo $id; ?>"/>
    <input type="hidden" name="proses" value="<?php //echo (isset($create))?'create':'update';?>"/>
    <fieldset>
        <legend style="display: none;">Pilih Kapal</legend>
        <table style="/*display: none;*/">
            <tr class="odd">
                <td class="first">
                    <label>Tampilkan</label>
                </td>
                <td class="last">:
                    <!--<input type="email" name="kodekapal" value="" />-->
                    <select id="filter-combo" name="namakapal" >
                        <option value="all" >Semua</option>
                        <option value="stil" >Masih Perjalanan</option>
                        <option value="late" >Terlambat</option>
                        <?php /*foreach($kapals as $kapal) : */?><!--
                            <option value="<?/*=$kapal->kode_kapal*/?>" ><?/*=$kapal->nama_kapal*/?></option>
                        --><?php /*endforeach; */?>
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