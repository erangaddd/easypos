<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends CI_Controller {
    function __construct(){
        parent:: __construct();
		$this->is_logged_in();
       	$this->load->model('configurations');
    }
    
	public function units(){
		$data['page'] = 'config';
		$data['action'] = 'units';
		if($_POST){
			//check availability
			if($this->configurations->check_units()){
				$this->session->set_flashdata('error', 'Unit name exists.');
				redirect('config/units/');
			}
			if($this->configurations->add_units()){
				$this->session->set_flashdata('msg', 'Successfully inserted the unit.');
			}else{
				$this->session->set_flashdata('error', 'Something went wrong.');
			}
			redirect('config/units/');
		}else{
			$data['units'] = $this->configurations->get_all_units();
      		$this->load->view('config/units',$data);
		}
    }
	
	function edit_unit($unit_id = ''){
		$data['page'] = 'config';
		$data['action'] = 'edit_unit';	
		$unit_id = $this->encryption->decode($unit_id);
		if($_POST){
			//check availability
			if($this->configurations->check_units()){
				$this->session->set_flashdata('error', 'Unit name exists.');
				redirect('config/units/');
			}
			if($this->configurations->edit_unit()){
				$this->session->set_flashdata('msg', 'Successfully updated the unit.');
			}else{
				$this->session->set_flashdata('error', 'Something went wrong.');
			}
			redirect('config/units/');
		}else{
			$data['units'] = $this->configurations->get_all_units();
			$data['unit'] = $this->configurations->get_unit_by_id($unit_id);
      		$this->load->view('config/units',$data);
		}	
	}
	
	function delete_unit($unit_id = ''){
		$unit_id = $this->encryption->decode($unit_id);	
		$this->configurations->delete_unit($unit_id);
		$this->session->set_flashdata('msg', 'Successfully deleted the unit.');
		redirect('config/units/');
	}
	
	public function categories(){
		$data['page'] = 'config';
		$data['action'] = 'categories';
		if($_POST){
			//check availability
			if($this->configurations->check_categories()){
				$this->session->set_flashdata('error', 'Category name exists.');
				redirect('config/categories/');
			}
			if($this->configurations->add_categories()){
				$this->session->set_flashdata('msg', 'Successfully inserted the category.');
			}else{
				$this->session->set_flashdata('error', 'Something went wrong.');
			}
			redirect('config/categories/');
		}else{
			$data['categories'] = $this->configurations->get_all_categories();
      		$this->load->view('config/categories',$data);
		}
    }
	
	function edit_category($category_id = ''){
		$data['page'] = 'config';
		$data['action'] = 'edit_category';	
		$category_id = $this->encryption->decode($category_id);
		if($_POST){
			//check availability
			if($this->configurations->check_categories()){
				$this->session->set_flashdata('error', 'Category name exists.');
				redirect('config/categories/');
			}
			if($this->configurations->edit_category()){
				$this->session->set_flashdata('msg', 'Successfully updated the category.');
			}else{
				$this->session->set_flashdata('error', 'Something went wrong.');
			}
			redirect('config/categories/');
		}else{
			$data['categories'] = $this->configurations->get_all_categories();
			$data['category'] = $this->configurations->get_category_by_id($category_id);
      		$this->load->view('config/categories',$data);
		}	
	}
	
	function delete_category($category_id = ''){
		$category_id = $this->encryption->decode($category_id);	
		$this->configurations->delete_category($category_id);
		$this->session->set_flashdata('msg', 'Successfully deleted the category.');
		redirect('config/categories/');
	}
	
	public function types(){
		$data['page'] = 'config';
		$data['action'] = 'types';
		if($_POST){
			//check availability
			if($this->configurations->check_types()){
				$this->session->set_flashdata('error', 'Type name exists.');
				redirect('config/types');
			}
			if($this->configurations->add_types()){
				$this->session->set_flashdata('msg', 'Successfully inserted the type.');
			}else{
				$this->session->set_flashdata('error', 'Something went wrong.');
			}
			redirect('config/types/');
		}else{
			$data['categories'] = $this->configurations->get_all_categories();
			$data['types'] = $this->configurations->get_all_types();
      		$this->load->view('config/types',$data);
		}
    }
	
	function edit_type($type_id = ''){
		$data['page'] = 'config';
		$data['action'] = 'edit_type';	
		$type_id = $this->encryption->decode($type_id);
		if($_POST){
			//check availability
			if($this->configurations->check_types()){
				$this->session->set_flashdata('error', 'Type exists.');
				redirect('config/types/');
			}
			if($this->configurations->edit_type()){
				$this->session->set_flashdata('msg', 'Successfully updated the type.');
			}else{
				$this->session->set_flashdata('error', 'Something went wrong.');
			}
			redirect('config/types');
		}else{
			$data['types'] = $this->configurations->get_all_types();
			$data['categories'] = $this->configurations->get_all_categories();
			$data['type'] = $this->configurations->get_type_by_id($type_id);
      		$this->load->view('config/types',$data);
		}	
	}
	
	function delete_type($type_id = ''){
		$type_id = $this->encryption->decode($type_id);	
		$this->configurations->delete_type($type_id);
		$this->session->set_flashdata('msg', 'Successfully deleted the type.');
		redirect('config/types');
	}
	
	public function items(){
		$data['page'] = 'config';
		$data['action'] = 'items';
		$this->load->library('pagination');
		$config['base_url'] = base_url() . "config/items";;
		$config["total_rows"] = $this->configurations->count_items();
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
		
		if($_POST){
			//check availability
			if($this->configurations->check_items()){
				$this->session->set_flashdata('error', 'Item exists.');
				redirect('config/items');
			}
			if($this->configurations->add_items()){
				$this->session->set_flashdata('msg', 'Successfully inserted the item.');
			}else{
				$this->session->set_flashdata('error', 'Something went wrong.');
			}
			redirect('config/items');
		}else{
			$data['types'] = $this->configurations->get_all_types();
			$data['units'] = $this->configurations->get_all_units();
			$data['items'] = $this->configurations->get_all_items($config["per_page"], $page);
      		$this->load->view('config/items',$data);
		}
    }
	
	function edit_item($item_id = ''){
		$data['page'] = 'config';
		$data['action'] = 'edit_item';	
		$item_id = $this->encryption->decode($item_id);
		if($_POST){
			//check availability
			if($this->configurations->check_items()){
				$this->session->set_flashdata('error', 'Item name exists.');
				redirect('config/items');
			}
			if($this->configurations->edit_item()){
				$this->session->set_flashdata('msg', 'Successfully updated the item.');
			}else{
				$this->session->set_flashdata('error', 'Something went wrong.');
			}
			redirect('config/items');
		}else{
			//$data['items'] = $this->configurations->get_all_items();
			$data['types'] = $this->configurations->get_all_types();
			$data['units'] = $this->configurations->get_all_units();
			$data['item'] = $this->configurations->get_item_by_id($item_id);
      		$this->load->view('config/items',$data);
		}	
	}
	
	function delete_item($item_id = ''){
		$item_id = $this->encryption->decode($item_id);	
		$this->configurations->delete_item($item_id);
		$this->session->set_flashdata('msg', 'Successfully deleted the item.');
		redirect('config/items');
	}
	
	function item_search(){
		$data['page'] = 'config';
		$data['action'] = 'items';
		$data["links"] = '';
		$data['types'] = $this->configurations->get_all_types();
		$data['units'] = $this->configurations->get_all_units();
		$data['items'] = $this->configurations->search_items();
		$this->load->view('config/items_search',$data);
	}

    
}