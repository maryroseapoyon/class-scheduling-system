<?php
$policy = '';
$policy2 = '';
foreach($data as $row){
  $policy .= '<div class="col-12 col-md-4">'.
  '<label class="form-control-label col-12">'.$row->policyTitle. 
  '<input name="'.$row->policyName.'" class="form-control" id="'.$row->id.'" value="'.$row->policyValue.'">'.'</div>';  
  }

?>

  <div class="breadcrumbs">
  <div class="animated fadeIn">
    <div class="col-sm-4 sm 4">
      <div class="page-header float-left">
        <div class="page-title">
            <h1>Policies</h1>
        </div>
      </div>
    </div>
    <div class="col-sm-8">
      <div class="page-header float-right">
          <div class="page-title">
              <ol class="breadcrumb text-right">
                  <li><a href="<?php echo site_url('welcome_admin');?>">Home</a></li>
                  <li><a href="#">Policy</a></li>
              </ol>
          </div>
      </div>
    </div>
  </div>
  </div>

  <div class="card-body card-block">
    <div class="card">
      <div class="card-body">
        <div class="form-group">
              <div class="alert alert-danger" align="center" style="display: none;"></div>
            </div>
        <div class="form-group" id="policyForm">
            <?php echo $policy ?>          
        </div>
      </div>
      <div class="card-footer">
        <button type="button" class="btn btn-outline-info" style="border-radius: 3px;" id="btn_policy" title="Edit Policy">Edit Policy</button>
      </div>
    </div>
  </div>


<div class="modal fade" id="editpolicy" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><strong>Edit Policy</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form class="form-horizontal" >
          <div class="modal-body">
            <div class="form-group">
              <div class="alert alert-danger" align="center" style="display: none;"></div>
            </div>
            <div class="row form-group">
                <?php 
                foreach($data as $row){ ?>
                <div class="col-12 col-md-4">
                <label class="form-control-label col-12"><?php echo $row->policyTitle ?>
                <input type="text" name="$row->policyName" class="form-control"></div>
                <?php } ?>         
              </div>
            </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-outline-info" style="border-radius: 3px;" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-outline-info" style="border-radius: 3px;" id="btn_policy" name="btn_policy">Confirm</button>
          </div>
        </form>
      </div>
    </div>
  </div>