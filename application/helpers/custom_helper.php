<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('check_unit_use'))
{
	function check_unit_use($unit_id)
	{
		$CI =& get_instance();
		$CI->load->model('configurations');
		$usage = $CI->configurations->check_unit_use($unit_id);
		return $usage;
	}
}

if ( ! function_exists('check_category_use'))
{
	function check_category_use($category_id)
	{
		$CI =& get_instance();
		$CI->load->model('configurations');
		$usage = $CI->configurations->check_category_use($category_id);
		return $usage;
	}
}

if ( ! function_exists('check_type_use'))
{
	function check_type_use($type_id)
	{
		$CI =& get_instance();
		$CI->load->model('configurations');
		$usage = $CI->configurations->check_type_use($type_id);
		return $usage;
	}
}

if ( ! function_exists('check_item_use'))
{
	function check_item_use($item_id)
	{
		$CI =& get_instance();
		$CI->load->model('configurations');
		$usage = $CI->configurations->check_item_use($item_id);
		return $usage;
	}
}

if ( ! function_exists('get_grn_items'))
{
	function get_grn_items($grn_id)
	{
		$CI =& get_instance();
		$CI->load->model('grns');
		$grn_data = $CI->grns->get_grn_items($grn_id);
		if($grn_data){
			return $grn_data;
		}
	}
}

if ( ! function_exists('get_return_items'))
{
	function get_return_items($return_id)
	{
		$CI =& get_instance();
		$CI->load->model('returning');
		$return_data = $CI->returning->get_return_items($return_id);
		if($return_data){
			return $return_data;
		}
	}
}

if ( ! function_exists('reorder_items'))
{
	function reorder_items()
	{
		$CI =& get_instance();
		$CI->load->model('grns');
		$item_data = $CI->grns->get_all_items_reorder();
		$count = 0;
		if($item_data){
			foreach($item_data as $data){
				if($data->minimum_quantity >= $data->total){
					$count++;
				}
			}
		}
		return $count;
	}
}

if ( ! function_exists('check_customer_use'))
{
	function check_customer_use($customer_id)
	{
		$CI =& get_instance();
		$CI->load->model('sales');
		$usage = $CI->sales->check_customer_use($customer_id);
		return $usage;
	}
}

if ( ! function_exists('get_return_total_by_sale_item'))
{
	function get_return_total_by_sale_item($sale_item_id)
	{
		$CI =& get_instance();
		$CI->load->model('returning');
		$total = $CI->returning->get_return_total_by_sale_item($sale_item_id);
		return $total;
	}
}

if ( ! function_exists('update_total'))
{
	function update_total($sale_id,$total)
	{
		$CI =& get_instance();
		$CI->load->model('sales');
		$CI->sales->update_total($sale_id,$total);
	}
}

if ( ! function_exists('get_merged_quantities'))
{
	function get_merged_quantities($grn_item_id)
	{
		$CI =& get_instance();
		$CI->load->model('grns');
		$reduced = $CI->grns->get_reduced_quantities($grn_item_id);
		$added = $CI->grns->get_added_quantities($grn_item_id);
		$data = '';
		if($reduced){
			$data .=  '('.$reduced.')';
		}
		if($reduced && $added){
			$data .= '<br>';
		}
		if($added){
			$data .=  $added;
		}
		return $data;
	}
}