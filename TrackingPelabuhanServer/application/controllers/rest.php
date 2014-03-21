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
    
}