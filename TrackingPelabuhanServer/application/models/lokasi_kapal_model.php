<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of lokasi_kapal_model
 *
 * @author LenovoDwidasa
 */
class Lokasi_kapal_model extends Super_model{
    
    public $kode_kapal = 'kode_kapal';
    public $lat = 'lat';
    public $lng = 'lng';
    
    public function save($data) {
        if( parent::findBy($this->kode_kapal, $data[$this->kode_kapal]) ) {
            return parent::update($data[$this->kode_kapal], $data);
        }
        return parent::save($data);
    }
    
    public function get_primary_column() {
        return $this->kode_kapal;
    }
    
    public function get_table_name() {
        return 't_lokasi_kapal';
    }
    
}