
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Log in</title>
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
  <style>
  .login-box, .register-box
  {
    width: auto;
  }
  </style>
</head>
<body class="hold-transition login-page" style="min-height: 362.391px;background-color: #dcdcdc;">
<div class="login-box">
  <!-- <div class="login-logo">
    <a href="<?php echo base_url();?>"><img src="<?php echo base_url('writable/themeData/dist/img/logo.png');?>" alt="" style="width:40%"></a>
    <a href="<?php echo base_url();?>"><b>Simu</b>Lessons</a>
  </div> -->
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg" onclick="window.location.href='https://simulessons.com'" style="cursor: pointer;">
        <img src="<?php echo base_url('writable/themeData/dist/img/logo.png');?>" alt="" style="width:100%;">
      </p>

      <form action="" id="userLoginForm" method="post" onsubmit="userLogin('', event);">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="user_Email" required="" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="user_PasswordEncrypt" required="" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-danger btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <div class="social-auth-links text-center mb-3 d-none">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div>
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <!-- <a href="<?php // echo base_url('forget_password');?>">I forgot my password</a> -->
        <a href="https://simulessons.com/trgroi2/user/password/request/">I forgot my password</a>
      </p>
      <p class="mb-0">
        <!-- <a href="<?php // echo base_url('register');?>" class="text-center">Register a new membership</a> -->
        <a href="https://simulessons.com/trgroi2/user/register/" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?php echo base_url("writable/themeData/");?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url("writable/themeData/");?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url("writable/themeData/");?>dist/js/adminlte.min.js"></script>
<!-- Toastr -->
<script src="<?php echo base_url("writable/themeData/");?>plugins/toastr/toastr.min.js"></script>
<style>
  a {
    color: #8B0000;
  }
</style>
<script>
  $(document).ready(function(){
    <?php if(!empty($autoLogin)){ ?> userLogin('autoLogin', event); <?php } ?>
  });
  function userLogin(autoLogin, event)
  {
    if(autoLogin=='autoLogin')
    {
      var formData = "<?php echo $autoLogin; ?>";
    }
    else
    {
      event.preventDefault();
      var formData = $('#userLoginForm').serialize();
    }

    fetch("<?php echo base_url('Ajax/verifyLogin')?>", {
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
      })
      eval(returnedResult.redirect);
      // location.reload(true); 
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
