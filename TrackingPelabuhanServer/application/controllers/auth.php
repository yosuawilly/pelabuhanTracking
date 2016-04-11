<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
//        $this->load->library('session');
        $this->load->library('form_validation');
//        $this->load->helper('url');
        
        date_default_timezone_set('Asia/Jakarta');
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
    }
    
    function index() {
        if (!$this->my_auth->logged_in())
	{
            //redirect them to the login page
	    redirect('auth/login', 'refresh');
	}
	else
	{
            //redirect to home page
            redirect('home', 'refresh');
	}
    }
    
    function login() {
        if($this->my_auth->logged_in()) redirect ('home', 'refresh');
        
        $this->data['title'] = "Login Pelabuhan Server";
        
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        
        if ($this->form_validation->run() == true){
            if($this->my_auth->login($this->input->post('username'), $this->input->post('password'))){
                redirect('home', 'refresh');
            } else {
                $this->session->set_flashdata('user', $this->input->post('username'));
                $this->session->set_flashdata('pesan', $this->my_auth->get_error());
                redirect('auth/login', 'refresh');
            }
        } else {
            $this->data['pesan'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('pesan');
        }
        
        $this->data['user'] = ($this->input->post('username')) ? $this->input->post('username') : $this->session->flashdata('user');
            
        $this->load->view('auth/login', $this->data);
    }
    
    public function logout(){
        $this->my_auth->logout();
        redirect('auth/login', 'refresh');
    }
    
}
