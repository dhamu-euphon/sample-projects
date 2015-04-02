<?php $this->load->view('include/header', Array("Page_title" => $Page_title, "Page_name" => $Page_name, "logged_in" => $logged_in, "logged_in_username" => $logged_in_username, "logged_in_user_role" => $logged_in_user_role));?>
<script type="text/javascript">		
	$(function() {
		$( "#project_fund_start" ).datepicker({
			showButtonPanel : true,
			changeMonth : true,
			changeYear : true
		});
		$( "#project_fund_end" ).datepicker({
			showButtonPanel : true,
			changeMonth : true,
			changeYear : true
		});
		$( "#project_date_needed" ).datepicker({
			showButtonPanel : true,
			changeMonth : true,
			changeYear : true
		});
	});

	$(document).ready(function(){
		
		$("#form_project_register").validate({
			rules: {
				project_name: {
					required: true,
					minlength: 2
				},
				project_description: {
					required: true,
					minlength: 2
				},
				
				project_class: {
					required: true,
					minlength: 2
				},
				project_subject: {
					required: true,
					minlength: 5
				},
				project_amount: {
					required: true,
					
				},
				project_date_needed: {
					required: true
					
				},
				profile_img: {
					remote: {
							  url: "<?php echo base_url(); ?>user/checkImageFormat",
							  type: "post",
							  data: {
								hidden_image_size: function(){return $("#hidden_image_size").val(); },
								hidden_image_type: function(){return $("#hidden_image_type").val(); }
					          }
					        }  
				},
				project_fund_start: {
					required: true
					
				},
				project_fund_end: {
					required: true
					
				}
			},
			messages: {
				project_name: {
					required: "Please enter project name",
					minlength: "Project name must consist of at least 2 characters"
				},
				project_description: {
					required: "Please enter project description",
					minlength: "Project description must consist of at least 2 characters"
				},
				project_class: {
					required: "Please enter class project is for",
					minlength: "Class project must consist of at least 2 characters",
				},
				project_subject: {
					required: "Please enter class project subject",
					minlength: "Project subject must be at least 5 characters long"
				},
				project_amount: {
					required: "Please enter project amount"
				},
				project_date_needed: {
					required: "Please enter Date needed"
				},
				profile_img: {
					required: "Please upload your profile image",
					remote: 'Please upload JPEG|GIF|PNG image below 500kb'
				},
				project_fund_start: {
					required: "Please enter funraising start date"
				},
				project_fund_end: {
					required: "Please enter funraising end date"
				}
			}
		});
});	
	
</script>
<div class="inner_page_container">

        <h4>Register Form</h4>
        
            <form id="form_project_register" name="form_project_register" method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>project/projectRegisterProcess">
              <input type="hidden" id="hidden_image_size" name="hidden_image_size"  />
            	<input type="hidden" id="hidden_image_type" name="hidden_image_type"  />
               <fieldset>
                  <label for="project_name">Project Name:</label>
               
                  <input type="text" name="project_name" id="project_name" value="" />
                </fieldset>
              
                <fieldset>
                  <label for="project_description">Project Description:</label>
                
                  <input type="text" name="project_description" id="project_description" value="" />
                </fieldset>
                
                <fieldset>
                  <label for="project_class">Class Project is for:</label>
               
                  <input type="text" name="project_class" id="project_class" value="" />
                </fieldset>
                
                <fieldset>
                  <label for="project_subject">Subject of Project:</label>
                   
                  <input type="text" name="project_subject" id="project_subject" value="" />
                </fieldset>
                
                <fieldset>
                  <label for="project_amount">Amount Needed:</label>
                  
                  <input type="text" name="project_amount" id="project_amount" value="" />
                </fieldset>
                
                <fieldset>
                  <label for="project_date_needed">Date Needed: &nbsp;&nbsp;&nbsp;</label>
                 
                  <input type="text" name="project_date_needed" id="project_date_needed" value="" />
                </fieldset>
            	
                 <fieldset>
                          <label for="profile_img">Upload Picture: &nbsp;</label>
                        
                          <input type="file" name="profile_img" id="profile_img" value="" onchange="getImageSize();" />
                        </fieldset>
                
                <fieldset>
                  <label for="project_fund_start">Fundraising Start Date:</label>
                 
                  <input type="text" name="project_fund_start" id="project_fund_start" value="" />
                </fieldset>
                 <fieldset>
                      <label for="project_fund_end">Fundraising End Date:</label>
                     
                      <input type="text" name="project_fund_end" id="project_fund_end" value="" />
                    </fieldset>
                <fieldset>
                  <input class="submit-button" type="submit" name="submit_project" id="submit_project" value="Submit" />
                </fieldset>
                
          </form>
    </div>
<?php $this->load->view('include/footer');?>