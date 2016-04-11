<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $title;?></title>
        <base href="<?php echo base_url(); ?>" />
        <link rel="shortcut icon" href="css/images/jangkar.png" />
        <link type="text/css" href="css/bootstrap.css" rel="stylesheet" />
        <link type="text/css" href="css/style.css" rel="stylesheet" />
        <link type="text/css" href="css/jquery-ui-1.10.3.custom.css" rel="stylesheet" />
        <!--<link type="text/css" href="css/demo_table.css" rel="stylesheet" />-->
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/jquery.json-2.4.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.10.3.custom.js"></script>
        <script type="text/javascript" src="js/nicEdit.js"></script>
    </head>
    <body>
        <div id="konfirmasi" style="display: none;">
            <center>
                <span>Apakah anda yakin akan menghapus data ini?</span>
            </center>
        </div>
        <div id="wrapper">
            <div id="page_home">
                <div id="head">
                    <a href="" title="Tracking Server" class="logo"></a>
                </div>
                
                <div id="main_menu" class="grid1">
                    <div id="mm_title">Main Menu</div>
                    <div id="mm_list_wraper">
                        <span class="emb_left"></span>
                        <span class="emb_right"></span>
                        <span class="emb_botleft"></span>
                        <span class="emb_botright"></span>
                        <span class="emb_footrpt"></span>
                        <div ID="mm_list">
                            <h3>Master Data<span class="arrowclose"></span></h3>
                            <div class="panel">
                                <ul>
                                    <li><?php echo anchor('home/kapal', 'Data Kapal', array('title'=>'Data Kapal', 'class'=>(isset($kapal)) ? 'active' : "" )); ?></li>
                                    <li><?php echo anchor('home/lokasiKapal', 'Tampilkan Lokasi Kapal', array('title'=>'Tampilkan Lokasi Kapal', 'class'=>(isset($lokasi)) ? 'active' : "" )); ?></li>
                                    <li><?php echo anchor('home/lokasiKapalBySchedule', 'Lokasi Kapal Berdasakan Jadwal', array('title'=>'Lokasi Kapal Berdasakan Jadwal', 'class'=>(isset($lokasiSchedule)) ? 'active' : "" )); ?></li>
                                    <li><?php echo anchor('home/dataLokasiKapal', 'Data Lokasi Kapal', array('title'=>'Data Lokasi Kapal', 'class'=>(isset($data_lokasi)) ? 'active' : "" )); ?></li>
                                    <li><?php echo anchor('home/activeDevice', 'Active Device', array('title'=>'Active Device', 'class'=>(isset($activeDevice)) ? 'active' : "" )); ?></li>
                                    <li><?php echo anchor('home/schedule', 'Jadwal Keberangkatan Kapal', array('title'=>'Jadwal Keberangkatan Kapal', 'class'=>(isset($jadwalKapal)) ? 'active' : "" )); ?></li>
                                    <li><?php echo anchor('home/laporanKapal', 'Laporan Kapal', array('title'=>'Laporan Kapal', 'class'=>(isset($laporanKapal)) ? 'active' : "" )); ?></li>
                                </ul>
                            </div>
                            <h3>Admin<span class="arrowclose"></span></h3>
                            <div class="panel">
                                <ul>
                                    <li><?php echo anchor('home', 'Home', array('title'=>'Home', 'class'=>(isset($home)) ? 'active' : "" )); ?></li>
                                    <!--<li><?php //echo anchor('auth/changepassword', 'Change Password', array('title'=>'Change Password')); ?></li>-->
                                    <li><?php echo anchor('auth/logout', 'Logout', array('title'=>'Logout')); ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>