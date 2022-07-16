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
        <li class="active">فروشات</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Alert -->
      <?php if ($this->session->flashdata('success')) : ?>
      <div class="alert alert-success alert-dismissable animated zoomIn" style="direction:rtl;">
        <span class="close" data-dismiss="alert" aria-label="close">&times;</span>
        <strong>موفقیت!</strong> عملیات موفقانه انجام شد.
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
            <div class="box animated zoomIn">
                <div class="box-header">
                    <h3 class="box-title">
                        فروشات به
                        <?= ($customer->perm_cust_id) ? ($customer->full_name . ' (' . $customer->phone . ')') : ($customer->cust_name . ' (' . $customer->cust_phone .')'); ?>
                    </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <table class="table direction table-striped table-bordered table-hover">
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>نام جنس</th>
                            <th>تعداد</th>
                            <th>قیمت</th>
                            <th>مجموع</th>
                            <th>تصحیح</th>
                            <th>حذف</th>
                        </tr>
                        <?php $good_no = 1; foreach ($goods as $good_item) : ?>
                            <tr>
                                <td><?= $good_no; $good_no++; ?></td>
                                <td><?= $good_item->good_name; ?></td>
                                <td><?= $good_item->good_qty . ' ' . $good_item->good_category; ?></td>
                                <td><?= $good_item->good_sale_price; ?></td>
                                <td><?= $good_item->good_total_af . ' افغانی'; ?></td>
                                <td>
                                    <a href="#" class="btn btn-xs btn-block btn-flat bg-light-blue" data-toggle="modal" data-target="#edit_good_modal_<?= $good_item->id; ?>"><i class="fa fa-edit"></i></a>
                                </td>
                                <td>
                                    <a href="<?= base_url(); ?>sales/<?= $customer->id; ?>/delete/<?= $good_item->id; ?>" onclick="return confirmation();" class="btn btn-xs btn-block btn-flat bg-red"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <a href="<?= base_url(); ?>sales/<?= $customer->id; ?>/step-1" class="btn bg-blue"><i class="fa fa-angle-double-left"></i> ادامه</a>
                    <a href="#" class="btn bg-light-blue pull-left" data-toggle="modal" data-target="#print_calculation_modal">چاپ <i class="fa fa-print"></i></a>
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

<?php foreach ($goods as $good_item_modal) : ?>
    <div id="edit_good_modal_<?= $good_item_modal->id; ?>" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">تصحیح</h4>
                </div>
                <?= form_open('', ['class'=>'form-horizontal']); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left"> :نام جنس</label>
                        <div class="col-sm-10">
                            <select name="good_id" class="select2" style="width:100% !important;">
                                <?php foreach ($godam_goods as $godam_good_item) : ?>
                                    <option <?php if ($godam_good_item->id==$good_item_modal->good_id) { echo 'selected'; } ?> value="<?= $godam_good_item->id; ?>"><?= $godam_good_item->good_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left"> :تعداد</label>
                        <div class="col-sm-10">
                            <input type="number" name="good_qty" class="form-control" min="1" value="<?= $good_item_modal->good_qty; ?>" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left"> :قیمت</label>
                        <div class="col-sm-10">
                            <input type="number" name="good_price" class="form-control" value="<?= $good_item_modal->good_sale_price; ?>" required="">
                        </div>
                    </div>

                    <!-- ID of good in sale TBL -->
                    <input type="hidden" name="sale_id" value="<?= $good_item_modal->id; ?>">
                    <input type="hidden" name="form_code" value="update_sale">

                </div>
                <div class="modal-footer">
                    <div class="form-group">        
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">کنسل</button>
                            <button class="btn btn-primary btn-flat bg-blue">ادامه <i class="fa fa-angle-double-left"></i></button>
                        </div>
                    </div>
                </div>
              <?= form_close(); ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>


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

<!-- find out the good_total_af -->
<?php
$good_total_af = 0;
foreach ($goods as $good_item) {
    $good_total_af += $good_item->good_total_af;
}
?>

<div id="print_calculation_modal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="direction:rtl;">چاپ</h4>
      </div>
      <?= form_open(); ?>
        <div class="modal-body">
          <div class="form-group">
            <label>مجموع تعداد</label>
            <input type="text" name="cust_name" class="form-control" value="<?php 
                foreach ($total_goods as $good_category_item) {
                    echo $good_category_item . ' ';
                }
            ?>" readonly="">
          </div>
          
          <?php if ($settings->sundries_price) : ?>
            <div class="form-group">
                <label>قیمت متفرقه</label>
                <input type="number" name="sundries_price" class="form-control" id="sundries_price" min="0" value="0" required="">
            </div>
            <div class="form-group">
                <label>دلیل قیمت متفرقه</label>
                <input type="text" name="sundries_reason" class="form-control" id="sundries_reason">
            </div>
          <?php endif; ?>

          <?php if ($settings->discount_amount) : ?>
            <div class="form-group">
                <label>مقدار تخفیف</label>
                <input type="number" name="discount_amount" class="form-control" id="discount_amount" min="0" value="0" required="">
            </div>
          <?php endif; ?>

          <div class="form-group">
            <label>مجموع کل</label>
            <input type="number" name="good_total" class="form-control" id="good_total" value="<?= $good_total_af; ?>" readonly="">
          </div>

          <div class="form-group">
            <label>رسید</label>
            <input type="number" name="paid_amount" class="form-control" id="paid_amount" min="0" required="" autofocus="">
          </div>

          <input type="hidden" name="form_code" value="print">

        </div>
        <div class="modal-footer">
          <button class="btn btn-primary btn-flat bg-blue">ادامه <i class="fa fa-angle-double-left"></i></button>
          <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">کنسل</button>
        </div>
      <?= form_close(); ?>
    </div>
  </div>
</div>
