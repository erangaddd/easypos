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
	select:invalid {
	  height: 0px !important;
	  opacity: 0 !important;
	  position: relative !important;
	  margin-top:-12px;
	  display: flex !important;
	}
	
	select:invalid[multiple] {
	  margin-top: 15px !important;
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
            <form class="user" enctype="multipart/form-data" id="item_form" method="post" action="<?=base_url()?>sale/print_invoice">
                <div class="container-fluid">

                   
                    <!-- Content Row -->
                    
                    <div class="row">
					
                        <div class="col-lg-12">
                        	

                            <!-- Overflow Hidden -->
                            <div class="card mb-4">
                                
                                <div class="card-body">
                                	<div class="form-row">
                                        <div class="form-group col-md-2">
                                            
                                            <input type="text" class="form-control" readonly="readonly" required="required"
                                                id="bill_number" name="bill_number" value="<?=$inv_no?>" 
                                                autocomplete="off" aria-describedby="Bill Number"
                                                placeholder="Bill Number">
          								</div>
                                        <div class="form-group col-md-3">
                                            
                                            <select class="form-control chosen-select" name="customer_id" id="customer_id" >
                                            	<option value="0"></option>
                                                <? if($customers){
														foreach($customers as $data2){	
												?>
                                                			<option value="<?=$data2->customer_id?>"><?=$data2->customer_name?></option>
                                                <?
														}
													}
												?>
                                            </select>
          								</div>
                                        <div class="form-group col-md-2">
                                            
                                            <select class="form-control" name="sale_type" id="sale_type" required >
                                            	<option value="Cash">Cash</option>
                                                <option value="Credit">Credit</option>
                                            </select>
          								</div>
                                        <div class="form-group col-md-2">
                                        	<input type="date" class="form-control"
                                                id="bill_date" name="bill_date"
                                                autocomplete="off" aria-describedby="Sale Date" value="<?=date('Y-m-d')?>"
                                                placeholder="Sale Date">
                                        </div>
                                        <div class="form-group col-md-2">   
                                            <input type="number" min="0.1" step="0.01" class="form-control"
                                                id="sale_discount" name="sale_discount" onchange="changeDiscount(this.value);"
                                                autocomplete="off" aria-describedby="Sale Discount"
                                                placeholder="Sale Discount">
                                        </div>
                                        <div class="form-group col-md-1"> 
                                        	<button type="submit" name="submit" title="Print Invoice"
                                            	id="submit" disabled="disabled" class="btn btn-success">
                                            	<i class="fas fa-print"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-12">

                            <!-- Overflow Hidden -->
                            <div class="card mb-4">
                                
                                <div class="card-body" id="grn_items">
                                	<div class="form-row">
                                        <div class="form-group col-md-5">
                                          <select class="form-control" tabindex="1" name="item_id" onchange="getItembatches(this.value);" id="item_id">
                                            	<option value=""></option>
                                                <? if($items){
														foreach($items as $data2){	
												?>
                                                			<option value="<?=$data2->item_id?>"><?=$data2->item_name?> - <?=$data2->item_description?> [<?=$data2->type_name?>]</option>
                                                <?
														}
													}
												?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                          	<select class="form-control" name="grn_item_id" id="grn_item_id" onchange="javascript:goNext();setquantity();">
                                          		<option value="">Select Batch</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                          <input type="number" class="form-control"
                                                id="discount" name="discount"
                                                autocomplete="off" min="0.1" step="0.01" aria-describedby="Item Discount"
                                                placeholder="Item Discount">
                                        </div>
                                        <div class="form-group col-md-2">
                                          <input type="number" class="form-control"
                                                id="quantity" min="0.1" step="0.01" name="quantity"
                                                autocomplete="off" aria-describedby="Quantity"
                                                placeholder="Quantity" >
                                        </div>
                          
                                        
                                 	</div>
                           
                                	<table id="item_table" class="table table-bordered table-condensed">
                                        <thead class="thead-dark">
                                            <tr>
                                            	<th scope="col"></th>
                                            	<th scope="col">#</th>
                                            	<th scope="col">Item Name</th>
                                                <th scope="col">Description</th>
                                                <th scope="col" class="text-right">Unit Price</th>
                                                <th scope="col" class="text-center">Qty</th>
                                            	<th scope="col" class="text-right">Discount Rate</th>  
                                                <th scope="col" class="text-right">Total</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                   			
                                   		</tbody>
                                	</table>
                                    <input type="hidden" name="count" id="count" value="0" />
                                    <input type="hidden" name="qty" id="qty" value="0" />
                                    
                                </div>
                                <div class="card-body text-right" id="grn_items">
                                	<input type="submit" title="Print Invoice" tabindex="2" name="submit2" id="submit2" disabled="disabled" class="btn btn-success" value="Print Invoice" />	
                                </div>	
                           </div>
                          
                       </div>
					 
                    </div>

                </div>
              </form>
                <!-- /.container-fluid -->

            </div>
            
            <!-- End of Main Content -->
    <?php $this->load->view('includes/footer');?>
    <script src="http://harvesthq.github.io/chosen/chosen.jquery.js"></script>
	<script>
    	$('.datepicker').datepicker();

      	$(function() {
			$(window).keydown(function(event){
			  if(event.keyCode == 13) {
				event.preventDefault();
				return false;
			  }
			});
			
        	$('.chosen-select').chosen({
				allow_single_deselect : true,
				search_contains: true,
				no_results_text: "Oops, nothing found!",
				placeholder_text_single: "Select Customer"
			});
			
			$('#item_id').chosen({
				allow_single_deselect : true,
				search_contains: true,
				no_results_text: "Oops, nothing found!",
				placeholder_text_single: "Select Item"
			});
			
			/*$('#grn_item_id').chosen({
				allow_single_deselect : true,
				search_contains: true,
				no_results_text: "Oops, nothing found!",
				placeholder_text_single: "Select Batch"
			});*/
			
        	$('.chosen-select-deselect').chosen({ allow_single_deselect: true });
			
			$('#item_id').trigger('chosen:activate');
			
			$("#sale_discount").on("keyup", function(e){
				if (e.which == 13) {
					$('#item_id').trigger('chosen:activate');
				}
			});
			
			$("#sale_type").on("change", function(e){
				$('#sale_discount').focus();
			});
			
			
			$("#discount").on("keyup", function(e){
				if (e.which == 13) {
					$('#quantity').focus();
				}
			});
			
			$("#quantity").on("keyup", function(e){
				if (e.which == 13) {
					//get values
					var item_id = $("#item_id").val();
					var grn_item_id = $("#grn_item_id").val();
					var sale_discount = $("#sale_discount").val();
					if(sale_discount > 0){
						var discount = $("#sale_discount").val();
					}else{
						var discount = $("#discount").val();
					}
					var quantity = $("#quantity").val();
					
					var now_quantity = parseInt($("#quantity").val());
					var item_remains = $("#"+item_id).val();
					if(now_quantity > item_remains){
						alert('Only '+item_remains+' remains.');
						exit;
					}
					
					var current_qty = $("#qty").val();
					
					if(now_quantity > current_qty){
						alert('Only '+current_qty+' items remains in the batch.');
						exit;
					}
					
					var balance = item_remains - quantity;
					$("#"+item_id).val(balance);
					
					$.ajax({
						cache: false,
						type: 'POST',
						url: '<?php echo base_url().'sale/add_sale_item';?>',
						data: {item_id:item_id,grn_item_id:grn_item_id,discount:discount,quantity:quantity},
						success: function(data) {
							if (data) {
								$('#item_table tbody').empty();
								$('#item_table > tbody:last-child').append(data);
								$('#item_id').val('');
								$('#item_id').trigger("chosen:updated");
								$('#item_id').trigger('chosen:activate');
								$('#grn_item_id').empty();
								$('#quantity').val('');
								$('#discount').val('');
								$('#submit').prop('disabled', false);
								$('#submit2').prop('disabled', false);
							}
							else
							{
								alert('Error in item add!');
							}
						}
					});
				}
			});
						
      	});
		
		function uniqId() {
		  	return Math.round(new Date().getTime() + (Math.random() * 100));
		}
		
		
		function getItembatches(val){
			var item_id = val;
			$.ajax({
				cache: false,
				type: 'POST',
				url: '<?php echo base_url().'sale/get_batches_by_item';?>',
				data: {item_id:item_id},
				success: function(data) {
					if (data) {
						var item_qty = $('#'+item_id).val();
						if(!item_qty){
							$('#item_form').append('<input type="hidden" id="'+item_id+'" name="'+item_id+'" value="'+item_id+'">');
							$.ajax({
								cache: false,
								type: 'POST',
								url: '<?php echo base_url().'sale/get_item_total_stock';?>',
								data: {item_id:item_id},
								success: function(data) {
									if (data) {
										$('#'+item_id).val(data);
									}
									else
									{
										alert('Error in getting stock!');
									}
								}
							});
						}
						
						$('#grn_item_id').empty();
						$('#grn_item_id').append(data);
						setquantity();
						//$('#grn_item_id').trigger("chosen:updated");
						//$('#grn_item_id').trigger("chosen:open");
						//$('#grn_item_id').find('option:eq(0)').prop('selected', true);
						//$('#grn_item_id').trigger("chosen:updated");
						//$('#grn_item_id').trigger('chosen:activate');
						$("#sale_discount").prop("readonly", true);
						goNext();
					}
					else
					{
						$('#grn_item_id').empty();
						$('#grn_item_id').trigger("chosen:updated");
						alert('Not in stock!');
					}
				}
			});
		}
		
		function changeDiscount(val){
			if(val > 0 || val == ''){
				$("#discount").prop("readonly", true);
				$("#discount").val('');
			}else{
				$("#discount").prop("readonly", false);
			}
			$('#item_id').trigger('chosen:activate');
		}
		
		function goNext(){
			var discount = $('#sale_discount').val();
			if(discount > 0 ){
				$( "#quantity" ).focus();
			}else{
				$( "#discount" ).focus();
			}
		}
		
		function setquantity(){
			var grm_item = $('#grn_item_id option:selected').text();
			var n = grm_item.split(" ");
    		var qty = n[n.length - 1];
			$("#qty").val(qty);
		}
		
		function removeTempitem(val){
			var r=confirm("Do you want to remove this?")
			if (r==true){
				$.ajax({
					cache: false,
					type: 'POST',
					url: '<?php echo base_url().'sale/remove_temp_item';?>',
					data: {temp_sale_id:val},
					success: function(data) {
						if (data) {
							$('#item_table tbody').empty();
							$('#item_table > tbody:last-child').append(data);
							$('#item_id').val('');
							$('#item_id').trigger("chosen:updated");
							$('#item_id').trigger('chosen:activate');
							$('#grn_item_id').empty();
							$('#quantity').val('');
							$('#discount').val('');
						}
						else
						{
							alert('Error removing item!');
						}
					}
				});
			} else {
				return false;
			}
		}
			
    </script>