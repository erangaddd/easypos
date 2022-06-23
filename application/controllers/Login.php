<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    function __construct(){
        parent:: __construct();
		$this->load->model('logins');
       
    }
    
	public function index(){
	   	if($_POST){
			if($this->input->post('username') != ''){
				if($this->logins->validate_username()){//if valid username check for password
					if($this->input->post('password') != ''){
						if($dataquery = $this->logins->validate_password()){ //valid for password
							$count = 0;
							$count = count($dataquery);
							if($count>0){//if login success redirect to alert page
								foreach($dataquery as $row){
									$usertype = $row->usertype;
									$username = $row->username;
									$userid = $row->userid;
		
								}
								
								$this->load->library('session'); //Load session library
								$session = array('username'=>$username, 'usertype'=>$usertype, 'user_id'=>$userid);
								$this->session->set_userdata($session); //set session
								redirect(base_url()."sale/new_sale");
							}else{
								$this->session->set_flashdata('error',"Something went wrong");
								redirect('login');
							}
						}else{
							$this->session->set_flashdata('error',"Incorrect Password");
							$this->session->set_flashdata('username',$this->input->post('username'));
							redirect('login');
						}
					}else{
						$this->session->set_flashdata('error',"Please enter password");
						$this->session->set_flashdata('username',$this->input->post('username'));
						redirect('login');
					}
				}else{
					$this->session->set_flashdata('error',"Incorrect username");
					redirect('login');
				}
			}else{
				$this->session->set_flashdata('error',"Please enter username");
				redirect('login');
			}
		}
	   	$data['page'] = 'login';
       	$this->load->view('login',$data);
    }
	
	function change_password(){
		if($_POST){
			if($this->logins->validate_password_change()){ //valid for password
				$new_password = $this->input->post('new_password');
				$confirm_password = $this->input->post('confirm_password');
				if($new_password != $confirm_password){
					$this->session->set_flashdata('error',"Password Mismatched");
				}else{
					if($this->logins->change_password($new_password)){
						$this->session->set_flashdata('msg',"Successfully Changed the Password");
					}else{
						$this->session->set_flashdata('error',"Something Went Wrong");	
					}				
				}
			}else{
				$this->session->set_flashdata('error',"Current Password is Incorrect");
				
			}
			redirect('login/change_password');
		}
		$data['page'] = 'change_password';
       	$this->load->view('change_password',$data);	
	}
	
	function logout(){
		$this->session->sess_destroy();
		redirect('login');
	}

    
}