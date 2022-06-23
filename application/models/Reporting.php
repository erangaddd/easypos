<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

class Reporting extends CI_Model{

	function get_inventory(){
		$type = $this->input->post('type');
		$this->db->select('SUM(grn_items.quantity) as total,items.*,types.type_name,categories.category_name,units.unit_name');
		$this->db->join('items','items.item_id = grn_items.item_id');
		$this->db->join('types','types.type_id = items.type_id','left');
		$this->db->join('categories','categories.category_id = types.category_id','left');
		$this->db->join('units','units.unit_id = items.unit_id','left');
		if($type == 'Available'){
			$this->db->where('grn_items.quantity >','0');
		}
		$this->db->group_by('grn_items.item_id');
		$query = $this->db->get('grn_items');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;	
		}	
	}
	
	function get_sales($start,$end){
		$type = $this->input->post('type');
		$this->db->select('sales.*,userdata.name,customers.customer_name');
		$this->db->join('userdata','userdata.userid = sales.user_id','left');
		$this->db->join('customers','customers.customer_id = sales.customer_id','left');
		if($type == 'Cash'){
			$this->db->where('sales.sale_type','Cash');
		}
		if($type == 'Credit'){
			$this->db->where('sales.sale_type','Credit');
		}
		$this->db->where('bill_date >=',$start);
		$this->db->where('bill_date <=',$end);
		$query = $this->db->get('sales');
		//echo $this->db->last_query();
		//exit;
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;	
		}	
	}
   
}

?>