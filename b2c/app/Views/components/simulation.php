<style>
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
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script>
    $(document).ready(function(){
      myGames = [];
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
      if(returnedResult.gamesCatalogue != undefined && returnedResult.gamesCatalogue.length>0)
      {
        // console.log(' add game rows from here');
        myGames = returnedResult;
        
        showData(1);
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
    // v;

    // Validate page
    if (page < 1) page = 1;
    if (page > numPages()) page = numPages();
     showData(page);
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
    return Math.ceil(myGames.gamesCatalogue.length / records_per_page);
  }
   // Create Listing view
   function showData(page) {
    returnedResult = myGames;
  
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
  
   console.log('dsatas' ,returnedResult );
   limit = page*records_per_page < returnedResult.gamesCatalogue.length ? page*records_per_page : returnedResult.gamesCatalogue.length ;

   for (var i = (page - 1) * records_per_page; i < limit; i++) {
 
          var Game_prise = returnedResult.gamesCatalogue[i].Game_prise ? returnedResult.gamesCatalogue[i].Game_prise+'-/INR' : '0.00-/INR'; // if there is no prise, set 0.00
          var Game_Image = returnedResult.gamesCatalogue[i].Game_Image ? returnedResult.gamesCatalogue[i].Game_Image : 'Game2.jpg'; // if there is no image, set default image
          var Game_longDescription = returnedResult.gamesCatalogue[i].Game_longDescription ? ((returnedResult.gamesCatalogue[i].Game_longDescription).length>500?(("<div class='toggleText'>"+returnedResult.gamesCatalogue[i].Game_longDescription).slice(0,500)+" <a href='javascript:void(0);' onclick='return showText(this);'>...Read More</a></div> <div class='longDescriptionText d-none'>"+returnedResult.gamesCatalogue[i].Game_longDescription+" <a href='javascript:void(0);' onclick='hideText(this)'>...Read Less</a></div>"):returnedResult.gamesCatalogue[i].Game_longDescription) : 'Put The Long Description Here'; // if there is no description, put default text 


            var packing_slip_orders = JSON.parse('<?php echo $catalog_links_array; ?>');
            if( packing_slip_orders[returnedResult.gamesCatalogue[i].Game_ID] && (packing_slip_orders[returnedResult.gamesCatalogue[i].Game_ID] != 'undefined') ) {
                $('#addGameRows').append('<div data-description="'+Game_longDescription+'" data-gamename="'+returnedResult.gamesCatalogue[i].Game_Name+'" class="card mb-3 col-md-12 allGameData" id="gameRow_'+returnedResult.gamesCatalogue[i].Game_ID+'"><div class="card-header text-blue"><span><b>'+returnedResult.gamesCatalogue[i].Game_Name+'</b></span> <span class="float-right d-none">'+Game_prise+'</span></div><div class="card-body"><div class="row"><div class="col-md-2"><img src="<?php echo API_URL;?>../../images/'+Game_Image+'" class="" alt="Image Not Available" style="width:100%; max-height:150px;"></div><div class="col-md-10">'+Game_longDescription+'<button type="button" class="btn btn-primary btn-flat float-right text-sm" data-number="0" onclick="return playSimulation();" >'+showButtonText(returnedResult.gamesCatalogue[i].gameStatus, returnedResult.gamesCatalogue[i].UG_ReplayCount)+'</button></div></div></div> <div class="col-md-12"><button style="width: 100%; margin: 10px; height: 35px;" onclick="redirectTophpFox(\''+packing_slip_orders[returnedResult.gamesCatalogue[i].Game_ID]+'\')">CLICK HERE FOR DETAILS</button></div> </div>');
            }else {
                $('#addGameRows').append('<div data-description="'+Game_longDescription+'" data-gamename="'+returnedResult.gamesCatalogue[i].Game_Name+'" class="card mb-3 col-md-12 allGameData" id="gameRow_'+returnedResult.gamesCatalogue[i].Game_ID+'"><div class="card-header text-blue"><span><b>'+returnedResult.gamesCatalogue[i].Game_Name+'</b></span> <span class="float-right d-none">'+Game_prise+'</span></div><div class="card-body"><div class="row"><div class="col-md-2"><img src="<?php echo API_URL;?>../../images/'+Game_Image+'" class="" alt="Image Not Available" style="width:100%; max-height:150px;"></div><div class="col-md-10">'+Game_longDescription+'<button type="button" class="btn btn-primary btn-flat float-right text-sm" data-number="0" onclick="return playSimulation();" >'+showButtonText(returnedResult.gamesCatalogue[i].gameStatus, returnedResult.gamesCatalogue[i].UG_ReplayCount)+'</button></div></div></div></div>');
            }
   }
  }
 
  </script>
