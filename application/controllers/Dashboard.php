<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if($this->session->userdata('login') != true){
			redirect('/welcome/index');
		}else return true;
	}
	public function index(){

		$this->load->model('Global_model','global');
		$header['menu'] = $this->global->menu('user');
		$footer['js'] = '';

		$this->load->view('partials/header_view',$header);
		$this->load->view('home_view');
		$this->load->view('partials/footer_view',$footer);
	}
	public function logout(){
		$sessions = ['username','login','fullname'];
		$this->session->unset_userdata($sessions);
		redirect('/welcome/login');
	}
}