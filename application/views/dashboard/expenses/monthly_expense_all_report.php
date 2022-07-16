<?php
$total_money = 0;
foreach ($expenses as $expense_item_for_total) {
    $total_money += $expense_item_for_total->total;
}
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      </h1>
      <ol class="breadcrumb" style="direction:rtl;">
        <li><a href="#"><i class="fa fa-dashboard"></i> خانه</a></li>
        <li class="active">گزارشات</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        گزارش ماهانه مصارف
                        (کلی)
                    </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <p class="">
                        (
                        تاریخ:
                        <?= $report_year . ' / ' . $report_month; ?>
                        )
                        (
                            تعداد:
                            <b><?= count($expenses); ?></b>
                        )
                        (
                            مجموع پول:
                            <b><?= $total_money; ?></b>
                        )
                    </p>

                      <table class="table direction table-striped table-bordered table-hover">
                          <tr>
                            <th style="width: 10px">#</th>
                            <th>نوع مصرف</th>
                            <th>تفصیل</th>
                            <th>قیمت</th>
                            <th>مقدار</th>
                            <th>مجموع</th>
                            <th>تاریخ</th>
                          </tr>
                          <?php $number = 0; foreach ($expenses as $item) : $number++; ?>
                            <tr>
                                <td><?= $number; ?></td>
                                <td><?= $item->cat_name; ?></td>
                                <td><?= $item->title; ?></td>
                                <td><?= $item->amount; ?></td>
                                <td><?= $item->qty; ?></td>
                                <td><?= $item->total; ?></td>
                                <td><?= $item->date_y . '/' . $item->date_m . '/' . $item->date_d; ?></td>
                            </tr>
                          <?php endforeach; ?>
                      </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <a href="<?= base_url(); ?>reports" class="btn btn-flat btn-info pull-left"><i class="fa fa-angle-double-left"></i> برگشت</a>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <div class="col-md-1"></div>
      </div>
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