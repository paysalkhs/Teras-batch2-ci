<?php
class Global_model extends CI_Model {

	function menu(){
		/*$this->db->select("*")
				->from("menus")
				->where('menu_status','Y')
				->get();*/


		$query = $this->db->where('menu_status','Y')
							->get('menus');
		return $query;
	}
	function postRegister($data){
		$query = $this->db->insert('users', $data);
		return $query;
	}

}