<div class="content-wrapper" style="min-height: 1416.81px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <!-- <h1>Reset Password</h1> -->
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
              <li class="breadcrumb-item active">Reset Password</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header p-2">
              Reset Password
              </div><!-- /.card-header -->
              <div class="card-body">
                <form class="form-horizontal" action="" id="changePasswordForm" onsubmit="changePassword(event);">

                <div class="mb-3">
                  <div class="input-group">
                    <label for="oldPassword" class="col-sm-2 col-form-label">Old Password</label>
                    <input type="password" class="form-control" name="oldPassword" id="oldPassword" required="" placeholder="Enter Old Password">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                      </div>
                    </div>
                  </div>
                  <!-- show error here -->
                  <div class="input-group">
                    <div class="col-sm-2 col-form-label"></div>
                    <div id="oldPasswordError" class="showError text-red"></div>
                  </div>
                </div>

                <div class="mb-3">
                  <div class="input-group">
                    <label for="newPassword" class="col-sm-2 col-form-label">New Password</label>
                    <input type="password" class="form-control" name="newPassword" id="newPassword" required="" placeholder="Enter New Password">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                      </div>
                    </div>
                  </div>
                  <!-- show error here -->
                  <div class="input-group">
                    <div class="col-sm-2 col-form-label"></div>
                    <div id="newPasswordError" class="showError text-red"></div>
                  </div>
                </div>

                <div class="mb-3">
                  <div class="input-group">
                    <label for="newPasswordConfirm" class="col-sm-2 col-form-label">Confirm Password</label>
                    <input type="password" class="form-control" name="newPasswordConfirm" id="newPasswordConfirm" required="" placeholder="Confirm Password">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                      </div>
                    </div>
                  </div>
                  <!-- show error here -->
                  <div class="input-group">
                    <div class="col-sm-2 col-form-label"></div>
                    <div id="newPasswordConfirmError" class="showError text-red"></div>
                  </div>
                </div>

                  <!-- <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                        </label>
                      </div>
                    </div>
                  </div> -->

                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Reset Password</button>
                    </div>
                  </div>
                </form>
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  <script>
    function changePassword(e)
    {
      $('.showError').each(function(){
        $(this).text('');
      });
      e.preventDefault();
      // alert('form submitted');
      var formData = $('#changePasswordForm').serialize();
      // console.log(formData);
      var oldPassword = $('#oldPassword').val();
      var newPassword = $('#newPassword').val();
      var newPasswordConfirm = $('#newPasswordConfirm').val();
      // if not empty
      if(oldPassword.length>0 && newPassword.length>0 && newPasswordConfirm.length>0)
      {
        if(newPassword == newPasswordConfirm)
        {
          // alert(' trigger ajax via fetch ');
          fetch("<?php echo base_url('Ajax/resetpassword')?>", {
            method: "POST",
            headers: {
              'Accept': 'application/json, text/plain, */*',
              "Content-type": "application/x-www-form-urlencoded;"
              // "Content-Type": "application/json",
              // "X-Requested-With": "XMLHttpRequest"
            },
            body: formData,
          }).then(function(response){
            return response.json();
          }).then(function(ajaxResult){
            if(ajaxResult.code == 201)
            {
              toastr.error(ajaxResult.message);
              if(ajaxResult.code == 201)
              {
                $.each(ajaxResult.errorMsg,function(i,e){
                  // console.log(i+' and '+e);
                  $('#'+i+'Error').text(e);
                });
              }
            }
            else
            {
              toastr.success(ajaxResult.message);
              $("#changePasswordForm").trigger('reset');
            }
            eval(ajaxResult.redirect);
          });
        }
        else
        {
          toastr.error('The Confirm Password field does not match the New Password field.');
        }
      }
      else
      {
        toastr.error('All fields are mandatory');
      }
    }
  </script>