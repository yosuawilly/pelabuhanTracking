<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of My_Util
 *
 * @author LenovoDwidasa
 */
class My_Util {
    
    public static $default_title = 'Pelabuhan Server';
    
    public function __construct() {
        $this->CI =& get_instance();
        
        $this->CI->load->helper('file');
    }
    
    public static function getTitle($title, $delimiter=NULL){
        if($delimiter!=NULL) return $title . ' ' .$delimiter. ' ' . self::$default_title;
        
        return $title . ' ' . self::$default_title;
    }
    
    public static function write_kordinat($kodeKapal=NULL, $namaKapal=NULL, $lat=NULL, $lng=NULL, $scheduleId=NULL) {
        if($kodeKapal==NULL || $namaKapal==NULL || $lat==NULL || $lng==NULL) return FALSE;
        
        //Save kordinat ke database
        //$kap = new Kapal_model();
        $lokasi = new Lokasi_kapal_model();
        
        //$kapal = $kap->findBy('nama_kapal', $namaKapal);
        //if($kapal) {
            $data = array('kode_kapal'=>$kodeKapal,
                          'lat'=>$lat,
                          'lng'=>$lng,
                          'tanggal'=>date('Y-m-d H:i:s'),
                          'schedule_id' => $scheduleId);
            $lokasi->save($data);
        //}
        
        $strKor = $lat . '&' . $lng;
        if(write_file('temp/'.$namaKapal.'.txt', $strKor)){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public static function read_kordinat($namaKapal=NULL) {
        if($namaKapal==NULL) return FALSE;
        
        $kordinat = array();
        
        $data = read_file('data_kordinat/'.$namaKapal.'.txt');
        if(! $data) return FALSE;
        
        $split = explode('&', $data);
        $kordinat['lat'] = $split[0];
        $kordinat['lng'] = $split[1];
        
        return $kordinat;
    }
    
    public static function read_save_kordinat($namaKapal=NULL) {
        if($namaKapal==NULL) return FALSE;
        
        $kordinat = array();
        
        $data = read_file('temp/'.$namaKapal.'.txt');
        if(! $data) return FALSE;
        
        copy('temp/'.$namaKapal.'.txt', 'data_kordinat/'.$namaKapal.'.txt');
        unlink('temp/'.$namaKapal.'.txt');
        
        $split = explode('&', $data);
        $kordinat['lat'] = $split[0];
        $kordinat['lng'] = $split[1];
        
        return $kordinat;
    }
    
    /* $namaKapals is array of kapal's name
     */
    public static function read_save_kordinat2($namaKapals) {
        $filenames = get_filenames('temp');
        
        $kordinats = array();
        
        foreach ($namaKapals as $namaKapal) {
            if (in_array($namaKapal.'.txt', $filenames)) {
                $data = read_file('temp/'.$namaKapal.'.txt');
                if ($data) {
                    copy('temp/'.$namaKapal.'.txt', 'data_kordinat/'.$namaKapal.'.txt');
                    unlink('temp/'.$namaKapal.'.txt');
                    
                    $split = explode('&', $data);
                    $kordinat['namakapal'] = $namaKapal;
                    $kordinat['lat'] = $split[0];
                    $kordinat['lng'] = $split[1];
                    
                    $kordinats[] = $kordinat;
                }
            }
        }
        
        if(count($kordinats) > 0) 
            return $kordinats;
        else return false;
    }
    
    public static function create_result($status, $fullMessage) {
        return json_encode(array('status'=>$status, 'fullMessage'=>$fullMessage));
    }
    
}