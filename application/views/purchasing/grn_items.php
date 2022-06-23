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
                    <h1 class="h3 mb-1 text-gray-800">GRN Items</h1>
                    <p></p>
                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-lg-12">

                            <!-- Roitation Utilities -->
                            <div class="card">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Search GRN Items</h6>
                                </div>
                                <div class="card-body text-right">
                                	<form method="post" action="<?=base_url()?>purchasings/grn_items" 
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
                                                <th scope="col">Merged Quantity</th>    
                                            </tr>
                                        </thead>
                                        <tbody>
										 <?
                                              if($grn_items){
												  foreach($grn_items as $data){
                                         ?>	
                                   			<tr <? if($data->quantity < 1){?>style="background:#FCF" <? }?>>            
                                                <td><?php echo $data->item_name;?><br /><?php echo $data->item_description;?></td>
                                                <td><?php echo $data->grn_batch_no;?></td>
                                                <td><?php echo $data->grn_date;?></td>
                                                <td><?php echo $data->grn_invoice_no;?></td>
                                                <td class="text-right"><?php echo number_format($data->cost,2);?></td>
                                                <td class="text-right"><?php echo number_format($data->selling_price,2);?></td>
                                                <td class="text-right"><?php echo number_format($data->original_selling_price,2);?></td>
                                                <td class="text-center"><?php echo $data->quantity;?></td>
                                                <td class="text-center"><?php echo $data->original_quantity;?></td>
                                                <td class="text-center"><?=get_merged_quantities($data->grn_item_id);?></td>
                                           </tr>
                                         <?
												
											 }
                                          }else{  echo '<tr><td colspan="2">Nothing to display!</td></tr>'; }
                                         ?> 
                                   		</tbody>
                                	</table>
                                    
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            
            <!-- End of Main Content -->
    <?php $this->load->view('includes/footer');?>