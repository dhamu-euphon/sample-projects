<?php
class Strategy_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
						
	}
	
	//----------------------------------------------------------------------------------------------
	

   /**
	*This function 'll insert a new strategy
	*
	* @access public
	* @params array details
	* @return boolean true/false
	*/	
	
	function insertStrategy($detailsArr){
		$insert	=	$this->db->insert('tbl_strategy',$detailsArr);
		
		$return	=	false;
		
		if($insert){
			$return	=	$this->db->insert_id();
		}
		
		return $return;
	}
	//----------------------------------------------------------------------------------------------
	
	/**
	*This function 'll get the strategy list details by vision id
	*
	* @access public
	* @params int vision_id
	* @return array details
	*/	
	
	function getStrategyListByPlanId($plan_id){
		$this->db->select('*');
		$this->db->where('plan_id',$plan_id);
		$query	=	$this->db->get('tbl_strategy');
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
	}
	//----------------------------------------------------------------------------------------------
	

   /**
	*This function 'll get the strategy details details by vision id and strategy id
	*
	* @access public
	* @params int vision_id
	* @params int strategy_id
	* @return array details
	*/	
	
	function getStrategyDetails($plan_id, $strategy_id){
		$this->db->select('*');
		$this->db->where('plan_id',$plan_id);
		$this->db->where('strategy_id',$strategy_id);
		$query	=	$this->db->get('tbl_strategy');
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();		
		}
		
		return $resultArr;
	}
	//----------------------------------------------------------------------------------------------
	

   /**
	*This function 'll update a startegy
	*
	* @access public
	* @params int vision id
	* @params int strategy id
	* @params array details
	* @return boolean true/false
	*/	
	
	function updateStrategy($strategy_id,$plan_id,$detailsArr){
		$this->db->where('plan_id',$plan_id);
		$this->db->where('strategy_id',$strategy_id);
		$update	=	$this->db->update('tbl_strategy',$detailsArr);
		
		$return	=	false;
		
		if($update){
			$return	=	true;
		}
		
		return $return;
	}
	//----------------------------------------------------------------------------------------------
	

   /**
	*This function 'll get the strategy activity list details by strategy id
	*
	* @access public
	* @params int strategy_id
	* @return array details
	*/	
	
	function getActivitiesList($strategy_id,$parent_activity_id){
		$this->db->select('*');
		$this->db->where('strategy_id',$strategy_id);
		$this->db->where('parent_activity_id',$parent_activity_id);
		$query	=	$this->db->get('tbl_strategy_activities');
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
	}
	//----------------------------------------------------------------------------------------------
	

   /**
	*This function 'll insert a new activity
	*
	* @access public
	* @params array details
	* @return boolean true/false
	*/	
	
	function insertActivity($detailsArr){
		$insert	=	$this->db->insert('tbl_strategy_activities',$detailsArr);
		
		$return	=	false;
		
		if($insert){
			$return	=	$this->db->insert_id();
		}
		
		return $return;
	}
	//----------------------------------------------------------------------------------------------
	

   /**
	*This function 'll get the activity details details by strategy id and activity id
	*
	* @access public
	* @params int strategy_id
	* @params int strategy_activity_id
	* @return array details
	*/	
	
	function getActivityDetails($strategy_id, $strategy_activity_id){
		$this->db->select('*');
		$this->db->where('strategy_id',$strategy_id);
		$this->db->where('strategy_activity_id',$strategy_activity_id);
		$query	=	$this->db->get('tbl_strategy_activities');
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();		
		}
		
		return $resultArr;
	}
	//----------------------------------------------------------------------------------------------
	

   /**
	*This function 'll update an activity
	*
	* @access public
	* @params int strategy_id
	* @params int strategy_activity_id
	* @params array details
	* @return boolean true/false
	*/	
	
	function updateActivity($strategy_id,$strategy_activity_id,$detailsArr){
		$this->db->where('strategy_id',$strategy_id);
		$this->db->where('strategy_activity_id',$strategy_activity_id);
		$update	=	$this->db->update('tbl_strategy_activities',$detailsArr);
		
		$return	=	false;
		
		if($update){
			$return	=	true;
		}
		
		return $return;
	}
	//----------------------------------------------------------------------------------------------
	

   /**
	*This function 'll delete an activity
	*
	* @access public
	* @params int strategy_id
	* @params int strategy_activity_id
	* @return boolean true/false
	*/	
	
	function deleteActivity($strategy_id,$strategy_activity_id){
		$this->db->where('strategy_id',$strategy_id);
		if(is_array($strategy_activity_id)){
			$this->db->where_in('strategy_activity_id',$strategy_activity_id);
		}else{
			$this->db->where('strategy_activity_id',$strategy_activity_id);
		}
		
		$delete	=	$this->db->delete('tbl_strategy_activities');
		
		$return	=	false;
		
		if($delete){
			$return	=	true;
		}
		
		return $return;
	}
	//----------------------------------------------------------------------------------------------
	
	 /**
	*This function 'll delete a strategy
	*
	* @access public
	* @params int vision_id
	* @params int strategy_id
	* @return boolean true/false
	*/	
	
	function deleteStrategy($plan_id,$strategy_id){
		$this->db->where('plan_id',$plan_id);
		$this->db->where('strategy_id',$strategy_id);
		$delete	=	$this->db->delete('tbl_strategy');
		
		$return	=	false;
		
		if($delete){
			$return	=	true;
		}
		
		return $return;
	}
	//----------------------------------------------------------------------------------------------
	

   /**
	*This function 'll get the children of an activity
	*
	* @access public
	* @params int vision_id
	* @return text children
	*/	
	
	function getActivityChildren($strategy_activity_id){
		$this->db->select('children');
		$this->db->where('strategy_activity_id',$strategy_activity_id);
		$query	=	$this->db->get('tbl_strategy_activities');
		
		$children	=	'';
		
		if($query->num_rows() > 0){
			$childrenArr	=	$query->row_array();
			$children		=	$childrenArr['children'];
		}
		
		return $children;
	}
	//----------------------------------------------------------------------------------------------
	

   /**
	*This function 'll update the children of an activity
	*
	* @access public
	* @params int strategy_activity_id
	* @params text children
	* @return boolean true/false
	*/	
	
	function updateActivityChildren($strategy_activity_id,$updateArr){
		$this->db->where('strategy_activity_id',$strategy_activity_id);
		$update	=	$this->db->update('tbl_strategy_activities',$updateArr);
		
		$return	=	false;
		
		if($update){
			$return	=	true;
		}
		
		return $return;
	}
	//----------------------------------------------------------------------------------------------
	

   /**
	*This function 'll get the parent of an activity
	*
	* @access public
	* @params int vision_id
	* @return text children
	*/	
	
	function getParentByActivity($strategy_activity_id){
		$this->db->select('parent_activity_id');
		$this->db->where('strategy_activity_id',$strategy_activity_id);
		$query	=	$this->db->get('tbl_strategy_activities');
		
		$parent_activity_id	=	0;
		
		if($query->num_rows() > 0){
			$detailsArr				=	$query->row_array();
			$parent_activity_id		=	$detailsArr['parent_activity_id'];
		}
		
		return $parent_activity_id;
	}
	//----------------------------------------------------------------------------------------------
	
	

   /**
	*This function 'll get the strategy details details by strategy id
	*
	* @access public
	* @params int vision_id
	* @return array details
	*/	
	
	function getStrategyDetailsByPlanId($plan_id){
		$this->db->select('*');
		$this->db->where('plan_id',$plan_id);
		$query	=	$this->db->get('tbl_strategy');
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->row_array();		
		}
		
		return $resultArr;
	}
	
	//----------------------------------------------------------------------------------------------
	
	

   /**
	*This function 'll get the strategy activity name 
	*
	* @access public
	* @params int strategy_id
	* @return strategy activity name, parent_activity_id
	*/	
	
	function getStrategyActivityName($strategyId){
		
		$return = false;
		
		$this->db->select('activity_name, parent_activity_id');
		$this->db->where('strategy_id', $strategyId);
		$query = $this->db->get('tbl_strategy_activities');
		$data = $query->result_array();
		if(!$query){
			$return = false;
		}else{
			$return =  $data;
		}
		
		return $return;
	}
}