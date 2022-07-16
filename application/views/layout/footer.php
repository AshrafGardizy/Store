  <footer class="main-footer text-left">
    <strong>Copyright &copy; <?= date('Y'); ?> <a href="mailto://ashrafgardizy@gmail.com">Ashraf Gardizy</a>.</strong> All rights
    reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.0 -->
<script src="<?= base_url(); ?>assets/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<!-- My JavaScript -->
<script src="<?= base_url(); ?>assets/js/general.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url(); ?>assets/js/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="<?= base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
<!-- PACE -->
<script src="<?= base_url(); ?>assets/plugins/pace/pace.min.js"></script>
<!-- Select2 -->
<script src="<?= base_url(); ?>assets/plugins/select2/select2.min.js"></script>
<!-- iCheck -->
<script src="<?= base_url(); ?>assets/plugins/iCheck/icheck.min.js"></script>
<script>
  // Select2
  $(function () {
    $('.select2.code_category').select2({
      dir: 'ltr'
    });
    $('.select2').select2({
      dir: 'rtl'
    });
  });

  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
  function confirmation() {
    var conf = window.confirm('آیا مطمئن هستید؟');
    if (conf == false) {
      return false;
    }
  }
</script>
<!-- Morris.js charts -->
<script src="<?= base_url(); ?>assets/js/raphael-min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?= base_url(); ?>assets/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?= base_url(); ?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?= base_url(); ?>assets/plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="<?= base_url(); ?>assets/js/moment.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?= base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?= base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?= base_url(); ?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?= base_url(); ?>assets/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url(); ?>assets/dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?= base_url(); ?>assets/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url(); ?>assets/dist/js/demo.js"></script>




<!-- System Modals -->
<!-- add_good_modal -->
<div id="add_good_modal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">
          درج جنس جدید
        </h4>
      </div>
      <?= form_open('dashboard'); ?>
        <div class="modal-body">
          <table class="table table-striped" style="direction:rtl;">
            <tr>
              <th>#</th>
              <th>نام جنس</th>
              <th>تعداد جنس</th>
              <th>واحد جنس</th>
              <th>قیمت خرید</th>
            </tr>
            <?php for ($rows = 1; $rows <= 10; $rows++) : ?>
            <tr>
              <td><?= $rows; ?></td>
              <td>
                <input type="text" name="good_name[]" class="form-control" <?php if ($rows==1) { echo 'required'; } ?>>
              </td>
              <td>
                <input type="text" name="good_total_no[]" class="form-control" <?php if ($rows==1) { echo 'required'; } ?>>
              </td>
              <td>
                <select name="good_category[]" class="select2" style="width:100% !important;">
                  <?php foreach ($categories as $category_item) : ?>
                      <option><?= $category_item->category; ?></option>
                  <?php endforeach; ?>
                </select>
              </td>
              <td>
                <input type="text" name="good_buy[]" class="form-control">
              </td>
            </tr>
            <?php endfor; ?>
          </table>
          <!--
          <div class="form-group">
            <label>نام جنس</label>
            <input type="text" name="good_name" class="form-control" required="">
          </div>
          <div class="form-group">
            <label>تعداد جنس</label>
            <input type="text" name="good_total_no" class="form-control" required="">
          </div>
          <div class="form-group">
            <label>واحد جنس</label>
            <select name="good_category" class="select2" style="width:100% !important;">
              <?php // foreach ($categories as $category_item) : ?>
                  <option><?= ''; // $category_item->category; ?></option>
              <?php // endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>قیمت خرید</label>
            <input type="text" name="good_buy" class="form-control">
          </div>
          -->
        </div>
        <div class="modal-footer">
          <input type="hidden" name="form_code" value="add_new_good">
          <button class="btn btn-primary btn-flat bg-blue">افزودن <i class="fa fa-plus"></i></button>
          <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">کنسل</button>
        </div>
      <?= form_close(); ?>
    </div>
  </div>
</div>



<!-- add_sale_modal -->
<div id="add_sale_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">
          فروش جدید
        </h4>
      </div>
      <div class="modal-body">
        <!-- Custom Tabs -->
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">مشتری متفرقه</a></li>
            <li><a href="#tab_2" data-toggle="tab">مشتری دایمی</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
              <?= form_open('dashboard'); ?>
                <div class="form-group">
                  <label>نمبر فروش</label>
                  <input type="text" name="code_no" class="form-control" value="<?= $settings->code_no; ?>" readonly="">
                </div>
                <div class="form-group">
                  <label>نام خریدار</label>
                  <input type="text" name="cust_name" class="form-control" value="مشتری متفرقه">
                </div>
                <div class="form-group">
                  <label>شماره تماس خریدار</label>
                  <input type="text" name="cust_phone" class="form-control">
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-4">
                      <label>روز</label>
                      <select name="date_d" class="select2" style="width:100% !important;">
                        <?php for ($day=1; $day<=31; $day++) { ?>
                          <option <?php if ($this->model->jalali_today('day')==$day) { echo 'selected'; } ?>><?= $day; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label>ماه</label>
                      <select name="date_m" class="select2" style="width:100% !important;">
                        <option <?php if ($this->model->jalali_today('month')=='1') { echo 'selected'; } ?> value="1">حمل - 1</option>
                        <option <?php if ($this->model->jalali_today('month')=='2') { echo 'selected'; } ?> value="2">ثور - 2</option>
                        <option <?php if ($this->model->jalali_today('month')=='3') { echo 'selected'; } ?> value="3">جوزا - 3</option>
                        <option <?php if ($this->model->jalali_today('month')=='4') { echo 'selected'; } ?> value="4">سرطان - 4</option>
                        <option <?php if ($this->model->jalali_today('month')=='5') { echo 'selected'; } ?> value="5">اسد - 5</option>
                        <option <?php if ($this->model->jalali_today('month')=='6') { echo 'selected'; } ?> value="6">سنبله - 6</option>
                        <option <?php if ($this->model->jalali_today('month')=='7') { echo 'selected'; } ?> value="7">میزان - 7</option>
                        <option <?php if ($this->model->jalali_today('month')=='8') { echo 'selected'; } ?> value="8">عقرب - 8</option>
                        <option <?php if ($this->model->jalali_today('month')=='9') { echo 'selected'; } ?> value="9">قوس - 9</option>
                        <option <?php if ($this->model->jalali_today('month')=='10') { echo 'selected'; } ?> value="10">جدی - 10</option>
                        <option <?php if ($this->model->jalali_today('month')=='11') { echo 'selected'; } ?> value="11">دلو - 11</option>
                        <option <?php if ($this->model->jalali_today('month')=='12') { echo 'selected'; } ?> value="12">حوت - 12</option>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label>سال</label>
                      <select name="date_y" class="select2" style="width:100% !important;">
                        <?php for ($year=1395; $year<=1410; $year++) { ?>
                          <option <?php if ($this->model->jalali_today('year')==$year) { echo 'selected'; } ?>><?= $year; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <input type="hidden" name="form_code" value="add_new_sale">
                  <button class="btn btn-primary btn-flat bg-blue">ادامه <i class="fa fa-angle-double-left"></i></button>
                </div>
              <?= form_close(); ?>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_2">
              <?= form_open('dashboard'); ?>
                <div class="form-group">
                  <label>نمبر فروش</label>
                  <input type="text" name="code_no" class="form-control" value="<?= $settings->code_no; ?>" readonly="">
                </div>
                <?php
                  $perm_customers_footer = $this->model->get_tbl_rows('perm_customers', 'DESC');
                ?>
                <div class="form-group">
                  <label>نام مشترک دایمی</label>
                  <select name="perm_cust_id" class="select2" style="width:100% !important;">
                    <?php foreach ($perm_customers_footer as $perm_customer_item) : ?>
                      <option value="<?= $perm_customer_item->id; ?>"><?= $perm_customer_item->full_name; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-4">
                      <label>روز</label>
                      <select name="date_d" class="select2" style="width:100% !important;">
                        <?php for ($day=1; $day<=31; $day++) { ?>
                          <option <?php if ($this->model->jalali_today('day')==$day) { echo 'selected'; } ?>><?= $day; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label>ماه</label>
                      <select name="date_m" class="select2" style="width:100% !important;">
                        <option <?php if ($this->model->jalali_today('month')=='1') { echo 'selected'; } ?> value="1">حمل - 1</option>
                        <option <?php if ($this->model->jalali_today('month')=='2') { echo 'selected'; } ?> value="2">ثور - 2</option>
                        <option <?php if ($this->model->jalali_today('month')=='3') { echo 'selected'; } ?> value="3">جوزا - 3</option>
                        <option <?php if ($this->model->jalali_today('month')=='4') { echo 'selected'; } ?> value="4">سرطان - 4</option>
                        <option <?php if ($this->model->jalali_today('month')=='5') { echo 'selected'; } ?> value="5">اسد - 5</option>
                        <option <?php if ($this->model->jalali_today('month')=='6') { echo 'selected'; } ?> value="6">سنبله - 6</option>
                        <option <?php if ($this->model->jalali_today('month')=='7') { echo 'selected'; } ?> value="7">میزان - 7</option>
                        <option <?php if ($this->model->jalali_today('month')=='8') { echo 'selected'; } ?> value="8">عقرب - 8</option>
                        <option <?php if ($this->model->jalali_today('month')=='9') { echo 'selected'; } ?> value="9">قوس - 9</option>
                        <option <?php if ($this->model->jalali_today('month')=='10') { echo 'selected'; } ?> value="10">جدی - 10</option>
                        <option <?php if ($this->model->jalali_today('month')=='11') { echo 'selected'; } ?> value="11">دلو - 11</option>
                        <option <?php if ($this->model->jalali_today('month')=='12') { echo 'selected'; } ?> value="12">حوت - 12</option>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label>سال</label>
                      <select name="date_y" class="select2" style="width:100% !important;">
                        <?php for ($year=1395; $year<=1410; $year++) { ?>
                          <option <?php if ($this->model->jalali_today('year')==$year) { echo 'selected'; } ?>><?= $year; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <input type="hidden" name="form_code" value="add_new_sale">
                  <button class="btn btn-primary btn-flat bg-blue">ادامه <i class="fa fa-angle-double-left"></i></button>
                </div>
              <?= form_close(); ?>
            </div>
            <!-- /.tab-pane -->
          </div>
          <!-- /.tab-content -->
        </div>
        <!-- nav-tabs-custom -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">کنسل</button>
      </div>
    </div>
  </div>
</div>



<!-- store_settings_modal -->
<div id="store_settings_modal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">تنظیمات <?= $settings->store_name; ?></h4>
      </div>
      <?= form_open_multipart('dashboard'); ?>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>نام فروشگاه</label>
                <input type="text" name="store_name" class="form-control" required="" min="3" value="<?= $settings->store_name; ?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>شعار فروشگاه</label>
                <input type="text" name="store_slogan" class="form-control" required="" min="3" value="<?= $settings->store_slogan; ?>">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>لوگوی فروشگاه</label>
                <input type="file" name="userfile" class="form-control">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>شماره تماس فروشگاه</label>
                <input type="text" name="store_phone" class="form-control" required="" min="3" value="<?= $settings->store_phone; ?>">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>آدرس فروشگاه</label>
                <input type="text" name="store_address" class="form-control" required="" min="3" value="<?= $settings->store_address; ?>">
              </div>
            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group" style="direction:rtl;">
                <label>محاسبه دالر روی بل نشان داده شود؟</label>
                <label>
                  <input type="radio" name="us_in_bill" value="1" <?php if ($settings->us_in_bill==1) { echo 'checked=""'; } ?>> بلی
                </label>
                <label>
                  <input type="radio" name="us_in_bill" value="0" <?php if ($settings->us_in_bill==0) { echo 'checked=""'; } ?>> نخیر
                </label>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>یک دالر</label>
                <input type="number" name="one_us" class="form-control" required="" value="1">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>مساوی به چند افغانی</label>
                <input type="text" name="af_value" class="form-control" required="" value="<?= $settings->af_value; ?>">
              </div>
            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>نمبر فروش</label>
                <input type="number" name="code_no" class="form-control" required="" value="<?= $settings->code_no; ?>" readonly="">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>نوت روی بل</label>
                <input type="text" name="bill_note" class="form-control" value="<?= $settings->bill_note; ?>">
              </div>
            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group" style="direction:rtl;">
                <label>قیمت متفرقه فعال باشد؟</label>
                <label>
                  <input type="radio" name="sundries_price" value="1" <?php if ($settings->sundries_price==1) { echo 'checked=""'; } ?>> بلی
                </label>
                <label>
                  <input type="radio" name="sundries_price" value="0" <?php if ($settings->sundries_price==0) { echo 'checked=""'; } ?>> نخیر
                </label>
              </div>
            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group" style="direction:rtl;">
                <label>تخفیف فعال باشد؟</label>
                <label>
                  <input type="radio" name="discount_amount" value="1" <?php if ($settings->discount_amount==1) { echo 'checked=""'; } ?>> بلی
                </label>
                <label>
                  <input type="radio" name="discount_amount" value="0" <?php if ($settings->discount_amount==0) { echo 'checked=""'; } ?>> نخیر
                </label>
              </div>
            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group" style="direction:rtl;">
                <label>اجناس فروش از گدام کم شود؟</label>
                <label>
                  <input type="radio" name="enable_godam" value="1" <?php if ($settings->enable_godam==1) { echo 'checked=""'; } ?>> بلی
                </label>
                <label>
                  <input type="radio" name="enable_godam" value="0" <?php if ($settings->enable_godam==0) { echo 'checked=""'; } ?>> نخیر
                </label>
              </div>
            </div>
          </div>

          <input type="hidden" name="form_code" value="change_settings">
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary btn-flat bg-blue">تغییر <i class="fa fa-check"></i></button>
          <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">کنسل</button>
        </div>
      <?= form_close(); ?>
    </div>
  </div>
</div>

<!-- categories_modal -->
<div id="categories_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">گتگوری های اجناس</h4>
      </div>
      <?= form_open('dashboard'); ?>
        <div class="modal-body">
          <!-- Table Starts -->
            <table class="table table-striped" style="direction:rtl;">
              <thead>
                <tr>
                  <th>شماره</th>
                  <th>گتگوری</th>
                  <th>حذف</th>
                </tr>
              </thead>
              <?php if ($categories) : ?>
                <tbody>
                  <?php $category_no = 1; foreach ($categories as $category_item) : ?>
                    <tr>
                      <td><?= $category_no; $category_no++; ?></td>
                      <td><?= $category_item->category; ?></td>
                      <td>
                        <a href="<?= base_url(); ?>categories/<?= $category_item->id; ?>/delete" onclick="return confirmation()" class="btn btn-flat bg-red"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              <?php endif; ?>
            </table>
          <!-- ./Table -->
          <hr>
          <div class="row">
            <div class="col-md-12">
              <label>افزودن گتگوری</label>
              <input type="text" name="category" class="form-control" required="" placeholder="نام گتگوری">
              <input type="hidden" name="form_code" value="add_category">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary btn-flat bg-blue">افزودن <i class="fa fa-plus"></i></button>
          <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">کنسل</button>
        </div>
      <?= form_close(); ?>
    </div>
  </div>
</div>

<!-- backup_modal -->
<div id="backup_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">دانلود فایل پشتیبانی</h4>
      </div>
      <?= form_open('dashboard/backup'); ?>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <label>نام فایل</label>
              <input type="text" name="backup" class="form-control" required="" placeholder="نام فایل برای ذخیره شدن">
              <input type="hidden" name="form_code" value="backup">
              <p class="text-info">نوت: فایل پشتیبانی (sql) به پوشه دانلود ذخیره میشود.</p>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary btn-flat bg-blue">دانلود <i class="fa fa-download"></i></button>
          <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">کنسل</button>
        </div>
      <?= form_close(); ?>
    </div>
  </div>
</div>

<!-- change_password_modal -->
<div id="change_password_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">تغییر کلمه عبور</h4>
      </div>
      <?= form_open('dashboard'); ?>
        <div class="modal-body">
          <div class="form-group">
            <label>کلمه عبور فعلی</label>
            <input type="password" name="cur_password" class="form-control" required="" min="3">
          </div>
          <div class="form-group">
            <label>کلمه عبور جدید</label>
            <input type="password" name="new_password" class="form-control" required="" min="3">
          </div>
          <div class="form-group">
            <label>تایید کلمه عبور</label>
            <input type="password" name="conf_password" class="form-control" required="" min="3">
            <input type="hidden" name="form_code" value="change_password">
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary btn-flat bg-blue">تغییر <i class="fa fa-check"></i></button>
          <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">کنسل</button>
        </div>
      <?= form_close(); ?>
    </div>
  </div>
</div>

<!-- change_username_modal -->
<div id="change_username_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">تغییر نام کاربری</h4>
      </div>
      <?= form_open('dashboard'); ?>
        <div class="modal-body">
          <div class="form-group">
            <label>نام کاربری فعلی</label>
            <input type="text" name="cur_username" class="form-control" required="" min="3" readonly="" value="<?= $settings->username; ?>">
          </div>
          <div class="form-group">
            <label>نام کاربری جدید</label>
            <input type="text" name="new_username" class="form-control" required="" min="3">
          </div>
          <div class="form-group">
            <label>تایید نام کاربری جدید</label>
            <input type="text" name="conf_username" class="form-control" required="" min="3">
            <input type="hidden" name="form_code" value="change_username">
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary btn-flat bg-blue">تغییر <i class="fa fa-check"></i></button>
          <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">کنسل</button>
        </div>
      <?= form_close(); ?>
    </div>
  </div>
</div>

<!-- profile_modal -->
<div id="profile_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">پروفایل کاربری</h4>
      </div>
      <?= form_open('dashboard'); ?>
        <div class="modal-body">
          <div class="form-group">
            <label>نام</label>
            <input type="text" name="firstname" class="form-control" required="" value="<?= $settings->firstname; ?>">
          </div>
          <div class="form-group">
            <label>تخلص</label>
            <input type="text" name="lastname" class="form-control" required="" value="<?= $settings->lastname; ?>">
            <input type="hidden" name="form_code" value="profile">
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary btn-flat bg-blue">تغییر <i class="fa fa-check"></i></button>
          <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">کنسل</button>
        </div>
      <?= form_close(); ?>
    </div>
  </div>
</div>

<!-- change_photo_modal -->
<div id="change_photo_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">تغییر عکس کاربر</h4>
      </div>
      <?= form_open_multipart('dashboard'); ?>
      <div class="modal-body">
        <div class="form-group">
          <label>عکس را انتخاب کنید</label>
          <input type="file" name="userfile" class="form-control" required="">
          <input type="hidden" name="form_code" value="profile-pic">
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary btn-flat bg-blue">تغییر <i class="fa fa-check"></i></button>
        <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">کنسل</button>
      </div>
      <?= form_close(); ?>
    </div>
  </div>
</div>

</body>
</html>
