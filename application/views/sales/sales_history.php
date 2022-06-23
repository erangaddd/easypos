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
                    <h1 class="h3 mb-1 text-gray-800">Sales History</h1>
                    <p></p>
                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-lg-12">

                            <!-- Roitation Utilities -->
                            <div class="card">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Invoice List</h6>
                                </div>
                                <div class="card-body text-right">
                                	<form method="post" action="<?=base_url()?>sale/sales_history" 
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
                                            	<th scope="col">Invoie No</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Customer Name</th>
                                                <th scope="col">Sale Type</th>
                                            	<th scope="col">Pay Status</th> 
                                                <th scope="col">Actions</th>       
                                            </tr>
                                        </thead>
                                        <tbody>
										 <?
                                              if($sales){
												  foreach($sales as $data){
                                         ?>	
                                   			<tr <? if($data->pay_status == '0'){?> style="background:#FCC;" <? }?>>            
                                                <td><?php echo $data->bill_number;?></td>
                                                <td><?php echo $data->bill_date;?></td>
                                                <td><?php echo $data->customer_name;?></td>
                                                <td><?php echo $data->sale_type;?></td>
                                                <td><?php 
													if($data->pay_status == '1'){
														echo 'Paid';
													}else{
														echo 'Unpaid';
													}
													?>
                                                </td>
                                                <td>
                                                		<a href="<?=base_url()?>sale/reprint_invoice/<?=$data->sale_id?>" role="button" title="Print" aria-expanded="false" aria-controls="collapseExample">
    <i class="fas fa-print"></i>
  </a>&nbsp;&nbsp;
  <a href="<?=base_url()?>returns/return_sales/<?=$data->sale_id?>" role="button" title="Sales Return" aria-expanded="false" aria-controls="collapseExample">
    <i class="fas fa-undo-alt text-danger"></i>
  </a>&nbsp;&nbsp;
                                                		<?
															if($data->pay_status == 0)
															{
													   ?>
                                                	
                                                        	<a href="<?=base_url()?>sale/pay/<?=$data->sale_id?>" role="button" title="Mark as Paid" aria-expanded="false" aria-controls="collapseExample" onclick="return confirm('Are you sure you want to mark this as paid?')">
    <i class="far fa-money-bill-alt text-success"></i>
  </a>
  														<? }?>
                                                           
                                                </td>
                                           </tr>
                                           
										 <?
											 }
											
                                          }else{  echo '<tr><td colspan="2">Nothing to display!</td></tr>'; }
                                         ?> 
                                         <?
										  if($this->session->userdata('search_string')){
										?>
                                        	<tr>
                                            	<td class="text-right" colspan="6">
                                                	<a href="<?=base_url()?>sale/clear_search" class="btn btn-success">Reset Filter</a>
                                            </tr>
                                        <?
											 }
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