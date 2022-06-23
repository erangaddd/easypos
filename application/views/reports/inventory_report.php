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
            <form class="user" enctype="multipart/form-data" id="item_form" method="post" action="<?=base_url()?>reports/inventory_report">
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-1 text-gray-800">Stock Report</h1>
                    <p></p>
                    <!-- Content Row -->
                    
                    <div class="row">
					
                        <div class="col-lg-12">

                            <!-- Overflow Hidden -->
                            <div class="card mb-4">
                                
                                <div class="card-body" id="grn_items">
                                	<div class="form-row">
                                        <div class="form-group col-md-4">
                                          <select class="form-control" name="type" id="type" required >
                                            	<option value="">Select Option</option>
                                                <option value="Available">Available Items</option>
                                                <option value="All">All Items</option>
                                            </select>
                                        </div>
                                    </div>
                                <div class="card-body" id="grn_items">
                                	<input type="submit" name="submit"  class="btn btn-success" value="Download" />	
                                </div>	
                             </div>						
                           </div>
                          
                       </div>
					 
                    </div>

                </div>
              </form>
                <!-- /.container-fluid -->

            </div>
            
            <!-- End of Main Content -->
    <?php $this->load->view('includes/footer');?>
	<script>

      	$(function() {
        	$('.chosen-select').chosen({
				allow_single_deselect : true,
				search_contains: true,
				no_results_text: "Oops, nothing found!",
				placeholder_text_single: "Select Option"
			});
        	$('.chosen-select-deselect').chosen({ allow_single_deselect: true });
			
		
      	});
				
    </script>