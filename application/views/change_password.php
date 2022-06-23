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
	select:invalid {
	  height: 0px !important;
	  opacity: 0 !important;
	  position: relative !important;
	  margin-top:-12px;
	  display: flex !important;
	}
	
	select:invalid[multiple] {
	  margin-top: 15px !important;
	}
	
	meter {
		/* Reset the default appearance */
	  -webkit-appearance: none;
		 -moz-appearance: none;
			  appearance: none;
				
	  margin: 0 auto 1em;
	  width: 100%;
	  height: .5em;
		
		/* Applicable only to Firefox */
	  background: none;
	  background-color: rgba(0,0,0,0.1);
	}
	
	meter::-webkit-meter-bar {
	  background: none;
	  background-color: rgba(0,0,0,0.1);
	}
	
	meter[value="1"]::-webkit-meter-optimum-value { background: red; }
	meter[value="2"]::-webkit-meter-optimum-value { background: yellow; }
	meter[value="3"]::-webkit-meter-optimum-value { background: orange; }
	meter[value="4"]::-webkit-meter-optimum-value { background: green; }
	
	meter[value="1"]::-moz-meter-bar { background: red; }
	meter[value="2"]::-moz-meter-bar { background: yellow; }
	meter[value="3"]::-moz-meter-bar { background: orange; }
	meter[value="4"]::-moz-meter-bar { background: green; }
	
	.feedback {
	  color: #9ab;
	  font-size: 90%;
	  padding: 0 .25em;
	  font-family: Courgette, cursive;
	  margin-top: 1em;
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
            <form class="user" enctype="multipart/form-data" id="item_form" method="post" action="<?=base_url()?>login/change_password">
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-1 text-gray-800">Change Password</h1>
                    <p></p>
                    <!-- Content Row -->
                    
                    <div class="row">
					
                        <div class="col-lg-12">
                        	

                            <!-- Overflow Hidden -->
                            <div class="card mb-4">
                                <div class="card-header py-3">
                                    
                                </div>
                                <div class="card-body">
                                	<div class="form-row">
                                        <div class="form-group col-md-4">
                                            <input type="password" class="form-control" required="required"
                                                id="password" name="password" 
                                                autocomplete="off" aria-describedby="Current Password"
                                                placeholder="Current Password">
          								</div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                        	<input type="password" class="form-control" required="required"
                                                id="new_password" name="new_password" 
                                                autocomplete="off" aria-describedby="New Password"
                                                placeholder="New Password">
                                        </div>
                                   </div>
                                   <div class="form-row">     
                                        <div class="form-group col-md-4">   
                                            <input type="password" class="form-control" required="required"
                                                id="confirm_password" name="confirm_password" 
                                                autocomplete="off" aria-describedby="Confirm Password"
                                                placeholder="Confirm Password">
                                        </div>
                                    </div>
                                    <meter max="4" id="password-strength-meter"></meter>
    <p id="password-strength-text"></p>
                                </div>
                                <div class="card-body" id="grn_items">
                                	<input type="submit" name="submit"  class="btn btn-success" value="Change Password" />	
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.2.0/zxcvbn.js"></script>
	<script>
	$(function() {
    	var strength = {
			0: "Worst ☹",
			1: "Bad ☹",
			2: "Weak ☹",
			3: "Good ☺",
			4: "Strong ☻"
		}
		
		var password = document.getElementById('new_password');
		var meter = document.getElementById('password-strength-meter');
		var text = document.getElementById('password-strength-text');
		
		password.addEventListener('input', function()
		{
			
			var val = password.value;
			var result = zxcvbn(val);
			// Update the password strength meter
			meter.value = result.score;
		   
			// Update the text indicator
			if(val !== "") {
				text.innerHTML = "Strength: " + "<strong>" + strength[result.score] + "</strong>" + "<span class='feedback'>" + result.feedback.warning + " " + result.feedback.suggestions + "</span"; 
			}
			else {
				text.innerHTML = "";
			}
		});
	});
    </script>