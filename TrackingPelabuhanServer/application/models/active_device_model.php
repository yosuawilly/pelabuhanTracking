<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of active_device_model
 *
 * @author USER
 */
class Active_device_model extends Super_model{
    
    public $kode_kapal = 'kode_kapal';
    public $device_id = 'device_id';

    public function __construct() {
        parent::__construct();

        $this->load->model('kapal_model', 'kapal');
    }

    public function getAllActiveDevice() {
        $strSQL = 'select ad.kode_kapal,k.nama_kapal,ad.device_id
from t_active_device ad, t_kapal k where ad.kode_kapal=k.kode_kapal';

        $query = $this->db->query($strSQL);
        return $query->result();
    }

    public function get_primary_column() {
        return $this->kode_kapal;
    }

    public function get_table_name() {
        return 't_active_device';
    }

}