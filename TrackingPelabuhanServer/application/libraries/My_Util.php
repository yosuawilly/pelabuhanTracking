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
    
    public static function write_kordinat($namaKapal=NULL, $lat=NULL, $lng=NULL) {
        if($namaKapal==NULL || $lat==NULL || $lng==NULL) return FALSE;
        
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
    
    public static function create_result($status, $fullMessage) {
        return array('status'=>$status, 'fullMessage'=>$fullMessage);
    }
    
}