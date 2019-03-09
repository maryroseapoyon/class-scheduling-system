<?php

$level = '';
$semester = '';
$section = '';
$cour = '';
$depart = '';

$level .= '<option value="1st Year">1st Year</option>
           <option value="2nd Year">2nd Year</option>
           <option value="3rd Year">3rd Year</option>
           <option value="4th Year">4th Year</option>';
$semester .= '<option value="1st Semester">1st Semester</option>
              <option value="2nd Semester">2nd Semester</option>';

$section .= '<option value="A">A</option>
             <option value="B">B</option>';

foreach($course as $row){
	$cour .= '<option value="'.$row->CourseCode.'">'.$row->CourseName.'</option> ';
}
foreach($department as $row){ if($row->Status == 'A'){
	$depart .= '<option value="'.$row->DepartmentCode.'">'.$row->DepartmentName.'</option> ';
} }


?>
<!-- Header-->
  <div class="breadcrumbs">
    <div class="col-sm-4">
      <div class="page-header float-left">
        <div class="page-title">
            <h1>Section</h1>
        </div>
      </div>
    </div>
    <div class="col-sm-8">
      <div class="page-header float-right">
          <div class="page-title">
              <ol class="breadcrumb text-right">
                  <li><a href="<?php echo site_url('welcome_admin');?>">Home</a></li>
                  <li><a href="#">Data</a></li>
                  <li class="active">Section</li>
              </ol>
          </div>
      </div>
    </div>
  </div>

  <div class="content mt-3">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="default-tab">
            <nav>
              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link fa fa-plus" id="nav-home-tab" data-toggle="modal" title="Add Data" href="#addsection" role="tab" aria-controls="nav-home" aria-selected="true"></a>
                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#active" role="tab" aria-controls="nav-profile" aria-selected="false">Section List</a>
              </div>
            </nav>
              <div class="tab-content pl-3 pt-2" id="nav-tabContent">
		          <div class="row">
		            <!--TABLE+++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
		              <div class="col-md-12">
		                <div class="card">
		                  <div class="card-header">
		                      <strong class="card-title">Data Table</strong>
		                  </div>
		                  <div class="card-body">
		                    <table id="bootstrap-data-table" class="table table-striped table-bordered table-hover">
		                      <thead>
		                        <tr>
		                          <th>ID</th>
		                          <th>School Year</th>
		                          <th>Level</th>
		                          <th>Semester</th>
		                          <th>Section</th>
		                          <th>Action</th>
		                        </tr>
		                      </thead>
		                      <tbody>
		                         <?php
		                          if ($data!=NULL) {
		                            foreach ($data as $row) {
		                              ?>
		                                <tr>
		                                  <td><center><?php echo $row->SectionID; ?></center></td>
		                                  <td><center><?php echo $row->SectionSchoolYr; ?></center></td>
		                                  <td><center><?php echo $row->SectionYearLvl; ?></center></td>
		                                  <td><center><?php echo $row->SectionSemester; ?></center></td>
		                                  <td><center><?php echo $row->CourseCode.'-'.$row->SectionYearLvl[0].''.$row->SectionCode; ?></center></td>
		                                  <td><center>
                                          <a href="<?php echo site_url('welcome_admin/delete_sec/'.$row->SectionID.''); ?>" onclick="return confirm('Do you want to delete this record?');" class="btn btn-outline-danger" class="btn btn-outline-danger" style="padding: 2px 6px 2px;" title="Delete Section"><i class="fa fa-trash"></i> Delete</a>
                                          <a href="<?php echo site_url('welcome_admin/viewsectionSched/'.$row->CourseCode.''.$row->SectionYearLvl[0].''.$row->SectionCode.'') ?>" class="btn btn-outline-info" class="btn btn-outline-info" style="padding: 2px 6px 2px;" title="View Section"><i class="fa fa-eye"></i> View
                                          </a>
                                        </center></td>
		                                  
		                                </tr>
		                              <?php
		                          	}
		                        }
		                        ?>
		                        </tbody>
		                    </table>
		                  </div>
		                </div>
		              </div>
		            <!--TABLE++++++++++++++++++++++++++++++++++++++++++-->
		          </div>



<!--ADD FACULTY MODAL ++++++++++++++++++++++++++++++++++++++++++-->
  <div class="modal fade" id="addsection" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Section</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form class="form-horizontal">
          <div class="modal-body">
            <div class="form-group">
              <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show" align="center" style="display: none;"></div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-4">
              	<input type="text" id="schoolyr" name="schoolyr" placeholder="School Year (ex. 2015-2016) " class="form-control">
              </div>
              <div class="col-12 col-md-4">
                  <select name="scourse" id="scourse" class="form-control">
                    <option value="">Select Course</option>
                    <?php echo $cour ?>
                  </select>
              </div>
              <div class="col-12 col-md-4">
                  <select name="sdepcode" id="sdepcode" class="form-control" >
                    <option value="">Select Department</option>
                    <?php echo $depart ?>
                  </select>
              </div>    
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-4">
                  <select name="level" id="level" class="form-control">
                    <option value="">Select Level</option>
                    <?php echo $level ?>
                  </select>
              </div>
              <div class="col-12 col-md-4">
                  <select name="sem" id="sem" class="form-control">
                    <option value="">Select Semester</option>
                    <?php echo $semester ?>
                  </select>
              </div>
              <div class="col-12 col-md-4">
                  <select name="sect" id="sect" class="form-control" >
                    <option value="">Select Section</option>
                    <?php echo $section ?>
                  </select>
              </div>    
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-info" style="border-radius: 3px;" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-outline-info" style="border-radius: 3px;" id="btn_section" name="btn_section">Confirm</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<!--ADD FACULTY MODAL ++++++++++++++++++++++++++++++++++++++++++++-->
