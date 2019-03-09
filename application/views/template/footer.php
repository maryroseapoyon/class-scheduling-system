</div><!-- /#right-panel -->
    <!-- Right Panel -->
 
    <script src="<?php echo base_url('assets/vendors/jquery/dist/jquery.min.js');?>"></script>
    <script src="<?php echo base_url('assets/vendors/popper.js/dist/umd/popper.min.js');?>"></script>
    <script src="<?php echo base_url('assets/vendors/bootstrap/dist/js/bootstrap.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/main.js');?>"></script>
    <script src="<?php echo base_url('assets/js/resources.js');?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.lwMultiSelect.min.js');?>"></script>
  
    <script src="<?php echo base_url('assets/vendors/chart.js/dist/Chart.bundle.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/dashboard.js');?>"></script>
    <script src="<?php echo base_url('assets/js/widgets.js');?>"></script>
    <script src="<?php echo base_url('assets/vendors/jqvmap/dist/jquery.vmap.min.js');?>"></script>
    <script src="<?php echo base_url('assets/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js');?>"></script>
    <script src="<?php echo base_url('assets/vendors/jqvmap/dist/maps/jquery.vmap.world.js');?>"></script>


    <script src="<?php echo base_url('assets/js/input-mask/jquery.inputmask.js"');?>"></script>
    <script src="<?php echo base_url('assets/js/input-mask/jquery.inputmask.extensions.js"');?>"></script>
    <script src="<?php echo base_url('assets/js/input-mask/jquery.inputmask.numeric.extensions.js"');?>"></script>
    <script src="<?php echo base_url('assets/js/input-mask/jquery.inputmask.date.extensions.js"');?>"></script>
    <script src="<?php echo base_url('assets/js/input-mask/jquery.inputmask.phone.extensions.js"');?>"></script>

    <script src="<?php echo base_url('assets/vendors/datatables.net/js/jquery.dataTables.min.js');?>"></script>
    <script src="<?php echo base_url('assets/vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js');?>"></script>
    <script src="<?php echo base_url('assets/vendors/datatables.net-buttons/js/dataTables.buttons.min.js');?>"></script>
    <script src="<?php echo base_url('assets/vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js');?>"></script>
    <script src="<?php echo base_url('assets/vendors/jszip/dist/jszip.min.js');?>"></script>
    <script src="<?php echo base_url('assets/vendors/pdfmake/build/pdfmake.min.js');?>"></script>
    <script src="<?php echo base_url('assets/vendors/pdfmake/build/vfs_fonts.js');?>"></script>
    <script src="<?php echo base_url('assets/vendors/datatables.net-buttons/js/buttons.html5.min.js');?>"></script>
    <script src="<?php echo base_url('assets/vendors/datatables.net-buttons/js/buttons.print.min.js');?>"></script>
    <script src="<?php echo base_url('assets/vendors/datatables.net-buttons/js/buttons.colVis.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/init-scripts/data-table/datatables-init.js');?>"></script>
     <script type="text/javascript">
        jQuery(document).ready(function($) {
          // MODAL
          $('.modal').on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset();
            $('.alert').css('display', 'none');
 
          });

          //CONTACT
          $('input[name="fcontact"]').inputmask("(+63)999 999 9999", {"placeholder": "(+63)XXX XXX XXXX"});

          //MULTIPLE SELECT
          $('#selectmenu').lwMultiSelect();

        });
    </script>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
          
    // FACULTY //

          $('#btn_faculty_sub').on('click', function(){
              var sub_list = $('[name="sub_list[]"]').val();
              var fid = $('#profid').val();
              $.ajax({
                  type: 'post',
                  url: "<?php echo site_url('welcome_admin/facsub'); ?>",
                  data: {
                        sub_list : sub_list,
                        fid : fid
                  },
                dataType: 'JSON',
                success: function(data){
                  alert("Subject successfully added!");
                  location.reload();
                  $('#infosub').modal('hide');
                },
                error: function(){
                  alert('ERROR!');
                }
            });
          });


          $('#day').on('change', function(){
            var day = $(this).val();
            if(day == '' || day != '' && shift == ''){
              // $('#shift').attr('disabled', true);
              $('#time').data('plugin_lwMultiSelect').removeAll();    
              
              $('#time').data('plugin_lwMultiSelect').updateList();    
              $('#timezone')[0].reset();


            }
            else{
              $('#shift').attr('disabled', false);
              $.ajax({
                url: "<?php echo site_url('welcome_admin/facushift'); ?>",
                type: "POST",
                data: {'day':day},
                dataType: 'html',

                success: function(data){
                  $('#shift').html(data);
                  
                },
                error: function(){
                  alert('Error');
                }
              });
            }
          });


          $('#time').lwMultiSelect();
          $('#shift').on('change', function(){
            var tid = $('#profid').val();
            var day = $('#day').val();
            var shift = $(this).val();
            if(day == '' || shift == ''){
              $('#time').data('plugin_lwMultiSelect').updateList();    
              $('#time').data('plugin_lwMultiSelect').removeAll();    
              $('#timezone')[0].reset();
            }
            else{
              $('#time').attr('disabled', false);
              $.ajax({
                url: "<?php echo site_url('welcome_admin/facutime'); ?>",
                type: "POST",
                data: {'shift':shift, 'day':day, 'tid':tid},
                dataType: 'html',

                success: function(data){
                  $('#time').html(data);
                  $('#time').data('plugin_lwMultiSelect').updateList();

                },
                error: function(){
                  alert('Error');
                }
              });
            }
          });


          $('#btn_faculty_time').on('click', function(){
              var day = $('#day').val();
              var shift = $('#shift').val();
              var time_list = $('[name="time_list[]"]').val();
              var fid = $('#profid').val();

              if(day == ''){
                alert("Please Select Day");
                return false;
              }
              else if(shift == ''){
                alert("Please Select Shift");
                return false;
              }
              else if(time_list == ''){
                alert("Please Select Time");
                return false;
              }
              else{
              $.ajax({
                  type: 'post',
                  url: "<?php echo site_url('welcome_admin/factime'); ?>",
                  data: {
                        day : day,
                        shift : shift,
                        time_list : time_list,
                        fid : fid
                  },
                dataType: 'JSON',
                success: function(data){
                  alert("Time successfully added!");
                  location.reload();
                  $('#infotime').modal('hide');
                },
                error: function(){
                  alert('ERROR!');
                }
            });}
          });


     $('#btn_faculty').on('click', function(){
              var ffname = $('#ffname').val().trim();
              var fmname = $('#fmname').val();
              var flname = $('#flname').val();
              var fcontact = $('#fcontact').val();
              var fposition = $('#fposition').val();
              var fdepCode = $('#fdepCode').val();

              if(fposition == ''){
                alert("Please Select Position");
                return false;
              }
              else if(fdepCode == ''){
                alert("Please Select Department");
                return false;
              }
              else{
              $.ajax({
                  type: 'post',
                  url: "<?php echo site_url('welcome_admin/addFaculty'); ?>",
                  data: {
                        fname: ffname,
                        mname: fmname,
                        lname: flname,
                        contact: fcontact,
                        position: fposition,
                        depCode: fdepCode
                  },
                dataType: 'JSON',
                success: function(data){
                    if (data.status) {
                        alert("Faculty successfully added!");
                        location.reload();
                        $('#addfaculty').modal('hide');
                    }else{
                        $('.alert').css('display', 'block');
                        $('.alert').html(data.notif);   
                    }
                },
                error: function(request, status, error){
                  alert(request.responseText);
                }
            });return false;
            }
          });
          
          $('#btnupd_faculty').on('click', function(){
              var ffname = $('#ffname_upd').val();
              var fmname = $('#fmname_upd').val();
              var flname = $('#flname_upd').val();
              var fcontact = $('#fcontact_upd').val();
              var fposition = $('#fposition_upd').val();
              var fdepCode = $('#fdepCode_upd').val();
              var fid = $('#profid').val();
              $.ajax({
                  type: 'post',
                  url: "<?php echo site_url('welcome_admin/editFaculty'); ?>",
                  data: {
                        fname: ffname,
                        mname: fmname,
                        lname: flname,
                        contact: fcontact,
                        position: fposition,
                        depCode: fdepCode,
                        fid : fid
                  },
                dataType: 'JSON',
                success: function(data){
                    if (data.status) {
                        alert("Update Succesful!");
                        location.reload();
                        $('#editfaculty').modal('hide');
                    }else{
                        $('.alert').css('display', 'block');
                        $('.alert').html(data.notif);   
                    }
                },
                error: function(request, status, error){
                  alert(request.responseText);
                }
            });return false;
          });

    // DEPARTMENT // 
          $('#btn_department').on('click', function(){
              var depName = $('#ddepname').val();
              var depCode = $('#ddepcode').val();
              $.ajax({
                  type: 'post',
                  url: "<?php echo site_url('welcome_admin/addDepartment'); ?>",
                  data: {
                        depname: depName,
                        depcode: depCode
                  },
                dataType: 'JSON',
                success: function(data){
                    if (data.status) {
                        alert("Department successfully added!");
                        location.reload();
                        $('#adddepartment').modal('hide');
                    }else{
                        $('.alert').css('display', 'block');
                        $('.alert').html(data.notif);   
                    }
                },
                error: function(request, status, error){
                  alert(request.responseText);
                }
            });return false;
          });
          $('#btnupd_department').on('click', function(){
              var depName = $('#ddepname_upd').val();
              var depCode = $('#ddepcode_upd').val();
              var depID = $('#ddep_id').val();
              $.ajax({
                  type: 'post',
                  url: "<?php echo site_url('welcome_admin/editDepartment'); ?>",
                  data: {
                        depname: depName,
                        depcode: depCode,
                        depID: depID
                  },
                dataType: 'JSON',
                success: function(data){
                    if (data.status) {
                        alert("Update Succesful!");
                        location.reload();
                        $('#editdepartment').modal('hide');
                    }else{
                        $('.alert').css('display', 'block');
                        $('.alert').html(data.notif);   
                    }
                },
                error: function(request, status, error){
                  alert(request.responseText);
                }
            });return false;
          });

          $('#active-department table tbody').on('click', 'button:contains("Update")', function(){
                var id = $(this).val();
                $.ajax({
                    type: 'ajax',
                    url: "<?php echo base_url('welcome_admin/get_department')?>",
                    method: "GET",
                    dataType: 'json',
                    data:{DepartmentID:id},
                    success:function(result){
                        $('#editdepartment form')[0].reset();
                        $('#editdepartment form').attr('action', "<?php echo base_url()?>"+'welcome_admin/editDepartment'+'?id='+result.department[0].DepartmentID);
                        $('#editdepartment input[name="ddepname_upd"]').val(result.department[0].DepartmentName);
                        $('#editdepartment input[name="ddepcode_upd"]').val(result.department[0].DepartmentCode);
                        $('#editdepartment input[name="ddep_id"]').val(result.department[0].DepartmentID);
                    },
                    error:function(request){
                        alert(request.responseText);
                    }
                });
            });

    // SUBJECT //
          $('#btn_subject').on('click', function(){
              var subj_code = $('#subcode').val();
              var subj_name = $('#subname').val().trim();
              var units = $('#units').val();
              var hrs = $('#hrs').val();
              var type = $('#type').val();
              var dep = $('#dep').val();
              $.ajax({
                  type: 'post',
                  url: "<?php echo site_url('welcome_admin/addSubject'); ?>",
                  data: {
                        subj_code: subj_code,
                        subj_name: subj_name,
                        units: units,
                        hrs: hrs,
                        type: type,
                        dept: dep
                  },
                dataType: 'JSON',
                success: function(data){
                    if (data.status) {
                        alert("Subject successfully added!");
                        location.reload();
                        $('#addsubjects').modal('hide');
                    }else{
                        $('.alert').css('display', 'block');
                        $('.alert').html(data.notif);   
                    }
                },
                error: function(request, status, error){
                  alert(request.responseText);
                }
            });return false;
          });

          $('#btnupd_subject').on('click', function(){
              var code = $('#upsubcode').val();
              var name = $('#upsubname').val().trim();
              var units = $('#upunits').val();
              var hrs = $('#uphrs').val();
              var type = $('#uptype').val();
              var dep = $('#updepartment').val();
              var id = $('#upid').val();
              $.ajax({
                  type: 'post',
                  url: "<?php echo site_url('welcome_admin/editSubject'); ?>",
                  data: {
                        subj_code: code,
                        subj_name: name,
                        units: units,
                        hrs: hrs,
                        type: type,
                        dept: dep,
                        sid: id
                  },
                dataType: 'JSON',
                success: function(data){
                    if (data.status) {
                        alert("Update Succesful!");
                        location.reload();
                        $('#editsubjects').modal('hide');
                    }else{
                        $('.alert').css('display', 'block');
                        $('.alert').html(data.notif);   
                    }
                },
                error: function(request, status, error){
                  alert(request.responseText);
                }
            });return false;
          });

          $('#active table tbody').on('click', 'button:contains("Update")', function(){
                var id = $(this).val();
                $.ajax({
                    type: 'ajax',
                    url: "<?php echo base_url('welcome_admin/get_subjects')?>",
                    method: "GET",
                    dataType: 'json',
                    data:{SubjectID:id},
                    success:function(result){
                        $('#editsubjects form')[0].reset();
                        $('#editsubjects form').attr('action', "<?php echo base_url()?>"+'welcome_admin/editSubject'+'?id='+result.subject[0].SubjectID);
                        $('#editsubjects input[name="upsubcode"]').val(result.subject[0].SubjectCode);
                        $('#editsubjects input[name="upsubname"]').val(result.subject[0].SubjectName);

                        if(result.subject[0].SubjectType == "Lecture" ){
                          $('#editsubjects input[name="upunits"]').val(result.subject[0].LecUnits);
                          $('#editsubjects input[name="uphrs"]').val(result.subject[0].LecHours);
                        }
                        else{
                          $('#editsubjects input[name="upunits"]').val(result.subject[0].LabUnits);
                          $('#editsubjects input[name="uphrs"]').val(result.subject[0].LabHours); 
                        }
                        $('#editsubjects select[name="uptype"]').val(result.subject[0].SubjectType);
                        $('#editsubjects select[name="updepartment"]').val(result.subject[0].SubjectDeptCode);
                        $('#editsubjects input[name="sub_id"]').val(result.subject[0].SubjectID);

                    },
                    error:function(request){
                        alert(request.responseText);
                    }
                });
            });


           $('#btn_policy').on('click', function(){
              var pure = $('#4').val();
              var admin = $('#5').val();
              var ext = $('#6').val();
              var head = $('#16').val();
              var semester = $('#20').val();
              var morning = $('#21').val();
              var afternoon = $('#22').val();
              var newarray = new Array;
              var newarray2 = new Array;
              $('#policyForm input').each( function(){
                newarray.push(this.id);
                newarray2.push($('#'+this.id).val());

              });
              
              $.ajax({
                  type: 'post',
                  url: "<?php echo site_url('welcome_admin/editPolicy'); ?>",
                  data: {
                        pure : pure,
                        admin : admin,
                        ext : ext,
                        head : head,
                        semester : semester,
                        morning : morning,
                        afternoon : afternoon,
                        newarray : newarray,
                        newarray2 : newarray2
                  },
                dataType: 'JSON',
                success: function(data){
                    if (data.status) {
                        alert("Update Succesful!");
                        location.reload();
                    }else{

                        $('.alert').css('display', 'block');
                        $('.alert').html(data.notif);   
                    }
                },
                error: function(request, status, error){
                  alert(request.responseText);
                }
            });return false;
          });

          $('#roombut').on('click', function(){
             var r = document.getElementById('rooms');
             var rooms = r.options[r.selectedIndex].value;
              $.ajax({
                  url: "<?php echo site_url('welcome_admin/room_view'); ?>",
                  method: 'POST',
                  data: {
                      rooms:rooms
                  },
                  success: function(data){
                      $('#datatable').html(data);
                  },
                  error: function(){
                      alert('EROROROROR');
                  }
              });
          });


          $('#btn_room').on('click', function(){
            var room_no = $('#room_no').val();
            var room_type = $('#room_type').val();
            var dep = $('#dep').val();
            $.ajax({
                type: 'post',
                url: "<?php echo site_url('welcome_admin/add_room'); ?>",
                data: {
                    room_no: room_no,
                    room_type: room_type,
                    dep: dep
                },
                dataType: 'JSON',
                success: function(data){
                    if (data.status) {
                        alert("Room successfully created!");
                        location.reload();
                        javascript:window.location.reload();
                    }else{
                        $('.alert').css('display', 'block');
                        $('.alert').html(data.notif);
                    }
                },
                error: function(){
                    alert('ERROR!');
                }
            });return false;
          });

          $(".clickable-row").click(function() {
            window.location = $(this).data("href");
          });

          $('#master').on('click', function(e) {
                   if($(this).is(':checked',true))  
                   {
                      $(".del_subj").prop('checked', true);  
                   } else {  
                      $(".del_subj").prop('checked',false);  
                   }  
                  });

          $('#master2').on('click', function(e) {
                   if($(this).is(':checked',true))  
                   {
                      $(".del_time").prop('checked', true);  
                   } else {  
                      $(".del_time").prop('checked',false);  
                   }  
                  });
           
          $('.delete_all').on('click', function(e) {

              var allVals = [];  
              $(".del_subj:checked").each(function() {  
                  allVals.push($(this).attr('data-id'));
              });  

              if(allVals.length <=0)  
              {  
                  alert("Please select subject row.");  
              }  else {  

                  var check = confirm("Are you sure you want to delete this row?");  
                  if(check == true){  

                      var join_selected_values = allVals.join(","); 

                      $.ajax({
                          url: "<?php echo site_url('welcome_admin/delete_subj'); ?>",
                          type: 'POST',
                          data: 'ids='+join_selected_values,
                          success: function (data) {
                            console.log(data);
                            $(".del_subj:checked").each(function() {  
                                $(this).parents("tr").remove();
                            });
                            alert("Item Deleted successfully.");
                            javascript:window.location.reload();
                          },
                          error: function (data) {
                              alert(data.responseText);
                          }
                      });

                    // $.each(allVals, function( index, value ) {
                    //     $('table tr').filter("[data-row-id='" + value + "']").remove();
                    // });
                  }  
              }  
          });

          $('.delete_all2').on('click', function(e) {

              var allVals = [];  
              $(".del_time:checked").each(function() {  
                  allVals.push($(this).attr('data-id'));
              });  

              if(allVals.length <=0)  
              {  
                  alert("Please select time row.");  
              }  else {  

                  var check = confirm("Are you sure you want to delete this row?");  
                  if(check == true){  

                      var join_selected_values = allVals.join(","); 

                      $.ajax({
                          url: "<?php echo site_url('welcome_admin/delete_time'); ?>",
                          type: 'POST',
                          data: 'ids='+join_selected_values,
                          success: function (data) {
                            console.log(data);
                            $(".del_time:checked").each(function() {  
                                $(this).parents("tr").remove();
                            });
                            alert("Item Deleted successfully.");
                            javascript:window.location.reload();
                          },
                          error: function (data) {
                              alert(data.responseText);
                          }
                      });

                    // $.each(allVals, function( index, value ) {
                    //     $('table tr').filter("[data-row-id='" + value + "']").remove();
                    // });
                  }  
              }  
          });

// RANGE SLIDER-------------------------------------

      var rangeSlider = function(){
      var slider = $('.range-slider'),
          range = $('.range-slider__range'),
          value = $('.range-slider__value');

      slider.each(function(){

        value.each(function(){
          var value = $(this).prev().attr('value');
          $(this).html(value);
        });

        range.on('input', function(){
          $(this).next(value).html(this.value);
        });
      });
};

    rangeSlider();

    //----------SUBMIT RANGE----------------------------------------

    var mpv = document.getElementById("mutation-prob-range").value;
    var msr = document.getElementById("mutation-size-range").value;
    var cpr = document.getElementById("crossover-prob-range").value;
    var cpor = document.getElementById("crossover-points-range").value;
    var ssr = document.getElementById("sample-size-range").value;
    var gir = document.getElementById("gen-interval-range").value;
    var datai = 0;
    var terminate = 0;
    var gen;
    var generation = 0;
    var prevdata = datai;
    var geninterval;
    var map2 = 0;

    function generate(){
      $.ajax({
                  type: 'post',
                  url: "<?php echo site_url('welcome_admin/generate'); ?>",
                  data: {
                        datai:datai,
                        ssr:ssr
                      //  mpv: mpv,
                      //  msr: msr,
                      //  cpr: cpr,
                      //  cpor: cpor
                  },
                  dataType: 'json',
                success: function(data){
                  datai = data.dataindex;
                  terminate = data.term;
                  console.log(datai);
                  generation++;
                  if(prevdata==datai){
                    geninterval++;
                    if(geninterval == gir){
                      var t = confirm('Interval reached! Do you still want to continue?');
                      if(t != true){
                        clearInterval(gen);
                      }
                    }
                  }else{
                    prevdata=datai;
                    geninterval = 0;
                  }
                  if(datai == terminate-1){
                    clearInterval(gen);
                    $('#schedbtn').show(500);
                    $('#alertt').html('Scheduling Complete!');
                  }
                  var map = Math.ceil((datai/terminate)*100);
                  $('#idd').removeClass('p'+map2);
                  $('#idd').addClass('p'+map);
                  map2 = map;
                  $('#perc').html(map+"%");
                  $('#gencount').html("Generation: "+generation);

                },
                error: function(){
                  $('#alertt').html('An Error has occured!');
                  clearInterval(gen);
                  $('#hidme').show(1000);
                }
            });
      
    }

    $('#schedbtn').on('click', function(){
      location.replace('<?php echo site_url('welcome_admin/read_schedule')?>');
    });


    $('#fstop').on('click', function(){
                    var x = confirm('Do you want to stop the process?');
                    if(x == true){
                      clearInterval(gen);
                      $('#schedbtn').show(500);
                    }
                  });


    $('#submit-data').on('click', function(){
          $('#hidthis').show(500);         
          $.ajax({
          type:'get',
          url: "<?php echo site_url('welcome_admin/schedd');?>",
          dataType: 'json',
          success: function(data){
            if(data==0){
              gen = setInterval(generate, 250);
            }else{
              var r = confirm("A schedule already exist. Overwrite?");
              if(r == true){
                $.ajax({
                  type: 'get',
                  url:"<?php echo site_url('welcome_admin/delete_sched'); ?>",
                  dataType: 'json',
                  success: function(){
                    gen = setInterval(generate, 500);
                    $('#hidme').hide(500);
                  },
                  error: function(){
                    alert('Error encountered. Try again later!');
                  }
                });
              }else{
                location.reload();
              }
            }
          },
          error: function(){
            alert('Error Found. Please try again later.');
          }
      });
             
    });


    $('#btn_section').on('click', function(){
              var schoolyr = $('#schoolyr').val();
              var scourse = $('#scourse').val();
              var sdepcode = $('#sdepcode').val();
              var level = $('#level').val();
              var sem = $('#sem').val();
              var sec = $('#sect').val();
              if(scourse == ''){
                alert("Please Select Course");
                return false;
              }
              else if(sdepcode == ''){
                alert("Please Select Department");
                return false;
              }
              else if(level == ''){
                alert("Please Select Year Level");
                return false;
              }
              else if(sem == ''){
                alert("Please Select Semester");
                return false;
              }
              else if(sec == ''){
                alert("Please Select Block");
                return false;
              }

              else{
              $.ajax({
                  type: 'post',
                  url: "<?php echo site_url('welcome_admin/addSection'); ?>",
                  data: {
                        schyr: schoolyr,
                        scourse: scourse,
                        sdepcode: sdepcode,
                        level: level,
                        sem: sem,
                        sec: sec
                  },
                dataType: 'JSON',
                success: function(data){
                    if (data.status) {
                        alert("Section successfully added!");
                        location.reload();
                        $('#addsection').modal('hide');
                    }else{
                        $('.alert').css('display', 'block');
                        $('.alert').html(data.notif);   
                    }
                },
                error: function(request, status, error){
                  alert(request.responseText);
                }
            });return false;}
          });

          $('#btn_delete').on('click', function(){
          var id = $(this).val();        
          $.ajax({
              type: 'post',
              url: "<?php echo site_url('welcome_admin/delete_sec'); ?>",
              data: {
                    id : id
              },
            dataType: 'JSON',
            success: function(data){
                if (data.status) {
                    alert("Section Deleted successfully!");      
                    location.reload();
                }else{
                    $('.alert').css('display', 'block');
                    $('.alert').html(data.notif);   
                }
            },
            error: function(request, status, error){
              alert(request.responseText);
            }
          });
        });




    });
    </script>
    
</body>

</html>
