
<!-- <?php // echo "<pre>"; print_r($userGamesInCart); die(' here '); ?> -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Cart</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
              <button type="button" title="Purchase all cards" class="btn btn-outline-success float-right" id="purchaseAllGame" onclick="purchaseAllGame();" style="background: #28a745; color: #fff;">Purchase/Get for free</button>
          </div>
          <!-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
              <li class="breadcrumb-item active">Cart</li>
            </ol>
          </div> -->
          <!-- /.col -->
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
        <form action="https://secure.payu.in/_payment" id="payment_form" method="post" style="display:none;">
          <input type="hidden" id="surl" name="surl" value="<?php echo base_url('payment/success');?>" />
          <input type="hidden" id="furl" name="furl" value="<?php echo base_url('payment/fail');?>" />
          <input type="hidden" id="curl" name="curl" value="<?php echo base_url('payment/cancel');?>" />
          <input type="text" id="key" name="key" placeholder="Merchant Key" value="zPga6c" />
          <input type="text" id="salt" name="salt" placeholder="Merchant Salt" value="i9ZXPbAt" />
          <input type="text" id="txnid" name="txnid" placeholder="Transaction ID" value="<?php echo  "Txn" . rand(10000,9999999)*time()?>" />
          <input type="text" id="amount" name="amount" placeholder="Amount" value="" />    
          <input type="text" id="productinfo" name="productinfo" placeholder="Product Info" value="" />
          <input type="text" id="firstname" name="firstname" placeholder="First Name" value="<?php echo session('loginUserData')->user_Fname;?>" />
          <input type="text" id="email" name="email" placeholder="Email ID" value="<?php echo session('loginUserData')->user_Email;?>" />
          <input type="hidden" id="udf5" name="udf5" value="Simulation_Game_Purchase" />
          <input type="text" id="hash" name="hash" placeholder="Hash" value="" />
        </form>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script>
    $(document).ready(function(){
      userCartGames = [];
      cartGames = [];
      gameids = "<?php echo $fetchCartGameData??NULL ;?>";
      createGameRows('', gameids);
      $('#gameCountInCart').text(<?php echo count($userGamesInCart['userData']);?>);
    });
    
    function createGameRows(alertmsg, gameids)
    {
      var productinfo = [];
      var amount = [];
      // bring game rows via ajax
      fetch("<?php echo API_URL;?>fetchCartGame/8/1", {
      method: "POST",
      headers: {
        'Accept': 'application/json, text/plain, */*',
        "Content-type": "application/x-www-form-urlencoded;"
        // "Content-Type": "application/json",
        // "X-Requested-With": "XMLHttpRequest"
      },
      body: "<?php echo ENT_LOGIN_CRED;?>&gameid="+gameids,
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
        cartGames = returnedResult.gamesCatalogue;
        // console.log(' add game rows from here');
        $.each(cartGames, function(i,e){
          // console.log($.inArray(cartGames[i].Game_ID, userCartGames));
          // console.log($.type(cartGames[i].Game_ID));console.log($.type(userCartGames));
          
          // console.log(i); $('#addGameRows').append('<div class="row col-md-12">mksahu '+i+'</div>');
          // var Game_prise = cartGames[i].Game_prise ? cartGames[i].Game_prise: '0.00-/INR'; // if there is no prise, set 0.00
          productinfo.push(cartGames[i].Game_Name);
          var Game_prise = (cartGames[i].Game_prise > 0) ? (cartGames[i].Game_prise - cartGames[i].Game_discount) : '0.00'; // if there is no prise, set 0.00
          amount.push(Game_prise);
          var Game_Image = cartGames[i].Game_Image ? cartGames[i].Game_Image : 'Game2.jpg'; // if there is no image, set default image
          var Game_longDescription = cartGames[i].Game_longDescription ? ((cartGames[i].Game_longDescription).length>500?(("<div class='toggleText'>"+cartGames[i].Game_longDescription).slice(0,500)+" <a href='javascript:void(0);' onclick='return showText(this);'>...Read More</a></div> <div class='longDescriptionText d-none'>"+cartGames[i].Game_longDescription+" <a href='javascript:void(0);' onclick='hideText(this)'>...Read Less</a></div>"):cartGames[i].Game_longDescription) : 'Put The Long Description Here'; // if there is no description, put default text 

            var packing_slip_orders = JSON.parse('<?php echo $catalog_links_array; ?>');
            if( packing_slip_orders[cartGames[i].Game_ID] && (packing_slip_orders[cartGames[i].Game_ID] != 'undefined') ) {
                $('#addGameRows').append('<div data-description="'+Game_longDescription+'" data-gamename="'+cartGames[i].Game_Name+'" class="card mb-3 col-md-12 allGameData" id="gameRow_'+cartGames[i].Game_ID+'"><div class="card-header text-blue"><span><b>'+cartGames[i].Game_Name+'</b></span> <span class="float-right"> <b>&#8377; '+addZeroes(Game_prise)+'</b>'+showDiscount(cartGames[i].Game_prise, cartGames[i].Game_discount)+'</span></div><div class="card-body"><div class="row"><div class="col-md-2"><img src="<?php echo API_URL;?>../../images/'+Game_Image+'" class="" alt="Image Not Available" style="width:100%; max-height:150px;"></div><div class="col-md-10">'+Game_longDescription+'<button type="button" class="btn btn-primary btn-flat float-right text-sm d-none" data-number="0" onclick="return purchaseGame('+cartGames[i].Game_ID+');" >Purchase</button> <button type="button" class="btn btn-danger btn-flat float-right text-sm" data-number="0" onclick="return removeGame('+cartGames[i].Game_ID+');" >Remove</button></div></div></div> <div class="col-md-12"><button style="width: 100%; margin: 10px; height: 35px;" onclick="redirectTophpFox(\''+packing_slip_orders[cartGames[i].Game_ID]+'\')">CLICK HERE FOR DETAILS</button></div> </div>');
            }else {
                $('#addGameRows').append('<div data-description="'+Game_longDescription+'" data-gamename="'+cartGames[i].Game_Name+'" class="card mb-3 col-md-12 allGameData" id="gameRow_'+cartGames[i].Game_ID+'"><div class="card-header text-blue"><span><b>'+cartGames[i].Game_Name+'</b></span> <span class="float-right"> <b>&#8377; '+addZeroes(Game_prise)+'</b>'+showDiscount(cartGames[i].Game_prise, cartGames[i].Game_discount)+'</span></div><div class="card-body"><div class="row"><div class="col-md-2"><img src="<?php echo API_URL;?>../../images/'+Game_Image+'" class="" alt="Image Not Available" style="width:100%; max-height:150px;"></div><div class="col-md-10">'+Game_longDescription+'<button type="button" class="btn btn-primary btn-flat float-right text-sm d-none" data-number="0" onclick="return purchaseGame('+cartGames[i].Game_ID+');" >Purchase</button> <button type="button" class="btn btn-danger btn-flat float-right text-sm" data-number="0" onclick="return removeGame('+cartGames[i].Game_ID+');" >Remove</button></div></div></div></div>');
            }
        });
        $('#productinfo').val(productinfo.join(','));
        
        $('#amount').val(addZeroes(eval(amount.join("+"))));
        var key = $("#key").val();
        var txnid = $("#txnid").val();
        // var amount = $("#amount").val();
        // var productinfo = $("#productinfo").val();
        var firstname = $("#firstname").val();
        var email = $("#email").val();
        var udf5 = $("#udf5").val();
        var salt = $("#salt").val();
        var userHash = "'"+key+"|"+txnid+"|"+addZeroes(eval(amount.join("+")))+"|"+productinfo.join(',')+"|"+firstname+"|"+email+"|||||"+udf5+"||||||"+salt+"'";
        // console.log("'"+key+"|"+txnid+"|"+addZeroes(eval(amount.join("+")))+"|"+productinfo.join(',')+"|"+firstname+"|"+email+"|||||"+udf5+"||||||"+salt+"'");
        generateHash(userHash);
      }
      else
      {
        $('#addGameRows').html('<div class="card mb-3 col-md-12 bg-danger">No games available for purchase. Or, you have already added all the games to your cart.</div>')
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

    function removeGame(gameid)
    {
      fetch("<?php echo base_url('Ajax/removeGameFromCart/')?>"+gameid, {
        method: "POST",
        headers: {
          'Accept': 'application/json, text/plain, */*',
          "Content-type": "application/x-www-form-urlencoded;"
          // "Content-Type": "application/json",
          // "X-Requested-With": "XMLHttpRequest"
        },
        body: '',
      }).then(function(response){
        return response.json();
      }).then(function(ajaxResult){
        if(ajaxResult.code == 201)
        {
          toastr.error(ajaxResult.message);
        }
        else
        {
          toastr.success(ajaxResult.message);
          $('#gameRow_'+gameid).hide();
          var cartCount = $('#gameCountInCart').text();
          $('#gameCountInCart').text(cartCount-1);
          // when game is remvoed from cart then also remove this from json
          $.each(cartGames, function(i,e){
            if(cartGames[i].Game_ID == gameid)
            {
              cartGames.splice(i,1);
            }
          });
        }
        eval(ajaxResult.redirect);
      });
    }

    function purchaseGame(gameid)
    {
      fetch("<?php echo base_url('Ajax/purchaseGame/')?>"+gameid, {
      method: "POST",
      headers: {
        'Accept': 'application/json, text/plain, */*',
        "Content-type": "application/x-www-form-urlencoded;"
        // "Content-Type": "application/json",
        // "X-Requested-With": "XMLHttpRequest"
      },
      body: '',
    }).then(function(response){
      return response.json();
    }).then(function(ajaxResult){
      if(ajaxResult.code == 201)
      {
        toastr.error(ajaxResult.message);
      }
      else
      {
        userCartGames.push(gameid);
        toastr.success(ajaxResult.message);
        // console.log($('#gameRow_'+gameid));
        $('#gameRow_'+gameid).remove();
        // if(!$('#addGameRows').children().length>0)
        // {
        //   // console.log('there are no child');
        //   $('#addGameRows').html('<div class="card mb-3 col-md-12 bg-danger">Nothing to show.</div>')
        // }
        // add cart number
        // console.log(parseInt($('#gameCountInCart').text()) + 1);
        $('#gameCountInCart').text(parseInt($('#gameCountInCart').text()) - 1);
        // as all goes well, create user and allocate game to this user.
        // fetch("<?php // echo base_url('Ajax/createUser/$entId')?>", {
        //   method: "POST",
        //   headers: {
        //     'Accept': 'application/json, text/plain, */*',
        //     "Content-type": "application/x-www-form-urlencoded;"
        //     // "Content-Type": "application/json",
        //     // "X-Requested-With": "XMLHttpRequest"
        //   },
        //   body: 'send user details for account creation',
        // });
      }
      gameids = ajaxResult.data;
      eval(ajaxResult.redirect);
    });
      $('#addGameRows').html(''); // remove all game reows and then next line function will add them again
      // console.log();
      createGameRows('no-alert-msg',gameids);
    }

    function purchaseAllGame()
    {
      // console.log(cartGames);
      var showHtml = "";
      var totalPrize = 0;
      var tmpPrize = [];
      var gameidsToSend = '';
      // console.log(cartGames); alert(cartGames.length);
      if(cartGames.length > 0)
      {
        $.each(cartGames, function(i,e){
          var image_game = cartGames[i].Game_Image ? cartGames[i].Game_Image : 'Game2.jpg'; // if there is no image, set default image
          var Game_prise = cartGames[i].Game_prise ? (cartGames[i].Game_prise - cartGames[i].Game_discount) : '0.00'; // if there is no prise, set 0.00
          showHtml += "<div class='row col-md-12 mb-3' style='min-width:90vh;'><div class='col-md-8'><img src='<?php echo API_URL;?>../../images/"+image_game+"' style='max-width:100px;'></img> &nbsp;"+cartGames[i].Game_Name+"</div> <div class='col-md-4'>&#8377; "+Game_prise.toFixed(2)+"</div></div>";
          // console.log(cartGames[i].Game_ID);
          tmpPrize.push(Game_prise);
          gameidsToSend += cartGames[i].Game_ID+',';
        });
        // totalPrize = eval(totalPrize+cartGames[i].Game_prise);
        totalPrize = addZeroes(eval(tmpPrize.join("+")));
        showHtml += "<div class='row col-md-12 mb-3' style='min-width:90vh;'><div class='col-md-8'><b>Total</b></div> <div class='col-md-4'><b>&#8377; "+totalPrize+"</b></div>";
        // alert('all game purchased');
        const swalWithBootstrapButtons = Swal.mixin({
          customClass: {
            // confirmButton: 'btn btn-success',
            // cancelButton: 'btn btn-danger',
            popup: 'swal-size-sm',
          },
          // buttonsStyling: false,
        });
        swalWithBootstrapButtons.fire({
          popup  : 'swal-size-sm',
          icon   : 'question',
          title  : 'Details',
          html   : showHtml,
          // imageWidth : 200,
          // imageHeight: 100,
          // imageUrl         : '<?php echo base_url();?>../images/19.png',
          // imageAlt         : 'game name',
          // footer: '<a href>Why do I have this issue?</a>',
          showConfirmButton: true,
          confirmButtonText: 'Proceed',
          showCancelButton : true,
          cancelButtonColor: '#dc3545',
          // allowOutsideClick: false,
        }).then(function(response){
          // console.log(response);
          // if user choose pay then only trigger ajax
          if(response.value == true)
          {
            // console.log(gameidsToSend);
            // alert('integrate payment method');
            // $data->key.'|'.$data->txnid.'|'.$data->amount.'|'.$data->productinfo.'|'.$data->firstname.'|'.$data->email.'|||||'.$data->udf5.'||||||'.$data->salt
            gameidsToPass = btoa(gameidsToSend);
            // console.log($('#amount').val()); return false;
            // alert(totalPrize);
            if(totalPrize < 1)
            {
              // if user is asking for free games, then don't redirect him to payment
              // alert("recirect to: "+gameidsToPass);
              window.location = "<?php echo base_url('Payment/freeGame/free/'.session('loginUserData')->user_Id.'/');?>"+gameidsToPass;
            }
            else
            {
              var updatedScuuessUrl = $("#surl").val()+'/'+btoa(gameidsToSend);
              $("#surl").val(updatedScuuessUrl);
              $("#payment_form").submit();
            }
            return false;
          }
        });
      }
      else
      {
        Swal.fire({
          icon: 'error',
          title: 'Empty',
          html: 'There is no game in cart',
          showConfirmButton: false,
          showCancelButton: true,
          cancelButtonColor: '#dc3545',
          cancelButtonText: '<b>Close</b>',
        });
      }
    }

    async function generateHash(str)
    {
      var hashString = btoa(str);
      var hashData = await triggerAjaxAndReturnData("<?php echo base_url('Ajax/createHash/');?>"+hashString, 'hashString='+hashString);
      // console.log(hashData);
      if(hashData.code == 200)
      {
        // console.log(hashData.data);
        $("#hash").val(hashData.data);
      }
      else
      {
        console.log(hashData.message);
        console.log('Payment can not be made at this time. Please try later.')
      }
    }
    
    function redirectTophpFox(url) {
      window.location.href = '<?php echo $catalog_links_redirection_link ?>' + url;
    }
  </script>