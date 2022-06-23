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
            <form class="user" enctype="multipart/form-data" id="item_form" method="post" action="<?=base_url()?>purchasings/add_grn">
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-1 text-gray-800">Add GRN</h1>
                    <p></p>
                    <!-- Content Row -->
                    
                    <div class="row">
					
                        <div class="col-lg-12">
                        	

                            <!-- Overflow Hidden -->
                            <div class="card mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">GRN Details</h6>
                                </div>
                                <div class="card-body">
                                	<div class="form-row">
                                        <div class="form-group col-md-4">
                                            
                                            <input type="text" class="form-control" required="required"
                                                id="grn_invoice_no" name="grn_invoice_no" 
                                                autocomplete="off" aria-describedby="Document No"
                                                placeholder="Enter Document Number">
          								</div>
                                        <div class="form-group col-md-4">
                                        	<input type="date" class="form-control" required="required"
                                                id="grn_date" name="grn_date"
                                                autocomplete="off" aria-describedby="GRN Date"
                                                placeholder="Select Date">
                                        </div>
                                        <div class="form-group col-md-4">   
                                            <input type="text" class="form-control" required="required"
                                                id="grn_supplier" name="grn_supplier"
                                                autocomplete="off" aria-describedby="Supplier Name"
                                                placeholder="Supplier Name">
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
                                        <div class="form-group col-md-4">
                                          <select class="form-control chosen-select" name="item_id1" id="item_id1" required >
                                            	<option value=""></option>
                                                <? if($items){
														foreach($items as $data2){	
												?>
                                                			<option value="<?=$data2->item_id?>"><?=$data2->item_name?> <?=$data2->item_description?> - <?=$data2->type_name?></option>
                                                <?
														}
													}
												?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                          <input type="number" class="form-control" required="required"
                                                id="cost1" name="cost1"
                                                autocomplete="off" min="1" step="0.01" aria-describedby="Cost Rs."
                                                placeholder="Cost Rs." onblur="setMinselling(1,this.value)">
                                        </div>
                                        <div class="form-group col-md-2">
                                          <input type="number" class="form-control" required="required"
                                                id="selling_price1" min="1" step="0.01" name="selling_price1"
                                                autocomplete="off" aria-describedby="Selling Price"
                                                placeholder="Selling Price Rs.">
                                        </div>
                                        <div class="form-group col-md-2">
                                          <input type="number" class="form-control" required="required"
                                                id="quantity1" min="1" name="quantity1"
                                                autocomplete="off" aria-describedby="Quantity"
                                                placeholder="Quantity">
                                        </div>
                                        <div class="form-group col-md-2">
                                        	<a class="ml-4" href="#" onclick="addColumn();">
                                                  <i class="fas fa-plus-circle text-success pt-2"></i>
                                             </a>
                                        </div>
                                 	</div>
                                </div>
                                <div class="card-body" id="grn_items">
                                	<input type="hidden" name="count" id="count" value="1" />
                                	<input type="submit" name="submit"  class="btn btn-success" value="Submit" />	
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
        	$('.chosen-select').chosen({
				allow_single_deselect : true,
				search_contains: true,
				no_results_text: "Oops, nothing found!",
				placeholder_text_single: "Select Item"
			});
        	$('.chosen-select-deselect').chosen({ allow_single_deselect: true });
			
		
      	});
		
		function addColumn(){
			var count = parseInt($('#count').val())+1;
			$.ajax({
				cache: false,
				type: 'POST',
				url: '<?php echo base_url().'purchasings/add_item_grn';?>',
				data: {count:count},
				success: function(data) {
					if (data) {
						$('#grn_items').append(data).show('slow');
						$('#count').val(count);
						$('#item_id'+count).chosen({
							allow_single_deselect : true,
							search_contains: true,
							no_results_text: "Oops, nothing found!",
							placeholder_text_single: "Select Item"
						});
				
					}
					else
					{
						alert('Unable to add a row!');
					}
				}
			});
		}
		
		function removeColumn(ele){
			$('#'+ele).fadeOut(300, function(){ $(this).remove();});
		}
		
		function setMinselling(id,val){
			$('#selling_price'+id).attr({
				 "min" : val
		   });
		}
    </script>