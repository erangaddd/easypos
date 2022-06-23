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
                    <h1 class="h3 mb-1 text-gray-800">New GRN</h1>
                    <p></p>
                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-lg-12">

                            <!-- Roitation Utilities -->
                            <div class="card">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">GRN List</h6>
                                </div>
                                <div class="card-body text-right">
                                	
                                	<form method="post" action="<?=base_url()?>purchasings/grns_search/0" 
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
                                    <a href="<?=base_url()?>purchasings/add_grn" class="btn btn-success btn-user">Add New</a>
                                </div>
                                <div class="card-body text-center">
                                	<table class="table table-bordered table-condensed">
                                        <thead class="thead-dark">
                                            <tr>
                                            	<th scope="col">Batch No</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Document No</th>
                                                <th scope="col">Supplier</th>
                                            	<th scope="col">Actions</th>       
                                            </tr>
                                        </thead>
                                        <tbody>
										 <?
                                              if($grn){
												  foreach($grn as $data){
                                         ?>	
                                   			<tr>            
                                                <td><?php echo $data->grn_batch_no;?></td>
                                                <td><?php echo $data->grn_date;?></td>
                                                <td><?php echo $data->grn_invoice_no;?></td>
                                                <td><?php echo $data->grn_supplier;?></td>
                                                <td>
                                                		<?
															$grn_items = get_grn_items($data->grn_id);
															if($grn_items)
															{
													   ?>
                                                	
                                                        	<a data-toggle="collapse" href="#grn<?=$data->grn_id?>" role="button" aria-expanded="false" aria-controls="collapseExample">
    															<i class="fas fa-chevron-down"></i>
  															</a>
                                                            &nbsp;&nbsp;
                                                            <a href="<?=base_url()?>purchasings/edit_grn/<?=$this->encryption->encode($data->grn_id)?>" role="button">
    															<i class="fas fa-pen text-warning"></i>
  															</a>
                                                            &nbsp;&nbsp;
                                                            <a href="<?=base_url()?>purchasings/delete_grn/<?=$this->encryption->encode($data->grn_id)?>" role="button" onclick="return confirm('Are you sure you want to delete this?')">
                                                                <i class="far fa-trash-alt text-danger"></i>
  															</a>
                                                            &nbsp;&nbsp;
                                                            <a href="<?=base_url()?>purchasings/confirm_grn/<?=$this->encryption->encode($data->grn_id)?>" role="button" onclick="return confirm('Are you sure you want to confirm this?')">
    															<i class="far fa-check-circle text-success"></i>
  															</a>
                                                            
  														<? }?>
                                                           
                                                </td>
                                           </tr>
                                           <?
                                           		$grn_items = get_grn_items($data->grn_id);
												if($grn_items)
												{
										   ?>
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
                                                     
                                                    tr:nth-child(odd) {
                                                        background-color: #ffffff;
                                                    }
                                                </style>
                                           <tr>
                                              <td colspan="5" class="hiddenRow">
                                              	<div class="accordian-body collapse" id="grn<?=$data->grn_id?>"> 
                                                  	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    	<thead class="thead-light">
                                                            <tr>
                                                                <th scope="col">Item Name & Description</th>
                                                                <th scope="col">Cost</th>
                                                                <th scope="col">Current Price</th>
                                                                <th scope="col">Original Price</th> 
                                                                <th scope="col">Current Qty</th>
                                                                <th scope="col">Original Qty</th>      
                                                            </tr>
                                                        </thead>
                                                    	<tbody>
                                                  		<? 	foreach ($grn_items as $data){?>
                                                         
                                                            <tr>
                                                              <td><?=$data->item_name?><br /><?=$data->item_description?></td>
                                                              <td class="text-right"><?=number_format($data->cost,2)?></td>
                                                              <td class="text-right"><?=number_format($data->selling_price,2)?></td>
                                                              <td class="text-right"><?=number_format($data->original_selling_price,2)?></td>
                                                              <td><?=$data->quantity?></td>
                                                              <td><?=$data->original_quantity?></td>
                                                            </tr>
                                                            
                                                    	<? }?>
                                                        </tbody>
                                                  	</table>
                                          		</div>
                                              </td>
                                           </tr>
										 <?
												}
											 }
                                          }else{  echo '<tr><td colspan="2">Nothing to display!</td></tr>'; }
                                         ?> 
                                   		</tbody>
                                	</table>
                                    
                                    <p><?php echo $links; ?></p>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            
            <!-- End of Main Content -->
    <?php $this->load->view('includes/footer');?>