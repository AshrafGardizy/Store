  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        حساب
        <?= $perm_customer->full_name; ?>
        (<?= count($perm_customer_finances); ?>)
        |
        نتیجه:
        مبلغ
        <?php
          $total_debt = $total_debtor_perm_customer_finances->total_amount;
          $total_credit = $total_creditor_perm_customer_finances->total_amount;
          if (($total_debt - $total_credit) < 0) {
            echo $total_credit - $total_debt . ' رسید';
          } elseif (($total_credit - $total_debt) < 0) {
            echo $total_debt - $total_credit . ' باقی';
          } else {
            echo 'تصفیه شد';
          }
        ?>
      </h1>
      <ol class="breadcrumb" style="direction:rtl;">
        <li><a href="#"><i class="fa fa-dashboard"></i> خانه</a></li>
        <li class="active">گزارشات</li>
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

      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
          <div class="box">
            <div class="box-header">

              <h3>
                حساب
                <?= $perm_customer->full_name; ?>
                <?= ($perm_customer->phone) ? (' / ' . $perm_customer->phone) : (''); ?>
                (<?= count($perm_customer_finances); ?>)
                |
                نتیجه:
                مبلغ
                <?php
                  $total_debt = $total_debtor_perm_customer_finances->total_amount;
                  $total_credit = $total_creditor_perm_customer_finances->total_amount;
                  if (($total_debt - $total_credit) < 0) {
                    echo $total_credit - $total_debt . ' رسید';
                  } elseif (($total_credit - $total_debt) < 0) {
                    echo $total_debt - $total_credit . ' باقی';
                  } else {
                    echo 'تصفیه شد';
                  }
                ?>
              </h3>
              <table class="table direction table-striped table-bordered table-hover">
                <caption>
                  <p>
                    جمله رسید:
                    <?= $total_credit; ?>
                  </p>
                  <p>
                    جمله باقی:
                    <?= $total_debt; ?>
                  </p>
                </caption>
                <tr>
                  <th style="width:10px">#</th>
                  <th style="width:50px;">تاریخ</th>
                  <th>تفصیل</th>
                  <th style="width:30px;">بل</th>
                  <th>رسید</th>
                  <th>باقی</th>
                </tr>
                <?php if ($perm_customer_finances) : ?>
                  <?php $perm_customer_finance_no = 1; foreach ($perm_customer_finances as $perm_customer_finance_item) : ?>
                    <tr>
                      <td><?= $perm_customer_finance_no; $perm_customer_finance_no++; ?></td>
                      <td><?= $perm_customer_finance_item->date_y . '/' . $perm_customer_finance_item->date_m . '/' . $perm_customer_finance_item->date_d; ?></td>
                      <td><?= $perm_customer_finance_item->description; ?></td>
                      <td><?= $perm_customer_finance_item->bill_no; ?></td>
                      <td>
                        <?php if ($perm_customer_finance_item->category=='creditor') { echo $perm_customer_finance_item->amount; } ?>
                      </td>
                      <td>
                        <?php if ($perm_customer_finance_item->category=='debtor') { echo $perm_customer_finance_item->amount; } ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </table>


            </div>
          </div>
        </div>
        <div class="col-md-1"></div>
      </div>
      
      <!-- Main row -->
      <div class="row">
      </div>
      <!-- /.row (main row) -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
