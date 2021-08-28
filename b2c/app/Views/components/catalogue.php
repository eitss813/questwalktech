<style>
  .swal2-close{
    outline: 5px auto -webkit-focus-ring-color;
    font-weight: bold;
    color: red
  }
  
  .swal2-popup {
      width: 35%;
  }
  
  .swal-addlink-popup-dropdown {
    width: 100%;
    height: 35px;
    color: #495057;
    font-size: 16px;
    padding-left: 5px;
  }
  
  #swal2-content {
      margin-left: 0%;
      margin: 5%;
  }
</style>
<!-- <?php // echo "<pre>"; print_r($userGamesInCart); die(' here '); ?> -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Catalogue</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
              <li class="breadcrumb-item active">Catalogue</li>
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
      userCartGames = [];
      createGameRows('');
      $('#gameCountInCart').text(<?php echo count($userGamesInCart['userData']);?>);
    });
    
    function createGameRows(alertmsg)
    {
      // bring game rows via ajax
      fetch("<?php echo API_URL;?>getGamesCatalogue/8", {
      method: "POST",
      headers: {
        'Accept': 'application/json, text/plain, */*',
        "Content-type": "application/x-www-form-urlencoded;"
        // "Content-Type": "application/json",
        // "X-Requested-With": "XMLHttpRequest"
      },
      body: '<?php echo ENT_LOGIN_CRED;?>',
    }).then(function(response){
      return response.json();
    }).then(function(returnedResult){
      // console.log(returnedResult);
      if(returnedResult.code == 201)
      {
        toastr.error(returnedResult.message);
      }
      if(returnedResult.gamesCatalogue.length>0)
      {
        // console.log(' add game rows from here');
        if(<?php echo $userGamesInCart['code'];?> == 200)
        {
          // console.log('in if');
          <?php foreach($userGamesInCart['userData'] as $cartGames){ ?>
            userCartGames.push(<?php echo $cartGames->cart_GameId;?>);
          <?php } ?>
        }
        // console.log(userCartGames);
        var checkGameRow = true; // this is to check that all the game are already in cart
        $.each(returnedResult.gamesCatalogue, function(i,e){
          // console.log($.inArray(returnedResult.gamesCatalogue[i].Game_ID, userCartGames));
          // console.log($.type(returnedResult.gamesCatalogue[i].Game_ID));console.log($.type(userCartGames));
          
          if($.inArray(parseInt(returnedResult.gamesCatalogue[i].Game_ID), userCartGames) != -1)
          {
            // console.log(returnedResult.gamesCatalogue[i].Game_Name+' is already in cart with '+returnedResult.gamesCatalogue[i].Game_ID);
            console.log('game already in cart');
          }
          else
          {
            checkGameRow = false;
            // console.log(i); $('#addGameRows').append('<div class="row col-md-12">mksahu '+i+'</div>');
            var Game_prise = (returnedResult.gamesCatalogue[i].Game_prise > 0) ? (returnedResult.gamesCatalogue[i].Game_prise - returnedResult.gamesCatalogue[i].Game_discount) : 'Free (Allowed Only Once)'; // if there is no prise, set 0.00
            var Game_Image = returnedResult.gamesCatalogue[i].Game_Image ? returnedResult.gamesCatalogue[i].Game_Image : 'Game2.jpg'; // if there is no image, set default image
            var Game_longDescription = returnedResult.gamesCatalogue[i].Game_longDescription ? ((returnedResult.gamesCatalogue[i].Game_longDescription).length>500?(("<div class='toggleText'>"+returnedResult.gamesCatalogue[i].Game_longDescription).slice(0,500)+" <a href='javascript:void(0);' onclick='return showText(this);'>...Read More</a></div> <div class='longDescriptionText d-none'>"+returnedResult.gamesCatalogue[i].Game_longDescription+" <a href='javascript:void(0);' onclick='hideText(this)'>...Read Less</a></div>"):returnedResult.gamesCatalogue[i].Game_longDescription) : 'Put The Long Description Here'; // if there is no description, put default text 


            console.log("Long Description: " + Game_longDescription);

            var enable_link_btns = '<?php echo $enable_link_btns ?>';
            var packing_slip_orders = JSON.parse('<?php echo $catalog_links_array; ?>');
            if( packing_slip_orders[returnedResult.gamesCatalogue[i].Game_ID] && (packing_slip_orders[returnedResult.gamesCatalogue[i].Game_ID] != 'undefined') ) {
                if( enable_link_btns ) {
                    $('#addGameRows').append('<div data-description="'+Game_longDescription+'" data-gamename="'+returnedResult.gamesCatalogue[i].Game_Name+'" class="card mb-3 col-md-12 allGameData" id="gameRow_'+returnedResult.gamesCatalogue[i].Game_ID+'"><div class="card-header text-blue"><span><b>'+returnedResult.gamesCatalogue[i].Game_Name+'</b> </span> <span class="float-right"><b>'+addZeroesToPrize(Game_prise)+'</b> '+showDiscount(returnedResult.gamesCatalogue[i].Game_prise, returnedResult.gamesCatalogue[i].Game_discount)+' </span></div><div class="card-body"><div class="row"><div class="col-md-2"><img src="<?php echo API_URL;?>../../images/'+Game_Image+'" class="" alt="Image Not Available" style="width:100%; max-height:150px;"></div><div class="col-md-10">'+Game_longDescription+'<button type="button" class="btn btn-primary btn-flat float-right text-sm" data-number="0" onclick="return addGameToCart('+returnedResult.gamesCatalogue[i].Game_ID+');" >Add To Cart</button><button type="button" class="btn btn-success btn-flat float-right text-sm mr-2" data-number="0" onclick="return addLink('+returnedResult.gamesCatalogue[i].Game_ID+', \''+packing_slip_orders[returnedResult.gamesCatalogue[i].Game_ID]+'\');" >Edit Link</button><button type="button" class="btn btn-danger btn-flat float-right text-sm mr-2" data-number="0" onclick="return deleteLink('+returnedResult.gamesCatalogue[i].Game_ID+');" >Delete Link</button></div></div></div> <div class="col-md-12"><button style="width: 100%; margin: 10px; height: 35px;" onclick="redirectTophpFox(\''+packing_slip_orders[returnedResult.gamesCatalogue[i].Game_ID]+'\')">CLICK HERE FOR DETAILS</button></div>  </div>');
                }else {
                    $('#addGameRows').append('<div data-description="'+Game_longDescription+'" data-gamename="'+returnedResult.gamesCatalogue[i].Game_Name+'" class="card mb-3 col-md-12 allGameData" id="gameRow_'+returnedResult.gamesCatalogue[i].Game_ID+'"><div class="card-header text-blue"><span><b>'+returnedResult.gamesCatalogue[i].Game_Name+'</b> </span> <span class="float-right"><b>'+addZeroesToPrize(Game_prise)+'</b> '+showDiscount(returnedResult.gamesCatalogue[i].Game_prise, returnedResult.gamesCatalogue[i].Game_discount)+' </span></div><div class="card-body"><div class="row"><div class="col-md-2"><img src="<?php echo API_URL;?>../../images/'+Game_Image+'" class="" alt="Image Not Available" style="width:100%; max-height:150px;"></div><div class="col-md-10">'+Game_longDescription+'<button type="button" class="btn btn-primary btn-flat float-right text-sm" data-number="0" onclick="return addGameToCart('+returnedResult.gamesCatalogue[i].Game_ID+');" >Add To Cart</button></div></div></div> <div class="col-md-12"><button style="width: 100%; margin: 10px; height: 35px;" onclick="redirectTophpFox(\''+packing_slip_orders[returnedResult.gamesCatalogue[i].Game_ID]+'\')">CLICK HERE FOR DETAILS</button></div>  </div>');
                }
            }else {
                if( enable_link_btns ) {
                    $('#addGameRows').append('<div data-description="'+Game_longDescription+'" data-gamename="'+returnedResult.gamesCatalogue[i].Game_Name+'" class="card mb-3 col-md-12 allGameData" id="gameRow_'+returnedResult.gamesCatalogue[i].Game_ID+'"><div class="card-header text-blue"><span><b>'+returnedResult.gamesCatalogue[i].Game_Name+'</b> </span> <span class="float-right"><b>'+addZeroesToPrize(Game_prise)+'</b> '+showDiscount(returnedResult.gamesCatalogue[i].Game_prise, returnedResult.gamesCatalogue[i].Game_discount)+' </span></div><div class="card-body"><div class="row"><div class="col-md-2"><img src="<?php echo API_URL;?>../../images/'+Game_Image+'" class="" alt="Image Not Available" style="width:100%; max-height:150px;"></div><div class="col-md-10">'+Game_longDescription+'<button type="button" class="btn btn-primary btn-flat float-right text-sm" data-number="0" onclick="return addGameToCart('+returnedResult.gamesCatalogue[i].Game_ID+');" >Add To Cart</button><button type="button" class="btn btn-success btn-flat float-right text-sm mr-2" data-number="0" onclick="return addLink('+returnedResult.gamesCatalogue[i].Game_ID+');" >Add Link</button></div></div></div></div>');
                }else {
                    $('#addGameRows').append('<div data-description="'+Game_longDescription+'" data-gamename="'+returnedResult.gamesCatalogue[i].Game_Name+'" class="card mb-3 col-md-12 allGameData" id="gameRow_'+returnedResult.gamesCatalogue[i].Game_ID+'"><div class="card-header text-blue"><span><b>'+returnedResult.gamesCatalogue[i].Game_Name+'</b> </span> <span class="float-right"><b>'+addZeroesToPrize(Game_prise)+'</b> '+showDiscount(returnedResult.gamesCatalogue[i].Game_prise, returnedResult.gamesCatalogue[i].Game_discount)+' </span></div><div class="card-body"><div class="row"><div class="col-md-2"><img src="<?php echo API_URL;?>../../images/'+Game_Image+'" class="" alt="Image Not Available" style="width:100%; max-height:150px;"></div><div class="col-md-10">'+Game_longDescription+'<button type="button" class="btn btn-primary btn-flat float-right text-sm" data-number="0" onclick="return addGameToCart('+returnedResult.gamesCatalogue[i].Game_ID+');" >Add To Cart</button></div></div></div></div>');
                }
            }
          }
        });
        if(checkGameRow)
        {
          $('#addGameRows').html('<div class="card mb-3 col-md-12 bg-danger">You have already added all the games to your cart.</div>')
        }
        // toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.');
        var alertmsg = 'no-alert-msg'; // to hide the alert msg
        if(alertmsg != 'no-alert-msg' && checkGameRow==false)
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

    function addZeroesToPrize(num)
    {
      if(num != 'Free (Allowed Only Once)')
      {
        if(Number.isInteger(num))
        {
          return '&#8377 '+num+'.00';
        }
        else
        {
          return '&#8377 '+num;
        }
      }
      else
      {
        return num;
      }
    }

    function addGameToCart(gameid)
    {
      fetch("<?php echo base_url('Ajax/addGameToCart/')?>"+gameid, {
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
        $('#gameCountInCart').text(parseInt($('#gameCountInCart').text()) + 1);
      }
      eval(ajaxResult.redirect);
    });
      $('#addGameRows').html(''); // remove all game reows and then next line function will add them again
      createGameRows('no-alert-msg');
    }
    
    
  function addLink(game_id, urls = '', target = '') {
    let is_update = false;

//    if (urls && urls != '')
//      is_update = true;
  
    let html = '<div class="add-link-box"><div class="form-group">';
    html += '<label for="link_field" style="font-size: 16px;">Enter Link</label>';
    html += '<input type="email" class="form-control mb-1" id="link_field" aria-describedby="emailHelp" placeholder="Enter Url" value="' + urls + '">';
    // html += '<small id="emailHelp" class="form-text text-muted">Multiple URLs should be comma separated.</small></div>';
//    html += '<div class="form-group"><label for="target_field" style="font-size: 16px;">Open Link In</label><br>';
//    html += '<select id="target_field" class="swal-addlink-popup-dropdown">';
//    if (target == '_blank')
//      html += '<option value="_blank" selected>Open in new tab</option>';
//    else
//      html += '<option value="_blank">Open in new tab</option>';

//    if (target == '_self')
//      html += '<option value="_self" selected>Open in same tab</option>';
//    else
//      html += '<option value="_self">Open in same tab</option>';

//    html += '</select> </div></div>';
    html += '</div>';


    Swal.fire({
      title: 'Add/Edit Link', //is_update ? 'Edit Link' : 'Add Link',
      html: html,
      inputPlaceholder: 'Enter URLs by comma seperated.',
      inputAttributes: {
        autocapitalize: 'off'
      },
      showCancelButton: true,
      confirmButtonText: is_update ? 'Update' : 'Submit',
      showLoaderOnConfirm: true,
      cancelButtonColor: '#d33',
      customClass: {
        title: 'swal-2-title-champ',
        popup: 'add-link-popup',
        input: 'add-link-input',
        content: 'add-link-content',
        confirmButton: 'btn-text',
        cancelButton: 'btn-text',
      },
      preConfirm: function preConfirm(value) {
        let link = $('#link_field').val();
        let target = $('#target_field').val()

        if (true || link) {
          return $.ajax({
            type: "post",
            url: is_update ? '<?php echo base_url("Ajax/updateLinkToCatalogItem"); ?>' : '<?php echo base_url("Ajax/addLinkToCatalogItem"); ?>',
            data: {
              action: is_update ? 'updateLinkToCatalogItem' : 'addLinkToCatalogItem',
              link: link,
              target: target,
              game_id: game_id,
            },
            success: function(resp) {
              resp = JSON.parse(resp);
              if (resp.success)
                return true;
              else if (resp.message)
                Swal.showValidationMessage(resp.message);
              else
                Swal.showValidationMessage('Not submitted, Please try again later.');
            },
            error: function(text) {
              Swal.showValidationMessage(text);
            }
          });
        } else {
        
//           Swal.showValidationMessage('Please provide valid url.');
        }
      },
      allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
      if (result.value) {

        if (is_update)
          toastr.success('Link updated successfully.');
        else
          toastr.success('Link added successfully.');

        window.location.reload();
      }
    })
  }

  function deleteLink(game_id) {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
      customClass: {
        popup: 'add-link-popup',
        confirmButton: 'btn-text',
        cancelButton: 'btn-text'
      }
    }).then((result) => {
      if (result.value) {
        $.ajax({
          type: "post",
          url: '<?php echo base_url("Ajax/deleteLinkToCatalogItem"); ?>',
          data: {
            action: 'deleteLinkToCatalogItem',
            game_id: game_id,
          },
          success: function(resp) {
            resp = JSON.parse(resp);
            if (resp.success) {
              $('.links').remove();
              $('#delete_btn_' + game_id).hide();
              $('#edit_btn_' + game_id).hide();
              $('#add_btn_' + game_id).removeClass('d-none');
              $('#add_btn_' + game_id).show();
              toastr.success('Link has been deleted.');
              
              window.location.reload();
            }
          },
          error: function(text) {
            console.log('error', text);
          }
        });

      }
    })
  }
  
  function redirectTophpFox(url) {
    window.location.href = '<?php echo $catalog_links_redirection_link ?>' + url;
  }

  </script>
