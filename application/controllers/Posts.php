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
	public function edit(){
		$id = $this->uri->segment(3);
		$header['menu'] = $this->global->menu('user');
		$footer['js'] = 'add-post.js';

		$data['data'] = $this->global->getDataPost($id);

		$this->load->view('partials/header_view',$header);
		$this->load->view('post_edit_view',$data);
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
		$this->load->library('form_validation');
		$this->load->library('upload');

		$title = $this->input->post('post_title');
		$description = $this->input->post('post_description');

		$config['upload_path'] 		= './uploads/';
		$config['allowed_types'] 	= 'gif|jpg|png|jpeg';
		$config['max_size']     	= '200';
		$config['encrypt_name'] 	= true;


		$this->form_validation->set_rules('post_title','Judul Post','required');
		$this->form_validation->set_rules('post_description','Deskripsi Post','required');

		if($this->form_validation->run() == FALSE){

			$data = ['post_title' => form_error('post_title'),
					'post_description' => form_error('post_description')];

			$output = ['status' => false,'type' => 'validation','data' => $data];
		}else{
			$this->upload->initialize($config);

			if($this->upload->do_upload('post_image')){
				$dataPost = ['post_title' => $title,
						'post_description' => $description,
						'user_id' => $this->session->userdata('username'),
						'post_image' => $this->upload->data('file_name'),
						'created_at' => date('Y-m-d h:i:s'),
						'updated_at' => date('Y-m-d h:i:s')
						];
				$query = $this->global->addPost($dataPost);
				if($query){
					$output = ['status' => true,'message' => 'Data Berhasil Disimpan'];
				}else{
					$output = ['status' => false,'message' => 'Data Tidak Berhasil Disimpan'];
				}
			}else{
				echo $this->upload->display_errors();
			}
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
	function ajaxEditPost(){
		$idpost = $this->input->post('id');
		$data = [
			'post_title' => $this->input->post('post_title'),
			'post_description' => $this->input->post('post_description'),
			'user_id' => $this->session->userdata('username'),
			'updated_at' => date('Y-m-d h:i:s')
		];
		$query = $this->global->updatePost($idpost,$data);
		if($query){
			$output = ['status' => true,'message' => 'Data Berhasil Duibah'];
		}else{
			$output = ['status' => false,'message' => 'Data Tidak Berhasil Diubah'];
		}
		echo json_encode($output);
	}
}