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
                    <h1 class="h3 mb-1 text-gray-800">Items</h1>
                    <p></p>
                    <!-- Content Row -->
                    <div class="row">

                        <div class="col-lg-6">

                            <!-- Overflow Hidden -->
                            <div class="card mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary"><? if(isset($item)){?> Update Item <? } else{?>Add Item <? }?></h6>
                                </div>
                                <div class="card-body">
                                    <form class="user" method="post" action="<?=base_url()?>config/<?=$action?>">
                                        <div class="form-group">
                                            <input type="text" class="form-control" required="required"
                                                id="item_name" name="item_name" <? if(isset($item)){?>value="<?=$item->item_name?>"<? }?> 
                                                autocomplete="off" aria-describedby="Item Name"
                                                placeholder="Enter Item Name">
                                            <input type="hidden" name="item_id" <? if(isset($item)){?>value="<?=$item->item_id?>"<? }?>/>
                                            <p></p>
                                            <input type="text" class="form-control" required="required"
                                                id="item_description" name="item_description" <? if(isset($item)){?>value="<?=$item->item_description?>"<? }?> 
                                                autocomplete="off" aria-describedby="Item Description"
                                                placeholder="Enter Item Description">
                                            
                                            <p></p>
                                            <input type="text" class="form-control" required="required"
                                                id="item_origin" name="item_origin" <? if(isset($item)){?>value="<?=$item->item_origin?>"<? }?> 
                                                autocomplete="off" aria-describedby="Country of Origin"
                                                placeholder="Country of Origin">
                                          
                                            
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
                                            <input type="text" class="form-control" required="required"
                                                id="minimum_quantity" name="minimum_quantity" <? if(isset($item)){?>value="<?=$item->minimum_quantity?>"<? }?> 
                                                autocomplete="off" aria-describedby="Minimum Order Quantity"
                                                placeholder="Minimum Order Quantity">
                                            <p></p>
                                            <? 
												$type_id = '';
												if(isset($item)){
													$type_id = $item->type_id;
												}
											?>
                                            <select class="form-control" name="type_id" id="type_id" required >
                                            	<option value="">Select Type</option>
                                                <? if($types){
														foreach($types as $data2){	
												?>
                                                			<option <? if($type_id == $data2->type_id){?> selected="selected" <? }?> value="<?=$data2->type_id?>"><?=$data2->type_name?></option>
                                                <?
														}
													}
												?>
                                            </select>
                                            <p></p>
                                            <? 
												$unit_id = '';
												if(isset($item)){
													$unit_id = $item->unit_id;
												}
											?>
                                            <select class="form-control" name="unit_id" id="unit_id" required >
                                            	<option value="">Select Unit</option>
                                                <? if($units){
														foreach($units as $data2){	
												?>
                                                			<option <? if($unit_id == $data2->unit_id){?> selected="selected" <? }?> value="<?=$data2->unit_id?>"><?=$data2->unit_name?></option>
                                                <?
														}
													}
												?>
                                            </select>
                                            
                                        </div>
                                       
                                        <input type="submit" name="submit"  class="btn btn-primary btn-user btn-block" <? if(isset($item)){?> value="Update"<? }else{?> value="Add"<? }?> />
                                        
                                    </form>
                                </div>
                            </div>

                        </div>
					<? if(!isset($item)){?>
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
                                        <thead class="thead-dark">
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
                                    <p><?php echo $links; ?></p>
                                </div>
                            </div>

                        </div>
					<? }?>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            
            <!-- End of Main Content -->
    <?php $this->load->view('includes/footer');?>