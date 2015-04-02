<?php $this -> load -> view("includes/header", Array("Page_title" => $Page_title, "Page_name" => $Page_name, "logged_in" => $logged_in, "logged_in_username" => $logged_in_username)); ?>
<script type="text/javascript">
	$(document).ready(function(){
		
		new nicEditor({iconsPath : '<?php echo base_url(); ?>asset/js/nicEdit/nicEditorIcons.gif'}).panelInstance('activity_description'); 	
	});
	
	function updateActivity(){
		var activity_name			=	$('#activity_name').val();
		var activity_description	=	$('#activity_description').html();
		var hidden_strategy_id		=	$('#hidden_strategy_id').val();
		var hidden_plan_id			=	$('#hidden_plan_id').val();
		var hidden_activity_id		=	$('#hidden_activity_id').val();
		
		var checker		=	true;
		var message		=	'<div class="error_text_div">Error</div>';
		message		   +=	'<ul class="cls_error_list">';
		
		if(activity_name == '' || activity_name == '<p><br data-mce-bogus="1"></p>' || activity_name == '<p><br></p>'){
			checker=false;
			message		+=	"<li>Please enter an activity name.</li>";
		}
		
		/*if(activity_description == '' || activity_description == '<p><br data-mce-bogus="1"></p>' || activity_description == '<p><br></p>'){
			checker=false;
			message		+=	"<li>Please enter description.</li>";
		}
		
		message			+=	'</ul></div>';*/
		
		if (checker){
			
			var url	=	base_url+'strategy/updateActivity';
					$.post(	url, 
							{
								activity_name:activity_name,
								activity_description:activity_description,
								hidden_strategy_id:hidden_strategy_id,
								hidden_activity_id:hidden_activity_id
							},
							
							function(data){
								if(data	==	'true'){
									window.location	=	base_url+'strategy/editStrategy/'+hidden_plan_id+'/'+hidden_strategy_id;
								}else{
									var message		=	'<div class="error_text_div">Error</div><ul class="cls_error_list"><li>Some error occured, try again!.</li></ul></div>';
									showErrorMessage(message);
								}
							}
					);
		}
		else{
			showErrorMessage(message);
		}
	}
</script>
<!--Alert-->
<div id="alert-modal" style="display:none;">
    <div id="alert-inner">
    	<span id="alert-message">
        	All related activities will be deleted. Do you really want to delete this activity?
        </span>
        <fieldset style="margin-left: 23%;margin-top: 5%;">
        <input class="alert-button" type="button" name="alert_activity_ok_btn" id="alert_activity_ok_btn" value="OK" />
        <input class="alert-button" type="button" name="alert_activity_cancel_btn" id="alert_activity_cancel_btn" value="CANCEL" />
        </fieldset>
    </div>
</div>
<div id="fancybox-overlay" class="overlay-fixed" style="cursor: pointer; opacity: 0.8; display: none;"></div>
<!--EOF Alert-->

<div class="inner_page_container">
	<div class="standard-form compressed">
    <div id="error_msg_div" class="error_display_div" style="display:none;">
    Please fill in all fields
	</div>
	<h4 class="semi">Edit Activity</h4>
    
        	<div class="left-container">
        	<form id="form_add_activity" name="form_add_activity" method="post" enctype="multipart/form-data" action="">
            	<input type="hidden" id="hidden_plan_id" name="hidden_plan_id" value="<?php echo $strategyDetailsArr['plan_id']; ?>" />
            	<input type="hidden" id="hidden_strategy_id" name="hidden_strategy_id" value="<?php echo $strategyDetailsArr['strategy_id']; ?>" />
                <input type="hidden" id="hidden_activity_id" name="hidden_activity_id" value="<?php echo $activityDetailsArr['strategy_activity_id']; ?>" />
               <fieldset>
               	  <label for="activity_name">Activity name:</label>
               </fieldset>
               
               <fieldset>  
              	 <input type="text" id="activity_name" name="activity_name" value="<?php echo html_entity_decode($activityDetailsArr['activity_name'], ENT_NOQUOTES, 'UTF-8'); ?>"/>  
               </fieldset>
               
               <fieldset>                   
               	  <label for="activity_description">Description:</label>
               </fieldset>
               
               <fieldset>       
                  <div id="activity_description" class="vision-enter-div"><?php echo html_entity_decode($activityDetailsArr['activity_description'], ENT_NOQUOTES, 'UTF-8'); ?></div>                  
               </fieldset>
               
               <fieldset>
                  <input class="submit-button" type="button" name="submit_activity" id="submit_activity" value="Submit" onclick="updateActivity();" />
                </fieldset>
          </form>
          </div>
           
           <div class="right-container">
           	<h4 class="semi">Related Activities</h4>
            
            <a class="button-link" href="<?php echo base_url(); ?>strategy/addActivity/<?php echo $strategyDetailsArr['plan_id'].'/'.$strategyDetailsArr['strategy_id'].'/'.$activityDetailsArr['strategy_activity_id']; ?>">Add Activity</a>
            
            <br />
            
            	<table id="activity_list" cellpadding="10" cellspacing="10">
            	<thead>
                    <th>Activity Name</th>
                    <th>Delete</th>
                </thead>
                <tbody>
                <?php if(count($activitiesArr) > 0 ): ?>
                	<?php
						$count	=	1;
						foreach($activitiesArr as $key => $value):
					?>
                    		<tr>
                            	<td><a href="<?php echo base_url(); ?>strategy/editActivity/<?php echo $strategyDetailsArr['plan_id'].'/'.$strategyDetailsArr['strategy_id'].'/'.$activitiesArr[$key]['strategy_activity_id']; ?>"><?php echo html_entity_decode($activitiesArr[$key]['activity_name'], ENT_NOQUOTES, 'UTF-8'); ?></a></td>
                                <td><a href="javascript:alertConfirmationActivityMessage('<?php echo $strategyDetailsArr['vision_id']; ?>', '<?php echo $strategyDetailsArr['strategy_id']; ?>', '<?php echo $activitiesArr[$key]['strategy_activity_id']; ?>')"><img  src="<?php echo base_url(); ?>asset/images/delete-icon-black.png" /></a></td>
                            </tr>
                    <?php
						$count++;
						endforeach;
					?>
                <?php else: ?>
                	<tr>
                    	<td colspan="3">
                        	No activities added.
                        </td>
                    </tr>
                <?php endif;?>    
                </tbody>
            </table>
            
        </div>
    </div>
    
    <br />

</div>
<?php $this -> load -> view("includes/footer"); ?>