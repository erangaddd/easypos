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
                    <h1 class="h3 mb-1 text-gray-800">Customers</h1>
                    <p></p>
                    <!-- Content Row -->
                    <form class="user" method="post" action="<?=base_url()?>sale/<?=$action?>">
                    <div class="row">
						
                        <div class="col-lg-6">

                            <!-- Overflow Hidden -->
                            <div class="card mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary"><? if(isset($customer)){?> Update Customer <? } else{?>Add Customer <? }?></h6>
                                </div>
                                <div class="card-body">
                                    
                                        <div class="form-group">
                                            <input type="text" class="form-control" required="required"
                                                id="customer_name" name="customer_name" <? if(isset($customer)){?>value="<?=$customer->customer_name?>"<? }?> 
                                                autocomplete="off" aria-describedby="Enter Customer Name"
                                                placeholder="Enter Customer Name">
                                            <input type="hidden" name="customer_id" <? if(isset($customer)){?>value="<?=$customer->customer_id?>"<? }?>/>
                                            <p></p>
                                            <textarea class="form-control" id="customer_address" name="customer_address" placeholder="Enter Customer Address"><? if(isset($customer)){ echo $customer->customer_address; }?></textarea>
                                            <p></p>
                                            <input type="text" class="form-control" 
                                                id="customer_mobile" name="customer_mobile" <? if(isset($customer)){?>value="<?=$customer->customer_mobile?>"<? }?> 
                                                autocomplete="off" aria-describedby="Enter Customer Mobile"
                                                placeholder="Enter Customer Mobile">
                                           
                                        </div>

                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6">

                            <!-- Overflow Hidden -->
                            <div class="card mb-4">
               
                                <div class="card-body">
                                        <div class="form-group">
                                        	<p></p>
                                            <input type="text" class="form-control" 
                                                id="customer_telephone" name="customer_telephone" <? if(isset($customer)){?>value="<?=$customer->customer_telephone?>"<? }?> 
                                                autocomplete="off" aria-describedby="Enter Customer Phone"
                                                placeholder="Enter Customer Telephone">
                                            <p></p>
                                            
                                            <input type="text" class="form-control"
                                                id="customer_fax" name="customer_fax" <? if(isset($customer)){?>value="<?=$customer->customer_fax?>"<? }?> 
                                                autocomplete="off" aria-describedby="Enter Customer Fax"
                                                placeholder="Enter Customer Fax">
                                            <p></p>
                                            
                                            <input type="text" class="form-control"
                                                id="customer_email" name="customer_email" <? if(isset($customer)){?>value="<?=$customer->customer_email?>"<? }?> 
                                                autocomplete="off" aria-describedby="Enter Customer Email"
                                                placeholder="Enter Customer Email">
                                            <p></p>
                                           
                                           
                                        </div>
                                       
                                        <input type="submit" name="submit"  class="btn btn-primary btn-user btn-block" <? if(isset($customer)){?> value="Update"<? }else{?> value="Add"<? }?> />
                                        
                                    </form>
                                </div>
                            </div>

                        </div>
						<? if($customers){?>
                        <div class="col-lg-12">

                            <!-- Roitation Utilities -->
                            <div class="card">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Customer List</h6>
                                </div>
                                <div class="card-body text-center">
                                	<table class="table table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                            	<th scope="col">Customer Name</th>
                                                <th scope="col">Address</th>
                                            	<th scope="col">Mobile</th>    
                                                <th scope="col">Telephone</th> 
                                                <th scope="col">Fax</th> 
                                                <th scope="col">Email</th>    
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										 <?
                                              if($customers){
												  foreach($customers as $data){
                                         ?>	
                                   			<tr>            
                                                <td><?php echo $data->customer_name;?></td>
                                                <td><?php echo $data->customer_address;?></td>
                                                <td><?php echo $data->customer_mobile;?></td>
                                                <td><?php echo $data->customer_telephone;?></td>
                                                <td><?php echo $data->customer_fax;?></td>
                                                <td><?php echo $data->customer_email;?></td>
                                                <td>
                                                	
                                                        <a href="<?=base_url()?>sale/edit_customer/<?=$this->encryption->encode($data->customer_id)?>">
                                                            <i class="fas fa-pen"></i>
                                                        </a>
                                                      <? if(!check_customer_use($data->customer_id)){?>  
                                                        <a class="ml-4" href="<?=base_url()?>sale/delete_customer/<?=$this->encryption->encode($data->customer_id)?>" onclick="return confirm('Are you sure you want to delete this customer?');">
                                                            <i class="text-danger fas fa-trash-alt"></i>
                                                        </a>
                                                    <? }?>
                                                </td>
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
                        <? }?>

                    </div>
					</form>
                </div>
                <!-- /.container-fluid -->

            </div>
            
            <!-- End of Main Content -->
    <?php $this->load->view('includes/footer');?>