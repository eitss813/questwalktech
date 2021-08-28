
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Forgot Password</title>
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
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="<?php echo base_url();?>"><b>Simu</b>Lessons</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

      <form action="" id="passwordRequest" method="post" onsubmit="return requestPassword(event)">
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="user_Email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Request new password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mt-3 mb-1">
        <a href="<?php echo base_url();?>">I already have a membership! Login</a>
      </p>
      <p class="mb-0">
        <a href="<?php echo base_url("register");?>" class="text-center">Register a new membership</a>
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
<script>
  async function requestPassword(event)
  {
    event.preventDefault();
    var formData = $("#passwordRequest").serialize();
    var retsult = await triggerAjaxAndReturnData("<?php echo base_url('Ajax/forget_password');?>", formData);
    // console.log(retsult);
    if(retsult.code == 200)
    {
      toastr.success(retsult.message);
    }
    else
    {
      toastr.error(retsult.message);
    }
  }

  function triggerAjaxAndReturnData(url, data) {
    var returnedData = fetch(url, {
      method: "POST",
      headers: {
        'Accept': 'application/json, text/plain, */*',
        "Content-type": "application/x-www-form-urlencoded;"
        // "Content-Type": "application/json",
        // "X-Requested-With": "XMLHttpRequest"
      },
      body: data,
    }).then(function(response) {
      return response.json();
    });
    return returnedData;
  }
</script>
</body>
</html>
