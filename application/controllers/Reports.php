<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

    function __construct(){
        parent:: __construct();
		$this->is_logged_in();
		$this->load->model('reporting');
		$this->load->model('returning');
    }
	
	function sales_report(){
		if($_POST){
			$start = $this->input->post('from');
			$end = $this->input->post('to');
			
			$start_ts = strtotime($start);
			$end_ts = strtotime($end);
			
			if($end_ts < $start_ts){
				$this->session->set_flashdata('error', 'To date cannot be lower than From date.');
				redirect('reports/sales_report');
			}
			
			$diff = $end_ts - $start_ts;
			$total_days = round($diff / 86400);
			
			if($total_days > 365){
				$this->session->set_flashdata('error', 'Maximum 365 days allowed.');
				redirect('reports/sales_report');
			}
			if($sales = $this->reporting->get_sales($start,$end)){
				$this->load->library('Excel');
					
				$headers = array('Sale ID' => 'integer', 'Bill Number' => 'string', 'Date' => 'string','Customer' => 'string', 'Sale Type' => 'string', 'Pay Status' => 'string',  'Cashier' => 'string','Total' => 'price');
				
				$writer = new Excel();
				
				$keywords = array('xlsx','MySQL','Codeigniter');
				$writer->setTitle('Sales Report');
				$writer->setSubject('Report generated using Codeigniter and XLSXWriter');
				$writer->setAuthor('Simple POS');
				$writer->setCompany('Deus International');
				$writer->setKeywords($keywords);
				$writer->setDescription('Sales information of products');
				$writer->setTempDir(sys_get_temp_dir());
				
				$writer->writeSheetHeader('Sheet1', $headers);
				$total_sales = 0;
				$total_returns = 0;
				foreach ($sales as $row){
					$pay_status = '';
					if($row->pay_status == '1'){
						$pay_status = 'Paid';	
					}else{
						$pay_status = 'Un-Paid';	
					}
					
					$total_sales = $total_sales + $row->total;
					
					$writer->writeSheetRow('Sheet1',array($row->sale_id, $row->bill_number, $row->bill_date, $row->customer_name, $row->sale_type, $pay_status, $row->name, $row->total));
					
					//get returns
					if($returns = $this->returning->get_returns_by_sale_id($row->sale_id)){
						$return_total = 0;
						$return_amount = 0;
						foreach($returns as $data){
							$return_amount = $data->return_quantity * $data->sale_item_price;
							$return_total = $return_total + $return_amount;
						}
						$writer->writeSheetRow('Sheet1',array("","Sales Return ".$row->bill_number , "", "", "","" , "", -$return_total));
						$total_returns = $total_returns + $return_total;
					}
					
				}
				
				$writer->writeSheetRow('Sheet1',array("","Total" , "", "", "","" , "", $total_sales - $total_returns));
				
				$fileLocation = 'sales_report_'.$start.'_'.$end.'.xlsx';
				
				$writer->writeToFile($fileLocation);
				header('Content-Description: File Transfer');
				header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
				header("Content-Disposition: attachment; filename=".basename($fileLocation));
				header("Content-Transfer-Encoding: binary");
				header("Expires: 0");
				header("Pragma: public");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header('Content-Length: ' . filesize($fileLocation)); //Remove
			
				ob_clean();
				flush();
			
				readfile($fileLocation);
				unlink($fileLocation);
				exit(0);
				
			}else{
				$this->session->set_flashdata('error', 'Something went wrong.');
			}
			redirect('reports/sales_report');
		}
		$data['page'] = 'sales_report';
		$this->load->view('reports/sales_report',$data);
	}
	
	function inventory_report(){
	
		if($_POST){
			if($items = $this->reporting->get_inventory()){
				$this->load->library('Excel');
					
				$headers = array('Item ID' => 'integer', 'Item Name' => 'string', 'Item Description' => 'string','Item Category' => 'string', 'Item Type' => 'string', 'Unit' => 'string',  'Origin' => 'string', 'Available Qty' => 'price');
				
				$writer = new Excel();
				
				$keywords = array('xlsx','MySQL','Codeigniter');
				$writer->setTitle('Stock Report');
				$writer->setSubject('Report generated using Codeigniter and XLSXWriter');
				$writer->setAuthor('Simple POS');
				$writer->setCompany('Deus International');
				$writer->setKeywords($keywords);
				$writer->setDescription('Stock information of products');
				$writer->setTempDir(sys_get_temp_dir());
				
				$writer->writeSheetHeader('Sheet1', $headers);
				
				foreach ($items as $row){
					$writer->writeSheetRow('Sheet1',array($row->item_id, $row->item_name, $row->item_description, $row->category_name, $row->type_name, $row->unit_name, $row->item_origin, $row->total));
				}
				
				$fileLocation = 'stock_report_'.date('Y-m-d').'.xlsx';
				
				$writer->writeToFile($fileLocation);
				header('Content-Description: File Transfer');
				header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
				header("Content-Disposition: attachment; filename=".basename($fileLocation));
				header("Content-Transfer-Encoding: binary");
				header("Expires: 0");
				header("Pragma: public");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header('Content-Length: ' . filesize($fileLocation)); //Remove
			
				ob_clean();
				flush();
			
				readfile($fileLocation);
				unlink($fileLocation);
				exit(0);
				
			}else{
				$this->session->set_flashdata('error', 'Something went wrong.');
			}
			redirect('reports/inventory_report');
		}
		$data['page'] = 'inventory_report';
		$this->load->view('reports/inventory_report',$data);
	}
	
}