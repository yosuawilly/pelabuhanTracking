<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home
 *
 * @author LenovoDwidasa
 */
class Home extends CI_Controller{
    
    public $user_data = array();

    public $tmpl = array ('table_open'          => '<table class="table table-hover table-bordered" border="0" cellpadding="0" cellspacing="0" style="width:100%">',
                       'heading_row_start'   => '<tr class="heading">',
                       'heading_row_end'     => '</tr>',
                       'heading_cell_start'  => '<th class="center">',
                       'heading_cell_end'    => '</th>',
                       'row_start'           => '<tr>',
                       'row_end'             => '</tr>',
                       'cell_start'          => '<td>',
                       'cell_end'            => '</td>',
                       'row_alt_start'       => '<tr class="even">',
                       'row_alt_end'         => '</tr>',
                       'cell_alt_start'      => '<td>',
                       'cell_alt_end'        => '</td>',
                       'table_close'         => '</table>'
                       );
    
    public function __construct() {
        parent::__construct();
        if(!$this->my_auth->logged_in()) redirect ('auth/login', 'refresh');
        
        $this->load->library('table');
        $this->load->library('pagination');
        
        $this->load->helper('file');
        
        $this->load->model('kapal_model', 'kapal');
        $this->load->model('active_device_model', 'active_device');
        
        date_default_timezone_set('Asia/Jakarta');
        
        $this->user_data['username'] = $this->session->userdata('username');
    }
    
    public function index() {
        $this->user_data['title'] = My_Util::getTitle('Home');
        $this->user_data['home'] = true;
        
        $this->load->view('home', $this->user_data);
    }
    
    public function kapal() {
        $this->user_data['title'] = My_Util::getTitle('Data Kapal', '-');
        $this->user_data['kapal'] = true;
        
        $kapals = $this->kapal->findAll();
        
        $this->table->set_template($this->tmpl);
        $this->table->set_heading('Kode Kapal', 'Nama Kapal', 'Ukuran', 'Mesin', 'Action');
        
        if($kapals)
        foreach ($kapals as $kapal) {
            $button_update_delete = '<div style="float:right;"><a style="margin-right:5px;" href="'.base_url().'home/updateKapal/'.$kapal->kode_kapal.'" class="btn btn-warning">
            <i class="icon icon-pencil"></i> Update</a>';
            $button_update_delete .= '<a href="'.base_url().'home/deleteKapal/'.$kapal->kode_kapal.'" class="btn btn-danger" onclick="return deleteData(this,\''.$kapal->kode_kapal.'\');">
            <i class="icon icon-trash"></i> Delete</a></div>';
            $this->table->add_row(
                array('data'=>$kapal->kode_kapal, 'class'=>'center', 'style'=>'width:60px;'),
                array('data'=>$kapal->nama_kapal, 'class'=>'center'),
                array('data'=>$kapal->ukuran, 'class'=>'center', 'style'=>'width:100px;'),
                array('data'=>$kapal->mesin, 'class'=>'center', 'style'=>'width:100px;'),
                array('data'=>$button_update_delete, 'style'=>'width:164px;')
            );
        }
        
        $this->user_data['table'] = $this->table->generate();
        
        $this->load->view('kapal', $this->user_data);
        
//        $data = array('kode_kapal'=>'K001', 'lat'=>'5', 'lng'=>'6');
//        $result = $this->kapal->save_lokasi($data);
//        if($result) {
//            echo json_encode($result);
//        }
//        $kapals = $this->kapal->get_lokasi('K001');
//        echo json_encode($kapals);
    }
    
    public function createKapal() {
        $this->user_data['title'] = My_Util::getTitle('Create Kapal', '-');
        $this->user_data['kapal'] = true;
        $this->user_data['id'] = '';
        $this->user_data['create'] = true;
        $this->user_data['kodekapal'] = ($this->session->flashdata('kodekapal')) ? $this->session->flashdata('kodekapal') : '';
        $this->user_data['namakapal'] = ($this->session->flashdata('namakapal')) ? $this->session->flashdata('namakapal') : '';
        $this->user_data['ukuran'] = ($this->session->flashdata('ukuran')) ? $this->session->flashdata('ukuran') : '';
        $this->user_data['mesin'] = ($this->session->flashdata('mesin')) ? $this->session->flashdata('mesin') : '';
        $this->user_data['error'] = ($this->session->flashdata('error')) ? $this->session->flashdata('error') : '';
        
        $this->load->view('kapal', $this->user_data);
    }
    
    public function updateKapal($kode_kapal=NULL) {
        if($kode_kapal==NULL) redirect ('home/kapal', 'refresh');
        
        $row = $this->kapal->findBy($this->kapal->kode_kapal, $kode_kapal);
        if(!$row) redirect ('home/kapal', 'refresh');
        
        $this->user_data['title'] = My_Util::getTitle('Update Kapal', '-');
        $this->user_data['bab'] = true;
        $this->user_data['id'] = $kode_kapal;
        $this->user_data['update'] = true;
        $this->user_data['kodekapal'] = ($this->session->flashdata('kodekapal')) ? $this->session->flashdata('kodekapal') : $row->kode_kapal;
        $this->user_data['namakapal'] = ($this->session->flashdata('namakapal')) ? $this->session->flashdata('namakapal') : $row->nama_kapal;
        $this->user_data['ukuran'] = ($this->session->flashdata('ukuran')) ? $this->session->flashdata('ukuran') : $row->ukuran;
        $this->user_data['mesin'] = ($this->session->flashdata('mesin')) ? $this->session->flashdata('mesin') : $row->mesin;
        $this->user_data['error'] = ($this->session->flashdata('error')) ? $this->session->flashdata('error') : '';
        
        $this->load->view('kapal', $this->user_data);
    }
    
    public function deleteKapal($kode_kapal=NULL) {
        if($kode_kapal==NULL) redirect ('home/kapal', 'refresh');
        
        $result = $this->kapal->delete($kode_kapal);
        if($result) redirect ('home/kapal', 'refresh');
        else show_error ('Delete Gagal');
    }
    
    public function submitKapal() {
        if($this->input->post('batal')) redirect ('home/kapal', 'refresh');
        
        $id = $this->input->post('id');
        $proses = $this->input->post('proses');
        $kodekapal = $this->input->post('kodekapal');
        $namakapal = $this->input->post('namakapal');
        $ukuran = $this->input->post('ukuran');
        $mesin = $this->input->post('mesin');
        
        switch ($proses) {
            case 'create':
                //if ($this->form_validation->run() == false) {
                if(trim($kodekapal) == ''){
                    $this->session->set_flashdata('error', 'Kode Kapal is required');
                } else if(trim($namakapal) == ''){
                    $this->session->set_flashdata('error', 'Nama Kapal is required');
                } else {

                    $is_exist = $this->kapal->isKapalExist($kodekapal, $namakapal);
                    if($is_exist['exist']){
                        $this->session->set_flashdata('error', $is_exist['error']);
                    } else {
                        $data = array('kode_kapal' => $kodekapal,
                                      'nama_kapal' => $namakapal,
                                      'ukuran' => $ukuran,
                                      'mesin' => $mesin);
                        $result = $this->kapal->save($data);
                        if(!$result['error']) {
                            redirect ('home/kapal', 'refresh');
                            return;
                        }
                        else {
                            $this->session->set_flashdata('error', $result['error']);
                        }
                    }
                    
                }
                
                $this->session->set_flashdata('kodekapal', $kodekapal);
                $this->session->set_flashdata('namakapal', $namakapal);
                $this->session->set_flashdata('ukuran', $ukuran);
                $this->session->set_flashdata('mesin', $mesin);
                redirect('home/createKapal', 'refresh');
                    
                break;
            case 'update':
                if(trim($kodekapal) == ''){
                    $this->session->set_flashdata('error', 'Kode Kapal is required');
                } else if(trim($namakapal) == ''){
                    $this->session->set_flashdata('error', 'Nama Kapal is required');
                } else {

                    $is_exist = $this->kapal->isNamaKapalExist($kodekapal, $namakapal);
                    if($is_exist['exist']){
                        $this->session->set_flashdata('error', $is_exist['error']);
                    } else {
                        $data = array('kode_kapal' => $kodekapal,
                                      'nama_kapal' => $namakapal,
                                      'ukuran' => $ukuran,
                                      'mesin' => $mesin);
                        $sukses = $this->kapal->update($id, $data);
                        if($sukses) {
                            redirect ('home/kapal', 'refresh');
                            return;
                        }
                    }
                    
                }
                
                $this->session->set_flashdata('kodekapal', $kodekapal);
                $this->session->set_flashdata('namakapal', $namakapal);
                $this->session->set_flashdata('ukuran', $ukuran);
                $this->session->set_flashdata('mesin', $mesin);
                redirect('home/updateKapal/'.$id, 'refresh');
                
                break;
            default:
                break;
        }
    }

    public function lokasiKapal() {
        $this->load->library('googlemaps');
        
        $this->user_data['title'] = My_Util::getTitle('Lokasi Kapal', '-');
        $this->user_data['lokasi'] = true;
        $this->user_data['error'] = '';
        
        $kapals = $this->kapal->findAll();
        $this->user_data['kapals'] = $kapals;
        
        $config['center'] = '37.4419, -122.1419';
        $config['zoom'] = 'auto';
        $this->googlemaps->initialize($config);
        $this->user_data['map'] = $this->googlemaps->create_map();
        
        $this->load->view('lokasi_kapal', $this->user_data);
    }
    
    public function dataLokasiKapal($kodeKapal=NULL, $page=0) {
        $kode = $this->input->post('namakapal');
        if($kode!=NULL) redirect('home/dataLokasiKapal/'.$kode, 'refresh');
        
        $this->load->model('lokasi_kapal_model', 'lokasi_kapal');
        
        $config = array();
        $per_page = 5;
        $uri_segment = 4;
        
        $this->user_data['title'] = My_Util::getTitle('Data Lokasi Kapal', '-');
        $this->user_data['data_lokasi'] = true;
        $this->user_data['error'] = '';
        $kapals = $this->kapal->findAll();
        $this->user_data['kapals'] = $kapals;
        $this->user_data['selected'] = $kodeKapal;
        
        if($kodeKapal!=NULL) {
            $result = $this->lokasi_kapal->getDataLokasiKapal($kodeKapal, $per_page, $page);
            
            $this->table->set_template($this->tmpl);
            $this->table->set_heading('Kode Kapal', 'Lat', 'Lng', 'Tanggal');
            
            foreach ($result['rows'] as $lokasi) {
//                $button_update_delete = '<div style="float:right;"><a style="margin-right:5px;" href="'.base_url().'home/updateKapal/'.$kapal->kode_kapal.'" class="btn btn-warning">
//                <i class="icon icon-pencil"></i> Update</a>';
//                $button_update_delete .= '<a href="'.base_url().'home/deleteKapal/'.$kapal->kode_kapal.'" class="btn btn-danger" onclick="return deleteData(this,\''.$kapal->kode_kapal.'\');">
//                <i class="icon icon-trash"></i> Delete</a></div>';
                $this->table->add_row(
                    array('data'=>$lokasi['kode_kapal'], 'class'=>'center', 'style'=>'width:63px;'),
                    array('data'=>$lokasi['lat'], 'class'=>'center', 'style'=>'width:200px;'),
                    array('data'=>$lokasi['lng'], 'class'=>'center', 'style'=>'width:200px;'),
                    array('data'=>$lokasi['tanggal'], 'class'=>'center', 'style'=>'width:auto;')
                    //array('data'=>$button_update_delete, 'style'=>'width:164px;')
                );
            }

            $this->user_data['table'] = $this->table->generate();
        
            $config['base_url'] = base_url() . 'home/dataLokasiKapal/'.$kodeKapal;
            $config['total_rows'] = $result['num_rows'];
            $config['per_page'] = $per_page;
            $config['full_tag_open'] = '<p class="paging">';
            $config['full_tag_close'] = '</p>';
            $config['uri_segment'] = $uri_segment;
            $this->pagination->initialize($config);
            
            $this->user_data['pagination'] = $this->pagination->create_links();
        }
        
        $this->load->view('data_lokasi', $this->user_data);
    }

    public function activeDevice() {
        $this->user_data['title'] = My_Util::getTitle('Data Active Device', '-');
        $this->user_data['activeDevice'] = true;

        $devices = $this->active_device->getAllActiveDevice();

        $this->table->set_template($this->tmpl);
        $this->table->set_heading('Kode Kapal', 'Nama Kapal', 'Device ID', 'Action');

        if($devices)
        foreach ($devices as $device) {
            $button_update_delete = '<div style="float:right;">';
            $button_update_delete .= '<a href="'.base_url().'home/deactivateDevice/'.$device->kode_kapal.'/'.$device->device_id.'" class="btn btn-danger" onclick="return deleteData(this,\''.$device->kode_kapal.'\');">
            <i class="icon icon-trash"></i> Deactivate</a></div>';
            $this->table->add_row(
                array('data'=>$device->kode_kapal, 'class'=>'center', 'style'=>'width:60px;'),
                array('data'=>$device->nama_kapal, 'class'=>'center'),
                array('data'=>$device->device_id, 'class'=>'center', 'style'=>'width:100px;'),
                array('data'=>$button_update_delete, 'style'=>'width:164px;')
            );
        }

        $this->user_data['table'] = $this->table->generate();

        $this->load->view('active_device', $this->user_data);
    }

    public function deactivateDevice($kode_kapal=NULL, $device_id=NULL) {
        if($kode_kapal==NULL || $device_id=NULL) redirect ('home/activeDevice', 'refresh');

        $result = $this->active_device->delete($kode_kapal);
        if($result) redirect ('home/activeDevice', 'refresh');
        else show_error ('Delete Gagal');
    }
    
}