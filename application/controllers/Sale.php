<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sale extends CI_Controller {
    function __construct(){
        parent:: __construct();
		$this->is_logged_in();
		$this->load->model('sales');
    }
	
	function new_sale(){
		$data['page'] = 'new_sale';
		$this->sales->clear_all_temp_sale();
		$data['customers'] = $this->sales->get_all_customers_sale();
		$data['inv_no'] = $this->get_finacial_year_range();
		$data['items'] = $this->sales->get_all_items_available();
		$this->load->view('sales/new_sale',$data);
	}
	
	function get_finacial_year_range() {
		$year = date('Y');
		$month = date('m');
		if($month<4){
			$year = $year-1;
		}
		$start_date = date('Y-m-d',strtotime(($year).'-04-01'));
		$end_date = date('Y-m-d',strtotime(($year+1).'-03-31'));
		$response = array('start_date' => $start_date, 'end_date' => $end_date);
		//return $response;
		$bill_number = $this->sales->generate_next_invno($response['start_date'],$response['end_date']);
		if($bill_number > 1){
			return $bill_number;
		}else{
			return date('Y').'0001';	
		}
	}
	
	function get_batches_by_item(){
		$data = $this->sales->get_batches_by_item();
		//echo '<option value=""></option>';
		if($data){
			foreach($data as $batch){
				echo '<option value="'.$batch->grn_item_id.'"><b style="color:purple;">'.number_format($batch->selling_price,2).'</b> [ '.number_format($batch->cost,2).' ][ '.$batch->grn_id.' ] <b style="color:purple;">'.$batch->quantity.'</b></option>';
			}
		}
	}
	
	function get_item_total_stock(){
		$total = $this->sales->get_item_total_stock();
		echo $total;
	}
	
	function get_temp_sale_items(){
		$row = $this->sales->get_temp_sale_items();
		$count = 0;
		$html = '';
		$total_discount = 0;
		$sub_total = 0;
		if($row){
			foreach($row as $data){
				$count++;
				$total = $data->sale_item_quantity * ($data->sale_item_price + +$data->sale_item_discount);
				$html .= '<tr> 
						  <td class="text-center"><a title="Remove item" style="cursor:pointer" onclick="removeTempitem('.$data->temp_sale_id.')" class="text-danger">
							<i class="far fa-times-circle"></i></a>
						  </td>           
						  <td>'.$count.'</td>
						  <td>'.$data->item_name.'</td>
						  <td>'.$data->item_description.'</td>
						  <td class="text-right">'.number_format($data->sale_item_price + $data->sale_item_discount,2).'</td>
						  <td class="text-center">'.$data->sale_item_quantity.'</td>
						  <td class="text-right">'.number_format($data->sale_item_discount,2).'</td>
						  <td class="text-right">'.number_format($total,2).'</td>
					 </tr>';
				$total_discount = $total_discount + ($data->sale_item_discount * $data->sale_item_quantity);
				$sub_total = $sub_total + $total;
			}
		}
		$html .= '<tr> 
					<td colspan="6" style="background:#fff" rowspan="3"></td>           
					<td><strong>Sub Total</strong></td>
					<td class="text-right"><strong>'.number_format($sub_total,2).'</strong></td>
				</tr>
				<tr>  
					<td><strong>Discounts</strong></td>
					<td class="text-right"><strong>'.number_format($total_discount,2).'</strong></td>
				</tr>
				<tr>    
					<td><strong>Grand Total</strong></td>
					<td class="text-right"><strong>'.number_format($sub_total - $total_discount,2).'</strong></td>
				</tr>';
		return $html;
	}
	
	function add_sale_item(){
		if($this->sales->add_sale_item()){
			echo $this->get_temp_sale_items();
		}
	}
	
	function remove_temp_item(){
		if($this->sales->remove_temp_item()){
			echo $this->get_temp_sale_items();
		}
	}
	
	function customers(){
		$data['page'] = 'customers';
		$data['action'] = 'customers';
		$this->load->library('pagination');
		$config['base_url'] = base_url() . "sale/customers";;
		$config["total_rows"] = $this->sales->count_customers();
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
			if($this->sales->check_customer()){
				$this->session->set_flashdata('error', 'Customer exists.');
				redirect('sale/customers');
			}
			if($this->sales->add_customer()){
				$this->session->set_flashdata('msg', 'Successfully inserted the customer.');
			}else{
				$this->session->set_flashdata('error', 'Something went wrong.');
			}
			redirect('sale/customers');
		}else{
			$data['customers'] = $this->sales->get_all_customers($config["per_page"], $page);
      		$this->load->view('sales/customers',$data);
		}
	}
	
	function edit_customer($customer_id){
		$customer_id = $this->encryption->decode($customer_id);	
		$data['page'] = 'customers';
		$data['action'] = 'edit_customer';
		if($_POST){
			if($this->sales->edit_customer()){
				$this->session->set_flashdata('msg', 'Successfully updated the customer.');
			}else{
				$this->session->set_flashdata('error', 'Something went wrong.');
			}
			redirect('sale/customers');
		}else{
			$data['customer'] = $this->sales->get_customer($customer_id);
			$data['customers'] = '';
      		$this->load->view('sales/customers',$data);
		}
	}
	
	function delete_customer($customer_id){
		$customer_id = $this->encryption->decode($customer_id);	
		$this->sales->delete_customer($customer_id);
		$this->session->set_flashdata('msg', 'Successfully deleted the customer.');
		redirect('sale/customers');
	}
	
	function print_invoice(){
		$sale_id = $this->sales->add_sale();
		if($sale_id){
			$data['invoice'] = $this->sales->get_sale_by_id($sale_id);
			$data['invoice_data'] = $this->sales->get_sale_data($sale_id);
			$this->load->view('sales/print_invoice',$data);
		}else{
			$this->session->set_flashdata('error', 'Cannot print the invoice.');
			redirect('sale/new_sale');
		}
		
	}
	
	function reprint_invoice($sale_id){
		$data['invoice'] = $this->sales->get_sale_by_id($sale_id);
		$data['invoice_data'] = $this->sales->get_sale_data($sale_id);
		$this->load->view('sales/reprint_invoice',$data);
	}
	
	function pay($sale_id){
		if($this->sales->pay($sale_id)){
			$this->session->set_flashdata('msg', 'Successfully marked as paid.');
		}else{
		 	$this->session->set_flashdata('error', 'Something went wrong.');
		}
		redirect('sale/sales_history');
	}
	
	function clear_search(){
		$this->session->unset_userdata('search_string');
		redirect('sale/sales_history');
	}
	
	function sales_history(){
		
		if($_POST){
			$search_string = $this->input->post('search');
			$this->session->set_userdata('search_string', $search_string);
		}
		else{
			$search_string = $this->session->userdata('search_string');
		}
		
		$data['page'] = 'sales_history';
		$this->load->library('pagination');
		$config['base_url'] = base_url() . "sale/sales_history";;
		$config["total_rows"] = $this->sales->count_sales($search_string);
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
		
		$data['sales'] = $this->sales->sales_history($config["per_page"], $page,$search_string);
		
      	$this->load->view('sales/sales_history',$data);	
	}	
	
}