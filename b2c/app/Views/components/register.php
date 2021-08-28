
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Registration</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url("writable/themeData/");?>plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo base_url("writable/themeData/");?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url("writable/themeData/");?>dist/css/adminlte.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?php echo base_url("writable/themeData/");?>plugins/toastr/toastr.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>writable/faviconnew.ico">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="<?php echo base_url();?>"><b>Simu</b>Lessons</a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new membership</p>
      <!-- <div id="" class="text-red mb-3">All fields are mandatory</div> -->

      <form action="" method="post" id="userRegistrationForm" name="userRegistrationForm" onsubmit="registerUser(event);">
      
      <div class="mb-3">
        <div class="input-group">
          <input type="text" class="form-control" name="user_Fname" required="" placeholder="First name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-address-book"></span>
            </div>
          </div>
        </div>
        <span id="user_Fname" class="showError text-red"></span>
      </div>
        
        <div class="mb-3">
          <div class="input-group">
            <input type="text" class="form-control" name="user_Lname" required="" placeholder="Last name">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-address-card"></span>
              </div>
            </div>
          </div>
          <span id="user_Lname" class="showError text-red"></span>
        </div>
        
        <div class="mb-3">
          <div class="input-group">
            <input type="email" class="form-control" name="user_Email" required="" placeholder="Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <span id="user_Email" class="showError text-red"></span>
        </div>
        
        <div class="mb-3">
          <div class="input-group">
            <input type="text" class="form-control" name="user_UserName" required="" placeholder="username">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user-secret"></span>
              </div>
            </div>
          </div>
          <span id="user_UserName" class="showError text-red"></span>
        </div>
        
        <div class="mb-3">
          <div class="input-group">
            <input type="text" class="form-control" name="user_Phone" required="" placeholder="Mobile Number Only 10 Digits">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-phone"></span>
              </div>
            </div>
          </div>
          <span id="user_Phone" class="showError text-red"></span>
        </div>
        
        <div class="mb-3">
          <div class="input-group">
            <input type="password" class="form-control" name="user_PasswordEncrypt" required="" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <span id="user_PasswordEncrypt" class="showError text-red"></span>
        </div>
        
        <div class="mb-3">
          <div class="input-group">
            <input type="password" class="form-control" name="user_PasswordEncrypt_re" required="" placeholder="Retype password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-unlock-alt"></span>
              </div>
            </div>
          </div>
          <span id="user_PasswordEncrypt_re" class="showError text-red"></span>
        </div>

        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <label for="agreeTerms">
               I agree to the <a href="#">terms</a>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <div class="social-auth-links text-center d-none">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i>
          Sign up using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i>
          Sign up using Google+
        </a>
      </div>

      <a href="<?php echo base_url();?>" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="<?php echo base_url("writable/themeData/");?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url("writable/themeData/");?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Toastr -->
<script src="<?php echo base_url("writable/themeData/");?>plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url("writable/themeData/");?>dist/js/adminlte.min.js"></script>
<script>
  // $(document).ready(function(){
  // });
  function registerUser(event)
  {
    event.preventDefault();
    // clear the error messages
    $('.showError').each(function(){
      $(this).text('');
    });
    var formData = $('#userRegistrationForm').serialize();
    // console.log(formData);

    fetch("<?php echo base_url('Ajax/register')?>", {
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
    }).then(function(returnedResult){
      // console.log(returnedResult);
      // toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.');
      $(document).Toasts('create', {
        class: returnedResult.class,
        title: returnedResult.title,
        subtitle: "<strong>"+returnedResult.subtitle+"</strong>",
        autohide: true,
        icon: returnedResult.icon,
        delay: returnedResult.delay,
        // image: '<?php // echo base_url('writable/themeData/dist/img/user3-128x128.jpg');?>',
        // imageAlt: 'User Picture',
        body: returnedResult.message
      });
      // if success then clear all the fields
      if(returnedResult.code == 200)
      {
        $("#userRegistrationForm").trigger('reset');
      }
      // to show validation error message
      if(returnedResult.code == 201)
      {
        $.each(returnedResult.errorMsg,function(i,e){
          // console.log(i+' and '+e);
          $('#'+i).text(e);
        });
      }
    }).catch(function(err){
      console.log('Fetch Error :-S', err);
      // $(document).Toasts('create', {
      //   class: 'bg-error',
      //   title: '',
      //   autohide: true,
      //   icon: 'fas fa-times-circle',
      //   delay: 2000,
      //   subtitle: 'FAILED',
      //   // image: '<?php // echo base_url('writable/themeData/dist/img/user3-128x128.jpg');?>',
      //   // imageAlt: 'User Picture',
      //   body: err,
      // })
    });
  }
</script>
</body>
</html>
