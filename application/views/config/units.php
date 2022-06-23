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
                    <h1 class="h3 mb-1 text-gray-800">Units</h1>
                    <p></p>
                    <!-- Content Row -->
                    <div class="row">

                        <div class="col-lg-6">

                            <!-- Overflow Hidden -->
                            <div class="card mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary"><? if(isset($unit)){?> Update Unit <? } else{?>Add Units <? }?></h6>
                                </div>
                                <div class="card-body">
                                    <form class="user" method="post" action="<?=base_url()?>config/<?=$action?>">
                                        <div class="form-group">
                                            <input type="text" class="form-control" required="required"
                                                id="unit_name" name="unit_name" <? if(isset($unit)){?>value="<?=$unit->unit_name?>"<? }?> 
                                                autocomplete="off" aria-describedby="Unit Name"
                                                placeholder="Enter Unit Name">
                                            <input type="hidden" name="unit_id" <? if(isset($unit)){?>value="<?=$unit->unit_id?>"<? }?>/>
                                        </div>
                                       
                                        <input type="submit" name="submit"  class="btn btn-primary btn-user btn-block" <? if(isset($unit)){?> value="Update"<? }else{?> value="Add"<? }?> />
                                        
                                    </form>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-6">

                            <!-- Roitation Utilities -->
                            <div class="card">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Unit List</h6>
                                </div>
                                <div class="card-body text-center">
                                	<table class="table table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                            	<th scope="col">Unit Name</th>
                                            	<th scope="col">Actions</th>       
                                            </tr>
                                        </thead>
                                        <tbody>
										 <?
                                              if(isset($units)){
												  foreach($units as $data){
                                         ?>	
                                   			<tr>            
                                                <td><?php echo $data->unit_name;?></td>
                                                <td>
                                                	
                                                        <a href="<?=base_url()?>config/edit_unit/<?=$this->encryption->encode($data->unit_id)?>">
                                                            <i class="fas fa-pen"></i>
                                                        </a>
                                                     <? if(!check_unit_use($data->unit_id)){?>   
                                                        <a class="ml-4" href="<?=base_url()?>config/delete_unit/<?=$this->encryption->encode($data->unit_id)?>" onclick="return confirm('Are you sure you want to delete this unit?');">
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
           