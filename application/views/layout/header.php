<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $settings->store_name; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/fonts/font-awesome/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/fonts/ionicons/ionicons.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/select2/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/daterangepicker/daterangepicker-bs3.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!-- Pace style -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/pace/pace.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/iCheck/square/blue.css">
  <!-- animate.css -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/animate/animate.css">
  <!-- mycss -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/mycss.css">
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="<?= base_url(); ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>M</b>B</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><?= $settings->store_name; ?></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?= base_url(); ?>assets/images/profile-pic/<?= $settings->photo; ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?= $settings->firstname . ' ' . $settings->lastname; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?= base_url(); ?>assets/images/profile-pic/<?= $settings->photo; ?>" class="img-circle" alt="User Image" style="width:160px; height:160px; cursor:pointer;" data-toggle="modal" data-target="#change_photo_modal">
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#" data-toggle="modal" data-target="#profile_modal">پروفایل</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#" data-toggle="modal" data-target="#change_username_modal">تغییر نام کاربری</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#" data-toggle="modal" data-target="#change_password_modal">تغییر کلمه عبور</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#" class="btn btn-default btn-flat" data-toggle="modal" data-target="#store_settings_modal">تنظیمات</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#" class="btn btn-default btn-flat" data-toggle="modal" data-target="#categories_modal">گتگوری ها</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="<?= base_url(); ?>logout" class="btn btn-block btn-default btn-flat">خروج</a>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12 text-center">
                    <a href="#" class="btn btn-block btn-default btn-flat" data-toggle="modal" data-target="#backup_modal">دانلود فایل پشتیبانی <i class="fa fa-database"></i></a>
                  </div>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
        </ul>
      </div>
    </nav>
  </header>

