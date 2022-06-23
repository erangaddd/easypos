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
                    <h1 class="h3 mb-1 text-gray-800">Items</h1>
                    <p></p>
                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-lg-12">

                            <!-- Roitation Utilities -->
                            <div class="card">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Item List</h6>
                                    
                                </div>
                                <div class="card-body text-right">
                                	<form method="post" action="<?=base_url()?>config/item_search" 
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
                                	
                                	<table class="table table-bordered">
                                        <thead>
                                            <tr>
                                            	<th scope="col">Item Name</th>
                                                <th scope="col">Item Description</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Unit</th>
                                                <th scope="col">Origin</th>
                                                <th scope="col">Minimum Qty</th>
                                            	<th scope="col">Actions</th>       
                                            </tr>
                                        </thead>
                                        <tbody>
										 <?
                                              if($items){
												  foreach($items as $data){
                                         ?>	
                                   			<tr>            
                                                <td><?php echo $data->item_name;?></td>
                                                <td><?php echo $data->item_description;?></td>
                                                <td><?php echo $data->type_name;?></td>
                                                <td><?php echo $data->unit_name;?></td>
                                                <td><?php echo $data->item_origin;?></td>
                                                <td><?php echo $data->minimum_quantity;?></td>
                                                <td>
                                                	
                                                        <a href="<?=base_url()?>config/edit_item/<?=$this->encryption->encode($data->item_id)?>">
                                                            <i class="fas fa-pen"></i>
                                                        </a>
                                                      <? if(!check_item_use($data->item_id)){?>  
                                                        <a class="ml-4" href="<?=base_url()?>config/delete_item/<?=$this->encryption->encode($data->item_id)?>" onclick="return confirm('Are you sure you want to delete this item?');">
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

                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            
            <!-- End of Main Content -->
    <?php $this->load->view('includes/footer');?>