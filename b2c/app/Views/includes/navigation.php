<!-- Main Sidebar Container -->
<?php 
  // echo "<pre>"; print_r(session('loginUserData')->user_Pic); die(' here '); // $this->session->get('loginUserData')->user_Pic; 
  // echo "<pre>"; print_r(uri_string()); die(' here ');
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url();?>" class="brand-link">
      <img src="<?php echo base_url("writable/themeData/");?>dist/img/logo.png" alt="Humanlinks Logo" class="brand-image elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">&nbsp;</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo base_url("writable/uploads/profilePic/");?><?php echo session('loginUserData')->user_Pic?:'avatar.png';?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo session('loginUserData')->user_Fname .' '.session('loginUserData')->user_Lname; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?php echo base_url('Catalogue');?>" class="nav-link <?php echo (uri_string() == 'Catalogue'?'active':NULL);?>">
              <i class="far fa-circle nav-icon text-danger"></i>
              <p>Catalogue</p>
            </a>
          </li>
          <?php
         
          
          if($_SESSION['loginUserData']->user_Id != 1){?>
            <li class="nav-item">
            <a href="<?php echo base_url('Cart');?>" class="nav-link <?php echo (uri_string() == 'Cart'?'active':NULL);?>">
              <i class="far fa-circle nav-icon text-warning"></i>
              <p>Cart</p>
            </a>
          </li>
          <?php } else{?>
            <li class="nav-item">
            <a href="javacript:void();" onclick="showLoginModel()" class="nav-link <?php echo (uri_string() == 'Cart'?'active':NULL);?>" on>
              <i class="far fa-circle nav-icon text-warning"></i>
              <p>Cart</p>
            </a>
          </li>
            <?php }?>
         
         
          <!-- <li class="nav-item">
            <a href="<?php // echo base_url('profile');?>" class="nav-link <?php // echo (uri_string() == 'profile'?'active':NULL);?>">
              <i class="far fa-circle nav-icon text-info"></i>
              <p>Profile</p>
            </a>
          </li> -->
          <?php  if($_SESSION['loginUserData']->user_Id != 1){?>
          <li class="nav-item">
            <a href="<?php echo base_url('Simulation');?>" class="nav-link <?php echo (uri_string() == 'Simulation'?'active':NULL);?>">
              <i class="far fa-circle nav-icon text-success"></i>
              <p>My Items</p>
            </a>
          </li>
          <?php } ?>
          <!-- <li class="nav-header">MULTI LEVEL EXAMPLE</li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-circle nav-icon"></i>
              <p>Level 1</p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-circle"></i>
              <p>
                Level 1
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Level 2</p>
                </a>
              </li>
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Level 2
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Level 3</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Level 3</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Level 3</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Level 2</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-circle nav-icon"></i>
              <p>Level 1</p>
            </a>
          </li> -->
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <script>
    function showLoginModel(){
      Swal.fire({
      icon: 'warning',
      html: '<h3 style="text-align:center">Please Login!</h3>',
      showConfirmButton: false,
      footer: '<a href="<?php base_url()?>login">Click here to login</a>'
})
}
  </script>
