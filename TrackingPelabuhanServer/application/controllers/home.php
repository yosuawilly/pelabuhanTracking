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
        
        $this->load->model('kapal_model', 'kapal');
        
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
                if(trim($namakapal) == ''){
                    $this->session->set_flashdata('error', 'Nama Kapal is required');
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
                
                $this->session->set_flashdata('kodekapal', $kodekapal);
                $this->session->set_flashdata('namakapal', $namakapal);
                $this->session->set_flashdata('ukuran', $ukuran);
                $this->session->set_flashdata('mesin', $mesin);
                redirect('home/createKapal', 'refresh');
                    
                break;
            case 'update':
                if(trim($namakapal) == ''){
                    $this->session->set_flashdata('error', 'Nama Kapal is required');
                    
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
        $this->user_data['title'] = My_Util::getTitle('Lokasi Kapal', '-');
        $this->user_data['lokasi'] = true;
        $this->user_data['error'] = '';
        
        $kapals = $this->kapal->findAll();
        $this->user_data['kapals'] = $kapals;
        
        $this->load->view('lokasi_kapal', $this->user_data);
    }
    
}