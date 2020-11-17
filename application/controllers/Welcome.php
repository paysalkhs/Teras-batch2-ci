<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct(){
		parent::__construct();
	}
	public function index()
	{
		$this->load->model('Global_model','global');
		$header['menu'] = $this->global->menu();
		$footer['js'] = '';

		$this->load->view('partials/header_view',$header);
		$this->load->view('welcome_message');
		$this->load->view('partials/footer_view',$footer);
	}
	public function login(){
		if($this->session->has_userdata('username') && $this->session->has_userdata('login')){
			redirect('/home');
		}else{
			$this->load->model('Global_model','global');
			$header['menu'] = $this->global->menu();
			$footer['js'] = 'login.js';

			$this->load->view('partials/header_view',$header);
			$this->load->view('login_view');
			$this->load->view('partials/footer_view',$footer);
		}	
	}
	public function register(){
		$this->load->model('Global_model','global');
		$header['menu'] = $this->global->menu();
		$footer['js'] = 'register.js';
		
		$this->load->view('partials/header_view',$header);
		$this->load->view('register_view');
		$this->load->view('partials/footer_view',$footer);	
	}
	public function home(){
		$this->load->model('Global_model','global');
		$header['menu'] = $this->global->menu();
		$footer['js'] = 'register.js';
		
		$this->load->view('partials/header_view',$header);
		$this->load->view('home_view');
		$this->load->view('partials/footer_view',$footer);
	}

	############ AJAX PROCESS ############

	public function register_process(){
		$this->load->model('Global_model','global');
		$this->load->library('encryption');

		$username = $this->input->post('username');
		$password = $this->encryption->encrypt($this->input->post('password'));
		$fullname = $this->input->post('fullname');
		$status = 'Y';

		//Pengiriman Data Ke Model GLobal Model
		$arr = [
				'username' => $username,
				'password' => $password,
				'fullname' => $fullname,
				'status' => $status,
				'created_at' => date('Y-m-d h:i:s')
				];
		//Mengiriman dan memproses data ke model
		$insert = $this->global->postRegister($arr);
		if($insert){
			//Hasil Berhasil
			$output = ['status' => true,'message' => 'Data berhasil didaftarkan'];
		}else{
			//Hasil Gagal
			$output = ['status' => false,'message' => 'Gagal Mendaftarkan'];
		}
		echo json_encode($output);
	}
	public function login_process()
	{
		$this->load->model('Global_model','global');
		$this->load->library('encryption');
		$this->load->library('form_validation');

		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$this->form_validation->set_rules('username','Username','required');
		$this->form_validation->set_rules('password','Password','required');

		if($this->form_validation->run() == FALSE){
			$data = ['username' => form_error('username'),'password' => form_error('password')];
			echo json_encode(['status' => false,'type' => 'validation','data' => $data]);
		}else{
			$check = $this->global->check_user($username);
			if($check->num_rows() == 1){
				$dePassword = $this->encryption->decrypt($check->row()->password);
				if($dePassword == $password){
					$this->session->set_userdata('username',$username);
					$this->session->set_userdata('login',true);
					$this->session->set_userdata('fullname',$check->row()->fullname);
					echo json_encode(['status' => true]);
				}else{
					echo json_encode(['status' => false,'message' => 'Maaf Username & Password Salah']);
				}
			}else{
				echo json_encode(['status' => false,'message' => 'Maaf Username & Password Salah']);
			}
		}
	}
}