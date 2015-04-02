<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends CI_Controller {
	
	function __construct(){		
		parent::__construct();
		
		$this->logged_in			=	$this->quickauth->is_logged_in();
		$this->logged_in_user		=	$this->quickauth->logged_in_user();
		$this->logged_in_username	=	$this->quickauth->logged_in_username();
		$this->logged_in_user_role	=	$this->quickauth->logged_in_user_role();
		$data						=	array();	
		$this->load->model('user_model','user');
		$this->load->model('project_model','project');
		
		
	}
	//----------------------------------------------------------------------------------------------
	

   /**
	*This function is the index function which loads the project page
	*
	* @access public
	* @return view to user management page
	*/	
	
	public function index(){
		
		if(!$this->logged_in){
			redirect(base_url());
		}
				
		$data['logged_in']			=	$this->logged_in;
		$data['logged_in_user']		=	$this->logged_in_user;
		$data['logged_in_username']	=	$this->logged_in_username;
		$data['logged_in_user_role']=	$this->logged_in_user_role;
		
		$data['Page_title']			=	'Project';
		$data['Page_name']			=	'Manage Project';
		
	}
	
	//----------------------------------------------------------------------------------------------
	

   /**
	*This function loads the registration page
	*
	* @access public
	* @return view to registration page
	*/	
	
	function addProject(){
		
		
		if(!$this->logged_in){
			redirect(base_url());
		}
		
		$data['logged_in']			=	$this->logged_in;
		$data['logged_in_user']		=	$this->logged_in_user;
		$data['logged_in_username']	=	$this->logged_in_username;
		$data['logged_in_user_role']=	$this->logged_in_user_role;
		
		$data['Page_title']			=	'project';
		$data['Page_name']			=	'project Registration page';
				
		$this->load->view('project/project-register',$data);
	}
	
	//----------------------------------------------------------------------------------------------
	

   /**
	*This function inserts the project registration details
	*
	* @access public
	* @return redirect to login page after registration
	*/	
	
	function projectRegisterProcess(){
		
		
		$this->load->library('mailer');
		
		$project_name			=	trim($this->input->post('project_name'));
		$project_description	=	trim($this->input->post('project_description'));
		$project_class			=	trim($this->input->post('project_class'));
		$project_subject		=	trim($this->input->post('project_subject'));
		$project_amount			=	trim($this->input->post('project_amount'));
		$project_date_needed	=	$this->quickauth->convert_date_format(trim($this->input->post('project_date_needed')));
		$fund_start_date		=	$this->quickauth->convert_date_format(trim($this->input->post('project_fund_start')));
		$fund_end_date			=	$this->quickauth->convert_date_format(trim($this->input->post('project_fund_end')));
		
		$image_name  			= 	'profile_img';
		$tmp_name				= 	$_FILES[$image_name]['tmp_name'];
		
		$school_user_id			=	$this->logged_in_user;
		
		
		$logged_in_user_id	=	$this->logged_in_user;
		$school	=	$this->project->getSchoolId($logged_in_user_id);
		foreach($school as $val){
			$school_id	=	$val['school_id'];
		}
		
		
		
		if(!empty($tmp_name)){
			$image_large		=	$this->user->getBlobImageResize($image_name,250,250);		
			$image_medium		=	$this->user->getBlobImageResize($image_name,100,100);
			$image_small		=	$this->user->getBlobImageResize($image_name,50,50);
				
		$detailsArr		=	array(
								'project_name'			=>	$project_name,
								'project_description'	=>	$project_description,
								'school_user_id'		=>	$school_user_id,
								'project_class'			=>	$project_class,
								'project_subject'		=>	$project_subject,
								'project_amount'		=>	$project_amount,
								'project_date_needed'	=>	$project_date_needed,
								'fund_start_date'		=>	$fund_start_date,
								'fund_end_date'			=>	$fund_end_date,
								'image_small'			=>	$image_small,
								'image_medium'			=>	$image_medium,
								'image_large'			=>	$image_large,
								'school_id'				=>	$school_id
							);
		}else{
			
			$detailsArr		=	array(
								'project_name'			=>	$project_name,
								'project_description'	=>	$project_description,
								'school_user_id'		=>	$school_user_id,
								'project_class'			=>	$project_class,
								'project_subject'		=>	$project_subject,
								'project_amount'		=>	$project_amount,
								'project_date_needed'	=>	$project_date_needed,
								'fund_start_date'		=>	$fund_start_date,
								'fund_end_date'			=>	$fund_end_date,
								'school_id'				=>	$school_id
							);
		}
		$insert_id	=	$this->project->insertProject($detailsArr);
		
		
		if($insert_id){
			redirect(base_url().'login/index/3');
		}else{
			redirect(base_url().'login/register');
		}
	}
	//----------------------------------------------------------------------------------------------
	

   /**
	*This function browse the project 
	*
	* @access public
	* @return redirect to browse project page
	*/	
	
	function browseProject(){
		
		if(!$this->logged_in){
			redirect(base_url());
		}
		
		$data['logged_in']			=	$this->logged_in;
		$data['logged_in_user']		=	$this->logged_in_user;
		$data['logged_in_username']	=	$this->logged_in_username;
		$data['logged_in_user_role']=	$this->logged_in_user_role;
		
		$data['Page_title']			=	'Browse project';
		$data['Page_name']			=	'project browse page';	
		
		$projecDetailArr			=	$this->project->getProjectDetails();
		$data['project_details']	=	$projecDetailArr;
		
		$subjectDetailArr			=	$this->selectProjectSubjectCategory();
		$data['project_subject']	=	$subjectDetailArr;
		
		$this->load->view('project/browse-project',$data);
	}
	
	//----------------------------------------------------------------------------------------------
	

   /**
	*This function will display user profile img
	*
	* @access public
	* @param integer user_id
	* @return varchar img_name
	*/	
	function displayProjectImage($project_id){
		$img_name	=	$this->project->getProjectImageName($project_id);
		header("Content-type: image/jpeg");
		echo $img_name;
	}
	//----------------------------------------------------------------------------------------------
	

   /**
	*This function will display subject category
	*
	* @access public
	* @param integer subject_name
	* @return array subject_name
	*/	
	
	function selectProjectSubjectCategory(){
		$subject_name	= '';
		$subject_name	=	$this->project->getAllSubjectName();
		
		if($subject_name){
			return $subject_name;
		}
	}
	//----------------------------------------------------------------------------------------------
	

   /**
	*This function will display project based on subject
	*
	* @access public
	* @param integer subject_name
	* @return view subject_name
	*/	
	function sortProject($subject_name){
		$subjectNameArr	=	$this->project->selectProjectBySubject($subject_name);
		$data['project_details']	=	$subjectNameArr;
		$this->load->view('project/filter-project-view',$data);
		
	}
	//----------------------------------------------------------------------------------------------
	

   /**
	*This function will display project view
	*
	* @access public
	* @param integer project_id
	* @return view project
	*/	
	function viewProject($project_id){
		if(!$this->logged_in){
			redirect(base_url());
		}
		
		$data['logged_in']			=	$this->logged_in;
		$data['logged_in_user']		=	$this->logged_in_user;
		$data['logged_in_username']	=	$this->logged_in_username;
		$data['logged_in_user_role']=	$this->logged_in_user_role;
		
		$data['Page_title']			=	'Browse project';
		$data['Page_name']			=	'project browse page';	
		
		$projecDetailArr			=	$this->project->getProjectDetailsById($project_id);
		$data['project_details']	=	$projecDetailArr;
		
		$this->load->view('project/project-view',$data);
	}
	
}

?>