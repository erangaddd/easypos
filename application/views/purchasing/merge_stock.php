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
            <form class="user" enctype="multipart/form-data" id="item_form" method="post" action="<?=base_url()?>purchasings/merge_stock" onSubmit="if(!confirm('Are you sure you want to transfer this?')){return false;}">
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-1 text-gray-800">Merge Stock</h1>
                    <p></p>
                    <!-- Content Row -->
                    
                    <div class="row">
					
                        <div class="col-lg-12">

                            <!-- Overflow Hidden -->
                            <div class="card mb-4">
                                
                                <div class="card-body" id="grn_items">
                                	<div class="form-row">
                                        <div class="form-group col-md-4">
                                          <select class="form-control chosen-select" onchange="getGrnitems(this.value)" name="item_id" id="item_id" required >
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
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                          <select class="form-control" name="from_grn_item_id" onchange="removeTo(this.value,this)" id="from_grn_item_id" required >
                                            	<option value="">Select From</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                          <select class="form-control" name="to_grn_item_id" id="to_grn_item_id" onchange="clearQty();" required >
                                            	<option value="">Select To</option>
                                            </select>
                                        </div>
                                 	</div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                          <input type="number" min="0.1" step="0.01" class="form-control"
                                                id="quantity" name="quantity" required="required"
                                                autocomplete="off" aria-describedby="Transfer Quantity"
                                                placeholder="Transfer Quantity">
                                        </div>
                                 	</div>
                                </div>
                                <div class="card-body" id="grn_items">
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

      	$(function() {
        	$('.chosen-select').chosen({
				allow_single_deselect : true,
				search_contains: true,
				no_results_text: "Oops, nothing found!",
				placeholder_text_single: "Select Item"
			});
        	$('.chosen-select-deselect').chosen({ allow_single_deselect: true });
			
		
      	});
		
		function getGrnitems(value){
			var item_id = value;
			$.ajax({
				cache: false,
				type: 'POST',
				url: '<?php echo base_url().'sale/get_batches_by_item';?>',
				data: {item_id:item_id},
				success: function(data) {
					if (data) {
						$('#from_grn_item_id')
							.find('option')
							.remove()
							.end()
							.append('<option value="">Select From</option>')
							.val('')
						;
						$('#to_grn_item_id')
							.find('option')
							.remove()
							.end()
							.append('<option value="">Select To</option>')
							.val('')
						;
						$("#from_grn_item_id").append(data);
						$("#to_grn_item_id").append(data);
						$("#to_grn_item_id option").prop('disabled', true);
					}else
					{
						alert('Something went wrong!');
					}
				}
			});
		}
		
		function removeTo(value,ele){
			$('#to_grn_item_id')
				.find('option')
				.remove()
				.end()
			;
			$('#to_grn_item_id').append('<option value="">Select To</option>');
			$("#from_grn_item_id option").each(function()
			{
				if($(this).val() != ''){
					$('#to_grn_item_id')
						.append('<option value="'+$(this).val()+'">'+$(this).text()+'</option>')
						.val($(this).text())
					;
				}
			});
			$("#to_grn_item_id option[value='"+value+"']").remove();
			$("#to_grn_item_id option").prop('disabled', false);
			
			var selected_text = $( "#from_grn_item_id option:selected" ).text();
			var n = selected_text.split(" ");
    		var qty = n[n.length - 1];
			$("#quantity").prop('max',qty);
		}
		
		function clearQty(){
			$("#quantity").val('');
		}
		
    </script>