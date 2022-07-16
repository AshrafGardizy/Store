  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php if ($search_result) : ?>
          جستجوی
          <?= $q; ?>
          براساس
          <?= ($q_category == 'code_no') ? ('نمبر فروش') : ( ($q_category=='cust_name')?('نام مشتری'):( ($q_category=='cust_phone')?('شماره مشتری'):( ($q_category=='sale_date')?('تاریخ فروش'):( ($q_category=='remain_amount_af')?('باقیمانده'):('ERROR') ) ) ) ); ?>
          به ترتیب
          <?= ($q_sort == 'ASC') ? ('اولین ها') : ('آخرین ها'); ?>
          (
            مجموع:
            <?= count($search_result); ?>
          )
          <?php else : ?>
          لیست آخرین فروشات
          (<?= $total_rows; ?>)
        <?php endif; ?>
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
            <div class="box">
                <div class="box-header">
                    <!-- <h3 class="box-title"></h3> -->
                    <?= form_open('', ['class'=>'form-inline']); ?>
                      <div class="form-group">
                        <label for="q">جستجو:</label>
                        <input type="text" class="form-control input-sm" name="q" id="q" value="<?= set_value('q'); ?>" required="">
                      </div>
                      <div class="form-group">
                        <label for="q_category">براساس:</label>
                        <select name="q_category" id="q_category" class="select2 input-sm">
                          <option value="code_no" <?php if ($q_category=='code') { echo 'selected'; } ?>>نمبر فروش</option>
                          <option value="cust_name" <?php if ($q_category=='cust_name') { echo 'selected'; } ?>>نام مشتری</option>
                          <option value="cust_phone" <?php if ($q_category=='cust_phone') { echo 'selected'; } ?>>شماره تماس</option>
                          <option value="sale_date" <?php if ($q_category=='sale_date') { echo 'selected'; } ?>>تاریخ فروش</option>
                          <option value="remain_amount_af" <?php if ($q_category=='remain_amount_af') { echo 'selected'; } ?>>باقیمانده</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="q_sort">ترتیب:</label>
                        <select name="q_sort" id="q_sort" class="select2 input-sm">
                          <option value="DESC" <?php if ($q_sort=='DESC') { echo 'selected'; } ?>>آخرین ها</option>
                          <option value="ASC" <?php if ($q_sort=='ASC') { echo 'selected'; } ?>>اولین ها</option>
                        </select>
                      </div>
                      <input type="hidden" name="form_code" value="search">
                      <button type="submit" class="btn btn-flat bg-grey"><i class="fa fa-search"></i></button>
                    <?= form_close(); ?>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <?php if ($search_result) : ?>
                      <table class="table direction table-striped table-bordered table-hover">
                          <tr>
                              <th style="width: 10px">#</th>
                              <th>نمبر فروش</th>
                              <th>نام مشتری</th>
                              <th>شماره مشتری</th>
                              <th>تاریخ فروش</th>
                              <th>باقیمانده</th>
                              <th>پرداخت باقیمانده</th>
                              <th>فاکتور</th>
                              <th>حذف</th>
                          </tr>
                          <?php $sale_no = 1; foreach ($search_result as $search_result_item) : ?>
                              <tr>
                                  <td><?= $sale_no; $sale_no++; ?></td>
                                  <td><?= $search_result_item->code_no; ?></td>
                                  <td><?= $search_result_item->cust_name . $search_result_item->full_name; ?></td>
                                  <td><?= $search_result_item->cust_phone . $search_result_item->phone; ?></td>
                                  <td><?= $search_result_item->sale_date; ?></td>
                                  <td><?= $search_result_item->remain_amount_af . ' افغانی'; ?></td>
                                  <td>
                                      <?php if ($search_result_item->remain_amount_af) : ?>
                                          <a href="#" class="btn btn-xs btn-block btn-flat bg-light-blue" data-toggle="modal" data-target="#pay_remain_modal_<?= $search_result_item->id; ?>"><i class="fa fa-money"></i></a>
                                      <?php endif; ?>
                                  </td>
                                  <td>
                                      <a href="<?= base_url(); ?>sales/<?= $search_result_item->id; ?>" class="btn btn-xs btn-block btn-flat bg-blue"><i class="fa fa-list"></i></a>
                                  </td>
                                  <td>
                                      <a href="<?= base_url(); ?>sales/<?= $search_result_item->id; ?>/delete" onclick="return confirmation();" class="btn btn-xs btn-block btn-flat bg-red"><i class="fa fa-trash"></i></a>
                                  </td>
                              </tr>

                              <!-- start of the pay remain modal -->
                              <div id="pay_remain_modal_<?= $search_result_item->id; ?>" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      <h4 class="modal-title">پرداخت باقیمانده <?= $search_result_item->cust_name; ?></h4>
                                    </div>
                                    <?= form_open(); ?>
                                      <div class="modal-body">
                                        <div class="form-group">
                                          <label>مبلغ پرداخت</label>
                                          <input type="number" name="pay_remain" class="form-control" required="">
                                          <input type="hidden" name="cust_id" value="<?= $search_result_item->id; ?>">
                                          <input type="hidden" name="paid_amount_af" value="<?= $search_result_item->paid_amount_af; ?>">
                                          <input type="hidden" name="remain_amount_af" value="<?= $search_result_item->remain_amount_af; ?>">
                                        </div>
                                      </div>
                                      <input type="hidden" name="form_code" value="pay_remain">
                                      <div class="modal-footer">
                                        <button class="btn btn-primary btn-flat bg-blue">ادامه <i class="fa fa-angle-double-left"></i></button>
                                        <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">کنسل</button>
                                      </div>
                                    <?= form_close(); ?>
                                  </div>
                                </div>
                              </div>
                              <!-- /.pay remain modal -->

                          <?php endforeach; ?>
                      </table>

                      
                      <?php else : ?>
                      <!-- show the default TBL -->
                        <table class="table direction table-striped table-bordered table-hover">
                          <tr>
                              <th style="width: 10px">#</th>
                              <th>نمبر فروش</th>
                              <th>نام مشتری</th>
                              <th>شماره مشتری</th>
                              <th>تاریخ فروش</th>
                              <th>باقیمانده</th>
                              <th>پرداخت باقیمانده</th>
                              <th>فاکتور</th>
                              <th>حذف</th>
                          </tr>
                          <?php if ($sale_lists) : ?>
                            <?php $sale_no = 1; foreach ($sale_lists as $sale_list_item) : ?>
                                <tr>
                                    <td><?= $sale_no; $sale_no++; ?></td>
                                    <td><?= $sale_list_item->code_no; ?></td>
                                    <td><?= $sale_list_item->cust_name . $sale_list_item->full_name; ?></td>
                                    <td><?= $sale_list_item->cust_phone . $sale_list_item->phone; ?></td>
                                    <td><?= $sale_list_item->sale_date; ?></td>
                                    <td><?= $sale_list_item->remain_amount_af . ' افغانی'; ?></td>
                                    <td>
                                        <?php if ($sale_list_item->remain_amount_af) : ?>
                                            <a href="#" class="btn btn-xs btn-block btn-flat bg-light-blue" data-toggle="modal" data-target="#pay_remain_modal_<?= $sale_list_item->id; ?>"><i class="fa fa-money"></i></a>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url(); ?>sales/<?= $sale_list_item->id; ?>" class="btn btn-xs btn-block btn-flat bg-blue"><i class="fa fa-list"></i></a>
                                    </td>
                                    <td>
                                        <a href="<?= base_url(); ?>sales/<?= $sale_list_item->id; ?>/delete" onclick="return confirmation();" class="btn btn-xs btn-block btn-flat bg-red"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>

                                <!-- start of the pay remain modal -->
                                <div id="pay_remain_modal_<?= $sale_list_item->id; ?>" class="modal fade" role="dialog">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">پرداخت باقیمانده <?= $sale_list_item->cust_name; ?></h4>
                                      </div>
                                      <?= form_open(); ?>
                                        <div class="modal-body">
                                          <div class="form-group">
                                            <label>مبلغ پرداخت</label>
                                            <input type="number" name="pay_remain" class="form-control" required="">
                                            <input type="hidden" name="cust_id" value="<?= $sale_list_item->id; ?>">
                                            <input type="hidden" name="paid_amount_af" value="<?= $sale_list_item->paid_amount_af; ?>">
                                            <input type="hidden" name="remain_amount_af" value="<?= $sale_list_item->remain_amount_af; ?>">
                                          </div>
                                        </div>
                                        <input type="hidden" name="form_code" value="pay_remain">
                                        <div class="modal-footer">
                                          <button class="btn btn-primary btn-flat bg-blue">ادامه <i class="fa fa-angle-double-left"></i></button>
                                          <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">کنسل</button>
                                        </div>
                                      <?= form_close(); ?>
                                    </div>
                                  </div>
                                </div>
                                <!-- /.pay remain modal -->

                            <?php endforeach; ?>
                          <?php endif; ?>
                      </table>
                    <?php endif; ?>
                    
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                  <?php if (!$search_result) : ?>
                    <!-- Add Pagination Links -->
                    <?= $this->pagination->create_links(); ?>
                  <?php endif; ?>
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
