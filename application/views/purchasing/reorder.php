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
		background-color: #FFF0F0;
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
                    <h1 class="h3 mb-1 text-gray-800">Reorder Point</h1>
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
                                	<button class="btn btn-success btn-user">Print List</button>
                                </div>
                                <div class="card-body text-center">
                                	<table class="table table-bordered table-condensed" id="printTable">
                                        <thead class="thead-dark">
                                            <tr>
                                            	<th scope="col">Item Name & Description</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Origin</th>
                                                <th scope="col">Unit</th>
                                                <th scope="col">Minimum Quantity</th>
                                                <th scope="col">Quantity Remains</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										 <?
                                              if($items){
												  foreach($items as $data){
													  if($data->minimum_quantity >= $data->total){
                                         ?>	
                                   			<tr>            
                                                <td><?php echo $data->item_name;?><br /><?php echo $data->item_description;?></td>
                                                <td><?php echo $data->type_name;?></td>
                                                <td><?php echo $data->item_origin;?></td>
                                                <td><?php echo $data->unit_name;?></td>
                                                <td><?php echo $data->minimum_quantity;?></td>
                                                <td><?php echo $data->total;?></td>
                                                
                                           </tr>
                                          
										<?
												}
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
<script>
function printData()
{
   var divToPrint=document.getElementById("printTable");
   newWin= window.open("");
   newWin.document.write(divToPrint.outerHTML);
   newWin.print();
   newWin.close();
}

$('button').on('click',function(){
printData();
})
</script>