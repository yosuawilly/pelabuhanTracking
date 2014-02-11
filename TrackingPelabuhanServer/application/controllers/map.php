<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of map
 *
 * @author LenovoDwidasa
 */
class Map extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        
        $this->load->library('googlemaps');
    }
    
    public function index() {
        $config['center'] = '37.4419, -122.1419';
        $config['zoom'] = 'auto';
        $this->googlemaps->initialize($config);

        $marker = array();
        $marker['position'] = '37.429, -122.1419';
        $marker['draggable'] = true;
        $marker['ondragend'] = 'updateDatabase(event.latLng.lat(), event.latLng.lng());';
        $this->googlemaps->add_marker($marker);
        $data['map'] = $this->googlemaps->create_map();

        $this->load->view('map_page', $data);
    }
    
}