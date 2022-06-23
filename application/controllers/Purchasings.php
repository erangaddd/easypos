<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchasings extends CI_Controller {
    function __construct(){
        parent:: __construct();
		$this->is_logged_in();
       	$this->load->model('grns');
		$this->load->model('configurations');
    }
	
	function history(){
		$data['page'] = 'grns';
		$this->load->library('pagination');
		$config['base_url'] = base_url() . "purchasings/history";;
		$config["total_rows"] = $this->grns->count_grns($status = '1');
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
		$data['grn'] = $this->grns->get_all_grn($status = '1',$config["per_page"], $page);
		$this->load->view('purchasing/history',$data);
	}
	
	function grns_search($status){
		$data["links"] = '';
		
		$data['grn'] = $this->grns->grns_search($status);
		if($status == '1'){
			$data['page'] = 'grns';
			$this->load->view('purchasing/history',$data);
		}else{
			$data['page'] = 'grn_received';
			$this->load->view('purchasing/grn_received',$data);
		}
	}
	
	function reorder(){
		$data['page'] = 'reorder';
		$data['items'] = $this->grns->get_all_items_reorder();
		$this->load->view('purchasing/reorder',$data);
	}
	
	function update_prices(){
		$data['page'] = 'update_prices';
		if($_POST){
			$this->grns->update_prices();
			$this->session->set_flashdata('msg', 'Successfully updated the prices.');
			redirect('purchasings/update_prices/');
			
		}else{
			$data['grn_items'] = '';
		}
		$this->load->view('purchasing/update_prices',$data);
	}
	
	function update_search(){
		$data['page'] = 'update_prices';
		$data['grn_items'] = $this->grns->get_grn_search_items();
		$this->load->view('purchasing/update_prices',$data);
	}
    
	function grn_received(){
		$data['page'] = 'grn_received';
		$this->load->library('pagination');
		$config['base_url'] = base_url() . "purchasings/grn_received";;
		$config["total_rows"] = $this->grns->count_grns($status = '0');
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
		$data['grn'] = $this->grns->get_all_grn($status = '0',$config["per_page"], $page);
		$this->load->view('purchasing/grn_received',$data);
	}
	
	function confirm_grn($grn_id){
		$grn_id = $this->encryption->decode($grn_id);
		if($this->grns->confirm_grn($grn_id)){
			$this->session->set_flashdata('msg', 'Successfully confirmed the GRN.');
		}else{
			$this->session->set_flashdata('error', 'Something went wrong.');
		}
		redirect('purchasings/grn_received/');
	}
	
	function add_grn(){
		if($_POST){
			if($this->grns->add_grn()){
				$this->session->set_flashdata('msg', 'Successfully added the GRN.');
			}else{
				$this->session->set_flashdata('error', 'Something went wrong.');
			}
			redirect('purchasings/grn_received/');
		}else{
			$data['page'] = 'grn_received';
			$data['items'] = $this->configurations->get_all_items_grn();
			$this->load->view('purchasing/add_grn',$data);
		}
	}
	
	function add_item_grn(){
		$count = $this->input->post('count');
		$items = $this->configurations->get_all_items_grn();
		echo '<div class="form-row" id="item_'.$count.'"><div class="form-group col-md-4">
				  <select class="form-control chosen-select" name="item_id'.$count.'" id="item_id'.$count.'" required >
						<option value=""></option>';
						if($items){
								foreach($items as $data2){	
						
									echo '<option value="'.$data2->item_id.'">'.$data2->item_name.' '.$data2->item_description.' - '.$data2->type_name.'</option>';
						
								}
							}
						
			echo '</select>
				</div>
				<div class="form-group col-md-2">
				  <input type="number" step="0.01" class="form-control" required="required"
						id="cost'.$count.'" min="1" name="cost'.$count.'"
						autocomplete="off" aria-describedby="Cost Rs."
						placeholder="Cost Rs." onblur="setMinselling('.$count.',this.value)">
				</div>
				<div class="form-group col-md-2">
				  <input type="number" step="0.01" class="form-control" required="required"
						id="selling_price'.$count.'" min="1" name="selling_price'.$count.'"
						autocomplete="off" aria-describedby="Selling Price"
						placeholder="Selling Price Rs.">
				</div>
				<div class="form-group col-md-2">
				  <input type="number" class="form-control" required="required"
						id="quantity'.$count.'" min="1" name="quantity'.$count.'"
						autocomplete="off" aria-describedby="Quantity"
						placeholder="Quantity">
				</div>
				<div class="form-group col-md-2">
					
					<a class="ml-4" onclick="addColumn();" role="button">
						  <i class="fas fa-plus-circle text-success pt-2"></i>
					 </a>
					 <a class=ml-4 onclick=removeColumn("item_'.$count.'"); role=button>
						  <i class="fas fa-minus-circle text-danger pt-2"></i></i>
					 </a>
				</div></div>';
	}
	
	function delete_grn($grn_id){
		$grn_id = $this->encryption->decode($grn_id);
		if($this->grns->delete_grn($grn_id)){
			$this->session->set_flashdata('msg', 'Successfully deleted the GRN.');
		}else{
			$this->session->set_flashdata('error', 'Something went wrong.');
		}
		redirect('purchasings/grn_received/');	
	}
	
	function edit_grn($grn_id){
		$data['page'] = 'grn_received';
		if($_POST){
			if($this->grns->edit_grn($grn_id)){
				$this->session->set_flashdata('msg', 'Successfully updated the GRN.');
			}else{
				$this->session->set_flashdata('error', 'Something went wrong.');
			}
			redirect('purchasings/grn_received/');
		}else{
			$grn_id = $this->encryption->decode($grn_id);
			$data['items'] = $this->configurations->get_all_items_grn();
			$data['grn_items'] = $this->grns->get_grn_items($grn_id);
			$data['grn'] = $this->grns->get_grn($grn_id);
			$this->load->view('purchasing/edit_grn',$data);
		}
	}
	
	function grn_items(){
		$data['page'] = 'grn_items';
		$data['grn_items'] = '';
		if($_POST){
			$data['grn_items'] = $this->grns->get_grn_search_items();
		}
		$this->load->view('purchasing/grn_items',$data);
			
	}
	
	function merge_stock(){
		$data['page'] = 'merge_stock';
		if($_POST){
			if($this->grns->transfer_qty()){
				$this->session->set_flashdata('msg', 'Successfully transfers.');
			}else{
				$this->session->set_flashdata('error', 'Something went wrong.');
			}
			redirect('purchasings/merge_stock/');
		}
		$data['items'] = $this->configurations->get_all_items_grn();
		$this->load->view('purchasing/merge_stock',$data);	
	}
}