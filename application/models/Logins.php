<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

class Logins extends CI_Model{

   function validate_username() { //validate exsiting for usernames
		$this->db->select('username');
        $this->db->where('username', $this->input->post('username'));
        $query = $this->db->get('userdata');
        if ($query->num_rows() >0) {
            return TRUE; //if matching records go to passowrd validate
        }
		else
		return false; //if no matching records
    }
	//Added by Eranga
	function validate_password() { //validate passowrd
	
		$password = $this->encryption->encode($this->input->post('password'));
		$this->db->select('userdata.username,userdata.userid,userdata.usertype');
		$this->db->where('username', $this->input->post('username'));
		$this->db->where('password',$password );   
		$query = $this->db->get('userdata');
		if ($query->num_rows() >0) {
            $result = $query->result();
			return $result;
        }
		else
		return false; //if no matching records
		
	}
	
	function validate_password_change() { //validate passowrd
	
		$password = $this->encryption->encode($this->input->post('password'));
		$this->db->select('userdata.username,userdata.userid,userdata.usertype');
		$this->db->where('username', $this->session->userdata('username'));
		$this->db->where('password',$password );   
		$query = $this->db->get('userdata');
		if ($query->num_rows() >0) {
            $result = $query->result();
			return $result;
        }
		else
		return false; //if no matching records
		
	}
	
	function change_password($new_password){
		$new_password = $this->encryption->encode($new_password);
		$data = array(
			'password' => $new_password
		);
		$this->db->where('userdata.userid',$this->session->userdata('user_id'));	
		$this->db->update('userdata',$data);
		if ($this->db->trans_status() === FALSE)
		{
			return false;
		}else{
			return true;
		}
	}
}

?>