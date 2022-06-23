<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    function __construct(){
		$this->is_logged_in();
        parent:: __construct();

       
    }
    
	public function index(){
	   $data['page'] = 'dashboard';
       $this->load->view('dashboard',$data);
    }

    
}