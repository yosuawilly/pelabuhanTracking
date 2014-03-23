<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of kapal_model
 *
 * @author LenovoDwidasa
 */
class Kapal_model extends Super_model{
    
    public $kode_kapal = 'kode_kapal';
    public $nama_kapal = 'nama_kapal';
    public $ukuran = 'ukuran';
    public $mesin = 'mesin';
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model('lokasi_kapal_model', 'lokasi');
    }
    
    public function get_lokasi($kode_kapal) {
        return $this->lokasi->findBy($this->kode_kapal, $kode_kapal);
    }
    
    public function get_lokasi_by_name($nama_kapal) {
        $kapal = $this->findBy($this->nama_kapal, $nama_kapal);
        if($kapal){
            $kode_kapal = $kapal->kode_kapal;
        } else {
            return My_Util::create_result(false, 'Data tidak ditemukan');
        }
        return $this->lokasi->findBy($this->kode_kapal, $kode_kapal);
    }
    
    public function save_lokasi($data) {
        return $this->lokasi->save($data);
    }

    public function isKapalExist($kode_kapal, $nama_kapal) {
        $result1 = $this->findBy($this->kode_kapal, $kode_kapal);
        $result2 = $this->findBy($this->nama_kapal, $nama_kapal);

        if($result1) {
            return array('exist'=>TRUE, 'error'=>'Kode kapal ' .$kode_kapal. ' sudah ada di database');
        } else if($result2) {
            return array('exist'=>TRUE, 'error'=>'Nama kapal ' .$nama_kapal. ' sudah ada di database');
        } else
            return array('exist'=>FALSE, 'error'=>'');
    }

    public function isNamaKapalExist($kode_kapal, $nama_kapal) {
        $kapal = $this->findBy($this->kode_kapal, $kode_kapal);
        if($kapal->nama_kapal == $nama_kapal) {
            return array('exist'=>FALSE, 'error'=>'');
        }
        
        $result1 = $this->findBy($this->nama_kapal, $nama_kapal);

        if($result1) {
            return array('exist'=>TRUE, 'error'=>'Nama kapal ' .$nama_kapal. ' sudah ada di database');
        } else
            return array('exist'=>FALSE, 'error'=>'');
    }

    public function get_primary_column() {
        return $this->kode_kapal;
    }

    public function get_table_name() {
        return 't_kapal';
    }
    
}