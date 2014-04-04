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
    
    public function sendKordinatKapal($namaKapal=NULL, $lat=NULL, $lng=NULL) {
        if($namaKapal==NULL || $lat==NULL || $lng==NULL) {
            echo My_Util::create_result(false, 'Parameter tidak lengkap');
            exit();
        }
        
        if(My_Util::write_kordinat($namaKapal, $lat, $lng)){
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
    
}