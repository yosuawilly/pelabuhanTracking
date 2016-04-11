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

    public function lokasiKapalBySchedule() {
        $this->load->library('googlemaps');

        $this->user_data['title'] = My_Util::getTitle('Lokasi Kapal Berdasarkan Jadwal', '-');
        $this->user_data['lokasiSchedule'] = true;
        $this->user_data['error'] = '';

        $kapals = $this->kapal->findAll();
        $this->user_data['kapals'] = $kapals;

        $config['center'] = '37.4419, -122.1419';
        $config['zoom'] = 'auto';
        $this->googlemaps->initialize($config);
        $this->user_data['map'] = $this->googlemaps->create_map();

        $this->load->view('lokasi_kapal_by_schedule', $this->user_data);
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

    public function schedule() {
        $this->user_data['title'] = My_Util::getTitle('Jadwal Keberangkatan', '-');
        $this->user_data['jadwalKapal'] = true;

        $this->load->model('schedule_model', 'schedule');
        $schedules = $this->schedule->findAll();

        $this->table->set_template($this->tmpl);
        $this->table->set_heading('Kode Kapal', 'Dari', 'Ke', 'Jadwal Berangkat', 'Jadwal Datang', 'Action');

        if ($schedules)
            foreach ($schedules as $schedule) {
                $button_update_delete = '<div style="float:right;"><a style="margin-right:5px;" href="'.base_url().'home/updateSchedule/'.$schedule->id.'" class="btn btn-warning">
            <i class="icon icon-pencil"></i> Update</a>';
                $button_update_delete .= '<a href="'.base_url().'home/deleteSchedule/'.$schedule->id.'" class="btn btn-danger" onclick="return deleteData(this,\''.$schedule->id.'\');">
            <i class="icon icon-trash"></i> Delete</a></div>';
                $this->table->add_row(
                    array('data'=>$schedule->kode_kapal, 'class'=>'center', 'style'=>'width:63px;'),
                    array('data'=>$schedule->dari, 'class'=>'center', 'style'=>'width:80px;'),
                    array('data'=>$schedule->ke, 'class'=>'center', 'style'=>'width:80px;'),
                    array('data'=>$schedule->jadwal_berangkat, 'class'=>'center', 'style'=>'width:auto;'),
                    array('data'=>$schedule->jadwal_datang, 'class'=>'center', 'style'=>'width:auto;'),
                    array('data'=>$button_update_delete, 'style'=>'width:164px;')
                );
            }

        $this->user_data['table'] = $this->table->generate();

        $this->load->view('schedule', $this->user_data);
    }

    public function createSchedule() {
        $this->user_data['title'] = My_Util::getTitle('Tambah Jadwal', '-');
        $this->user_data['jadwalKapal'] = true;

        $kapals = $this->kapal->findAll();
        $this->user_data['kapals'] = $kapals;

        $this->user_data['id'] = '';
        $this->user_data['create'] = true;
        $this->user_data['kodekapal'] = ($this->session->flashdata('kodekapal')) ? $this->session->flashdata('kodekapal') : '';
        $this->user_data['dari'] = ($this->session->flashdata('dari')) ? $this->session->flashdata('dari') : '';
        $this->user_data['ke'] = ($this->session->flashdata('ke')) ? $this->session->flashdata('ke') : '';
        $this->user_data['jadwal_berangkat'] = ($this->session->flashdata('jadwal_berangkat')) ? $this->session->flashdata('jadwal_berangkat') : '';
        $this->user_data['jadwal_datang'] = ($this->session->flashdata('jadwal_datang')) ? $this->session->flashdata('jadwal_datang') : '';
        $this->user_data['error'] = ($this->session->flashdata('error')) ? $this->session->flashdata('error') : '';

        $this->load->view('schedule', $this->user_data);
    }

    public function updateSchedule($id_schedule=NULL) {
        if($id_schedule==NULL) redirect ('home/schedule', 'refresh');

        $kapals = $this->kapal->findAll();
        $this->user_data['kapals'] = $kapals;

        $this->load->model('schedule_model', 'schedule');

        $row = $this->schedule->findBy($this->schedule->id, $id_schedule);
        if(!$row) redirect ('home/schedule', 'refresh');

        $berangkat_d = new DateTime($row->jadwal_berangkat);
        $jadwal_berangkat = date_format($berangkat_d,'Y-m-d') .'T'. date_format($berangkat_d,'h:i:s');
        $datang_d = new DateTime($row->jadwal_datang);
        $jadwal_datang = date_format($datang_d,'Y-m-d') .'T'. date_format($datang_d,'h:i:s');

        $this->user_data['title'] = My_Util::getTitle('Update Jadwal', '-');
        $this->user_data['jadwalKapal'] = true;
        $this->user_data['id'] = $id_schedule;
        $this->user_data['update'] = true;
        $this->user_data['kodekapal'] = ($this->session->flashdata('kodekapal')) ? $this->session->flashdata('kodekapal') : $row->kode_kapal;
        $this->user_data['dari'] = ($this->session->flashdata('dari')) ? $this->session->flashdata('dari') : $row->dari;
        $this->user_data['ke'] = ($this->session->flashdata('ke')) ? $this->session->flashdata('ke') : $row->ke;
        $this->user_data['jadwal_berangkat'] = ($this->session->flashdata('jadwal_berangkat')) ? $this->session->flashdata('jadwal_berangkat') : $jadwal_berangkat;
        $this->user_data['jadwal_datang'] = ($this->session->flashdata('jadwal_datang')) ? $this->session->flashdata('jadwal_datang') : $jadwal_datang;
        $this->user_data['error'] = ($this->session->flashdata('error')) ? $this->session->flashdata('error') : '';

        $this->load->view('schedule', $this->user_data);
    }

    public function deleteSchedule($id=NULL) {
        if($id==NULL) redirect ('home/schedule', 'refresh');

        $this->load->model('schedule_model', 'schedule');

        $result = $this->schedule->delete($id);
        if($result) redirect ('home/schedule', 'refresh');
        else show_error ('Delete Gagal');
    }

    public function submitSchedule() {
        if($this->input->post('batal')) redirect ('home/schedule', 'refresh');

        $this->load->model('schedule_model', 'schedule');

        $id = $this->input->post('id');
        $proses = $this->input->post('proses');
        $kodekapal = $this->input->post('kodekapal');
        $dari = $this->input->post('dari');
        $ke = $this->input->post('ke');
        $jadwal_berangkat = $this->input->post('jadwal_berangkat');
        $jadwal_datang = $this->input->post('jadwal_datang');

        switch ($proses) {
            case 'create':
                if (trim($kodekapal) == '') {
                    $this->session->set_flashdata('error', 'Kode Kapal is required');
                } else if(trim($dari) == '') {
                    $this->session->set_flashdata('error', 'Dari harus diisi');
                } else if(trim($ke) == '') {
                    $this->session->set_flashdata('error', 'Ke harus diisi');
                } else {

//                    $is_exist = $this->kapal->isKapalExist($kodekapal, $namakapal);
//                    if($is_exist['exist']){
//                        $this->session->set_flashdata('error', $is_exist['error']);
//                    } else {
                        $data = array('kode_kapal' => $kodekapal,
                            'dari' => $dari,
                            'ke' => $ke,
                            'jadwal_berangkat' => $jadwal_berangkat,
                            'jadwal_datang' => $jadwal_datang,
                            'berangkat' => null,
                            'datang' => null,
                            'done' => 'false');
                        $result = $this->schedule->save($data);
                        if(!$result['error']) {
                            redirect ('home/schedule', 'refresh');
                            return;
                        }
                        else {
                            $this->session->set_flashdata('error', $result['error']);
                        }
                    //}

                }

                $this->session->set_flashdata('kodekapal', $kodekapal);
                $this->session->set_flashdata('dari', $dari);
                $this->session->set_flashdata('ke', $ke);
                $this->session->set_flashdata('jadwal_berangkat', $jadwal_berangkat);
                $this->session->set_flashdata('jadwal_datang', $jadwal_datang);
                redirect('home/createSchedule', 'refresh');

                break;
            case 'update':
                if (trim($kodekapal) == '') {
                    $this->session->set_flashdata('error', 'Kode Kapal is required');
                } else if(trim($dari) == '') {
                    $this->session->set_flashdata('error', 'Dari harus diisi');
                } else if(trim($ke) == '') {
                    $this->session->set_flashdata('error', 'Ke harus diisi');
                } else {

//                    $is_exist = $this->kapal->isNamaKapalExist($kodekapal, $namakapal);
//                    if($is_exist['exist']){
//                        $this->session->set_flashdata('error', $is_exist['error']);
//                    } else {
                        $data = array('kode_kapal' => $kodekapal,
                            'dari' => $dari,
                            'ke' => $ke,
                            'jadwal_berangkat' => $jadwal_berangkat,
                            'jadwal_datang' => $jadwal_datang);
                        $sukses = $this->schedule->update($id, $data);
                        if($sukses) {
                            redirect ('home/schedule', 'refresh');
                            return;
                        }
                    //}

                }

                $this->session->set_flashdata('kodekapal', $kodekapal);
                $this->session->set_flashdata('dari', $dari);
                $this->session->set_flashdata('ke', $ke);
                $this->session->set_flashdata('jadwal_berangkat', $jadwal_berangkat);
                $this->session->set_flashdata('jadwal_datang', $jadwal_datang);
                redirect('home/updateSchedule/'.$id, 'refresh');

                break;
            default:
                break;
        }
    }

    public function laporanKapal($kodeKapal=NULL, $page=0) {
        $kode = $this->input->post('namakapal');
        if($kode!=NULL) redirect('home/laporanKapal/'.$kode, 'refresh');

        $this->load->model('schedule_model', 'schedule');

        $config = array();
        $per_page = 5;
        $uri_segment = 4;

        $this->user_data['title'] = My_Util::getTitle('Laporan Kapal', '-');
        $this->user_data['laporanKapal'] = true;

        $kapals = $this->kapal->findAll();
        $this->user_data['kapals'] = $kapals;
        $this->user_data['selected'] = $kodeKapal;
        $this->user_data['total_rows'] = 0;

        if ($kodeKapal != NULL) {
            $result = $this->schedule->getStatusSchedule($kodeKapal, $per_page, $page);

            $this->user_data['total_rows'] = $result['num_rows'];

            $this->table->set_template($this->tmpl);
            $this->table->set_heading('Kode Kapal', 'Dari', 'Ke', 'Jadwal Berangkat', 'Jadwal Datang', 'Status');

            foreach ($result['rows'] as $schedule) {
                $this->table->add_row(
                    array('data'=>$schedule['kode_kapal'], 'class'=>'center', 'style'=>'width:63px;'),
                    array('data'=>$schedule['dari'], 'class'=>'center', 'style'=>'width:100px;'),
                    array('data'=>$schedule['ke'], 'class'=>'center', 'style'=>'width:100px;'),
                    array('data'=>$schedule['jadwal_berangkat'], 'class'=>'center', 'style'=>'width:auto;'),
                    array('data'=>$schedule['jadwal_datang'], 'class'=>'center', 'style'=>'width:auto;'),
                    array('data'=>'<b class="bullet_'.$schedule['status'].'" />', 'class'=>'center', 'style'=>'width:38px; text-align: center;')
                );
            }

            $this->user_data['table'] = $this->table->generate();

            $config['base_url'] = base_url() . 'home/laporanKapal/'.$kodeKapal;
            $config['total_rows'] = $result['num_rows'];
            $config['per_page'] = $per_page;
            $config['full_tag_open'] = '<p class="paging">';
            $config['full_tag_close'] = '</p>';
            $config['uri_segment'] = $uri_segment;
            $this->pagination->initialize($config);

            $this->user_data['pagination'] = $this->pagination->create_links();
        }

        $this->load->view('laporan_kapal', $this->user_data);
    }
    
}