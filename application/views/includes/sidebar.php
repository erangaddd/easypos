 <!-- Sidebar -->
  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <!--<a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?=base_url();?>">
          
          <div class="sidebar-brand-text mx-3"><img src="<?=base_url()?>/assets/img/logo.jpg" class="img-fluid"></div>
      </a>-->
	<!-- Sidebar Toggler (Sidebar) -->
    <hr class="sidebar-divider d-none d-md-block">
      <div class="text-left ml-3 d-none d-md-inline">
          <button class="border-0" id="sidebarToggle"></button> 
      </div>
      <!-- Divider -->
      <!--<hr class="sidebar-divider my-0">-->

      <!-- Nav Item - Dashboard -->
      <!--<li class="nav-item <? if($page == 'dashboard'){?>active<? }?>">
          <a class="nav-link" href="<?=base_url()?>">
              <i class="fas fa-fw fa-tachometer-alt"></i>
              <span>Dashboard</span></a>
      </li>
-->
      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
          Sales and returns
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <!--<li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
              aria-expanded="true" aria-controls="collapseTwo">
              <i class="fas fa-fw fa-cog"></i>
              <span>Components</span>
          </a>
          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
              <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Custom Components:</h6>
                  <a class="collapse-item" href="buttons.html">Buttons</a>
                  <a class="collapse-item" href="cards.html">Cards</a>
              </div>
          </div>
      </li>-->
      <li class="nav-item <? if($page == 'new_sale'){?>active<? }?>">
          <a class="nav-link" href="<?=base_url()?>sale/new_sale">
              <i class="fas fa-fw fa-shopping-cart"></i>
              <span>New Sale</span></a>
      </li>
      
      <li class="nav-item <? if($page == 'sales_history'){?>active<? }?>">
          <a class="nav-link" href="<?=base_url()?>sale/sales_history">
              <i class="far fa-hourglass"></i>
              <span>Sales History</span></a>
      </li>
      
<!--      <li class="nav-item <? if($page == 'sales_returns'){?>active<? }?>">
          <a class="nav-link" href="<?=base_url()?>returns/return_sales">
              <i class="fas fa-fw fa-exchange-alt"></i>
              <span>Sales Returns</span></a>
      </li>-->
      
      <li class="nav-item <? if($page == 'return_list'){?>active<? }?>">
          <a class="nav-link" href="<?=base_url()?>returns/return_list">
              <i class="fas fa-fw fa-undo"></i>
              <span>Return History</span></a>
      </li>

      <li class="nav-item <? if($page == 'customers'){?>active<? }?>">
          <a class="nav-link" href="<?=base_url()?>sale/customers">
              <i class="far fa-user"></i>
              <span>Customers</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
          Purchasing
      </div>

      <li class="nav-item <? if($page == 'grn_received'){?>active<? }?>">
          <a class="nav-link" href="<?=base_url()?>purchasings/grn_received">
              <i class="fas fa-fw fa-money-bill-wave"></i>
              <span>Goods Received</span></a>
      </li>
      
      <li class="nav-item <? if($page == 'reorder'){?>active<? }?>">
          <a class="nav-link" href="<?=base_url()?>purchasings/reorder">
              <i class="fas fa-fw fa-list"></i>
              <span>Re-order List</span></a>
      </li>
      
      <li class="nav-item <? if($page == 'grns'){?>active<? }?>">
          <a class="nav-link" href="<?=base_url()?>purchasings/history">
              <i class="fas fa-fw fa-history"></i>
              <span>History</span></a>
      </li>
      
      <li class="nav-item <? if($page == 'grn_items'){?>active<? }?>">
          <a class="nav-link" href="<?=base_url()?>purchasings/grn_items">
              <i class="fas fa-sitemap"></i>
              <span>GRN Items</span></a>
      </li>
       <li class="nav-item <? if($page == 'update_prices'){?>active<? }?>">
          <a class="nav-link" href="<?=base_url()?>purchasings/update_prices">
              <i class="fas fa-cloud-upload-alt"></i>
              <span>Update Price</span></a>
      </li>
      <li class="nav-item <? if($page == 'merge_stock'){?>active<? }?>">
          <a class="nav-link" href="<?=base_url()?>purchasings/merge_stock">
              <i class="far fa-object-ungroup"></i>
              <span>Merge Stock</span></a>
      </li>
      
      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
          Reports
      </div>

      <li class="nav-item <? if($page == 'sales_report'){?>active<? }?>">
          <a class="nav-link" href="<?=base_url()?>reports/sales_report">
              <i class="fab fa-fw fa-sellsy"></i>
              <span>Sales Report</span></a>
      </li>
      
      <li class="nav-item <? if($page == 'inventory_report'){?>active<? }?>">
          <a class="nav-link" href="<?=base_url()?>reports/inventory_report">
              <i class="fas fa-fw fa-cubes"></i>
              <span>Stock Report</span></a>
      </li>

      
      <!-- Divider -->
      <hr class="sidebar-divider">
      
      <div class="sidebar-heading">
          Configurations
      </div>
      
      <li class="nav-item <? if($page == 'config'){?>active<? }?>">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
              aria-expanded="true" aria-controls="collapseTwo">
              <i class="fas fa-fw fa-cog"></i>
              <span>Configs</span>
          </a>
          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
              <div class="bg-white py-2 collapse-inner rounded">
                  <!--<h6 class="collapse-header">Custom Components:</h6>-->
                  <a class="collapse-item" href="<?=base_url()?>config/items">Items</a>
                  <a class="collapse-item" href="<?=base_url()?>config/types">Types</a>
                  <a class="collapse-item" href="<?=base_url()?>config/categories">Categories</a>
                  <a class="collapse-item" href="<?=base_url()?>config/units">Units</a>
              </div>
          </div>
      </li>
	  <hr class="sidebar-divider">
      
      <li class="nav-item <? if($page == 'change_password'){?>active<? }?>">
          <a class="nav-link" href="<?=base_url()?>login/change_password">
              <i class="fas fa-key"></i>
              <span>Change Password</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

  </ul>
  <!-- End of Sidebar -->