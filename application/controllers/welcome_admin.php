<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class welcome_admin extends CI_Controller {

	public function __construct(){
		parent:: __construct();
		if(!$this->session->userdata('logged_in')) {
            redirect(base_url());
        }
		$this->load->model('Admin_model');
		$this->load->model('Schedule_model');
		
	}
	
	public function index(){		
		$this->load->view('template/header');
		$data = array(
			'faculty' => $this->Admin_model->faculty_count(),
			'faculty_on' => $this->Admin_model->faculty_count2(),
			'faculty_off' => $this->Admin_model->faculty_count3(),
			'department' => $this->Admin_model->department_count(),
			'department_on' => $this->Admin_model->department_count2(),
			'department_off' => $this->Admin_model->department_count3(),
			'subjects' => $this->Admin_model->subjects_count(),
			'subjects_on' => $this->Admin_model->subjects_count2(),
			'subjects_off' => $this->Admin_model->subjects_count3(),
			'rooms' => $this->Admin_model->rooms_count(),
			'sections' => $this->Admin_model->section_count(),
			'courses' => $this->Admin_model->course_count()
		);
		$this->load->view('adminDashboards/admin', $data);
		$this->load->view('template/footer');
	}

	//FACULTY//
	public function facsub(){
		$subject['sub'] = $this->input->post('sub_list');
		foreach($subject['sub'] as $subjid){
			$data = $this->Admin_model->facsub($subjid);	
		}
		echo json_encode($data);
	}

	public function faculty(){
		$data['data'] = $this->Admin_model->view_faculty();
		$data['department'] = $this->Admin_model->view_department();
		$data['subjects'] = $this->Admin_model->view_subjects();
		$data['position'] = $this->Admin_model->view_position();
		$this->load->view('template/header');
		$this->load->view('data/faculty',$data);
		$this->load->view('template/footer');		
	}
	
	public function viewFaculty($id){
		$data['data'] =$this->Admin_model->view_faculty_name($id);
		$data['info'] =$this->Admin_model->view_faculty_info($id);
		$data['info2'] =$this->Admin_model->view_faculty_info2($id);
		$data['info3'] =$this->Admin_model->view_faculty_info3($id);
		$data['department'] = $this->Admin_model->view_department();

		$data['subjects'] = $this->Admin_model->view_faculty_subjects($id);
		
		$data['position'] = $this->Admin_model->view_position();
		$data['day'] = $this->Admin_model->view_faculty_day();
		$this->load->view('template/header');
		$this->load->view('adminDashboards/viewFaculty',$data);
		$this->load->view('template/footer');
	}
	public function facushift(){
		$day = $this->input->post('day');
		$result = $this->Admin_model->view_faculty_shift($day);
		if(count($result)>0){
			$data = '';
			$data .= '<option value="">Select Shift</option>';
			foreach($result as $rows ){
				$data .= '<option value="'.$rows->Shift.'">'.$rows->Shift.'</option>';
			}
			echo $data;
		}

	}

	public function facutime(){
		$id = $this->input->post('tid');
		$day = $this->input->post('day');
		$shift = $this->input->post('shift');
		$result = $this->Admin_model->view_faculty_time2($id, $day, $shift);
		if(count($result)>0){
			$data = '';
			foreach($result as $rows ){
				$data .= 
				'<option value="'.$rows->TimeID.'">'.$rows->Time.'</option>';
			}
			echo $data;
		}

	}

	public function addFaculty(){
		$response = array();
		$this->form_validation->set_rules('fname', 'First Name', 'required');
		$this->form_validation->set_rules('mname', 'Middle Name', 'required');
		$this->form_validation->set_rules('lname', 'Last Name', 'required');
		if ($this->form_validation->run() == TRUE) {
			$data = $this->Admin_model->add_faculty();
			$response['status'] = TRUE;
			$response[] = $data;
		}
		else {
			$response['status'] = FALSE;
	    	$response['notif']	= validation_errors();
		}
		echo json_encode($response);    
	}

	public function editFaculty(){
		$response = array();
		$this->form_validation->set_rules('fname', 'First Name', 'required');
		$this->form_validation->set_rules('mname', 'Middle Name', 'required');
		$this->form_validation->set_rules('lname', 'Last Name', 'required');
		if ($this->form_validation->run() == TRUE) {
			$data = $this->Admin_model->edit_faculty();
			$response['status'] = TRUE;
			$response[] = $data;
		}
		else {
			$response['status'] = FALSE;
	    	$response['notif']	= validation_errors();
		}
		echo json_encode($response);    
	}

	public function activateFaculty($id){
		
	    $this->Admin_model->act_faculty($id);
	    redirect('welcome_admin/faculty');
	}

	public function deleteFaculty($id){
		
	    $this->Admin_model->del_faculty($id);
	    redirect('welcome_admin/faculty');
	}

	//DEPARTMENT//
	public function department(){
		$data['department'] = $this->Admin_model->view_department();
		$data['subjects'] = $this->Admin_model->view_subjects();
		$this->load->view('template/header');
		$this->load->view('data/department',$data);
		$this->load->view('template/footer');	
	}

	public function addDepartment(){
		$response = array();
		$this->form_validation->set_rules('depname', 'Department Name', 'required|is_unique[department.DepartmentName]',array(
			'is_unique' => '%s already exist!'));
		$this->form_validation->set_rules('depcode', 'Department Code', 'required|is_unique[department.DepartmentCode]',array(
			'is_unique' => '%s already exist!'));
		if ($this->form_validation->run() == TRUE) {
			$data = $this->Admin_model->add_department();
			$response['status'] = TRUE;
			$response[] = $data;
		}
		else {
			$response['status'] = FALSE;
	    	$response['notif']	= validation_errors();
		}
		echo json_encode($response);    
	}

	public function editDepartment(){
		$response = array();
		$this->form_validation->set_rules('depname', 'Department Name', 'required');
		$this->form_validation->set_rules('depcode', 'Department Code', 'required');
		if ($this->form_validation->run() == TRUE) {
			$data = $this->Admin_model->edit_department();
			$response['status'] = TRUE;
			$response[] = $data;
		}
		else {
			$response['status'] = FALSE;
	    	$response['notif']	= validation_errors();
		}
		echo json_encode($response);    
	}

	public function get_department(){
		$data['department'] = $this->Admin_model->view_department_name($_GET['DepartmentID']);
		echo json_encode($data);
	}


	public function activateDepartment($id){
	    $this->Admin_model->act_department($id);
	    redirect('welcome_admin/department');
	}

	public function deleteDepartment($id){
	    $this->Admin_model->del_department($id);
	    redirect('welcome_admin/department');
	}

	//SUBJECT//

	public function get_subjects(){
		$data['subject'] = $this->Admin_model->view_subjects_name($_GET['SubjectID']);
		echo json_encode($data);
	}

	public function subjects(){
		$data['data'] = $this->Admin_model->view_faculty();
		// $data['data2'] =$this->Admin_model->view_subjects_name($_GET['id']);
		$data['department'] = $this->Admin_model->view_department();
		$data['subject'] = $this->Admin_model->view_subjects();
		$data['position'] = $this->Admin_model->view_position();
		$this->load->view('template/header');
		$this->load->view('data/subjects',$data);
		$this->load->view('template/footer');		
	}

	public function addSubject(){
		$response = array();
		$this->form_validation->set_rules('subj_code', 'Subject Code', 'required|is_unique[subject.SubjectCode]',array(
			'is_unique' => '%s already exist!'));
		$this->form_validation->set_rules('subj_name', 'Subject Name', 'required|alpha_numeric_spaces|is_unique[subject.SubjectName]',array(
			'is_unique' => '%s already exist!'));
		$this->form_validation->set_rules('units', 'No. of units', 'required|numeric');
		$this->form_validation->set_rules('hrs', 'No. of hours', 'required|numeric');
		if ($this->form_validation->run() == TRUE) {
			$data = $this->Admin_model->add_subject();
			$response['status'] = TRUE;
			$response[] = $data;
		}
		else {
			$response['status'] = FALSE;
	    	$response['notif']	= validation_errors();
		}
		echo json_encode($response);    
	}

	public function editSubject(){		
	    $response = array();
		$this->form_validation->set_rules('subj_code', 'Subject Code', 'required');
		$this->form_validation->set_rules('subj_name', 'Subject Name', 'required|alpha_numeric_spaces');
		$this->form_validation->set_rules('units', 'No. of units', 'required|numeric');
		$this->form_validation->set_rules('hrs', 'No. of hours', 'required|numeric');
		if ($this->form_validation->run() == TRUE) {
			$data = $this->Admin_model->edit_subject();
			$response['status'] = TRUE;
			$response[] = $data;
		}
		else {
			$response['status'] = FALSE;
	    	$response['notif']	= validation_errors();
		}
		echo json_encode($response);    
	}

	public function deleteSubject($id){
		
	    $this->Admin_model->del_subject($id);
	    redirect('welcome_admin/subjects');
	}

	public function activateSubject($id){
		
	    $this->Admin_model->act_subject($id);
	    redirect('welcome_admin/subjects');
	}

	// public function getSubject(){
	// 	$id = $_POST['id']; 
	// 	$response = $this->Admin_model->edit_subjects($id);
	// 	echo json_encode($response);    
	// }
	//SUBJECT//

	//SECTION//


	//COURSES//
	public function courses(){
		$data['data'] = $this->Admin_model->view_courses();
		$data['department'] = $this->Admin_model->view_department();
		$this->load->view('template/header');
		$this->load->view('data/courses',$data);
		$this->load->view('template/footer');
	}

	public function viewSched(){
		$this->load->view('template/header');
		$this->load->view('adminDashboards/view_schedule');
		$this->load->view('template/footer');
	}


	//ROOMS//
	public function rooms(){
		$data['room'] =$this->Admin_model->view_room_name();
		$data['dep_list'] = $this->Admin_model->departments();
		$data['list'] = $this->Admin_model->list_room();
		$this->load->view('template/header');
		$this->load->view('data/rooms',$data);
		$this->load->view('template/footer');
	}
			
	public function viewroomSched($id){
		$data['room'] = $this->Admin_model->room_name($id);
		$data['hey'] = $this->Admin_model->view_room_schedule($id);
		$this->load->view('template/header');
		$this->load->view('data/displayroom',$data);
		$this->load->view('template/footer');
	}

	public function add_room(){
		$response = array();
		$this->form_validation->set_rules('room_no', 'Room No', 'required|is_unique[room.RoomNo]');
		if ($this->form_validation->run() == TRUE) {
			$data = $this->Admin_model->add_room();
			$response['status'] = TRUE;
			$response[] = $data;
		}
		else {
			$response['status'] = FALSE;
	    	$response['notif']	= validation_errors();
		}
		echo json_encode($response);
	}

	public function delete_sec($id){
		$this->Admin_model->delete_sec($id);
		if($result){
			$this->session->set_flashdata('success_msg', 'Record deleted successfully');
		}else{
			$this->session->set_flashdata('error_msg', 'Fail to delete record');
		}
	    redirect('welcome_admin/section');
	}


	public function delete_subj()
    {
        $ids = $this->input->post('ids');
 
        $this->db->where_in('subjectLID', explode(",", $ids));
        $this->db->delete('subject_list');
 
        echo json_encode(['success'=>"Item Deleted successfully."]);
    }
    //TIME

    public function timetime(){
    	if(isset($_POST['day'])){
    		$output = '';
    		if($_POST["action"] == 'shift'){
				$query = $this->Admin_model->view_faculty_shift();
    		}
    	}
    }

    public function factime(){
		$time['time'] = $this->input->post('time_list');
		foreach($time['time'] as $timeid){
			$data = $this->Admin_model->factime($timeid);
		}
		echo json_encode($data);
	}

    public function delete_time()
    {
        $ids = $this->input->post('ids');
 
        $this->db->where_in('TimeLID', explode(",", $ids));
        $this->db->delete('time_list');
 
        echo json_encode(['success'=>"Item Deleted successfully."]);
    }
	
	//POLICY
    public function policy(){
		$data['data'] = $this->Admin_model->view_policy();
		$this->load->view('template/header');
		$this->load->view('policy',$data);
		$this->load->view('template/footer');
    }


    public function editPolicy(){
		$response = array();
		$postData = $this->input->post();
		$this->form_validation->set_rules('pure', 'Pure Teaching', 'required|numeric');
		$this->form_validation->set_rules('admin', 'Administrative', 'required|numeric');
		$this->form_validation->set_rules('ext', 'Research and Extension', 'required|numeric');
		$this->form_validation->set_rules('head', 'Head', 'required|numeric');
		$this->form_validation->set_rules('semester', 'Semester', 'required|alpha_numeric_spaces');
		$this->form_validation->set_rules('morning', 'Morning', 'required|numeric');
		$this->form_validation->set_rules('afternoon', 'Afternoon', 'required|numeric');
		if ($this->form_validation->run() == TRUE) {
			$data = $this->Admin_model->edit_policy($postData);
			$response['status'] = TRUE;
			$response[] = $data;
		}
		else {
			$response['status'] = FALSE;
	    	$response['notif']	= validation_errors();
		}
		echo json_encode($response); 
    }

    public function section(){
		$data['data'] = $this->Admin_model->view_section();
		$data['department'] = $this->Admin_model->view_department();
		$data['course'] = $this->Admin_model->view_course();
		$this->load->view('template/header');
		$this->load->view('data/section',$data);
		$this->load->view('template/footer');
	}

	public function viewsectionSched($id){
		// $data['section'] = $this->Admin_model->section_name($id);
		$data['hey'] = $this->Admin_model->view_sec_schedule($id);
		$this->load->view('template/header');
		$this->load->view('data/displaysection',$data);
		$this->load->view('template/footer');
	}

	public function addSection(){
		$response = array();
		$postData = $this->input->post();
		$this->form_validation->set_rules('schyr', 'School Year', 'required|min_length[9]',array(
			'min_length' => 'Must input school year (ex: 2015-2016)'));
		if ($this->form_validation->run() == TRUE) {
			$data = $this->Admin_model->add_section($postData);
			if($data['status'] == 'success'){
				$response['status'] = FALSE;
	  		  	$response['notif']	= array('Section already exists!');
			}
			else{
				$response['status'] = TRUE;
				$response[] = $data;
			}
		}
		else {
			$response['status'] = FALSE;
	    	$response['notif']	= validation_errors();
		}
		echo json_encode($response);
	}


        //GENERATE//

	public function schedd(){
		$sched = $this->Schedule_model->getSched();
		$data = count($sched);
		echo json_encode($data);
	}

	public function delete_sched(){
		$data = $this->Schedule_model->delete_sched();
		echo json_encode($data);
	}


	public function gen_Sched(){
		
		$this->load->view('template/header');
		$this->load->view('Scheduler/generate_sched');
		$this->load->view('template/footer');
	}

	//START OF GENERATION
	public function generate(){
		$data = array();
    	$ssr =$this->input->post('ssr');
    	$mpv = $this->input->post('mpv');
    	$msr = $this->input->post('msr');
    	$cpr = $this->input->post('cpr');
    	$cpor = $this->input->post('cpor');
    	$schedule = $this->Schedule_model->getSched();
		$sched = $this->Schedule_model->curriculum();
		$schednum = count($sched);
		$dataIndex = $this->input->post('datai');
		$previndex = $dataIndex;
		$mutrand = 0;
		$crosrand = 0;
		for($index=0; $index != $ssr; $index++){
			$SchedArray = $this->initPop($dataIndex);									
			$dataIndex = $this->checkfitness($SchedArray,$dataIndex);
			if($dataIndex == $previndex){
				$mutrand = rand($mpv,100);
				if($mutrand == 100){

				}	
			}
			$crosrand = rand($cpr,100);
			if($crosrand == 100){

			}
		}

		$data['dataindex'] = $dataIndex;
		$data['term'] = $schednum;
		echo json_encode($data);
		
	}

/*
	//MUTATION//
	public function mutation(){
		$schedule = $this->Schedule_model->getSched();

	}

	//CROSSOVER//
	public function crossover(){

	}
*/

	//INITIAL POPULATION
	public function initPop($dataIndex){
		$data = $this->Schedule_model->curriculum();
		$schedname = $this->schedname($data,$dataIndex);
		$room = $this->Schedule_model->getRoom();
		$time = $this->Schedule_model->time();
		$endtime = $this->getEndtime($time,$data,$dataIndex);
		$day = $this->Schedule_model->day();
		$faculty = $this->Schedule_model->faculty();
		$facsubject = $this->facsubject($faculty);
		$SchedArray = array($schedname,$time[0],$endtime,$day[0],$room[0],$faculty[0],$facsubject,$data[$dataIndex]);
		return $SchedArray;

	}

	public function checkfitness($data,$index){
		$fitno = 0;
		$fitno += $this->checkTimeConflict($data);
		$fitno += $this->checkRoomType($data);
		//$fitno += $this->facultysubcode($data);
		$fitno += $this->checkfactimeconflict($data);
		$fitno += $this->SectionTimeShift($data);
		$fitno += $this->checkDeptCodeFitness($data);
		$fitno += $this->checkFacPolicy($data);
		//$fitno += $this->breaktime($data);
		if($fitno == 6){
			$this->insert($data);
			$index += 1;
			return $index;
		}else{
			return $index;
		} 
	}

	

	public function checkFacPolicy($data){
		$sched = $this->Schedule_model->getSched();
		$facPure = $this->Schedule_model->policyFacPure();
		$facHead = $this->Schedule_model->policyFacHead();
		$varhr = 0;
		if($data[7]['LecUnits']!=0 || $data[7]['LecUnits'] != NULL ){
			$varhr = $data[7]['LabHours'];
		}else{
			$varhr = $data[7]['LecHours'];
		}
		$maxHrs = 0;
		if(!$sched){
			return 1;
		}

		foreach($sched as $key=>$value){
			if($sched[$key]['SchedProf'] == $data[5]['ProfID']){
				$maxHrs += $sched[$key]['SubjectHours']+$varhr;
			}
		}
		
		if($data[5]['PositionCode'] == "1"){
			if($maxHrs > $facHead[0]['policyValue']){
				return 0;
			}else{
				return 1;
			}
		}else{
			if($maxHrs > $facPure[0]['policyValue']){
				return 0;
			}else{
				return 1;
			}
			
		} 
	}

	public function SectionTimeShift($data){
		$start = explode(":", $data[1]['Time']);
		$endtime = explode(":",$data[2]['EndTime']);
		if($data[7]['SectionCode'] == "A"){
			if($endtime[0] <= "12"){
				return 1;
			}else{
				return 0;
			}
		}else if($data[7]['SectionCode'] == "B"){
			if($endtime[0] >= "12" && $start[0] >="12"){
				return 1;
			}else{
				return 0;
			}
		}else{
			return 0;
		}	
	}

/*
	public function preftime($data){
		if($data[5]['ProfID'] == ){

		}
	}
*/

	public function checkTimeConflict($newsched){
		$schedule = $this->Schedule_model->getSched();
		$schedsnew = explode(":",$newsched[1]['Time']);
		$schedenew = explode(":",$newsched[2]['EndTime']);
		if(!$schedule){
			return 1;
		}
		foreach($schedule as $key=>$value){
			if($schedule[$key]['SchedRoom'] == $newsched[4]['RoomNo']){
				if($schedule[$key]['SchedDays'] == $newsched[3]['Day']){
					$schedstart = explode(":",$schedule[$key]['SchedTime']);
					$schedend = explode(":",$schedule[$key]['SchedEnd']);
					if( /*$schedsnew[0] > $schedstart[0] && $schedenew[0] < $schedend[0] ||*/ 
						$schedsnew[0] >= $schedstart[0] && $schedenew[0] >= $schedend[0] && $schedsnew[0] <= $schedend[0] || 
						$schedsnew[0] <= $schedstart[0] && $schedenew[0] <= $schedend &&  $schedenew[0] >= $schedstart[0] ){
						return 0;
					}
				}
			}	
		}

		return 1;

	}	

	public function checkfactimeconflict($data){
		$sched = $this->Schedule_model->getSched();
		$schedstartnew = explode(":",$data[1]['Time']);
		$schedendnew = explode(":",$data[2]['EndTime']);
		if(!$sched){
			return 1;
		}
		foreach($sched as $key=>$value){
			if($sched[$key]['SchedProf'] == $data[5]['ProfID']){
				if($sched[$key]['SchedDays'] == $data[3]['Day']){
					$schedstart = explode(":",$sched[$key]['SchedTime']);
					$schedend = explode(":",$sched[$key]['SchedEnd']);
					if( /*$schedstartnew[0] > $schedstart[0] && $schedendnew[0] < $schedend[0] ||*/ 
						$schedstartnew[0] >= $schedstart[0] && $schedendnew[0] >= $schedend[0] && $schedstartnew[0] <= $schedend[0] || 
						$schedstartnew[0] <= $schedstart[0] && $schedendnew[0] <= $schedend &&  $schedendnew[0] >= $schedstart[0] ){
						return 0;
					}
				}
			}
		}
		return 1;
	}

	//SCHED NAME MAKER
	public function schedname($data,$index){
		$first = $data[$index]['SubjectDeptCode'];
		$sec = $data[$index]['CourseCode'];
		if($data[$index]['Year'] == "1st Year"){
			$digit = "1";
		}else if($data[$index]['Year'] == "2nd Year"){
			$digit = "2";
		}else if($data[$index]['Year'] == "3rd Year"){
			$digit = "3";
		}else{
			$digit = "4";
		}
		$thi = $data[$index]['SectionCode'];
		$fou = $data[$index]['SubjectCode'];
		return $first."-".$sec.$digit.$thi."-".$fou;
	}

	public function facsubject($data){
		$subarr = $this->Schedule_model->facultysub();
		$newarr = array();
		foreach($subarr as $key=>$value){
			if($subarr[$key]['ProfID'] == $data[0]['ProfID']){
				array_push($newarr,$subarr[$key]['SubjectCode']);
			}
		}
		return $newarr;
	}

	//END TIME CALCULATOR
	public function getEndtime($time,$sched,$index){
		$newtime[] = explode(":",$time[0]['Time']);
		$shift = $newtime[0][0];
		if($sched[$index]['SubjectType'] == "Lecture"){
			$newtime[0][0] = $newtime[0][0]+$sched[$index]['LecHours'];
		}else{
			$newtime[0][0] = $newtime[0][0]+$sched[$index]['LabHours'];
		}
		$endtime['EndTime'] = implode(":",$newtime[0]);
		if($shift < "12"){
			$endtime['Shift'] = "Morning";
		}else{
			$endtime['Shift'] = "Afternoon";
		}
		return $endtime;
	}


	public function insert($Sched){
		$this->Schedule_model->insert($Sched);
	}


/*	public function facultysubcode($data){
		foreach($data[6] as $key=>$value){
			if($data[$key] == $data[7]['SubjectCode']){
				return 1;
			}
		}
	}
*/
	public function checkDeptCodeFitness($data){
		if($data[5]['DepartmentCode'] == $data[7]['SubjectDeptCode']){
			return 1;
		}else{
			return 0;
		}
	}

	public function checkRoomType($sched){
		///YOW NILAGAY ko LANG UNG '1' PARA GAGANA PAG NILOAD SA BROWSER
		//if(){
			if($sched[4]['DepartmentCode'] == $sched[7]['SubjectDeptCode']){	
				if($sched[4]['RoomType'] == $sched[7]['SubjectType']){
					return 1;
				}else{
					return 0;
				}
			}
		//}
	}


		

	public function breaktime($newSched){
	//	$Schedule = $this->Schedule_model->getSched();
		$start = explode(":",$newSched[1]['Time']);
		$end = explode(":",$newSched[2]['EndTime']);
	//	foreach($Schedule as $key=>$value){
	//		if($newSched[3]['Day'] == $Schedule[$key]['SchedDays']){
				if($start[0] > "11" && $end[0] < "12"){
					return 0;
				}else if($start[0] > "12" && $end[0] < "1"){
					return 0;
				}else{
					return 1;
				}
			//}
		//}	
	}

	public function range()
    {
    	$mpv = $this->input->post('mpv');
    	$msr = $this->input->post('msr');
    	$cpr =$this->input->post('cpr');
    	$cpor = $this->input->post('cpor');
    	$ssr =$this->input->post('ssr');
    	$gir = $this->input->post('gir');
    	
    }

    public function read_schedule()
    {
    	$data['department'] = $this->Admin_model->department();
		$data['fac_name'] = $this->Admin_model->faculty_name();
		$data['faculty'] = $this->Admin_model->faculty_name_default();
		$data['sched'] = $this->Admin_model->view_sched_default();
		$data['math'] = $this->Admin_model->math();
		$data['phys'] = $this->Admin_model->physics();
		$data['chem'] = $this->Admin_model->chemistry();
    	$this->load->view('template/header');
		$this->load->view('adminDashboards/read_schedule',$data);
		$this->load->view('template/footer');
    }

    public function schedule($id){
		$data['department'] = $this->Admin_model->department();
		$data['sched'] = $this->Admin_model->view_prof_sched($id);
		$data['faculty'] = $this->Admin_model->faculty_name_2($id);
		$data['fac_name'] = $this->Admin_model->faculty_name();
		$data['math'] = $this->Admin_model->math();
		$data['phys'] = $this->Admin_model->physics();
		$data['chem'] = $this->Admin_model->chemistry();
		$this->load->view('template/header');
		$this->load->view('adminDashboards/read_schedule',$data);
		$this->load->view('template/footer');
	}
	
}
