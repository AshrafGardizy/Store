  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar direction">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-right image">
          <img src="<?= base_url(); ?>assets/images/profile-pic/<?= $settings->photo; ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-right info">
          <p><?= $settings->firstname . ' ' . $settings->lastname; ?></p>
          <small><i class="fa fa-circle text-success"></i> مدیر سیستم</small>
        </div>
      </div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">منو اصلی</li>
        <li id="dashboard-nav-item">
          <a href="<?= base_url(); ?>">
            <i class="fa fa-dashboard"></i> <span>داشبورد</span> <i class="pull-right"></i>
          </a>
        </li>
        <li class="treeview" id="sales-nav-item">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>فروشات</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li id="sales-list-nav-item"><a href="<?= base_url(); ?>sales"><i class="fa fa-circle-o"></i> لیست فروشات</a></li>
            <li id="add-sale-nav-item"><a href="#" data-toggle="modal" data-target="#add_sale_modal"><i class="fa fa-circle-o"></i> فروش جدید</a></li>
          </ul>
        </li>

        <li class="treeview" id="goods-nav-item">
          <a href="#">
            <i class="fa fa-database"></i>
            <span>گدام</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li id="goods-list-nav-item"><a href="<?= base_url(); ?>goods"><i class="fa fa-circle-o"></i> لیست اجناس</a></li>
            <li id="add-good-nav-item"><a href="#" data-toggle="modal" data-target="#add_good_modal"><i class="fa fa-circle-o"></i> درج جنس جدید</a></li>
          </ul>
        </li>

        <li id="perm-customers-nav-item">
          <a href="<?= base_url(); ?>perm-customers">
            <i class="fa fa-users"></i> <span>مشترکین دایمی</span> <i class="pull-right"></i>
          </a>
        </li>

        <li id="company-finances-nav-item">
          <a href="<?= base_url(); ?>expenses">
            <i class="fa fa-book"></i> <span>حسابات شرکت</span>
          </a>
        </li>

        <li class="treeview" id="finances-nav-item">
          <a href="#">
            <i class="fa fa-th"></i>
            <span>حسابات مردم</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li id="perm-customers-finances-nav-item"><a href="<?= base_url(); ?>perm-customers-finances"><i class="fa fa-circle-o"></i> حسابات مشترکین دایمی</a></li>
            <li id="people-finances-nav-item"><a href="<?= base_url(); ?>people-finances"><i class="fa fa-circle-o"></i> حسابات مردم متفرقه</a></li>
          </ul>
        </li>
        
        <li id="expenses-nav-item">
          <a href="<?= base_url(); ?>expenses">
            <i class="fa fa-book"></i> <span>مصارف (روزنامچه)</span>
          </a>
        </li>
        
        <li id="reports-nav-item">
          <a href="<?= base_url(); ?>reports">
            <i class="fa fa-table"></i> <span>گزارشات</span>
          </a>
        </li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
