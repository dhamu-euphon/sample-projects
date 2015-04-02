<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Strategy extends CI_Controller {
	
	function __construct(){		
		parent::__construct();
		
		$this->logged_in			=	$this->quickauth->is_logged_in();
		$this->is_admin				=	$this->quickauth->is_admin();
		$this->logged_in_user		=	$this->quickauth->logged_in_user();
		$this->logged_in_username	=	$this->quickauth->logged_in_username();
		
		$this->load->model('strategy_model','strategy');
		$this->load->model('user_model','user');
		$this->load->model('plan_model','plan');
	}
	
	//----------------------------------------------------------------------------------------------
	

   /**
	*This function 'll be used to build a strategy for a plan
	*
	* @access public
	* @param int $plan_id
	* @return view to build strategy page
	*/	
	
	function buildStrategy($plan_id = 0){
		if(!$this->logged_in){
			redirect(base_url());
		}
		
		$strategy_name	=	'New Strategy';
		
		$detailsArr			=	array(
									'plan_id'			=>	$plan_id,
									'created_by'		=>	$this->logged_in_user,
									'created_date'		=>	date('Y-m-d'),
									'last_modified_by'	=>	$this->logged_in_user,
									'strategy_name'		=>	$strategy_name
								);
		
		$insert_id			=	$this->strategy->insertStrategy($detailsArr);	
		
		if($insert_id){
			redirect(base_url().'strategy/editStrategy/'.$plan_id.'/'.$insert_id);
		}else{
			echo 'false';
		}
		
	}
	
	//----------------------------------------------------------------------------------------------
	

   /**
	*This function 'll be used to edit a strategy
	*
	* @access public
	* @param int $vision_id
	* @param int $strategy_id
	* @return view to edit strategy page
	*/	
	
	function editStrategy($plan_id = 0, $strategy_id = 0){
		if(!$this->logged_in){
			redirect(base_url());
		}
		
		$userDetailsArr		=	$this->user->getUserDetailsById($this->logged_in_user);
		
		$account_id			=	$userDetailsArr['account_id'];
				
		$planDetailsArr	=	$this->plan->getPlanDetailsById($plan_id);
		
		if(empty($planDetailsArr)){
			die('Sorry, there is no such vision!');
		}else{
			if($plan_id != $planDetailsArr['plan_id']){
				die('Sorry, the vision does not belong to your account!');
			}
		}
		
		$strategyDetailsArr			=	$this->strategy->getStrategyDetails($plan_id, $strategy_id);
		
		if(empty($strategyDetailsArr)){
			die('Sorry, there is no such strategy!');
		}
		
		$activitiesArr				=	$this->strategy->getActivitiesList($strategy_id,0);
		
		$data						=	array();
		
		$data['logged_in']			=	$this->logged_in;
		$data['logged_in_user']		=	$this->logged_in_user;
		$data['is_admin']			=	$this->is_admin;
		$data['logged_in_username']	=	$this->logged_in_username;
		
		$data['Page_title']			=	'Vision';
		$data['Page_name']			=	'Edit Strategy';
		
		$data['strategyDetailsArr']	=	$strategyDetailsArr;
		$data['activitiesArr']		=	$activitiesArr;
		
		$this->load->view('strategy/edit-strategy',$data);
	}
	
	//----------------------------------------------------------------------------------------------
	
	
   /**
	*This function 'll be used to update a strategy 
	*
	* @access public
	* @return response to ajax request
	*/	
	
	function updateStrategy(){
		if(!$this->logged_in){
			redirect(base_url());
		}
		
		$strategy_name		=	htmlentities($this->input->post('strategy_name'));
		$strategy_id		=	trim($this->input->post('hidden_strategy_id'));
		$plan_id			=	trim($this->input->post('hidden_plan_id'));
		
		$detailsArr			=	array(
									'strategy_name'		=>	$strategy_name
								);
		
		$update			=	$this->strategy->updateStrategy($strategy_id,$plan_id,$detailsArr);	
		
		if($update){
			echo 'true';
		}else{
			echo 'false';
		}
		
	}
	
	//----------------------------------------------------------------------------------------------
	

   /**
	*This function 'll be used to add a strategy activity
	*
	* @access public
	* @param int $vision_id
	* @param int $strategy_id
	* @return view to build strategy page
	*/	
	
	function addActivity($plan_id = 0,$strategy_id = 0,$parent_activity_id = 0){
		if(!$this->logged_in){
			redirect(base_url());
		}
		
		$userDetailsArr		=	$this->user->getUserDetailsById($this->logged_in_user);
		
		$account_id			=	$userDetailsArr['account_id'];
		
		$planDetailsArr	=	$this->plan->getPlanDetailsById($plan_id);
		
		if(empty($planDetailsArr)){
			die('Sorry, there is no such vision!');
		}else{
			if($plan_id != $planDetailsArr['plan_id']){
				die('Sorry, the vision does not belong to your account!');
			}
		}
		
		$strategyDetailsArr			=	$this->strategy->getStrategyDetails($plan_id, $strategy_id);
		
		if(empty($strategyDetailsArr)){
			die('Sorry, there is no such strategy!');
		}
		
		$data						=	array();
		
		$data['logged_in']			=	$this->logged_in;
		$data['logged_in_user']		=	$this->logged_in_user;
		$data['is_admin']			=	$this->is_admin;
		$data['logged_in_username']	=	$this->logged_in_username;
		
		$data['Page_title']			=	'Vision';
		$data['Page_name']			=	'Add Activity';
		
		$data['parent_activity_id']	=	$parent_activity_id;
		
		$data['strategyDetailsArr']	=	$strategyDetailsArr;
		
		$this->load->view('strategy/add-activity',$data);
	}
	
	//----------------------------------------------------------------------------------------------
	

   /**
	*This function 'll be used to add a new activity
	*
	* @access public
	* @return response to ajax request
	*/	
	
	function addActivityProcess(){
		if(!$this->logged_in){
			redirect(base_url());
		}
		
		$activity_name				=	htmlentities($this->input->post('activity_name'));
		$activity_description		=	htmlentities($this->input->post('activity_description'));
		$strategy_id				=	trim($this->input->post('hidden_strategy_id'));
		$parent_activity_id			=	trim($this->input->post('hidden_parent_id'));
		
		$detailsArr			=	array(
									'strategy_id'			=>	$strategy_id,
									'activity_name'			=>	$activity_name,
									'activity_description'	=>	$activity_description,
									'parent_activity_id'	=>	$parent_activity_id,
									'created_date'			=>	date('Y-m-d')
								);
		
		$insert_id				=	$this->strategy->insertActivity($detailsArr);
		
		// If parent activity exists, update the children by adding the newly inserted activity id to its children
		if($parent_activity_id != 0 && is_numeric($parent_activity_id)){
			$this->updateChildren($parent_activity_id, $insert_id);
		}
		
		if($insert_id){
			echo 'true';
		}else{
			echo 'false';
		}
		
	}
	//----------------------------------------------------------------------------------------------
	

   /**
	*This function 'll be used to update the children of an activity
	*
	* @access public
	* @param int $parent_activity_id
	* @param int $activity_id
	* @return boolean true/recurse to same function
	*/	
	
	function updateChildren($parent_activity_id, $activity_id){
		$children	=	$this->strategy->getActivityChildren($parent_activity_id);
		$append		=	$activity_id;
		if($children != ''){
			$append	=	','.$activity_id;
		}
		
		$new_children		=	$children.$append;
		
		$updateArr			=	array(
									'children'	=>	$new_children
								);
		
		$update_children	=	$this->strategy->updateActivityChildren($parent_activity_id,$updateArr);
		
		$new_parent			=	$this->strategy->getParentByActivity($parent_activity_id);
		
		// If parent exists, continue the process else return
		if($new_parent == 0){
			return true;
		}else{
			$this->updateChildren($new_parent, $activity_id);
		}
	}
	//----------------------------------------------------------------------------------------------
	

   /**
	*This function 'll be used to edit an activity
	*
	* @access public
	* @param int $vision_id
	* @param int $strategy_id
	* @return view to edit strategy page
	*/	
	
	function editActivity($plan_id = 0, $strategy_id = 0, $strategy_activity_id = 0){
		if(!$this->logged_in){
			redirect(base_url());
		}
		
		$userDetailsArr		=	$this->user->getUserDetailsById($this->logged_in_user);
		
		$account_id			=	$userDetailsArr['account_id'];
		
		$planDetailsArr	=	$this->plan->getPlanDetailsById($plan_id);
		
		if(empty($planDetailsArr)){
			die('Sorry, there is no such vision!');
		}else{
			if($plan_id != $planDetailsArr['plan_id']){
				die('Sorry, the vision does not belong to your account!');
			}
		}
		
		$strategyDetailsArr			=	$this->strategy->getStrategyDetails($plan_id, $strategy_id);
		
		if(empty($strategyDetailsArr)){
			die('Sorry, there is no such strategy!');
		}
		
		$activityDetailsArr			=	$this->strategy->getActivityDetails($strategy_id, $strategy_activity_id);
		
		$activitiesArr				=	$this->strategy->getActivitiesList($strategy_id,$strategy_activity_id);
		
		$data						=	array();
		
		$data['logged_in']			=	$this->logged_in;
		$data['logged_in_user']		=	$this->logged_in_user;
		$data['is_admin']			=	$this->is_admin;
		$data['logged_in_username']	=	$this->logged_in_username;
		
		$data['Page_title']			=	'Vision';
		$data['Page_name']			=	'Edit Activity';
		
		$data['strategyDetailsArr']	=	$strategyDetailsArr;
		$data['activityDetailsArr']	=	$activityDetailsArr;
		$data['activitiesArr']		=	$activitiesArr;
		
		$this->load->view('strategy/edit-activity',$data);
	}
	//----------------------------------------------------------------------------------------------
	
	
   /**
	*This function 'll be used to update an activity 
	*
	* @access public
	* @return response to ajax request
	*/	
	
	function updateActivity(){
		if(!$this->logged_in){
			redirect(base_url());
		}
		
		$activity_name				=	htmlentities($this->input->post('activity_name'));
		$activity_description		=	htmlentities($this->input->post('activity_description'));
		$strategy_id				=	trim($this->input->post('hidden_strategy_id'));
		$strategy_activity_id		=	trim($this->input->post('hidden_activity_id'));
		
		$detailsArr			=	array(
									'activity_name'				=>	$activity_name,
									'activity_description'		=>	$activity_description
								);
		
		$update			=	$this->strategy->updateActivity($strategy_id,$strategy_activity_id,$detailsArr);	
		
		if($update){
			echo 'true';
		}else{
			echo 'false';
		}
		
	}
	//----------------------------------------------------------------------------------------------
	
	
   /**
	*This function 'll be used to delete an activity 
	*
	* @access public
	* @return response to ajax request
	*/	
	
	function deleteActivity(){
		if(!$this->logged_in){
			redirect(base_url());
		}
		
		$vision_id					=	trim($this->input->post('vision_id'));
		$strategy_id				=	trim($this->input->post('strategy_id'));
		$strategy_activity_id		=	trim($this->input->post('strategy_activity_id'));
		
		$children					=	$this->strategy->getActivityChildren($strategy_activity_id);
		
		$delete						=	$this->strategy->deleteActivity($strategy_id,$strategy_activity_id);
		
		if($children != ''){
			$childrenArr			=	explode(',',$children);
			$delete_children		=	$this->strategy->deleteActivity($strategy_id,$childrenArr);
		}
			
		
		if($delete){
			echo 'true';
		}else{
			echo 'false';
		}
		
	}
	//----------------------------------------------------------------------------------------------
	
	 /**
	*This function 'll be used to delete a strategy
	*
	* @access public
	* @return response to ajax request
	*/	
	
	function deleteStrategy(){
		if(!$this->logged_in){
			redirect(base_url());
		}
		
		$plan_id		=	trim($this->input->post('plan_id'));
		$strategy_id	=	trim($this->input->post('strategy_id'));
		
		$delete			=	$this->strategy->deleteStrategy($plan_id,$strategy_id);	
		
		if($delete){
			echo 'true';
		}else{
			echo 'false';
		}
		
	}
	//----------------------------------------------------------------------------------------------
	
	/**
	*This function 'll be used to display strategy
	*
	* @access public
	* @return response to ajax request
	*/	
	
	function popupStrategyView($plan_id = 1){
		if(!$this->logged_in){
			redirect(base_url());
		}
		$login_user			=	$this->logged_in_user;
		$planDetailsArr		=	$this->plan->getPlanDetailsById($plan_id);
		
		
		if(empty($planDetailsArr)){
			die('Sorry, there is no such plan!');
		}else{
			if($login_user != $planDetailsArr['created_by']){
				die('Sorry, the plan does not belong to your account!');
			}
		}
		
		$data						=	array();
		
		$data['logged_in']			=	$this->logged_in;
		$data['logged_in_user']		=	$this->logged_in_user;
		$data['is_admin']			=	$this->is_admin;
		$data['logged_in_username']	=	$this->logged_in_username;
		
		$data['Page_title']			=	'Plan';
		$data['Page_name']			=	'Build Strategy';
		
		$data['planDetailsArr']	=	$planDetailsArr;
		
		$strategiesArr				=	$this->strategy->getStrategyListByPlanId($plan_id);
		foreach($strategiesArr as $key=>$val){
			$strategiesArr[$key]['new'] =  $this->strategy->getStrategyActivityName($strategiesArr[$key]['strategy_id']);
		}
		
		$data['strategiesArr']		=	$strategiesArr;
		
		
		$this->load->view('strategy/popup-strategy-list',$data);
	}
}