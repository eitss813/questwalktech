
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>&copy; Copyright <a href="#">Humanlinks</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.5
    </div>
  </footer>
</div>
<!-- this div belongs to the first div of class wrapper -->
<!-- ./wrapper -->
<!-- REQUIRED SCRIPTS -->

<!-- Bootstrap -->
<script src="<?php echo base_url("writable/themeData/");?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="<?php echo base_url("writable/themeData/");?>dist/js/adminlte.js"></script>
<!-- Toastr -->
<script src="<?php echo base_url("writable/themeData/");?>plugins/toastr/toastr.min.js"></script>

<!-- OPTIONAL SCRIPTS -->
<!-- <script src="<?php echo base_url("writable/themeData/");?>plugins/chart.js/Chart.min.js"></script> -->
<script src="<?php echo base_url("writable/themeData/");?>dist/js/demo.js"></script>
<script src="<?php echo base_url("writable/themeData/");?>dist/js/pages/dashboard3.js"></script>
<!-- show success/error message here -->
<script>
<?php if(!empty(session('error'))) { ?>
    toastr.error("<?php echo session('error');?>");
  <?php } if(!empty(session('success'))) { ?>
    toastr.success("<?php echo session('success');?>");
  <?php } ?>

  function showDiscount(actualPrise, discount)
  {
    if(discount>0)
    {
      return '&nbsp;{<code>Original Price: &#8377; '+addZeroes(actualPrise)+' (Discount Applied: &#8377; '+addZeroes(discount)+')</code>}';
      // 
    }
    else
    {
      return '';
    }
  }

  function addZeroes(num)
  {
    if(num != 'Free')
    {
      if(Number.isInteger(num))
      {
        return num+'.00';
      }
      else
      {
        return num;
      }
    }
    else
    {
      return '<code>'+num+'</code>';
    }
  }

  function showText(element)
  {
    // toggleText longDescriptionText
    var parentDiv = $(element).parents('div.toggleText');
    parentDiv.toggleClass('d-none');
    parentDiv.next().toggleClass('d-none');
  }
  
  function hideText(element)
  {
    var parentDiv = $(element).parent('div.longDescriptionText');
    parentDiv.toggleClass('d-none');
    parentDiv.prev().toggleClass('d-none');
  }

  function searchGame(event)
  {
    event.preventDefault();
    searchGameData();
  }

  function searchGameData()
  {
    var searchFieldData = $('#gameSearch').val();
    // console.log(searchFieldData);
    searchGameByName(searchFieldData)
  }

  function searchGameByName(gameNameString)
  {
    var gameNameString = gameNameString.trim().toLowerCase();

    $('.allGameData').each(function(i,e){
      if(gameNameString.length > 0)
      {
        var gameName = $(this).data('gamename').toLowerCase();
        var description = $(this).data('description').toLowerCase();
        // gameName.includes(gameNameString)
        // $(this).hide(); // console.log(gameName.includes(gameNameString));
        if(gameName.includes(gameNameString) || description.includes(gameNameString))
        {
          $(this).show();
        }
        else
        {
          $(this).hide();
        }
      }
      else
      {
        $(this).show();
      }
    });
  }

//   function searchGame() {
//   var input, filter, cards, cardContainer, h5, title, i;
//   input = document.getElementById("myFilter");
//   filter = input.value.toUpperCase();
//   cardContainer = document.getElementById("simulationGames");
//   cards = cardContainer.getElementsByClassName("col-md-4");
//   for (i = 0; i < cards.length; i++) {
//     title = cards[i].querySelector(".card-body h3.card-title");
//     if (title.innerText.toUpperCase().indexOf(filter) > -1) {
//       cards[i].style.display = "";
//     } else {
//       cards[i].style.display = "none";
//     }
//   }
// }

async function triggerAjaxAndReturnData(url, data) {
    var returnedData = await fetch(url, {
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
<style>
  .toasts-top-right{
    margin-top: 3%;
    margin-right: 25%;
  }
  .toast-top-right{
    margin-top: 3%;
    margin-right: 25%;
  }
</style>
</body>
</html>