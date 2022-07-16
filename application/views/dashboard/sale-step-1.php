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
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    فروشات به
                    <?= ($customer->perm_cust_id) ? ($customer->full_name . ' (' . $customer->phone . ')') : ($customer->cust_name . ' (' . $customer->cust_phone .')'); ?>
                </div>
                <?= form_open(); ?>
                    <div class="panel-body">
                        <table class="table table-striped table-hover rtl">
                            <tr>
                                <th>#</th>
                                <th>نام جنس</th>
                                <th>تعداد</th>
                                <th>قیمت</th>
                            </tr>
                            <?php for ($x=1; $x<=10; $x++) : ?>
                                <tr>
                                    <td><?= $x; ?></td>
                                    <td>
                                        <select name="good_id[]" class="select2" style="width:100% !important;">
                                            <?php foreach ($godam_goods as $godam_good_item) : ?>
                                                <option value="<?= $godam_good_item->id; ?>"><?= $godam_good_item->good_name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="good_qty[]" class="form-control" <?php if ($x==1) { echo 'required'; } ?>>
                                    </td>
                                    <td>
                                        <input type="number" name="good_price[]" class="form-control" <?php if ($x==1) { echo 'required'; } ?>>
                                    </td>
                                </tr>
                            <?php endfor; ?>
                        </table>
                    </div>
                    <div class="panel-footer">
                        <?php if ($goods) : ?>
                            <a href="<?= base_url(); ?>sales/<?= $customer->id; ?>/step-1/succeed" class="btn bg-red btn-flat pull-left" id="cancel-btn">کنسل</a>
                        <?php else : ?>
                            <a href="<?= base_url(); ?>sales/<?= $customer->id; ?>/step-1/cancel" class="btn bg-red btn-flat pull-left" id="cancel-btn">کنسل</a>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-primary btn-flat bg-blue">ادامه <i class="fa fa-angle-double-left"></i></button>
                    </div>
                <?= form_close(); ?>
            </div>
        </div>
        <div class="col-md-2"></div>
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
