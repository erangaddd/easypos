<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Returns extends CI_Controller {
    function __construct(){
        parent:: __construct();
		$this->is_logged_in();
		$this->load->model('returning');
		$this->load->model('sales');
    }
	
	function return_sales($sale_id){
		if($_POST){
			if($this->returning->add_return()){
				$this->session->set_flashdata('msg', 'Successfully added the return.');	
			}else{
				$this->session->set_flashdata('error', 'Something went wrong.');	
			}
			redirect('returns/return_sales/'.$sale_id);
		}
		$data['page'] = 'sales_returns';
		$data['sale_data'] = $this->sales->get_sale_data($sale_id);
		$data['sale'] = $this->sales->get_sale_by_id($sale_id);
		$data['customers'] = $this->sales->get_all_customers_sale();
		$this->load->view('returns/sales_returns',$data);
	}
	
	function return_list(){
		if($_POST){
			$search_string = $this->input->post('search');
			$this->session->set_userdata('search_string2', $search_string);
		}
		else{
			$search_string = $this->session->userdata('search_string2');
		}
		
		$data['page'] = 'return_list';
		$this->load->library('pagination');
		$config['base_url'] = base_url() . "returns/return_list";;
		$config["total_rows"] = $this->returning->count_returns($search_string);
        $config["per_page"] = 20;
        $config["uri_segment"] = 3;		
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['attributes'] = ['class' => 'page-link'];
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
		$config['cur_tag_close'] = '<span class="sr-only">(current)</span></a></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["links"] = $this->pagination->create_links();
		$data['returns'] = $this->returning->get_all_returns($config["per_page"], $page,$search_string);
		$this->load->view('returns/return_list',$data);	
	}
	
	function clear_search(){
		$this->session->unset_userdata('search_string2');
		redirect('returns/return_list');
	}
	
}