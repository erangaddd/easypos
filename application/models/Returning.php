<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

class Returning extends CI_Model{

	function get_return_total_by_sale_item($sale_item_id){
		$this->db->select('SUM(return_quantity) AS total');
		$this->db->where('sale_item_id',$sale_item_id);
		$query = $this->db->get('return_items');
		if($query->num_rows() > 0){
			return $query->row()->total;
		}else{
			return false;	
		}
	}
	
	function count_returns($search_string){
		$this->db->select('*');
		$this->db->join('sales','sales.sale_id = returns.sale_id');
		$this->db->join('customers','customers.customer_id = sales.customer_id','left');
		if($search_string != ''){
			$this->db->group_start();
			$this->db->like('sales.bill_number',$search_string);
			$this->db->or_like('customers.customer_name',$search_string);
			$this->db->or_like('sales.bill_date',$search_string);
			$this->db->or_like('returns.return_date',$search_string);
			$this->db->group_end();	
		}
		$query = $this->db->get('returns');
		if($query->num_rows() > 0){
			return $query->num_rows();
		}else{
			return false;	
		}	
	}
	
	function get_all_returns($limit, $start,$search_string){
		$this->db->select('returns.*,sales.bill_number,sales.bill_date,customers.customer_name');
		$this->db->join('sales','sales.sale_id = returns.sale_id');
		$this->db->join('customers','customers.customer_id = sales.customer_id','left');
		if($search_string != ''){
			$this->db->group_start();
			$this->db->like('sales.bill_number',$search_string);
			$this->db->or_like('customers.customer_name',$search_string);
			$this->db->or_like('sales.bill_date',$search_string);
			$this->db->or_like('returns.return_date',$search_string);
			$this->db->group_end();	
		}
		$this->db->order_by('returns.return_id','DESC');
		$this->db->limit($limit, $start);
		$query = $this->db->get('returns');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;	
		}
	}
	
	function get_return_items($return_id){
		$this->db->select('return_items.*,items.item_name,items.item_description');
		$this->db->join('sales_items','sales_items.sale_item_id = return_items.sale_item_id');
		$this->db->join('grn_items','grn_items.grn_item_id = sales_items.grn_item_id');
		$this->db->join('items','items.item_id = grn_items.item_id');
		$this->db->where('return_id',$return_id);
		$query = $this->db->get('return_items');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;	
		}
	}
	
	function add_return(){
		$user_id = $this->session->userdata('user_id');
		$data = array(
			'sale_id' => $this->input->post('sale_id'),
			'return_date' => $this->input->post('return_date'),
			'user_id' => $user_id
		);
		$this->db->insert('returns',$data);
		if (!$this->db->affected_rows()) {
			return false;	
		}else{
			$insert_id = $this->db->insert_id();
			foreach ($_POST as $key => $value) {
				if (strpos($key, 'sale_item_id_') !== false) {
					
					$sale_item_id = substr($key, strrpos($key, '_' )+1);
					
					if($this->input->post('return_quantity_'.$sale_item_id) != ''){
						if($this->input->post('add_stock_'.$sale_item_id) == 'yes'){
							//add to stock
							$grn_item_id = $this->input->post('grn_item_id_'.$sale_item_id);
							$this->load->model('sales');
							$grn_item = $this->sales->get_grn_item_by_id($grn_item_id);
							$current_qty = $grn_item->quantity;
							$new_qty = $current_qty + $this->input->post('return_quantity_'.$sale_item_id);
							
							$data = array(
								'quantity' => $new_qty
							);
							$this->db->where('grn_items.grn_item_id',$grn_item_id);	
							$this->db->update('grn_items',$data);
						}
						
						$data = array(
							'return_id' => $insert_id,
							'sale_item_id' => $sale_item_id,
							'return_quantity' => htmlspecialchars($this->input->post('return_quantity_'.$sale_item_id)),
							'return_reason' => htmlspecialchars($this->input->post('return_reason_'.$sale_item_id)),
							'added_to_stock' => htmlspecialchars($this->input->post('add_stock_'.$sale_item_id)),
						);
						$this->db->insert('return_items',$data);
						
					}
				}
				
			}
			return true;
			
		}
	}
	
	function get_returns_by_sale_id($sale_id){
		$this->db->select('return_items.*,sales_items.sale_item_price');
		$this->db->join('returns','returns.return_id = return_items.return_id');
		$this->db->join('sales_items','sales_items.sale_item_id = return_items.sale_item_id');
		$this->db->where('returns.sale_id',$sale_id);
		$query = $this->db->get('return_items');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;	
		}
	}
   
}

?>