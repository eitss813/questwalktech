<!-- <?php // echo "<pre>"; print_r($userGamesInCart); die(' here '); ?> -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">My Items</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
              <li class="breadcrumb-item active">Items</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row" id="addGameRows">
          <!-- add game rows here, by triggering ajax -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script>
    $(document).ready(function(){
      gameids = "<?php echo $userGames??NULL ;?>";
      createGameRows('', gameids);
      $('#gameCountInCart').text(<?php echo count($userGamesInCart['userData']);?>);
    });
    
    function createGameRows(alertmsg, gameids)
    {
      // bring game rows via ajax
      fetch("<?php echo API_URL;?>getRequestedGames", {
      method: "POST",
      headers: {
        'Accept': 'application/json, text/plain, */*',
        "Content-type": "application/x-www-form-urlencoded;"
        // "Content-Type": "application/json",
        // "X-Requested-With": "XMLHttpRequest"
      },
      body: "<?php echo ENT_LOGIN_CRED;?>&gameid="+gameids+'&user_Email=<?php echo session("loginUserData")->user_Email;?>',
    }).then(function(response){
      return response.json();
    }).then(function(returnedResult){
      // toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.');
      var alertmsg = 'no-alert-msg'; // to hide the alert msg
      if(alertmsg != 'no-alert-msg')
      {
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
      }
      // console.log(returnedResult);
      if(returnedResult.gamesCatalogue.length>0)
      {
        // console.log(' add game rows from here');
        $.each(returnedResult.gamesCatalogue, function(i,e){
          // console.log($.inArray(returnedResult.gamesCatalogue[i].Game_ID, userCartGames));
          // console.log($.type(returnedResult.gamesCatalogue[i].Game_ID));console.log($.type(userCartGames));
          
          // console.log(i); $('#addGameRows').append('<div class="row col-md-12">mksahu '+i+'</div>');
          var Game_prise = returnedResult.gamesCatalogue[i].Game_prise ? returnedResult.gamesCatalogue[i].Game_prise+'-/INR' : '0.00-/INR'; // if there is no prise, set 0.00
          var Game_Image = returnedResult.gamesCatalogue[i].Game_Image ? returnedResult.gamesCatalogue[i].Game_Image : 'Game2.jpg'; // if there is no image, set default image
          var Game_longDescription = returnedResult.gamesCatalogue[i].Game_longDescription ? ((returnedResult.gamesCatalogue[i].Game_longDescription).length>500?(("<div class='toggleText'>"+returnedResult.gamesCatalogue[i].Game_longDescription).slice(0,500)+" <a href='javascript:void(0);' onclick='return showText(this);'>...Read More</a></div> <div class='longDescriptionText d-none'>"+returnedResult.gamesCatalogue[i].Game_longDescription+" <a href='javascript:void(0);' onclick='hideText(this)'>...Read Less</a></div>"):returnedResult.gamesCatalogue[i].Game_longDescription) : 'Put The Long Description Here'; // if there is no description, put default text 


            var packing_slip_orders = JSON.parse('<?php echo $catalog_links_array; ?>');
            if( packing_slip_orders[returnedResult.gamesCatalogue[i].Game_ID] && (packing_slip_orders[returnedResult.gamesCatalogue[i].Game_ID] != 'undefined') ) {
                $('#addGameRows').append('<div data-description="'+Game_longDescription+'" data-gamename="'+returnedResult.gamesCatalogue[i].Game_Name+'" class="card mb-3 col-md-12 allGameData" id="gameRow_'+returnedResult.gamesCatalogue[i].Game_ID+'"><div class="card-header text-blue"><span><b>'+returnedResult.gamesCatalogue[i].Game_Name+'</b></span> <span class="float-right d-none">'+Game_prise+'</span></div><div class="card-body"><div class="row"><div class="col-md-2"><img src="<?php echo API_URL;?>../../images/'+Game_Image+'" class="" alt="Image Not Available" style="width:100%; max-height:150px;"></div><div class="col-md-10">'+Game_longDescription+'<button type="button" class="btn btn-primary btn-flat float-right text-sm" data-number="0" onclick="return playSimulation();" >'+showButtonText(returnedResult.gamesCatalogue[i].gameStatus, returnedResult.gamesCatalogue[i].UG_ReplayCount)+'</button></div></div></div> <div class="col-md-12"><button style="width: 100%; margin: 10px; height: 35px;" onclick="redirectTophpFox(\''+packing_slip_orders[returnedResult.gamesCatalogue[i].Game_ID]+'\')">CLICK HERE FOR DETAILS</button></div> </div>');
            }else {
                $('#addGameRows').append('<div data-description="'+Game_longDescription+'" data-gamename="'+returnedResult.gamesCatalogue[i].Game_Name+'" class="card mb-3 col-md-12 allGameData" id="gameRow_'+returnedResult.gamesCatalogue[i].Game_ID+'"><div class="card-header text-blue"><span><b>'+returnedResult.gamesCatalogue[i].Game_Name+'</b></span> <span class="float-right d-none">'+Game_prise+'</span></div><div class="card-body"><div class="row"><div class="col-md-2"><img src="<?php echo API_URL;?>../../images/'+Game_Image+'" class="" alt="Image Not Available" style="width:100%; max-height:150px;"></div><div class="col-md-10">'+Game_longDescription+'<button type="button" class="btn btn-primary btn-flat float-right text-sm" data-number="0" onclick="return playSimulation();" >'+showButtonText(returnedResult.gamesCatalogue[i].gameStatus, returnedResult.gamesCatalogue[i].UG_ReplayCount)+'</button></div></div></div></div>');
            }
        });
      }
      else
      {
        $('#addGameRows').html('<div class="card mb-3 col-md-12 bg-danger">You have not purchased any game.</div>');
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

    function playSimulation(playUrl)
    {
      fetch("<?php echo API_URL;?>playSimulation", {
        method: "POST",
        headers: {
          'Accept': 'application/json, text/plain, */*',
          "Content-type": "application/x-www-form-urlencoded;"
          // "Content-Type": "application/json",
          // "X-Requested-With": "XMLHttpRequest"
        },
        body: "<?php echo ENT_LOGIN_CRED;?>&useremail=<?php echo base64_encode(session('loginUserData')->user_Email);?>&userpassword=<?php echo base64_encode(session('loginUserData')->user_Password);?>&returnUrl=<?php echo base_url(uri_string());?>",
      }).then(function(response){
        return response.json();
      }).then(function(returnedResult){
        // console.log(returnedResult);
        if(returnedResult.code==201)
        {
          toastr.error(returnedResult.message);
        }
        else
        {
          // alert('redirected');
          window.location = returnedResult.redirect;
        }
      });
    }

    function showButtonText(gameStatus, ReplayCount)
    {
      // console.log(gameStatus+' :: '+ReplayCount);
      if(ReplayCount>0)
      {
        return "Access (Available Reruns: "+ReplayCount+")";
      }
      else
      {
        if(gameStatus==1)
        {
          return "Completed (Available Reruns: "+ReplayCount+")";
        }
        else
        {
          return "Access (Available Reruns: "+ReplayCount+")";
        }
      }
    }
    
    function redirectTophpFox(url) {
      window.location.href = '<?php echo $catalog_links_redirection_link ?>' + url;
    }
  </script>
