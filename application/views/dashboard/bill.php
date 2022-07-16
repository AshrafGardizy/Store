<style>
th, td {
    padding: 4px !important;
}
@media print {
    table th.bg-black {
        background: #000 !important;
        color: #fff !important;
    }
}
</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        فروشات به
        <?= ($customer->perm_cust_id) ? ($customer->full_name . ' (' . $customer->phone . ')') : ($customer->cust_name . ' (' . $customer->cust_phone .')'); ?>
      </h1>
      <ol class="breadcrumb" style="direction:rtl;">
        <li><a href="#"><i class="fa fa-dashboard"></i> خانه</a></li>
        <li class="active">بل</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

    <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="box animated zoomIn">
                <div class="box-header">
                    <table class="table" style="border: none !important;">
                        <tr>
                            <td class="text-left" style="width:20%; border-top:none; border-bottom:2px solid lightgrey; border-left:3px solid grey;">
                                <?= $settings->store_phone; ?>
                                <br>
                                <?= $settings->store_address; ?>
                            </td>
                            <td class="text-right" style="border-top:none; border-bottom:2px solid lightgrey;">
                                <h3>
                                    <?= $settings->store_name; ?>
                                </h3>
                                <p><?= $settings->store_slogan; ?></p>
                            </td>
                            <td style="width:20%; border-top:none; border-bottom:2px solid lightgrey;">
                                <img src="<?= base_url(); ?>assets/images/logo/<?= $settings->store_logo; ?>" alt="" style="width:100px;">
                            </td>
                        </tr>
                        <tr></tr>
                    </table>
                    <!-- <h3 class="box-title"></h3> -->
                    <table class="table" style="border:none !important; margin-top:-18px;">
                        <tr>
                            <td class="text-left direction" style="border:none !important;">
                                <p class="text-left">
                                    نمبر فروش:
                                    <?= /*$customer->code_category . '-' . */$customer->code_no; ?>
                                </p>
                                <p class="text-left">
                                    تاریخ:
                                    <?= $customer->sale_date; ?>
                                </p>
                            </td>
                            <td class="text-right direction" style="border-top:none; border-right:3px solid grey;">
                                فروش به:
                                <h3 style="margin-top:6px;">
                                    <?= ($customer->perm_cust_id) ? ($customer->full_name . ' (' . $customer->phone . ')') : ($customer->cust_name . ' (' . $customer->cust_phone .')'); ?>
                                </h3>
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <table class="table direction table-striped table-bordered table-hover" style="margin-top:-30px;">
                        <tr>
                            <th class="bg-black" style="width:10px">#</th>
                            <th class="bg-black">نام جنس</th>
                            <th class="bg-black">تعداد</th>
                            <th class="bg-black">قیمت</th>
                            <th class="bg-black">مجموع</th>
                        </tr>
                        <?php $good_no = 1; foreach ($goods as $good_item) : ?>
                            <tr>
                                <td><?= $good_no; $good_no++; ?></td>
                                <td><?= $good_item->good_name; ?></td>
                                <td><?= $good_item->good_qty . ' ' . $good_item->good_category; ?></td>
                                <td><?= $good_item->good_sale_price; ?></td>
                                <td><?= $good_item->good_total_af . ' افغانی'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>


<!-- find out the good_qty with its good_category -->
<?php
$category_found = [];
foreach ($goods as $good_item) {
    $category_found[] = $good_item->good_category;
}
$found_categories = array_unique($category_found);

$items = [];

foreach ($found_categories as $found_category_item) {
    $this->db->select('SUM(good_qty) AS good_total_qty');
    $this->db->where('sale.deleted', '0');
    $this->db->where('godam.deleted', '0');
    $this->db->where('sale.cust_id', $goods[0]->cust_id);
    $this->db->where('godam.good_category', $found_category_item);
    $this->db->join('godam', 'sale.good_id=godam.id');
    $query = $this->db->get('sale');
    $items[$found_category_item] = $query->row();
}

$total_goods = [];
foreach ($items as $item_key => $item_value) {
    $total_goods[] = ($item_value->good_total_qty . ' ' . $item_key);
}
?>

                    <table class="table direction table-striped table-bordered table-hover" style="width:300px; margin-top:10px;">
                        <tr>
                            <td>مجموع تعداد</td>
                            <td>
                                <?php 
                                    foreach ($total_goods as $good_category_item) {
                                        echo $good_category_item . ' ';
                                    }
                                ?>
                            </td>
                        </tr>

                        <?php if ($payment->sundries_price) : ?>
                            <tr>
                                <td><?= ($payment->sundries_reason)?($payment->sundries_reason):('قیمت متفرقه'); ?></td>
                                <td><?= $payment->sundries_price; ?> افغانی</td>
                            </tr>
                        <?php endif; ?>
                        
                        <?php if ($payment->discount_amount) : ?>
                        <tr>
                            <td>مقدار تخفیف</td>
                            <td><?= $payment->discount_amount; ?> افغانی</td>
                        </tr>
                        <?php endif; ?>

                        <tr>
                            <td>مجموع کل</td>
                            <td>
                                <?= $payment->product_total_af; ?> افغانی
                                <?php if ($settings->us_in_bill) : ?>
                                    (<?= round($payment->product_total_us, 1); ?> $)
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>رسید</td>
                            <td>
                                <?= $payment->paid_amount_af; ?> افغانی
                                <?php if ($settings->us_in_bill) : ?>
                                    (<?= round($payment->paid_amount_us, 1); ?> $)
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>باقی</td>
                            <td>
                                <?= $payment->remain_amount_af; ?> افغانی
                                <?php if ($settings->us_in_bill) : ?>
                                    (<?= round($payment->remain_amount_us, 2); ?> $)
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                    <?php if ($settings->bill_note) : ?>
                        <p>
                            <strong>نوت: </strong>
                            <?= $settings->bill_note; ?>
                        </p>
                    <?php endif; ?>
                </div>
                <!-- /.box-body -->
                <div class="box-footer" style="border:none;">
                    <a href="javascript:window.print()" class="btn bg-light-blue pull-left">چاپ <i class="fa fa-print"></i></a>
                    <a href="<?= base_url(); ?>sales" class="btn bg-light-blue">برگشت <i class="fa fa-angle-double-right"></i></a>
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
