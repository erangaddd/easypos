<!-- CSS style to set alternate table
            row using color -->
<style>
	table {
		border-collapse: collapse;
		width: 100%;
	}
	 
	th, td {
		text-align: left;
		padding: 8px;
	}
	 
	tr:nth-child(even) {
		background-color: #F4F4F4;
	}
</style>
<!-- Page Wrapper -->
<div id="wrapper">

   <?php $this->load->view('includes/sidebar');?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            <?php $this->load->view('includes/topbar');?>

            <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-1 text-gray-800">Sales Return</h1>
                    <p></p>
                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-lg-12">
							<form class="user" enctype="multipart/form-data" id="item_form" method="post" action="<?=base_url()?>returns/return_sales/<?=$sale->sale_id?>">
                            <!-- Roitation Utilities -->
                            <div class="card">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Item List</h6>
                                </div>
                                <div class="card-body text-left">
                                	<div class="form-row">
                                        <div class="form-group col-md-2">
                                            <label>Invoice Number</label>
                                            <input type="text" class="form-control" disabled="disabled"
                                                id="bill_number" name="bill_number" value="<?=$sale->bill_number?>" 
                                                autocomplete="off" aria-describedby="Bill Number"
                                                placeholder="Bill Number">
          								</div>
                                        <div class="form-group col-md-3">
                                            <label>Customer</label>
                                            <select class="form-control chosen-select" disabled="disabled" name="customer_id" id="customer_id" >
                                            	<option value="">Select Customer</option>
                                                <? if($customers){
														foreach($customers as $data2){	
												?>
                                                			<option <? if($data2->customer_id == $sale->customer_id){?> selected="selected" <? }?> value="<?=$data2->customer_id?>"><?=$data2->customer_name?></option>
                                                <?
														}
													}
												?>
                                            </select>
          								</div>
                                        <div class="form-group col-md-2">
                                            <label>Sale Type</label>
                                            <select class="form-control" name="sale_type" disabled="disabled" id="sale_type" >
                                            	<option <? if($sale->sale_type == 'Cash'){?> selected="selected" <? }?> value="Cash">Cash</option>
                                                <option <? if($sale->sale_type == 'Credit'){?> selected="selected" <? }?> value="Credit">Credit</option>
                                            </select>
          								</div>
                                        <div class="form-group col-md-2">
                                        	<label>Sale Date</label> 
                                        	<input type="date" class="form-control"
                                                id="bill_date" name="bill_date" disabled="disabled"
                                                autocomplete="off" aria-describedby="Sale Date" value="<?=$sale->bill_date?>"
                                                placeholder="Sale Date">
                                        </div>
                                        <div class="form-group col-md-1"> 
                                        	<label>Discount</label>  
                                            <input type="text" min="0.1" step="0.01" class="form-control" value="<?=number_format($sale->sale_discount,2)?>"
                                                id="sale_discount" name="sale_discount" onchange="changeDiscount(this.value);"
                                                autocomplete="off" aria-describedby="Sale Discount" disabled="disabled"
                                                placeholder="Sale Discount">
                                        </div>
          								<div class="form-group col-md-2">
                                        	<label>Return Date</label> 
                                        	<input type="date" class="form-control"
                                                id="return_date" name="return_date"
                                                autocomplete="off" aria-describedby="Return Date" value="<?=date('Y-m-d')?>"
                                                placeholder="Return Date">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body text-center">
                                    <input type="hidden" name="sale_id" id="sale_id" value="<?=$sale->sale_id?>" />
                                	<table class="table table-bordered table-condensed">
                                        <thead class="thead-dark">
                                            <tr>
                                            	<th scope="col">Add to Stock</th>
                                            	<th scope="col">Item Name</th>
                                                <th scope="col">Item Description</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Quantity Sold</th>
                                            	<th scope="col">Quantity Returned</th>
                                                <th scope="col">New Return</th>   
                                                <th scope="col">Return Reason</th>
                                                    
                                            </tr>
                                        </thead>
                                        <tbody>
										 <?
                                              if($sale_data){
												  foreach($sale_data as $data){
													  $returned_qty = get_return_total_by_sale_item($data->sale_item_id);
													  $max_allowed = $data->sale_item_quantity - $returned_qty;
                                         ?>	
                                   			<tr>    
                                            	<td>
                                                    <fieldset id="group1">
                                                      	<input type="radio" value="yes" id ="add_stock_<?=$data->sale_item_id?>" name="add_stock_<?=$data->sale_item_id?>"> Yes
                                                      	<input type="radio" value="no" name="add_stock_<?=$data->sale_item_id?>"> No
                                                    </fieldset>
                                                   <!-- <input type="checkbox" name=">" id="add_stock_<?=$data->sale_item_id?>" checked="checked" />-->
                                                    <input type="hidden" name="grn_item_id_<?=$data->sale_item_id?>" id="grn_item_id_<?=$data->sale_item_id?>" value="<?=$data->grn_item_id?>"/>
                                                </td>        
                                                <td><?php echo $data->item_name;?></td>
                                                <td><?php echo $data->item_description;?></td>
                                                <td><?php echo number_format($data->sale_item_price,2);?></td>
                                                <td><?php echo $data->sale_item_quantity;?></td>
                                                <td><?php if($returned_qty) { echo $returned_qty; }else { echo 'N/A';}?></td>
                                                <td>
                                                	<input type="hidden" name="sale_item_id_<?=$data->sale_item_id?>" id="sale_item_id_<?=$data->sale_item_id?>" value="<?=$data->sale_item_id?>" />
                                                	
                                                    <input type="number" step="0.01" <? if($max_allowed == 0){?> disabled="disabled" <? }?> onkeyup="activateSubmit(this.value);checkAddstock(this.name,this.value);" min="0.01" class="form-control" max="<?=$max_allowed?>" name="return_quantity_<?=$data->sale_item_id?>" id="return_quantity_<?=$data->sale_item_id?>" />
                                                </td>
                                                <td><textarea name="return_reason_<?=$data->sale_item_id?>" <? if($max_allowed == 0){?> disabled="disabled" <? }?> class="form-control"></textarea></td>
                                                
                                           </tr>
                                           
										 <?
											 }
											
                                          }else{  echo '<tr><td colspan="2">Nothing to display!</td></tr>'; }
                                         ?> 
                                         	<tr>
                                         		<td colspan="8" class="text-right"><input type="submit" name="submit" id="submit" disabled="disabled" class="btn btn-success" value="Submit" /></td>
                                        	</tr>
                                   		</tbody>
                                	</table>
                                    
                                </div>
                            </div>
							</form>
                        </div>

                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            
            <!-- End of Main Content -->
    <?php $this->load->view('includes/footer');?>
	<script>
		function activateSubmit(){
			var isFilled = $('input[type="number"]', 'form').filter(function() {
				return $.trim(this.value).length; 
			}).length;
			if(isFilled){
				$("#submit").removeAttr('disabled');	
			}else{
				$("#submit").prop("disabled", true);	
			}
		}
		
		function checkAddstock(name,value){
			var n = name.split("_");
			var id = n[n.length - 1];
			if(parseInt(value) > 0){
				$("#add_stock_"+id).prop('required',true);
			}else{
				$("#add_stock_"+id).prop('required',false);
			}
		}
	</script>