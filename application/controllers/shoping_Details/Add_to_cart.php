
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_to_cart extends CI_Controller {

	public function index($data)
	{
		
		$this->load->database();

		$q = $this->db->query("select * from products where id='$data'");

		$product['results'] = $q->result_array();

		
		$this->load->view('website/shop_details',$product);
	}

}