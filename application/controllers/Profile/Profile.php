<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	public function index()
	{

  		$email = $_SESSION['email'];
  		$pass = $_SESSION['pass'];
		$name=$this->input->post("F_name");
		$L_name=$this->input->post("L_name");
		$mnum=$this->input->post("m_num");
		$gender=$this->input->post("gender");
		$address=$this->input->post("address");
		$pan_name=$this->input->post("pan_name");
		$pan_number=$this->input->post("pan_number");	
		$DOB=$this->input->post("DOB");
		


        $files_get=$_FILES["image"]["name"];
            if(!empty($files_get)){
                $config['upload_path'] = './photos/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|';
                $config['max_size'] = 20000;
                $config['max_width'] = 15000;
                $config['max_height'] = 15000;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('image')) {
                    $error = array('error' => $this->upload->display_errors()); 
                    print_r($error);   
                }
                else{
                    $data = array(
                       'image_metadata' => $this->upload->data()
                    );

                    $updateArr=array(
						'Frist_Name'=>$name,
						'Last_Name'=>$L_name,
						'Mobile'=>$mnum,
						'Gender'=>$gender,
						'DOB'=>$DOB,
						'Address'=>$address,
						'Pan_Full_Name'=>$pan_name,
						'Pan_Number'=>$pan_number,
						"photo"=> $data['image_metadata']['file_name']
                    );
                     $this->db->where("email",$email);
                    $update=$this->db->update('registeration', $updateArr);
                    }
                }else{
                    $updateArr=array(
                        'Frist_Name'=>$name,
						'Last_Name'=>$L_name,
						'Mobile'=>$mnum,
						'Gender'=>$gender,
						'DOB'=>$DOB,
						'Address'=>$address,
						'Pan_Full_Name'=>$pan_name,
						'Pan_Number'=>$pan_number
                    );
                   $this->db->where("email",$email);
                   $update=$this->db->update('registeration', $updateArr);
                 

                }   
                if($update){
                	$this->load->database();
					$res = $this->db->query("select * from registeration where email='$email' &&password='$pass' ");
					$data['results'] = $res->result_array();
					redirect(base_url('Home/Profile_Dtails'));
					/*return $this->load->view('Profile/Profile_Dtails',$data);*/
                }else{
                    echo "data not updated";
                }
	}
	public function Profile_Dtails()
	{

		$email = $_SESSION['email'];

		$this->load->database();
		$p = $this->db->query("select * from registeration where email='$email'");
		$data = $p->result_array();

		foreach($data as $dt){
				$id = $dt['id'];
			}
			
		$q = $this->db->query("select * from orders where user_ids='$id'");
		$data['results'] = $p->result_array();
		$data['result1'] = $q->result_array();
		$this->load->view('Profile/Profile_Dtails',$data);
		
	}
	public function Profile_Dtails_Processing(){
		$email = $_SESSION['email'];

		$this->load->database();
		$p = $this->db->query("select * from registeration where email='$email'");
		$data = $p->result_array();

		foreach($data as $dt){
				$id = $dt['id'];
			}
			
		$q = $this->db->query("select * from orders where user_ids='$id' && status = '1' ");
		$data['results'] = $p->result_array();
		$data['result1'] = $q->result_array();
		$this->load->view('Profile/Profile_Dtails',$data);
	}
}