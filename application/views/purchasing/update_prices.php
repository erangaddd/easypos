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
                    <h1 class="h3 mb-1 text-gray-800">Update Prices</h1>
                    <p></p>
                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-lg-12">

                            <!-- Roitation Utilities -->
                            <div class="card">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Search Items</h6>
                                </div>
                                <div class="card-body text-right">
                                	<form method="post" action="<?=base_url()?>purchasings/update_search" 
                                    class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100">
                                        <div class="input-group">
                                            <input type="text" required="required" name="search" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fas fa-search fa-sm"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-body text-center">
                                	<form method="post" class="user" enctype="multipart/form-data" id="price_form" action="<?=base_url()?>purchasings/update_prices">
                                    
                                	<table class="table table-bordered table-condensed">
                                        <thead class="thead-dark">
                                            <tr>
                                            	<th scope="col">Item Name & Description</th>
                                            	<th scope="col">Batch No</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Document No</th>
                                                <th scope="col">Cost</th>
                                            	<th scope="col">Selling Price</th>  
                                                <th scope="col">Original Price</th>
                                                <th scope="col">Current Quantity</th>  
                                                <th scope="col">Original Quantity</th>   
                                            </tr>
                                        </thead>
                                        <tbody>
										 <?
                                              if($grn_items){
												  foreach($grn_items as $data){
													$item_id = $data->item_id;
                                         ?>	
                                         	
                                   			<tr <? if($data->quantity < 1){?>style="background:#FCF" <? }?>>            
                                                <td><?php echo $data->item_name;?><br /><?php echo $data->item_description;?></td>
                                                <td><?php echo $data->grn_batch_no;?></td>
                                                <td><?php echo $data->grn_date;?></td>
                                                <td><?php echo $data->grn_invoice_no;?></td>
                                                <td><?php echo number_format($data->cost,2);?></td>
                                                <td><input type="number" min="0" step="0.01" name="<?=$data->grn_item_id?>" id="<?=$data->grn_item_id?>" value="<?php echo $data->selling_price;?>" /></td>
                                                <td><?php echo number_format($data->original_selling_price,2);?></td>
                                                <td><?php echo $data->quantity;?></td>
                                                <td><?php echo $data->original_quantity;?></td>
                                           </tr>
                                           
                                         <?
												
											 }
										?>
                                        	<tr>
                                            	<td class="text-right" colspan="9">
                                                    <input type="submit" title="Update Prices" tabindex="2" name="submit" id="submit" class="btn btn-success" value="Update Prices" />
                                                </td>
                                            </tr>
                                        <?
                                          }else{  echo '<tr><td colspan="2">Nothing to display!</td></tr>'; }
                                         ?> 
                                   		</tbody>
                                	</table>
                                    </form>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            
            <!-- End of Main Content -->
    <?php $this->load->view('includes/footer');?>
	<script>
	function updatePrice(ele){
		alert(ele.value);
	}
    </script>