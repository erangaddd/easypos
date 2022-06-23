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
                    <h1 class="h3 mb-1 text-gray-800">Returns History</h1>
                    <p></p>
                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-lg-12">

                            <!-- Roitation Utilities -->
                            <div class="card">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Returns List</h6>
                                </div>
                                <div class="card-body text-right">
                                	<form method="post" action="<?=base_url()?>returns/return_list" 
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
                                            	<th scope="col">Bill No</th>
                                                <th scope="col">Sale Date</th>
                                                <th scope="col">Return Date</th>
                                                <th scope="col">Customer Name</th>
                                            	<th scope="col">Actions</th>       
                                            </tr>
                                        </thead>
                                        <tbody>
										 <?
                                              if($returns){
												  foreach($returns as $data){
                                         ?>	
                                   			<tr>            
                                                <td><?php echo $data->bill_number;?></td>
                                                <td><?php echo $data->bill_date;?></td>
                                                <td><?php echo $data->return_date;?></td>
                                                <td><?php echo $data->customer_name;?></td>
                                                <td>
                                                		<?
															$return_items = get_return_items($data->return_id);
															if($return_items)
															{
													   ?>
                                                	
                                                        	<a data-toggle="collapse" href="#trturn<?=$data->return_id?>" role="button" aria-expanded="false" aria-controls="collapseExample">
    <i class="fas fa-chevron-down"></i>
  </a>
  														<? }?>
                                                           
                                                </td>
                                           </tr>
                                           <?
                                           		$return_items = get_return_items($data->return_id);
												if($return_items)
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
                                              	<div class="accordian-body collapse" id="trturn<?=$data->return_id?>"> 
                                                  	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    	<thead class="thead-light">
                                                            <tr>
                                                                <th scope="col">Item Name & Description</th>
                                                                <th scope="col">Returned Quantity</th>
                                                                <th scope="col">Returned Reason</th>
                                                                <th scope="col">Added to Stock</th>     
                                                            </tr>
                                                        </thead>
                                                    	<tbody>
                                                  		<? 	foreach ($return_items as $data){?>
                                                         
                                                            <tr>
                                                              <td><?=$data->item_name?><br /><?=$data->item_description?></td>
                                                              <td class="text-center"><?=$data->return_quantity?></td>
                                                              <td class="text-left"><?=$data->return_reason?></td>
                                                              <td class="text-center"><?=$data->added_to_stock?></td>
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
                                         <?
										  if($this->session->userdata('search_string2')){
										?>
                                        	<tr>
                                            	<td class="text-right" colspan="6">
                                                	<a href="<?=base_url()?>returns/clear_search" class="btn btn-success">Reset Filter</a>
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