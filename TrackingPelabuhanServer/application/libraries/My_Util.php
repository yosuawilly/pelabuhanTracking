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
    }
    
    public static function getTitle($title, $delimiter=NULL){
        if($delimiter!=NULL) return $title . ' ' .$delimiter. ' ' . self::$default_title;
        
        return $title . ' ' . self::$default_title;
    }
    
}