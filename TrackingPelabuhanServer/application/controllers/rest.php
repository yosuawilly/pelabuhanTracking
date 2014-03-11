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
            echo json_encode(My_Util::create_result(false, 'Parameter tidak lengkap'));
            exit();
        }
        //set_time_limit(0);
        
        $result = $this->kapal->get_lokasi_by_name($namaKapal);
        echo json_encode($result);
    }
    
    public function getKordinatKapal2($namaKapal=NULL) {
        if($namaKapal==NULL) {
            echo json_encode(My_Util::create_result(false, 'Parameter tidak lengkap'));
            exit();
        }
        
        $result = $this->kapal->get_lokasi_by_name($namaKapal);
        echo json_encode($result);
    }
    
}