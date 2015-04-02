<?php
class Project_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
						
	}
	
	//----------------------------------------------------------------------------------------------
	

   /**
	*This function 'll insert a new user
	*
	* @access public
	* @params array details
	* @return boolean true/false
	*/	
	
	function insertProject($detailsArr){
		
		$project_name 			=	$detailsArr['project_name'];
		$project_description 	= 	$detailsArr['project_description'];
		$school_user_id 		= 	$detailsArr['school_user_id'];
		$project_class 			= 	$detailsArr['project_class'];
		$project_subject 		= 	$detailsArr['project_subject'];
		$project_amount 		= 	$detailsArr['project_amount'];
		$project_date_needed	= 	$detailsArr['project_date_needed'];
		$fund_start_date 		=	$detailsArr['fund_start_date'];
		$fund_end_date 			=	$detailsArr['fund_end_date'];
		$school_id				=	$detailsArr['school_id'];
		
		if(isset($detailsArr['image_small']) && isset($detailsArr['image_medium']) && isset($detailsArr['image_large'])){
			
			$image_small	= 	$detailsArr['image_small'];
			$image_medium	= 	$detailsArr['image_medium'];
			$image_large	= 	$detailsArr['image_large'];
			
			$query			= "INSERT INTO tbl_projects";
			$query 			.= " (project_name,project_description,school_user_id,project_class,project_subject,project_amount,project_date_needed,fund_start_date,fund_end_date,image_small,image_medium,image_large,school_id) VALUES ('$project_name','$project_description','$school_user_id','$project_class','$project_subject','$project_amount','$project_date_needed','$fund_start_date','$fund_end_date','$image_small','$image_medium','$image_large','$school_id')";
			}else{
				
				$query			= "INSERT INTO tbl_projects";
				$query 			.= " (project_name,project_description,school_user_id,project_class,project_subject,project_amount,project_date_needed,fund_start_date,fund_end_date,school_id) VALUES ('$project_name','$project_description','$school_user_id','$project_class','$project_subject','$project_amount','$project_date_needed','$fund_start_date','$fund_end_date','$school_id')";
				
			}
	 	$query 			= $this->db->query($query);
												
		$return	=	false;
		
		if($query){
			$return	= $this->db->insert_id();
		}
		
		return $return;
	}
	//----------------------------------------------------------------------------------------------
	

   /**
	*This function 'll get the project list
	*
	* @access public
	* @return array details
	*/	
	
	function getProjectDetails(){
		$this->db->select('*');
		$query	=	$this->db->get('tbl_projects');
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
	}
	
	//----------------------------------------------------------------------------------------------
	

   /**
	*This function 'll get image name
	*
	* @access public
	* @params int user_id
	* @params varchar project_image
	* 
	*/	
	
	function getProjectImageName($project_id){
		$this->db->select('image_medium');
		$this->db->where('project_id',$project_id);
		$query	=	$this->db->get('tbl_projects');
		
		$project_image	=	'';
		
		if($query->num_rows() > 0){
			$resultArr		=	$query->row_array();
			$project_image	=	$resultArr['image_medium'];		
		}
		
		echo $project_image;
	}
	
	//----------------------------------------------------------------------------------------------
	

   /**
	*This function 'll get school name
	*
	* @access public
	* @params int user_id
	* @params varchar project_image
	* 
	*/	
	
	function getAllSubjectName(){
		$this->db->select('project_subject');
		$query	=	$this->db->get('tbl_projects');
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr		=	$query->result_array();	
		}
		return $resultArr;
	}
		
	//----------------------------------------------------------------------------------------------
	

   /**
	*This function 'll get project subject 
	*
	* @access public
	* @params int subject_name
	* @params varchar resultArr
	* 
	*/	
	function selectProjectBySubject($subject_name){
		$this->db->select('*');
		$this->db->where('project_subject',$subject_name);
		$query	=	$this->db->get('tbl_projects');
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
		
	}
	
	//----------------------------------------------------------------------------------------------
	

   /**
	*This function 'll get the project list
	*
	* @access public
	* @return array details
	*/	
	
	function getProjectDetailsById($project_id){
		$this->db->select('*');
		$this->db->where('project_id',$project_id);
		$this->db->limit(1);
		$query	=	$this->db->get('tbl_projects');
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
	}
	
	//----------------------------------------------------------------------------------------------
   /**
	*This function 'll get the project list
	*
	* @access public
	* @return array details
	*/
	function getSchoolId($logged_in_user_id){
		$this->db->select('*');
		$this->db->where('user_id', $logged_in_user_id);
		
		$query	=	$this->db->get('tbl_teachers');
		
		$resultArr	=	array();
		
		if($query->num_rows() > 0){
			$resultArr	=	$query->result_array();		
		}
		
		return $resultArr;
		
	}
	
	
}

?>