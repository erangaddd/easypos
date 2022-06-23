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
            <form class="user" enctype="multipart/form-data" id="item_form" method="post" action="<?=base_url()?>reports/sales_report">
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-1 text-gray-800">Sales Report</h1>
                    <p></p>
                    <!-- Content Row -->
                    
                    <div class="row">
					
                        <div class="col-lg-12">

                            <!-- Overflow Hidden -->
                            <div class="card mb-4">
                                
                                <div class="card-body" id="grn_items">
                                	<div class="form-row">
                                        <div class="form-group col-md-4">
                                        	<label>Report Type</label>
                                          	<select class="form-control" name="type" id="type" required >
                                            	<option value="">Select Option</option>
                                                <option value="All">All Sales</option>
                                                <option value="Cash">Cash Sales</option>
                                                <option value="Credit">Credit Sales</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                        	<label>From Date</label>
                                          	<input type="date" class="form-control"
                                                id="from" name="from" onchange="toDate(this.value);"
                                                autocomplete="off" aria-describedby="category Name"
                                                placeholder="From Date">
                                        </div>
                                        <div class="form-group col-md-3">
                                        	<label>To Date</label>
                                          	<input type="date" class="form-control"
                                                id="to" name="to" max='2000-13-13'
                                                autocomplete="off" aria-describedby="category Name"
                                                placeholder="To Date">
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
		
		function toDate(date){
			document.getElementById("to").value = '';
			//alert(date);
			var today = new Date(date);
			var dd = today.getDate();
			var mm = today.getMonth()+ 1;
			var yyyy = today.getFullYear() + 1;
			
			if (dd < 10) {
			   dd = '0' + dd;
			}
			
			if (mm < 10) {
			   mm = '0' + mm;
			} 
				
			today = yyyy + '-' + mm + '-' + dd;
			document.getElementById("to").setAttribute("max", today);
			document.getElementById("to").setAttribute("min", date);	
		}
				
    </script>