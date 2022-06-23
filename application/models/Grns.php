<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

class Grns extends CI_Model{
	
	function get_all_grn($status,$limit, $start){
		$this->db->select('*');
		$this->db->where('grn_status',$status);
		$this->db->order_by('grn_id','DESC');
		$this->db->limit($limit, $start);
		$query = $this->db->get('grn');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;	
		}
	}
	
	function count_grns($status){
		$this->db->where('grn_status',$status);
		return $this->db->count_all('grn');	
	}
	
	function get_grn_items($grn_id){
		$this->db->select('grn_items.*,items.item_name,items.item_description');
		$this->db->join('items','items.item_id = grn_items.item_id');
		$this->db->where('grn_id',$grn_id);
		$query = $this->db->get('grn_items');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;	
		}
	}
	
	function grns_search($status){
		$this->db->select('*');
		$this->db->where('grn_status',$status);
		$this->db->group_start();
		$this->db->like('grn_invoice_no',$this->input->post('search'));
		$this->db->or_like('grn_supplier',$this->input->post('search'));
		$this->db->or_like('grn_batch_no',$this->input->post('search'));
		$this->db->group_end();
		$this->db->order_by('grn_id','DESC');
		$query = $this->db->get('grn');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;	
		}	
	}
	
	function get_all_items_reorder(){
		$this->db->select('items.*,types.type_name,units.unit_name,SUM(grn_items.quantity) AS total');
		$this->db->join('grn_items','grn_items.item_id = items.item_id');
		$this->db->join('types','types.type_id = items.type_id');
		$this->db->join('units','units.unit_id = items.unit_id');
		$this->db->join('grn','grn.grn_id = grn_items.grn_id');
		$this->db->where('grn.grn_status','1');
		$this->db->group_by('items.item_id');
		$this->db->order_by('items.type_id');
		$query = $this->db->get('items');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;	
		}
	}
	
	function update_prices(){
		foreach ($_POST as $key => $value) {
			$data = array(
				'selling_price' => htmlspecialchars($value),
			);
			$this->db->where('grn_item_id',htmlspecialchars($key));
			$this->db->update('grn_items',$data);
		}	
	}
	
	function get_grn_search_items(){
		$search_string = $this->input->post('search');	
		$this->db->select('grn_items.*,items.item_name,items.item_description,grn.*');
		$this->db->join('items','items.item_id = grn_items.item_id');
		$this->db->join('grn','grn.grn_id = grn_items.grn_id');
		$this->db->where('grn.grn_status','1');
		$this->db->where('grn_items.quantity >','0');
		$this->db->group_start();
		$this->db->like('items.item_name',$search_string);
		$this->db->or_like('items.item_description',$search_string);
		$this->db->group_end();
		$this->db->order_by('grn.grn_id','DESC');
		$query = $this->db->get('grn_items');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;	
		}
	}
	
	function get_grnitems_by_item_id($item_id){
		$this->db->select('grn_items.*,items.item_name,items.item_description');
		$this->db->join('items','items.item_id = grn_items.item_id');
		$this->db->join('grn','grn.grn_id = grn_items.grn_id');
		$this->db->where('grn_items.item_id',$item_id);
		$this->db->where('grn.grn_status','1');
		$query = $this->db->get('grn_items');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;	
		}
	}
	
	function confirm_grn($grn_id){
		
		//get grn_items
		$grn_items = $this->get_grn_items($grn_id);
		
		//we check each item's selling price with previous stocks. If the previous price is lower than new price, We update that to current price.
		foreach($grn_items as $row){
			$item_id = $row->item_id;
			//get all grn_items using item_id
			$grn_all_items = $this->get_grnitems_by_item_id($item_id);
			foreach($grn_all_items as $data){
				if($data->selling_price < $row->selling_price){
					//update price
					$data2 = array(
						'selling_price' => $row->selling_price
					);
					$this->db->where('grn_items.grn_item_id',$data->grn_item_id);	
					$this->db->update('grn_items',$data2);	
				}
			}
		}
		
		$data = array(
			'grn_status' => '1'
		);
		$this->db->where('grn.grn_id',$grn_id);	
		$this->db->update('grn',$data);
		if ($this->db->trans_status() === FALSE)
		{
			return false;
		}
		return true;
	}
	
	function add_grn(){
		
		$count = $this->input->post('count');
		$grn_invoice_no = $this->input->post('grn_invoice_no');
		$grn_date = $this->input->post('grn_date');
		$grn_supplier = $this->input->post('grn_supplier');
		$grn_batch_no = $this->create_batch_no($grn_date);
		
		$this->db->trans_begin();
		//insert GRN
		$data = array(
			'grn_date' => $grn_date,
			'grn_invoice_no' => $grn_invoice_no,
			'grn_supplier' => $grn_supplier,
			'grn_batch_no' => $grn_batch_no,
		);
		$this->db->insert('grn',$data);
		$insert_id = $this->db->insert_id();
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}else{
			//add grn items
			for($x = $count; $x > 0; $x--){
				$item_id = $this->input->post('item_id'.$count);
				$cost = $this->input->post('cost'.$count);
				$selling_price = $this->input->post('selling_price'.$count);
				$quantity = $this->input->post('quantity'.$count);
				
				if($item_id){
					$data = array(
						'grn_id' => $insert_id,
						'item_id' => $item_id,
						'cost' => $cost,
						'selling_price' => $selling_price,
						'original_selling_price' => $selling_price,
						'quantity' => $quantity,
						'original_quantity' => $quantity,
					);
					$this->db->insert('grn_items',$data);
				}
				$count--;
			}
			$this->db->trans_commit();
			return true;
		}
		
	}
	
	function create_batch_no($grn_date,$length = 3){
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		
		$prefix = 'GRN'.date('Y', strtotime($grn_date)).date('m', strtotime($grn_date)).date('d', strtotime($grn_date));
		return $prefix.strtoupper($randomString);
	}
	
	function delete_grn($grn_id){
		
		$this->db->where('grn_id',$grn_id);
		$this->db->delete('grn');
		
		$this->db->where('grn_id',$grn_id);
		$this->db->delete('grn_items');
		
		return true;
	}
	
	function get_grn($grn_id){
		$this->db->select('grn.*');
		$this->db->where('grn.grn_id',$grn_id);
		$query = $this->db->get('grn');
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;	
		}
	}
	
	function edit_grn($grn_id){
		
		$count = $this->input->post('count');
		$grn_invoice_no = $this->input->post('grn_invoice_no');
		$grn_date = $this->input->post('grn_date');
		$grn_supplier = $this->input->post('grn_supplier');
		
		$this->db->trans_begin();
		//insert GRN
		$data = array(
			'grn_date' => $grn_date,
			'grn_invoice_no' => $grn_invoice_no,
			'grn_supplier' => $grn_supplier,
		);
		$this->db->where('grn_id',$grn_id);
		$this->db->update('grn',$data);
		
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}else{

			//remove old items
			$this->db->where('grn_id',$grn_id);
			$this->db->delete('grn_items');
			
			//add grn items
			for($x = $count; $x > 0; $x--){
				$item_id = $this->input->post('item_id'.$count);
				$cost = $this->input->post('cost'.$count);
				$selling_price = $this->input->post('selling_price'.$count);
				$quantity = $this->input->post('quantity'.$count);
				
				if($item_id){
					$data = array(
						'grn_id' => $grn_id,
						'item_id' => $item_id,
						'cost' => $cost,
						'selling_price' => $selling_price,
						'original_selling_price' => $selling_price,
						'quantity' => $quantity,
						'original_quantity' => $quantity,
					);
					$this->db->insert('grn_items',$data);
				}
				$count--;
			}
			$this->db->trans_commit();
			return true;
		}
			
	}
	
	function get_grn_item_id($grn_item_id){
		$this->db->select('grn_items.*');
		$this->db->where('grn_items.grn_item_id',$grn_item_id);
		$query = $this->db->get('grn_items');
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;	
		}
	}
	
	function transfer_qty(){
		$from_grn_item_id = $this->input->post('from_grn_item_id');
		$to_grn_item_id = $this->input->post('to_grn_item_id');
		$quantity = $this->input->post('quantity');

		$this->db->trans_begin();
		//reduce from $from_grn_item_id 
		$from_grn = $this->get_grn_item_id($from_grn_item_id);
		$new_qty_from = $from_grn->quantity - $quantity;
		$data = array(
			'quantity' => $new_qty_from,
		);
		$this->db->where('grn_item_id',$from_grn_item_id);
		$this->db->update('grn_items',$data);
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}else{
			//add to $to_grn_item_id
			$to_grn = $this->get_grn_item_id($to_grn_item_id);
			$new_qty_to = $to_grn->quantity + $quantity;
			$data = array(
				'quantity' => $new_qty_to,
			);
			$this->db->where('grn_item_id',$to_grn_item_id);
			$this->db->update('grn_items',$data);
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				return false;
			}else{
				$data = array(
					'from_item_id' => $from_grn_item_id,
					'to_item_id' => $to_grn_item_id,
					'quantity' => $quantity,
				);
				$this->db->insert('grn_items_merge',$data);
				$this->db->trans_commit();
				return true;
			}
		}
	}
	
	function get_reduced_quantities($grn_item_id){
		$this->db->select_sum('quantity');
		$this->db->where('from_item_id',$grn_item_id);
		$query = $this->db->get('grn_items_merge');
		if($query->num_rows() > 0){
			return $query->row()->quantity;
		}else{
			return false;	
		}
	}
	
	function get_added_quantities($grn_item_id){
		$this->db->select_sum('quantity');
		$this->db->where('to_item_id',$grn_item_id);
		$query = $this->db->get('grn_items_merge');
		if($query->num_rows() > 0){
			return $query->row()->quantity;
		}else{
			return false;	
		}
	}
}

?>