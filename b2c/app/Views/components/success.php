  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Please don't refresh or press back button...</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
              <li class="breadcrumb-item active">Payment</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row d-flex justify-content-center" id="showMessageHere">
          <!-- add some custom emssage here if needed -->
          <img src="<?php echo base_url($imgUrl);?>" alt="Payment made successfully" style="width:35%;">
        </div>
        <!-- /.row -->
      </div>

      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<script>
  function paymentSuccess()
    {
      // when purchased then create user account and add games to user game table
      fetch("<?php echo API_URL;?>createUser/8", {
        method: "POST",
        headers: {
          'Accept': 'application/json, text/plain, */*',
          "Content-type": "application/x-www-form-urlencoded;"
          // "Content-Type": "application/json",
          // "X-Requested-With": "XMLHttpRequest"
        },
        body: '<?php echo ENT_LOGIN_CRED;?>&userDataWithGame=<?php echo json_encode(session("loginUserData"));?>&games=<?php echo $gameIds; ?>',
      }).then(function(response){
        return response.json();
      }).then(function(result){
        console.log(result);
        if(result.code==200)
        {
          // when everything goes well then remove the game from cart, and add to purchase table txnid MerTxnId gameIds
          triggerAjaxAndReturnData("<?php echo base_url('Ajax/gamePurchased');?>", "<?php echo $postData; ?>").then(function(manageCart){
            window.location.href = "<?php echo base_url('Simulation');?>";
            // console.log(manageCart);
          });
        }
        else
        {
          console.log(result);
          alert('some error is there');
        }
      });
      // end of fetch method
    }
    paymentSuccess();

    // setTimeout(function(){
    //   alert('redirecting to the right page');
    // },3000);
</script>