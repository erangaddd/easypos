<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

class Configurations extends CI_Model{
	
	function get_all_units(){
		$this->db->select('*');
		$this->db->order_by('unit_name');
		$query = $this->db->get('units');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;	
		}
	}
	
	function add_units(){
		$data = array(
			'unit_name' => $this->input->post('unit_name')
		);
		$this->db->insert('units',$data);
		return ($this->db->affected_rows() != 1) ? false : true;
	}
	
	function check_units(){
		$this->db->select('*');
		$this->db->where('unit_name',$this->input->post('unit_name'));
		$query = $this->db->get('units');
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;	
		}
	}
	
	function get_unit_by_id($unit_id){
		$this->db->select('*');
		$this->db->where('unit_id',$unit_id);
		$query = $this->db->get('units');
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;	
		}
	}
	
	function edit_unit(){
		$data = array(
			'unit_name' => $this->input->post('unit_name')
		);
		$this->db->where('unit_id',$this->input->post('unit_id'));
		$this->db->update('units',$data);
		return ($this->db->affected_rows() != 1) ? false : true;	
	}
	
	function delete_unit($unit_id){
		$this->db->where('unit_id',$unit_id);
		$this->db->delete('units');
	}
	
	function check_unit_use($unit_id){
		$this->db->select('*');
		$this->db->where('unit_id',$unit_id);
		$query = $this->db->get('items');
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;	
		}
	}
	
	function get_all_categories(){
		$this->db->select('*');
		$this->db->order_by('category_name');
		$query = $this->db->get('categories');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;	
		}
	}
	
	function add_categories(){
		$data = array(
			'category_name' => $this->input->post('category_name')
		);
		$this->db->insert('categories',$data);
		return ($this->db->affected_rows() != 1) ? false : true;
	}
	
	function check_categories(){
		$this->db->select('*');
		$this->db->where('category_name',$this->input->post('category_name'));
		$query = $this->db->get('categories');
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;	
		}
	}
	
	function get_category_by_id($category_id){
		$this->db->select('*');
		$this->db->where('category_id',$category_id);
		$query = $this->db->get('categories');
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;	
		}
	}
	
	function edit_category(){
		$data = array(
			'category_name' => $this->input->post('category_name')
		);
		$this->db->where('category_id',$this->input->post('category_id'));
		$this->db->update('categories',$data);
		return ($this->db->affected_rows() != 1) ? false : true;	
	}
	
	function delete_category($category_id){
		$this->db->where('category_id',$category_id);
		$this->db->delete('categories');
	}
	
	function check_category_use($category_id){
		$this->db->select('*');
		$this->db->where('category_id',$category_id);
		$query = $this->db->get('types');
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;	
		}
	}
	
	function get_all_types(){
		$this->db->select('types.*,categories.category_name');
		$this->db->join('categories','categories.category_id = types.category_id');
		$this->db->order_by('types.type_name');
		$query = $this->db->get('types');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;	
		}
	}
	
	function add_types(){
		$data = array(
			'type_name' => $this->input->post('type_name'),
			'category_id' => $this->input->post('category_id')
		);
		$this->db->insert('types',$data);
		return ($this->db->affected_rows() != 1) ? false : true;
	}
	
	function check_types(){
		$this->db->select('*');
		$this->db->where('type_name',$this->input->post('type_name'));
		$this->db->where('category_id',$this->input->post('category_id'));
		$query = $this->db->get('types');
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;	
		}
	}
	
	function get_type_by_id($type_id){
		$this->db->select('*');
		$this->db->where('type_id',$type_id);
		$query = $this->db->get('types');
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;	
		}
	}
	
	function edit_type(){
		$data = array(
			'type_name' => $this->input->post('type_name'),
			'category_id' => $this->input->post('category_id')
		);
		$this->db->where('type_id',$this->input->post('type_id'));
		$this->db->update('types',$data);
		return ($this->db->affected_rows() != 1) ? false : true;	
	}
	
	function delete_type($type_id){
		$this->db->where('type_id',$type_id);
		$this->db->delete('types');
	}
	
	function check_type_use($type_id){
		$this->db->select('*');
		$this->db->where('type_id',$type_id);
		$query = $this->db->get('items');
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;	
		}
	}
	
	function get_all_items($limit, $start){
		$this->db->select('items.*,types.type_name,units.unit_name');
		$this->db->join('types','types.type_id = items.type_id');
		$this->db->join('units','units.unit_id = items.unit_id');
		$this->db->order_by('items.type_id');
		$this->db->limit($limit, $start);
		$query = $this->db->get('items');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;	
		}
	}
	
	function count_items(){
		return $this->db->count_all('items');	
	}
	
	function get_all_items_grn(){
		$this->db->select('items.*,types.type_name,units.unit_name');
		$this->db->join('types','types.type_id = items.type_id');
		$this->db->join('units','units.unit_id = items.unit_id');
		$this->db->order_by('items.type_id');
		$query = $this->db->get('items');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;	
		}
	}
	
	function add_items(){
		$data = array(
			'item_name' => $this->input->post('item_name'),
			'item_description' => $this->input->post('item_description'),
			'item_origin' => $this->input->post('item_origin'),
			'minimum_quantity' => $this->input->post('minimum_quantity'),
			'unit_id' => $this->input->post('unit_id'),
			'type_id' => $this->input->post('type_id')
		);
		$this->db->insert('items',$data);
		return ($this->db->affected_rows() != 1) ? false : true;
	}
	
	function check_items(){
		$this->db->select('*');
		$this->db->where('item_name',$this->input->post('item_name'));
		$this->db->where('item_description',$this->input->post('item_description'));
		$this->db->where('type_id',$this->input->post('type_id'));
		$this->db->where('unit_id',$this->input->post('unit_id'));
		$this->db->where('minimum_quantity',$this->input->post('minimum_quantity'));
		$query = $this->db->get('items');
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;	
		}
	}
	
	function get_item_by_id($item_id){
		$this->db->select('*');
		$this->db->where('item_id',$item_id);
		$query = $this->db->get('items');
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;	
		}
	}
	
	function edit_item(){
		$data = array(
			'item_name' => $this->input->post('item_name'),
			'item_description' => $this->input->post('item_description'),
			'item_origin' => $this->input->post('item_origin'),
			'minimum_quantity' => $this->input->post('minimum_quantity'),
			'unit_id' => $this->input->post('unit_id'),
			'type_id' => $this->input->post('type_id')
		);
		$this->db->where('item_id',$this->input->post('item_id'));
		$this->db->update('items',$data);
		return ($this->db->affected_rows() != 1) ? false : true;	
	}
	
	function delete_item($item_id){
		$this->db->where('item_id',$item_id);
		$this->db->delete('items');
	}
	
	function check_item_use($item_id){
		$this->db->select('*');
		$this->db->where('item_id',$item_id);
		$query = $this->db->get('grn_items');
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;	
		}
	}
	
	function search_items(){
		$search_string = $this->input->post('search');
		$this->db->select('items.*,types.type_name,units.unit_name');
		$this->db->join('types','types.type_id = items.type_id');
		$this->db->join('units','units.unit_id = items.unit_id');
		if($search_string != ''){
			$this->db->like('item_name',$search_string,'both');
			$this->db->or_like('item_description',$search_string,'both');
			$this->db->or_like('item_origin',$search_string,'both');
		}
		$this->db->order_by('items.type_id');
		$query = $this->db->get('items');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;	
		}
	}
   
}

?>