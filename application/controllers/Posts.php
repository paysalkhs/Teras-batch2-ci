<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Global_model','global');
		if($this->session->userdata('login') != true){
			redirect('/welcome/index');
		}else return true;
	}
	public function index(){
		$this->load->model('Global_model','global');
		$header['menu'] = $this->global->menu('user');
		$footer['js'] = 'add-post.js';

		$this->load->view('partials/header_view',$header);
		$this->load->view('posts_view');
		$this->load->view('partials/footer_view',$footer);
	}
	public function add(){
		$this->load->model('Global_model','global');
		$header['menu'] = $this->global->menu('user');
		$footer['js'] = 'add-post.js';

		$this->load->view('partials/header_view',$header);
		$this->load->view('post_add_view');
		$this->load->view('partials/footer_view',$footer);
	}

	//////////// AJAX PROCESS //////////////

	public function ajaxGetAllPosts(){
		
		$posts = $this->global->getPosts();
		$data = [];
		$no = 1;
		foreach($posts->result() as $p){
			$data[] = [
			'id' => $p->post_id,
			'no' => $no,
			'title' => $p->post_title,
			'description' => substr($p->post_description, 0,25),
			'user' => $p->user_id];
			$no++;
		}
		echo json_encode(['data' => $data]);

	}
	public function ajaxSubmitPost(){
		$this->load->model('Global_model','global');
		$title = $this->input->post('post_title');
		$description = $this->input->post('post_description');

		$dataPost = ['post_title' => $title,
					'post_description' => $description,
					'user_id' => $this->session->userdata('username'),
					'created_at' => date('Y-m-d h:i:s'),
					'updated_at' => date('Y-m-d h:i:s')
					];
		$query = $this->global->addPost($dataPost);
		if($query){
			$output = ['status' => true,'message' => 'Data Berhasil Disimpan'];
		}else{
			$output = ['status' => false,'message' => 'Data Tidak Berhasil Disimpan'];
		}
		echo json_encode($output);
	}
	function ajaxDeletePost(){
		$id = $this->uri->segment(3);
		$delete = $this->global->deletePost($id);
		if($delete){
			echo json_encode(['status' => true]);
		}else{
			echo json_encode(['status' => false]);
		}
	}
}