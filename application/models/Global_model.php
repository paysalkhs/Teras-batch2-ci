<?php
class Global_model extends CI_Model {

	function menu($user = null){
		if($user == null){
			$query = $this->db->where('menu_status','Y')
							->get('menus');
		}else{
			$query = $this->db->where('menu_status','A')
							->get('menus');
		}
		return $query;
	}
	function postRegister($data){
		$query = $this->db->insert('users', $data);
		return $query;
	}
	function check_user($username){
		return $this->db->select("username,password,status,fullname")
						->from("users")
						->where("username",$username)
						->where("status","Y")
						->get();
	}
	function getPosts(){
		return $this->db->select("*")
						->from("posts")
						->get();
	}
	function addPost($data){
		return $this->db->insert('posts',$data);
	}
	function deletePost($id){
		return $this->db->where('post_id',$id)
						->delete('posts');
	}
	function getDataPost($id){
		return $this->db->select("*")
						->from("posts")
						->where('post_id',$id)
						->get();
	}
	function updatePost($id,$data)
	{
		return $this->db->where('post_id',$id)
						->update('posts',$data);
	}
}