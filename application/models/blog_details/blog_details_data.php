<?php
class blog_details_data extends CI_Model 
{
	function index(){
		$this->load->database();
		$q = $this->db->query('select * from product');

		return $q->result_array();
		
	}
}