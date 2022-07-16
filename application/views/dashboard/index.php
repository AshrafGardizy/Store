  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        داشبورد
        <small>پنل مدیریت</small>
      </h1>
      <ol class="breadcrumb" style="direction:rtl;">
        <li><a href="#"><i class="fa fa-dashboard"></i> خانه</a></li>
        <li class="active">داشبورد</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Alert -->
      <?php if ($this->session->flashdata('success')) : ?>
      <div class="alert alert-success alert-dismissable animated zoomIn" style="direction:rtl;">
        <span class="close" data-dismiss="alert" aria-label="close">&times;</span>
        <?php if ($this->session->flashdata('success') == 'sale_canceled') : ?>
          <strong>موفقیت!</strong> فروش موفقانه کنسل شد.
        <?php else : ?>
          <strong>موفقیت!</strong> عملیات موفقانه انجام شد.
        <?php endif; ?>
      </div>
      <?php elseif ($this->session->flashdata('danger')) : ?>
      <div class="alert alert-danger alert-dismissable animated shake" style="direction:rtl;">
        <span class="close" data-dismiss="alert" aria-label="close">&times;</span>
        <strong>ناکام!</strong> عملیات ناکام ماند.
      </div>
      <?php endif; ?>

      <?= var_dump($jalali_today); ?>
      
      <!-- Small boxes (Stat box) -->
      <!-- <div class="row">
        <div class="col-lg-3 col-xs-6"> -->
          <!-- small box -->
          <!-- <div class="small-box bg-aqua">
            <div class="inner">
              <h3>150</h3>

              <p>سفارشات جدید</p>
            </div>
            <div class="icon">
              <i class="fa fa-shopping-cart"></i>
            </div>
            <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-left"></i> اطلاعات بیشتر </a>
          </div>
        </div> -->
        <!-- ./col -->
        <!-- <div class="col-lg-3 col-xs-6"> -->
          <!-- small box -->
          <!-- <div class="small-box bg-green">
            <div class="inner">
              <h3>53<sup style="font-size: 20px">%</sup></h3>

              <p>افزایش امتیاز</p>
            </div>
            <div class="icon">
              <i class="fa fa-thumbs-up"></i>
            </div>
            <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-left"></i> اطلاعات بیشتر </a>
          </div>
        </div> -->
        <!-- ./col -->
        <!-- <div class="col-lg-3 col-xs-6"> -->
          <!-- small box -->
          <!-- <div class="small-box bg-yellow">
            <div class="inner">
              <h3>44</h3>

              <p>کاربران ثبت شده</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-left"></i> اطلاعات بیشتر </a>
          </div>
        </div> -->
        <!-- ./col -->
        <!-- <div class="col-lg-3 col-xs-6"> -->
          <!-- small box -->
          <!-- <div class="small-box bg-red">
            <div class="inner">
              <h3>65</h3>

              <p>بازدید های جدید</p>
            </div>
            <div class="icon">
              <i class="fa fa-dashboard"></i>
            </div>
            <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-left"></i> اطلاعات بیشتر </a>          </div>
        </div> -->
        <!-- ./col -->
      <!-- </div> -->
      <!-- /.row -->

      <!-- Main row -->
      <div class="row">
        <!-- Main Content Goes Here -->
      </div>
      <!-- /.row (main row) -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
