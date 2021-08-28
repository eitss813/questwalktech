<style>
  .swal2-close {
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
  #pagination-items {
    width: 100%;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    margin-bottom: 15px;
 
}

#pagination a {
  color: black;
  /* float: left; */
  padding: 8px 16px;
  text-decoration: none;
  transition: background-color .3s;
  border: 1px solid #ddd;
  margin: 0 4px;
}
#pagination p{
  display: inline-block;
}
#pagination a.active {
  /* background-color: #4CAF50;
  color: white; */
  border: 1px solid #007bff;
}
.total_page{
  margin-bottom: 0%;
  padding: 0 10px;
}
</style>
<!-- <?php // echo "<pre>"; print_r($userGamesInCart); die(' here '); 
      ?> -->
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
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
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
      <div class="row" id="pagination">
        <!-- add game rows here, by triggering ajax -->

        <div id="pagination-items">

        <a href="javascript:firstPage()" id="btn_first"><i class="fa fa-chevron-left"></i><i class="fa fa-chevron-left"></i></a>
      
      <a href="javascript:prevPage()" id="btn_prev"><i class="fa fa-chevron-left"></i></a>
      <a href="javascript:void(0)" class="current_page"></a>
       <p class="total_page"></p>
      <a href="javascript:nextPage()" id="btn_next"><i class="fa fa-chevron-right"></i></i></a>
      <a href="javascript:lastPage()" id="btn_last"><i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i></a>
        </div>
       
      
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
  $(document).ready(function() {
    userCartGames = [];
    createGameRows('');
    $('#gameCountInCart').text(<?php echo count($userGamesInCart['userData']); ?>);
  });
  var realData = [];

  function createGameRows(alertmsg) {
    // bring game rows via ajax
    fetch("<?php echo API_URL; ?>getGamesCatalogue/8", {
      method: "POST",
      headers: {
        'Accept': 'application/json, text/plain, */*',
        "Content-type": "application/x-www-form-urlencoded;"
        // "Content-Type": "application/json",
        // "X-Requested-With": "XMLHttpRequest"
      },
      body: '<?php echo ENT_LOGIN_CRED; ?>',
    }).then(function(response) {
      return response.json();
    }).then(function(returnedResult) {
      // console.log('data',returnedResult);
      // realData = returnedResult;
      if (returnedResult.code == 201) {
        toastr.error(returnedResult.message);
      }
      if (returnedResult.gamesCatalogue.length > 0) {
        // console.log(' add game rows from here');
        if (<?php echo $userGamesInCart['code']; ?> == 200) {
          // console.log('in if');
          <?php foreach ($userGamesInCart['userData'] as $cartGames) { ?>
            userCartGames.push(<?php echo $cartGames->cart_GameId; ?>);
          <?php } ?>
        }
        // console.log("data",userCartGames);

        // Extract catlogus data
        for (i = 0; i < returnedResult.gamesCatalogue.length ; i++) {

          if ($.inArray(parseInt(returnedResult.gamesCatalogue[i].Game_ID), userCartGames) == -1) {
            
            realData.push(returnedResult.gamesCatalogue[i]);

          } 
        }

        var checkGameRow = true; // this is to check that all the game are already in cart

        if(realData.length > 0){
            checkGameRow = false;
            // Add Catalouges
            checkGameRow = showData(realData,1);

        }


        if (checkGameRow) {
          $('#pagination').hide();
          $('#addGameRows').html('<div class="card mb-3 col-md-12 bg-danger">You have already added all the games to your cart.</div>')
        }
        // toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.');
        var alertmsg = 'no-alert-msg'; // to hide the alert msg
        if (alertmsg != 'no-alert-msg' && checkGameRow == false) {
          $(document).Toasts('create', {
            class: returnedResult.class,
            title: returnedResult.title,
            subtitle: "<strong>" + returnedResult.subtitle + "</strong>",
            autohide: true,
            icon: returnedResult.icon,
            delay: returnedResult.delay,
            // image: '<?php // echo base_url('writable/themeData/dist/img/user3-128x128.jpg');
                        ?>',
            // imageAlt: 'User Picture',
            body: returnedResult.message
          })
        }
      } else {
        $('#addGameRows').html('<div class="card mb-3 col-md-12 bg-danger">No games available for purchase. Or, you have already added all the games to your cart.</div>')
      }
    }).catch(function(err) {
      console.log('Fetch Error :-S', err);
      // $(document).Toasts('create', {
      //   class: 'bg-error',
      //   title: '',
      //   autohide: true,
      //   icon: 'fas fa-times-circle',
      //   delay: 2000,
      //   subtitle: 'FAILED',
      //   // image: '<?php // echo base_url('writable/themeData/dist/img/user3-128x128.jpg');
                      ?>',
      //   // imageAlt: 'User Picture',
      //   body: err,
      // })
    });
  }

  function addZeroesToPrize(num) {
    if (num != 'Free (Allowed Only Once)') {
      if (Number.isInteger(num)) {
        return '&#8377 ' + num + '.00';
      } else {
        return '&#8377 ' + num;
      }
    } else {
      return num;
    }
  }

  function addGameToCart(gameid) {
    var currentUserId = "<?php echo $current_user_id?>";
     if(currentUserId == 1){
      showLoginModel();
      return;
     }
   
    fetch("<?php echo base_url('Ajax/addGameToCart/') ?>" + gameid, {
      method: "POST",
      headers: {
        'Accept': 'application/json, text/plain, */*',
        "Content-type": "application/x-www-form-urlencoded;"
        // "Content-Type": "application/json",
        // "X-Requested-With": "XMLHttpRequest"
      },
      body: '',
    }).then(function(response) {
      return response.json();
    }).then(function(ajaxResult) {
      if (ajaxResult.code == 201) {
        toastr.error(ajaxResult.message);
      } else {
        userCartGames.push(gameid);
        toastr.success(ajaxResult.message);
        // console.log($('#gameRow_'+gameid));
        // $('#gameRow_' + gameid).remove();
        // if(!$('#addGameRows').children().length>0)
        // {
        //   $('#pagination').hide();
        //   // console.log('there are no child');
        //   $('#addGameRows').html('<div class="card mb-3 col-md-12 bg-danger">Nothing to show.</div>')
        // }
        // add cart number
        // console.log(parseInt($('#gameCountInCart').text()) + 1);
        $('#gameCountInCart').text(parseInt($('#gameCountInCart').text()) + 1);
        location.reload();
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

// Pagination Work Start
  var current_page = 1;
  var records_per_page = <?php echo ITEM_PER_PAGE ;?>;
 

  function prevPage() {
  
    if (current_page > 1) {
      current_page--;
    
      changePage(current_page);
      $('#btn_next').removeClass('active');
      $('#btn_prev').addClass('active');
      if(current_page ==1){
        $('#btn_prev').removeClass('active');
      $('#btn_next').addClass('active');
      }
    }
  }

  function nextPage() {
   
    if (current_page < numPages()) {
      current_page++;
      changePage(current_page);
      $('#btn_prev').removeClass('active');
      $('#btn_next').addClass('active');
      if(current_page == numPages()){
        $('#btn_next').removeClass('active');
      $('#btn_prev').addClass('active');
      }
    }
  }

  function firstPage(){
  
    current_page = 2;
    prevPage();
  }
  function lastPage(){
  
    current_page = numPages() - 1;
    nextPage();
}


  function changePage(page) {
    $('#addGameRows').html('');
    var btn_next = document.getElementById("btn_next");
    var btn_prev = document.getElementById("btn_prev");
    // var listing_table = document.getElementById("listingTable");
    var page_span = document.getElementById("page");
    var returnedResult = realData;

    // Validate page
    if (page < 1) page = 1;
    if (page > numPages()) page = numPages();
     showData(returnedResult,page);
    // page_span.innerHTML = page;
    $('.current_page').html(page);
    if (page == 1) {
      btn_prev.disabled = true;
      btn_prev.style.color = '#ddd';
      btn_prev.style.backgroundColor = 'transparent';
      $('#btn_first').css('background','transparent');
    } else {
      btn_prev.disabled = false;
      btn_prev.style.color = '#000';
      btn_prev.style.backgroundColor = '#fff';
      $('#btn_first').css('background','#fff');
      $('#btn_first').css('color','#000');
    }
  
    if (page == numPages()) {
      btn_next.style.color = '#ddd';
      btn_next.disabled = true;
      btn_next.style.backgroundColor = 'transparent';
      $('#btn_last').css('background','transparent');
      $('#btn_last').css('color','#ddd');
      $('#btn_next').removeClass('active');
      $('#btn_prev').addClass('active');
    } else {
      btn_next.disabled = false;
      btn_next.style.color = '#000';
      $('#btn_last').css('color','#000');
      $('#btn_last').css('background','#fff');
      btn_next.style.backgroundColor = '#fff';
    
    }
  }

  function numPages() {
    return Math.ceil(realData.length / records_per_page);
  }

  // Create Listing view
  function showData(returnedResult,page) {
   
   if(page == 1){
    $('.total_page').text( 'of '+numPages());
    
    $('#btn_next').css('background','#fff');
    $('#btn_last').css('background','#fff');
    $('#btn_next').addClass('active');
     $('.current_page').html(1);
    // $('#btn_prev').addClass('disabled');
     $('#btn_prev').css('color','#ddd');
     $('#btn_first').css('color','#ddd');
     if(returnedResult.length == 1 || returnedResult.length == records_per_page){
      $('#btn_next').attr('disabled',true);
     }
   }

   limit = page*records_per_page < returnedResult.length ? page*records_per_page : returnedResult.length ;

   for (var i = (page - 1) * records_per_page; i < limit; i++) {
     console.log("data",returnedResult[i].Game_ID);
       
       var Game_prise = (returnedResult[i].Game_prise > 0) ? (returnedResult[i].Game_prise - returnedResult[i].Game_discount) : 'Free (Allowed Only Once)'; // if there is no prise, set 0.00
       var Game_Image = returnedResult[i].Game_Image ? returnedResult[i].Game_Image : 'Game2.jpg'; // if there is no image, set default image
       var Game_longDescription = returnedResult[i].Game_longDescription ? ((returnedResult[i].Game_longDescription).length > 500 ? (("<div class='toggleText'>" + returnedResult[i].Game_longDescription).slice(0, 500) + " <a href='javascript:void(0);' onclick='return showText(this);'>...Read More</a></div> <div class='longDescriptionText d-none'>" + returnedResult[i].Game_longDescription + " <a href='javascript:void(0);' onclick='hideText(this)'>...Read Less</a></div>") : returnedResult[i].Game_longDescription) : 'Put The Long Description Here'; // if there is no description, put default text 


       console.log("Long Description: " + Game_longDescription);

       var enable_link_btns = '<?php echo $enable_link_btns ?>';
       var packing_slip_orders = JSON.parse('<?php echo $catalog_links_array; ?>');
       if (packing_slip_orders[returnedResult[i].Game_ID] && (packing_slip_orders[returnedResult[i].Game_ID] != 'undefined')) {
         if (enable_link_btns) {
           $('#addGameRows').append('<div data-description="' + Game_longDescription + '" data-gamename="' + returnedResult[i].Game_Name + '" class="card mb-3 col-md-12 allGameData" id="gameRow_' + returnedResult[i].Game_ID + '"><div class="card-header text-blue"><span><b>' + returnedResult[i].Game_Name + '</b> </span> <span class="float-right"><b>' + addZeroesToPrize(Game_prise) + '</b> ' + showDiscount(returnedResult[i].Game_prise, returnedResult[i].Game_discount) + ' </span></div><div class="card-body"><div class="row"><div class="col-md-2"><img src="<?php echo API_URL; ?>../../images/' + Game_Image + '" class="" alt="Image Not Available" style="width:100%; max-height:150px;"></div><div class="col-md-10">' + Game_longDescription + '<button type="button" class="btn btn-primary btn-flat float-right text-sm" data-number="0" onclick="return addGameToCart(' + returnedResult[i].Game_ID + ');" >Add To Cart</button><button type="button" class="btn btn-success btn-flat float-right text-sm mr-2" data-number="0" onclick="return addLink(' + returnedResult[i].Game_ID + ', \'' + packing_slip_orders[returnedResult[i].Game_ID] + '\');" >Edit Link</button><button type="button" class="btn btn-danger btn-flat float-right text-sm mr-2" data-number="0" onclick="return deleteLink(' + returnedResult[i].Game_ID + ');" >Delete Link</button></div></div></div> <div class="col-md-12"><button style="width: 100%; margin: 10px; height: 35px;" onclick="redirectTophpFox(\'' + packing_slip_orders[returnedResult[i].Game_ID] + '\')">CLICK HERE FOR DETAILS</button></div>  </div>');
         } else {
           $('#addGameRows').append('<div data-description="' + Game_longDescription + '" data-gamename="' + returnedResult[i].Game_Name + '" class="card mb-3 col-md-12 allGameData" id="gameRow_' + returnedResult[i].Game_ID + '"><div class="card-header text-blue"><span><b>' + returnedResult[i].Game_Name + '</b> </span> <span class="float-right"><b>' + addZeroesToPrize(Game_prise) + '</b> ' + showDiscount(returnedResult[i].Game_prise, returnedResult[i].Game_discount) + ' </span></div><div class="card-body"><div class="row"><div class="col-md-2"><img src="<?php echo API_URL; ?>../../images/' + Game_Image + '" class="" alt="Image Not Available" style="width:100%; max-height:150px;"></div><div class="col-md-10">' + Game_longDescription + '<button type="button" class="btn btn-primary btn-flat float-right text-sm" data-number="0" onclick="return addGameToCart(' + returnedResult[i].Game_ID + ');" >Add To Cart</button></div></div></div> <div class="col-md-12"><button style="width: 100%; margin: 10px; height: 35px;" onclick="redirectTophpFox(\'' + packing_slip_orders[returnedResult[i].Game_ID] + '\')">CLICK HERE FOR DETAILS</button></div>  </div>');
         }
       } else {
         if (enable_link_btns) {
           $('#addGameRows').append('<div data-description="' + Game_longDescription + '" data-gamename="' + returnedResult[i].Game_Name + '" class="card mb-3 col-md-12 allGameData" id="gameRow_' + returnedResult[i].Game_ID + '"><div class="card-header text-blue"><span><b>' + returnedResult[i].Game_Name + '</b> </span> <span class="float-right"><b>' + addZeroesToPrize(Game_prise) + '</b> ' + showDiscount(returnedResult[i].Game_prise, returnedResult[i].Game_discount) + ' </span></div><div class="card-body"><div class="row"><div class="col-md-2"><img src="<?php echo API_URL; ?>../../images/' + Game_Image + '" class="" alt="Image Not Available" style="width:100%; max-height:150px;"></div><div class="col-md-10">' + Game_longDescription + '<button type="button" class="btn btn-primary btn-flat float-right text-sm" data-number="0" onclick="return addGameToCart(' + returnedResult[i].Game_ID + ');" >Add To Cart</button><button type="button" class="btn btn-success btn-flat float-right text-sm mr-2" data-number="0" onclick="return addLink(' + returnedResult[i].Game_ID + ');" >Add Link</button></div></div></div></div>');
         } else {
           $('#addGameRows').append('<div data-description="' + Game_longDescription + '" data-gamename="' + returnedResult[i].Game_Name + '" class="card mb-3 col-md-12 allGameData" id="gameRow_' + returnedResult[i].Game_ID + '"><div class="card-header text-blue"><span><b>' + returnedResult[i].Game_Name + '</b> </span> <span class="float-right"><b>' + addZeroesToPrize(Game_prise) + '</b> ' + showDiscount(returnedResult[i].Game_prise, returnedResult[i].Game_discount) + ' </span></div><div class="card-body"><div class="row"><div class="col-md-2"><img src="<?php echo API_URL; ?>../../images/' + Game_Image + '" class="" alt="Image Not Available" style="width:100%; max-height:150px;"></div><div class="col-md-10">' + Game_longDescription + '<button type="button" class="btn btn-primary btn-flat float-right text-sm" data-number="0" onclick="return addGameToCart(' + returnedResult[i].Game_ID + ');" >Add To Cart</button></div></div></div></div>');
         }
       }

   }

 }

</script>