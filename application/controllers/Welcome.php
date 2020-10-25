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
		$this->load->model('Global_model','global');
		$header['menu'] = $this->global->menu();
		$footer['js'] = 'login.js';

		$this->load->view('partials/header_view',$header);
		$this->load->view('login_view');
		$this->load->view('partials/footer_view',$footer);	
	}
	public function register(){
		$this->load->model('Global_model','global');
		$header['menu'] = $this->global->menu();
		$footer['js'] = 'register.js';
		
		$this->load->view('partials/header_view',$header);
		$this->load->view('register_view');
		$this->load->view('partials/footer_view',$footer);	
	}
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
}