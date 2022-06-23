<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

class Sales extends CI_Model{
	
	function get_all_items_available(){
		$this->db->select('items.item_id,items.item_name,items.item_description,types.type_name');
		$this->db->join('types','types.type_id = items.type_id');
		$query = $this->db->get('items');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;	
		}
	}
	
	function clear_all_temp_sale(){
		$user_id = $this->session->userdata('user_id');
		//get all temp items
		$temp_items = $this->get_temp_sale_items($user_id);
		if($temp_items){
		  $this->db->trans_begin();
		  foreach($temp_items as $data){
			  //add qty to Grns
			  $this->db->select('quantity');
			  $this->db->where('grn_item_id',$data->grn_item_id);
			  $query = $this->db->get('grn_items');
			  if($query->num_rows() > 0){
				  $qty = $query->row()->quantity + $data->sale_item_quantity;
				  $data2 = array(
					  'quantity' => $qty,
				  );
				  $this->db->where('grn_item_id',$data->grn_item_id);
				  $this->db->update('grn_items',$data2);
			  }else{
				  $this->db->trans_rollback();
				  return false;
			  }
		  }
		  $this->db->where('user_id',$user_id);
		  $this->db->delete('temp_sales_items');
		  $this->db->trans_commit();
		}
	}
	
	function generate_next_invno($start_date,$end_date){
		$this->db->select('MAX(bill_number) as bill_number');
		$this->db->where('bill_date >',$start_date.' 00:00:01');
		$this->db->where('bill_date <',$end_date.' 23:59:59');
		$query = $this->db->get('sales');
		if($query->num_rows() > 0){
			return $query->row()->bill_number+1;
		}else{
			return false;	
		}	
	}
	
	function get_batches_by_item(){
		$this->db->select('grn_items.*,grn.*');
		$this->db->join('grn','grn.grn_id = grn_items.grn_id');
		$this->db->where('grn_items.item_id',$this->input->post('item_id'));
		$this->db->where('grn_items.quantity >',0);
		$this->db->where('grn.grn_status','1');
		$this->db->order_by('grn.grn_id','ASC');
		$query = $this->db->get('grn_items');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;	
		}	
	}
	
	function get_item_total_stock(){
		$this->db->select('SUM(grn_items.quantity) AS total');
		$this->db->join('grn','grn.grn_id = grn_items.grn_id');
		$this->db->where('grn_items.item_id',$this->input->post('item_id'));
		$this->db->where('grn.grn_status','1');
		$query = $this->db->get('grn_items');
		if($query->num_rows() > 0){
			return $query->row()->total;
		}else{
			return false;	
		}		
	}
	
	function get_grn_item_by_id($grn_item_id){
		$this->db->select('grn_items.*');
		$this->db->where('grn_items.grn_item_id',$grn_item_id);
		$query = $this->db->get('grn_items');
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;	
		}
	}
	
	function add_sale_item(){
		$discount = 0;
		$item_id = $this->input->post('item_id');
		$grn_item_id = $this->input->post('grn_item_id');
		$discount = $this->input->post('discount');
		$quantity = $this->input->post('quantity');
		if(!$quantity){
			$quantity = 1;
		}
		//check quantity and the price
		$grn_item = $this->get_grn_item_by_id($grn_item_id);
		$user_id = $this->session->userdata('user_id');
		
		$price = 0;
		
		if($discount > 75){
			$price = $grn_item->selling_price - $discount;
		}else{
			$price = $grn_item->selling_price / 100 * (100 - $discount);
			$discount = $grn_item->selling_price / 100 * $discount;
		}
		
		$data = array(
			'grn_item_id' => $grn_item_id,
			'item_id' => $item_id,
			'sale_item_quantity' => $quantity,
			'sale_item_discount' => $discount,
			'sale_item_price' => $price,
			'user_id' => $user_id
		);
		if($this->add_item_sale_item($data)){
			//reduce qty from Grns
			$this->db->select('quantity');
			$this->db->where('grn_item_id',$grn_item_id);
			$query = $this->db->get('grn_items');
			if($query->num_rows() > 0){
				$qty = $query->row()->quantity - $quantity;
				$data = array(
					'quantity' => $qty,
				);
				$this->db->where('grn_item_id',$grn_item_id);
				$this->db->update('grn_items',$data);
			}else{
				return false;
			}
			return true;
		}
		
	}
	
	function remove_temp_item(){
		$this->db->where('temp_sale_id',$this->input->post('temp_sale_id'));
		$this->db->delete('temp_sales_items');
		if (!$this->db->affected_rows()) {
			return false;
		} else {
			return true;
		}
	}
	
	function get_temp_sale_items($user_id=''){
		$user_id = $this->session->userdata('user_id');
		$this->db->select('temp_sales_items.*,items.item_name,items.item_description');
		$this->db->join('items','items.item_id = temp_sales_items.item_id');
		$this->db->where('temp_sales_items.user_id',$user_id);
		$this->db->order_by('temp_sales_items.temp_sale_id','DESC');
		$query = $this->db->get('temp_sales_items');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;	
		}		
	}
	
	function add_item_sale_item($array){
		$this->db->insert('temp_sales_items',$array);
		return ($this->db->affected_rows() != 1) ? false : true;	
	}
	
	function get_all_customers($limit, $start){
		$this->db->select('customers.*');
		$this->db->order_by('customers.customer_name');
		$this->db->limit($limit, $start);
		$query = $this->db->get('customers');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;	
		}
	}
	
	function get_all_customers_sale(){
		$this->db->select('customers.*');
		$this->db->order_by('customers.customer_name');
		$query = $this->db->get('customers');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;	
		}
	}
	
	function count_customers(){
		return $this->db->count_all('customers');	
	}
	
	function count_sales($search_string){
		$this->db->select('*');
		$this->db->join('customers','customers.customer_id = sales.customer_id','left');
		if($search_string != ''){
			$this->db->group_start();
			$this->db->like('sales.bill_number',$search_string);
			$this->db->or_like('customers.customer_name',$search_string);
			$this->db->or_like('sales.bill_date',$search_string);
			$this->db->or_like('sales.sale_type',$search_string);
			$this->db->group_end();	
		}
		$this->db->where('sales.user_id !=','0');
		$query = $this->db->get('sales');
		if($query->num_rows() > 0){
			return $query->num_rows();
		}else{
			return false;	
		}
	}
	
	function check_customer(){
		$this->db->select('*');
		$this->db->where('customer_name',$this->input->post('customer_name'));
		$query = $this->db->get('customers');
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;	
		}
	}
	
	function add_customer(){
		$data = array(
			'customer_name' => $this->input->post('customer_name'),
			'customer_address' => $this->input->post('customer_address'),
			'customer_mobile' => $this->input->post('customer_mobile'),
			'customer_telephone' => $this->input->post('customer_telephone'),
			'customer_fax' => $this->input->post('customer_fax'),
			'customer_email' => $this->input->post('customer_email')
		);
		$this->db->insert('customers',$data);
		return ($this->db->affected_rows() != 1) ? false : true;
	}
	
	function get_customer($customer_id){
		$this->db->select('customers.*');
		$this->db->where('customers.customer_id',$customer_id);
		$query = $this->db->get('customers');
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;	
		}
	}
	
	function sales_history($limit, $start,$search_string){
		$this->db->select('sales.*,customers.*');
		$this->db->join('customers','customers.customer_id = sales.customer_id','left');
		if($search_string != ''){
			$this->db->group_start();
			$this->db->like('sales.bill_number',$search_string);
			$this->db->or_like('customers.customer_name',$search_string);
			$this->db->or_like('sales.bill_date',$search_string);
			$this->db->or_like('sales.sale_type',$search_string);
			$this->db->group_end();	
		}
		$this->db->where('sales.user_id !=','0');
		$this->db->order_by('sales.sale_id','DESC');
		$this->db->limit($limit, $start);
		$query = $this->db->get('sales');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;	
		}	
	}
	
	function pay($sale_id){
		$data = array(
			'pay_status' => '1'
		);
		$this->db->where('sales.sale_id',$sale_id);	
		$this->db->update('sales',$data);
		if ($this->db->trans_status() === FALSE)
		{
			return false;
		}else{
			return true;
		}
	}
	
	function edit_customer(){
		$data = array(
			'customer_name' => $this->input->post('customer_name'),
			'customer_address' => $this->input->post('customer_address'),
			'customer_mobile' => $this->input->post('customer_mobile'),
			'customer_telephone' => $this->input->post('customer_telephone'),
			'customer_fax' => $this->input->post('customer_fax'),
			'customer_email' => $this->input->post('customer_email')
		);
		$this->db->where('customer_id',$this->input->post('customer_id'));
		$this->db->update('customers',$data);
		return ($this->db->affected_rows() != 1) ? false : true;
	}
	
	function delete_customer($customer_id){
		$this->db->where('customer_id',$customer_id);
		$this->db->delete('customers');
	}
	
	function check_customer_use($customer_id){
		$this->db->select('*');
		$this->db->where('customer_id',$customer_id);
		$query = $this->db->get('sales');
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;	
		}	
	}
	
	function add_sale(){
		$user_id = $this->session->userdata('user_id');
		$this->db->select('*');
		$this->db->where('user_id',$user_id);
		$query = $this->db->get('temp_sales_items');
		if($this->input->post('sale_discount') == ''){
			$sale_discount = 0;	
		}else{
			$sale_discount = $this->input->post('sale_discount');
		}
		$this->db->trans_begin();
		if($query->num_rows() > 0){
			
			$data = array(
				'bill_number' => $this->input->post('bill_number'),
				'customer_id' => $this->input->post('customer_id'),
				'bill_date' => $this->input->post('bill_date'),
				'sale_date' => date('Y-m-d H:i:s'),
				'sale_type' => $this->input->post('sale_type'),
				'sale_discount' => $sale_discount,
				'user_id' => $user_id
			);
			$this->db->insert('sales',$data);

			if (!$this->db->affected_rows()) {
				$this->db->trans_rollback();
				return false;	
			}else{
				$insert_id = $this->db->insert_id();
				//update pay status
				if($this->input->post('sale_type') == 'Cash'){
					$data = array(
						'pay_status' => 1,
					);
					$this->db->where('sale_id',$insert_id);
					$this->db->update('sales',$data);
				}
				//insert items from tem table
				
				$this->db->select('*');
				$this->db->where('user_id',$user_id);
				$query = $this->db->get('temp_sales_items');
				if($query->num_rows() > 0){
					foreach($query->result() as $data){
						$temp_sale_id = $data->temp_sale_id;
						$grn_item_id = $data->grn_item_id;
						$item_sale_qty = $data->sale_item_quantity;
						$data2 = array(
							'sale_id' => $insert_id,
							'grn_item_id' => $data->grn_item_id,
							'item_id' => $data->item_id,
							'sale_item_quantity' => $data->sale_item_quantity,
							'sale_item_discount' => $data->sale_item_discount,
							'sale_item_price' => $data->sale_item_price,
						);
						$this->db->insert('sales_items',$data2);
						if ($this->db->trans_status() === FALSE) {
						   	$this->db->trans_rollback();
						 	return false;
					   } else {
						  	$this->db->where('temp_sale_id',$temp_sale_id);
							$this->db->delete('temp_sales_items');
					   }
						
					}
					$this->db->trans_commit();
					return $insert_id;
				}else{
					return false;	
				}
			}	
		}else{
			return false;	
		}
	}
	
	function get_sale_by_id($sale_id){
		$this->db->select('sales.*,customers.*');
		$this->db->join('customers','customers.customer_id = sales.customer_id','left');
		$this->db->where('sales.sale_id',$sale_id);
		$query = $this->db->get('sales');
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;	
		}
	}
	
	function get_sale_data($sale_id){
		$this->db->select('sales_items.*,items.item_name,items.item_description,units.unit_name');
		$this->db->join('items','items.item_id = sales_items.item_id');
		$this->db->join('units','units.unit_id = items.unit_id');
		$this->db->where('sales_items.sale_id',$sale_id);
		$this->db->order_by('sales_items.sale_item_id','DESC');
		$query = $this->db->get('sales_items');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;	
		}
	}
	
	function update_total($sale_id,$total){
		$data = array(
			'total' => $total,
		);
		$this->db->where('sale_id',$sale_id);
		$this->db->update('sales',$data);	
	}
	
   
}

?>