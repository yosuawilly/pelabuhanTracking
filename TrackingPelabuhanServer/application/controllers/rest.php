<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of rest
 *
 * @author LenovoDwidasa
 */
class Rest extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model('kapal_model', 'kapal');
        $this->load->model('active_device_model', 'active_device');
        $this->load->model('lokasi_kapal_model', 'lokasi_kapal');
        $this->load->model('schedule_model', 'schedule');
    }

    public function getAllKordinatKapal() {
        $result = array();
        //$kapals = $this->kapal->get_all_kapal_names();
        //$kapals = $this->kapal->findAll();
        $kapals = $this->kapal->getKapalWithStatus();
        foreach ($kapals as $kapal) {
            $detail = array();
            $detail['namakapal'] = $kapal->nama_kapal;
            $detail['status'] = $kapal->status;
            if( ($kordinat = My_Util::read_kordinat($kapal->nama_kapal)) ) {
                $detail['lat'] = $kordinat['lat'];
                $detail['lng'] = $kordinat['lng'];
            } else {
                $k = $this->lokasi_kapal->getLastLokasi($kapal->kode_kapal);
                if ($k) {
                    $detail['lat'] = $k->lat;
                    $detail['lng'] = $k->lng;
                } else {
                    $detail['lat'] = NULL;
                    $detail['lng'] = NULL;
                }
            }
            $result[] = $detail;
        }
        echo json_encode($result);
    }
    
    public function getKordinatKapal($namaKapal=NULL) {
        if($namaKapal==NULL) {
            echo My_Util::create_result(false, 'Parameter tidak lengkap');
            exit();
        }
        if( !($result = My_Util::read_kordinat($namaKapal))){
            echo My_Util::create_result(FALSE, 'Tidak ada kordinat');
            exit();
        }
        
        //$result = $this->kapal->get_lokasi_by_name($namaKapal);
        echo json_encode($result);
    }
    
    public function getKordinatKapal2($namaKapal=NULL) {
        if($namaKapal==NULL) {
            echo My_Util::create_result(false, 'Parameter tidak lengkap');
            exit();
        }
        
        while (!($result = My_Util::read_save_kordinat($namaKapal))) {
            usleep(10000); // sleep 10ms to unload the CPU
            clearstatcache();
//            echo json_encode(My_Util::create_result(false, 'Tidak ada data kordinat'));
//            exit();
        }
        
        //$result = $this->kapal->get_lokasi_by_name($namaKapal);
        echo json_encode($result);
        flush();
    }
    
    /* 
     * Example : rest/getKordinatKapal3?json=["Titanic","Baracuda"]
     */
    public function getKordinatKapal3() {
        if(!isset($_GET['json'])) {
            echo My_Util::create_result(false, 'Parameter tidak lengkap');
            exit();
        }
        
        $json = $_GET['json'];
        $obj = json_decode(stripslashes($json));
        
        while (!($result = My_Util::read_save_kordinat2($obj))) {
            usleep(10000); // sleep 10ms to unload the CPU
            clearstatcache();
        }
        
        echo json_encode($result);
        flush();
    }

    public function sendKordinatKapal($kodeKapal=NULL, $namaKapal=NULL, $lat=NULL, $lng=NULL) {
        if ($kodeKapal==NULL || $namaKapal==NULL || $lat==NULL || $lng==NULL) {
            echo My_Util::create_result(false, 'Parameter tidak lengkap');
            exit();
        }

        if (My_Util::write_kordinat($kodeKapal, $namaKapal, $lat, $lng)) {
            echo My_Util::create_result(true, 'Sukses');
        } else {
            echo My_Util::create_result(false, 'Gagal write kordinat');
        }
    }
    
    public function sendKordinatWithScheduleId($kodeKapal=NULL, $namaKapal=NULL, $lat=NULL, $lng=NULL, $scheduleId) {
        if ($kodeKapal==NULL || $namaKapal==NULL || $lat==NULL || $lng==NULL) {
            echo My_Util::create_result(false, 'Parameter tidak lengkap');
            exit();
        }
        
        if (My_Util::write_kordinat($kodeKapal, $namaKapal, $lat, $lng, $scheduleId)) {
            echo My_Util::create_result(true, 'Sukses');
        } else {
            echo My_Util::create_result(false, 'Gagal write kordinat');
        }
    }

    public function activation($nama_kapal=NULL, $device_id=NULL) {
        if($nama_kapal==NULL || $device_id==NULL) {
            echo My_Util::create_result(false, 'Parameter tidak lengkap');
            exit();
        }
        //$nama_kapal = str_replace('%20', ' ', $nama_kapal);

        $result = $this->kapal->findBy('nama_kapal', $nama_kapal);
        if($result) {
            //$is_active = $this->active_device->findBy('device_id', $device_id);
            $is_active = $this->active_device->findBy('kode_kapal', $result->kode_kapal);
            if($is_active) {
                echo My_Util::create_result(false, 'Kapal sudah active di device lain');
                exit();
            }

            $active = $this->active_device->save(array('kode_kapal'=>$result->kode_kapal, 'device_id'=>$device_id));
            if(!$active['error']) {
                echo json_encode($result);
            } else {
                echo My_Util::create_result(false, 'Activation Failed. detail error : '.$active['error']);
            }
        } else {
            echo My_Util::create_result(false, 'Kapal dengan nama ' .$nama_kapal. ' tidak ditemukan');
        }
    }

    public function checkActiveDevice($kode_kapal=NULL, $device_id=NULL) {
        if($kode_kapal==NULL || $device_id==NULL) {
            echo My_Util::create_result(false, 'Parameter tidak lengkap');
            exit();
        }

        //$result = $this->active_device->findBy('kode_kapal', $kode_kapal);
        $result = $this->active_device->findByKodeKapalDeviceId($kode_kapal, $device_id);
        if($result) {
            echo json_encode($result);
        } else {
            echo My_Util::create_result(true, 'You must activation again');
        }
    }

    public function deleteActiveDevice($device_id=NULL) {
        if($device_id==NULL) {
            echo My_Util::create_result(false, 'Parameter tidak lengkap');
            exit();
        }

        $result = $this->active_device->delete($device_id, 'device_id');
        if($result) {
            echo My_Util::create_result(true, 'sukses');
        } else {
            echo My_Util::create_result(false, 'delete failed');
        }
    }

    public function getAktifSchedule($kodeKapal = NULL) {
        if($kodeKapal == NULL) {
            echo My_Util::create_result(false, 'Parameter tidak lengkap');
            exit();
        }

        $schedules = $this->schedule->getAktifByKodeKapal($kodeKapal);

        echo json_encode($schedules);
    }

    public function getRunningSchedule($kodeKapal = NULL) {
        if($kodeKapal == NULL) {
            echo My_Util::create_result(false, 'Parameter tidak lengkap');
            exit();
        }

        $schedules = $this->schedule->getRunningByKodeKapal($kodeKapal);

        echo json_encode($schedules);
    }

    public function startStopSchedule($scheduleId = NULL, $isStart = 1) {
        $schedule = $this->schedule->findBy('id',$scheduleId);
        if (!$schedule) {
            echo My_Util::create_result(false, 'Schedule tidak ditemukan');
            exit();
        }

        if ($isStart == 1) { // keberangkatan
            $schedule->berangkat = date('Y-m-d h:i:s', time());
        }
        else if ($isStart == 0) { // kedatangan
            $schedule->datang = date('Y-m-d h:i:s', time());
            $schedule->done = 'true';
        }

        $this->schedule->update($schedule->id, $schedule);

        echo My_Util::create_result(true, 'sukses');
    }

    public function getKapalWithAktifSchedule() {
        $result = array();

        $kapals = $this->kapal->getKapalAktifSchedule();
        foreach ($kapals as $kapal)
        {
            $lokasi = $this->lokasi_kapal->getAllBySchedule($kapal->schedule_id);
            $result[] = [
                'kapal' => $kapal,
                'lokasi' => $lokasi
            ];
        }

        echo json_encode($result);
    }

    public function cekLateSchedule() {
        if (!isset($_GET['json'])) {
            echo My_Util::create_result(false, 'Parameter tidak lengkap');
            exit();
        }

        $json = $_GET['json'];
        $obj = json_decode(stripslashes($json), true);

        $param = [];
        foreach ($obj as $o) {
            $param[] = $o;
        }
        $param = "'" . implode("','", $param) . "'";

        $result = $this->schedule->getLateScheduleByNamaKapal($param);

        echo json_encode($result);
        flush();
    }

    /**
     * cek late schedule by schedule id
     * */
    public function cekLateSchedule2() {
        if (!isset($_GET['json'])) {
            echo My_Util::create_result(false, 'Parameter tidak lengkap');
            exit();
        }

        $json = $_GET['json'];
        $obj = json_decode(stripslashes($json), true);

        $param = [-1];
        foreach ($obj as $o) {
            $param[] = $o;
        }
        $param = implode(",", $param);

        $result = $this->schedule->getLateScheduleByScheduleId($param);

        echo json_encode($result);
        flush();
    }
    
    public function read() {
        /*Read file line by line*/
//        $file = fopen('data_kordinat/coba.txt', 'r');
//        while(!feof($file))
//        {
//            echo fgets($file). "<br />";
//        }
//        fclose($file);
        
        /*Read filenames in a directory*/
        echo json_encode(get_filenames('data_kordinat'));
    }
    
}