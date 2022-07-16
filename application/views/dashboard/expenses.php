  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php if ($search_result) : ?>
          جستجوی
          <?= $q; ?>
          براساس
          <?= ($q_category == 'title') ? ('تفصیل') : ( ($q_category=='date')?('تاریخ'):('ERROR') ); ?>
          به ترتیب
          <?= ($q_sort == 'ASC') ? ('اولین ها') : ('آخرین ها'); ?>
          (
            مجموع:
            <?= count($search_result); ?>
          )
          <?php else : ?>
            <button class="btn btn-flat btn-primary" data-toggle="modal" data-target="#add_modal"><i class="fa fa-plus"></i> افزودن</button>
            مصارف (روزنامچه)
            (<?= ($total_rows)?($total_rows):(0); ?>)
        <?php endif; ?>
      </h1>
      <ol class="breadcrumb" style="direction:rtl;">
        <li><a href="#"><i class="fa fa-dashboard"></i> خانه</a></li>
        <li class="active">مصارف (روزنامچه)</li>
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
                    <a href="#" data-toggle="modal" data-target="#expense_categories_modal" class="btn-link pull-left">
                      <i class="fa fa-gears"></i>
                      انواع مصارف
                    </a>
                    <?= form_open('', ['class'=>'form-inline']); ?>
                      <div class="form-group">
                        <label for="q">جستجو:</label>
                        <input type="text" class="form-control input-sm" name="q" id="q" value="<?= set_value('q'); ?>" required="">
                      </div>
                      <div class="form-group">
                        <label for="q_category">براساس:</label>
                        <select name="q_category" id="q_category" class="select2 input-sm">
                          <option value="title" <?php if ($q_category=='title') { echo 'selected'; } ?>>تفصیل</option>
                          <option value="date" <?php if ($q_category=='date') { echo 'selected'; } ?>>تاریخ</option>
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
                              <th>نوع مصرف</th>
                              <th>تفصیل</th>
                              <th>قیمت</th>
                              <th>مقدار</th>
                              <th>مجموع</th>
                              <th>تاریخ</th>
                              <th>تصحیح</th>
                              <th>حذف</th>
                          </tr>
                          <?php $expense_no = 1; foreach ($search_result as $search_result_item) : ?>
                              <tr>
                                  <td><?= $expense_no; $expense_no++; ?></td>
                                  <td><?= $search_result_item->cat_name; ?></td>
                                  <td><?= $search_result_item->title; ?></td>
                                  <td><?= $search_result_item->amount; ?></td>
                                  <td><?= $search_result_item->qty; ?></td>
                                  <td><?= $search_result_item->total; ?></td>
                                  <td><?= $search_result_item->date_y . '/' . $search_result_item->date_m . '/' . $search_result_item->date_d; ?></td>
                                  <td>
                                      <a href="#" class="btn btn-xs btn-block btn-flat bg-blue" data-toggle="modal" data-target="#edit_modal_<?= $search_result_item->id; ?>"><i class="fa fa-list"></i></a>
                                  </td>
                                  <td>
                                      <a href="<?= base_url(); ?>expenses/<?= $search_result_item->id; ?>/delete" onclick="return confirmation();" class="btn btn-xs btn-block btn-flat bg-red"><i class="fa fa-trash"></i></a>
                                  </td>
                              </tr>

                              <!-- start modal -->
                              <div id="edit_modal_<?= $search_result_item->id; ?>" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      <h4 class="modal-title">تصحیح <?= $search_result_item->title; ?></h4>
                                    </div>
                                    <?= form_open(); ?>
                                      <div class="modal-body">
                                        <div class="form-group">
                                          <label>نوع مصرف</label>
                                          <select name="expense_category" id="expense_category" class="select2 input-sm" style="width:100% !important;">
                                            <?php foreach ($expense_categories as $expense_category_item) : ?>
                                              <option <?php if ($search_result_item->category_id==$expense_category_item->id) { echo 'selected'; } ?> value="<?= $expense_category_item->id; ?>"><?= $expense_category_item->cat_name; ?></option>
                                            <?php endforeach; ?>
                                          </select>
                                        </div>
                                        <div class="form-group">
                                          <label>تفصیل</label>
                                          <input type="text" name="title" class="form-control" value="<?= $search_result_item->title; ?>" required="">
                                        </div>
                                        <div class="form-group">
                                          <label>قیمت</label>
                                          <input type="number" name="amount" class="form-control" value="<?= $search_result_item->amount; ?>" required="">
                                        </div>
                                        <div class="form-group">
                                          <label>مقدار</label>
                                          <input type="number" name="qty" class="form-control" value="<?= $search_result_item->qty; ?>" required="">
                                        </div>
                                        <div class="form-group">
                                          <div class="row">
                                            <div class="col-md-4">
                                              <label>روز</label>
                                              <select name="date_d" class="select2" style="width:100% !important;">
                                                <?php for ($day=1; $day<=31; $day++) { ?>
                                                  <option <?php if ($search_result_item->date_d==$day) { echo 'selected'; } ?>><?= $day; ?></option>
                                                <?php } ?>
                                              </select>
                                            </div>
                                            <div class="col-md-4">
                                              <label>ماه</label>
                                              <select name="date_m" class="select2" style="width:100% !important;">
                                                <option <?php if ($search_result_item->date_m=='1') { echo 'selected'; } ?> value="1">حمل - 1</option>
                                                <option <?php if ($search_result_item->date_m=='2') { echo 'selected'; } ?> value="2">ثور - 2</option>
                                                <option <?php if ($search_result_item->date_m=='3') { echo 'selected'; } ?> value="3">جوزا - 3</option>
                                                <option <?php if ($search_result_item->date_m=='4') { echo 'selected'; } ?> value="4">سرطان - 4</option>
                                                <option <?php if ($search_result_item->date_m=='5') { echo 'selected'; } ?> value="5">اسد - 5</option>
                                                <option <?php if ($search_result_item->date_m=='6') { echo 'selected'; } ?> value="6">سنبله - 6</option>
                                                <option <?php if ($search_result_item->date_m=='7') { echo 'selected'; } ?> value="7">میزان - 7</option>
                                                <option <?php if ($search_result_item->date_m=='8') { echo 'selected'; } ?> value="8">عقرب - 8</option>
                                                <option <?php if ($search_result_item->date_m=='9') { echo 'selected'; } ?> value="9">قوس - 9</option>
                                                <option <?php if ($search_result_item->date_m=='10') { echo 'selected'; } ?> value="10">جدی - 10</option>
                                                <option <?php if ($search_result_item->date_m=='11') { echo 'selected'; } ?> value="11">دلو - 11</option>
                                                <option <?php if ($search_result_item->date_m=='12') { echo 'selected'; } ?> value="12">حوت - 12</option>
                                              </select>
                                            </div>
                                            <div class="col-md-4">
                                              <label>سال</label>
                                              <select name="date_y" class="select2" style="width:100% !important;">
                                                <?php for ($year=1395; $year<=1410; $year++) { ?>
                                                  <option <?php if ($search_result_item->date_y==$year) { echo 'selected'; } ?>><?= $year; ?></option>
                                                <?php } ?>
                                              </select>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="modal-footer">
                                        <input type="hidden" name="id" value="<?= $search_result_item->id; ?>">
                                        <input type="hidden" name="form_code" value="edit">
                                        <button class="btn btn-primary btn-flat bg-blue">ذخیره <i class="fa fa-check"></i></button>
                                        <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">کنسل</button>
                                      </div>
                                    <?= form_close(); ?>
                                  </div>
                                </div>
                              </div>
                              <!-- /.modal -->

                          <?php endforeach; ?>
                      </table>

                      <?php else : ?>
                      <!-- show the default TBL -->
                        <table class="table direction table-striped table-bordered table-hover">
                          <tr>
                              <th style="width: 10px">#</th>
                              <th>نوع مصرف</th>
                              <th>تفصیل</th>
                              <th>قیمت</th>
                              <th>مقدار</th>
                              <th>مجموع</th>
                              <th>تاریخ</th>
                              <th>تصحیح</th>
                              <th>حذف</th>
                          </tr>
                          <?php if ($expenses) : ?>
                            <?php $expense_no = 1; foreach ($expenses as $expense_item) : ?>
                                <tr>
                                    <td><?= $expense_no; $expense_no++; ?></td>
                                    <td><?= $expense_item->cat_name; ?></td>
                                    <td><?= $expense_item->title; ?></td>
                                    <td><?= $expense_item->amount; ?></td>
                                    <td><?= $expense_item->qty; ?></td>
                                    <td><?= $expense_item->total; ?></td>
                                    <td><?= $expense_item->date_y . '/' . $expense_item->date_m . '/' . $expense_item->date_d; ?></td>
                                    <td>
                                        <a href="#" class="btn btn-xs btn-block btn-flat bg-blue" data-toggle="modal" data-target="#edit_modal_<?= $expense_item->id; ?>"><i class="fa fa-list"></i></a>
                                    </td>
                                    <td>
                                        <a href="<?= base_url(); ?>expenses/<?= $expense_item->id; ?>/delete" onclick="return confirmation();" class="btn btn-xs btn-block btn-flat bg-red"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>

                                <!-- start modal -->
                                <div id="edit_modal_<?= $expense_item->id; ?>" class="modal fade" role="dialog">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">تصحیح <?= $expense_item->title; ?></h4>
                                      </div>
                                      <?= form_open(); ?>
                                        <div class="modal-body">
                                          <div class="form-group">
                                            <label>نوع مصرف</label>
                                            <select name="expense_category" id="expense_category" class="select2 input-sm" style="width:100% !important;">
                                              <?php foreach ($expense_categories as $expense_category_item) : ?>
                                                <option <?php if ($expense_item->category_id==$expense_category_item->id) { echo 'selected'; } ?> value="<?= $expense_category_item->id; ?>"><?= $expense_category_item->cat_name; ?></option>
                                              <?php endforeach; ?>
                                            </select>
                                          </div>
                                          <div class="form-group">
                                            <label>تفصیل</label>
                                            <input type="text" name="title" class="form-control" value="<?= $expense_item->title; ?>" required="">
                                          </div>
                                          <div class="form-group">
                                            <label>قیمت</label>
                                            <input type="number" name="amount" class="form-control" value="<?= $expense_item->amount; ?>" required="">
                                          </div>
                                          <div class="form-group">
                                            <label>مقدار</label>
                                            <input type="number" name="qty" class="form-control" value="<?= $expense_item->qty; ?>" required="">
                                          </div>
                                          <div class="form-group">
                                            <div class="row">
                                              <div class="col-md-4">
                                                <label>روز</label>
                                                <select name="date_d" class="select2" style="width:100% !important;">
                                                  <?php for ($day=1; $day<=31; $day++) { ?>
                                                    <option <?php if ($expense_item->date_d==$day) { echo 'selected'; } ?>><?= $day; ?></option>
                                                  <?php } ?>
                                                </select>
                                              </div>
                                              <div class="col-md-4">
                                                <label>ماه</label>
                                                <select name="date_m" class="select2" style="width:100% !important;">
                                                  <option <?php if ($expense_item->date_m=='1') { echo 'selected'; } ?> value="1">حمل - 1</option>
                                                  <option <?php if ($expense_item->date_m=='2') { echo 'selected'; } ?> value="2">ثور - 2</option>
                                                  <option <?php if ($expense_item->date_m=='3') { echo 'selected'; } ?> value="3">جوزا - 3</option>
                                                  <option <?php if ($expense_item->date_m=='4') { echo 'selected'; } ?> value="4">سرطان - 4</option>
                                                  <option <?php if ($expense_item->date_m=='5') { echo 'selected'; } ?> value="5">اسد - 5</option>
                                                  <option <?php if ($expense_item->date_m=='6') { echo 'selected'; } ?> value="6">سنبله - 6</option>
                                                  <option <?php if ($expense_item->date_m=='7') { echo 'selected'; } ?> value="7">میزان - 7</option>
                                                  <option <?php if ($expense_item->date_m=='8') { echo 'selected'; } ?> value="8">عقرب - 8</option>
                                                  <option <?php if ($expense_item->date_m=='9') { echo 'selected'; } ?> value="9">قوس - 9</option>
                                                  <option <?php if ($expense_item->date_m=='10') { echo 'selected'; } ?> value="10">جدی - 10</option>
                                                  <option <?php if ($expense_item->date_m=='11') { echo 'selected'; } ?> value="11">دلو - 11</option>
                                                  <option <?php if ($expense_item->date_m=='12') { echo 'selected'; } ?> value="12">حوت - 12</option>
                                                </select>
                                              </div>
                                              <div class="col-md-4">
                                                <label>سال</label>
                                                <select name="date_y" class="select2" style="width:100% !important;">
                                                  <?php for ($year=1395; $year<=1410; $year++) { ?>
                                                    <option <?php if ($expense_item->date_y==$year) { echo 'selected'; } ?>><?= $year; ?></option>
                                                  <?php } ?>
                                                </select>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="modal-footer">
                                          <input type="hidden" name="id" value="<?= $expense_item->id; ?>">
                                          <input type="hidden" name="form_code" value="edit">
                                          <button class="btn btn-primary btn-flat bg-blue">ذخیره <i class="fa fa-check"></i></button>
                                          <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">کنسل</button>
                                        </div>
                                      <?= form_close(); ?>
                                    </div>
                                  </div>
                                </div>
                                <!-- /.modal -->
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

<!-- add_modal -->
<div id="add_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">
          افزودن
        </h4>
      </div>
      <?= form_open(); ?>
        <div class="modal-body">
          <div class="form-group">
            <label>نوع مصرف</label>
            <select name="expense_category" id="expense_category" class="select2 input-sm" style="width:100% !important;">
              <?php foreach ($expense_categories as $expense_category_item) : ?>
                <option value="<?= $expense_category_item->id; ?>"><?= $expense_category_item->cat_name; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>تفصیل</label>
            <input type="text" name="title" class="form-control" required="">
          </div>
          <div class="form-group">
            <label>قیمت</label>
            <input type="number" name="amount" class="form-control" required="">
          </div>
          <div class="form-group">
            <label>مقدار</label>
            <input type="number" name="qty" class="form-control" value="1" required="">
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-4">
                <label>روز</label>
                <select name="date_d" class="select2" style="width:100% !important;">
                  <?php for ($day=1; $day<=31; $day++) { ?>
                    <option><?= $day; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-4">
                <label>ماه</label>
                <select name="date_m" class="select2" style="width:100% !important;">
                  <option value="1">حمل - 1</option>
                  <option value="2">ثور - 2</option>
                  <option value="3">جوزا - 3</option>
                  <option value="4">سرطان - 4</option>
                  <option value="5">اسد - 5</option>
                  <option value="6">سنبله - 6</option>
                  <option value="7">میزان - 7</option>
                  <option value="8">عقرب - 8</option>
                  <option value="9">قوس - 9</option>
                  <option value="10">جدی - 10</option>
                  <option value="11">دلو - 11</option>
                  <option value="12">حوت - 12</option>
                </select>
              </div>
              <div class="col-md-4">
                <label>سال</label>
                <select name="date_y" class="select2" style="width:100% !important;">
                  <?php for ($year=1395; $year<=1410; $year++) { ?>
                    <option><?= $year; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="form_code" value="add">
          <button class="btn btn-primary btn-flat bg-blue">افزودن <i class="fa fa-plus"></i></button>
          <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">کنسل</button>
        </div>
      <?= form_close(); ?>
    </div>
  </div>
</div>



<!-- expense_categories_modal -->
<div id="expense_categories_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">انواع مصارف</h4>
      </div>
      <?= form_open(); ?>
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
              <?php if ($expense_categories) : ?>
                <tbody>
                  <?php $expense_category_no = 1; foreach ($expense_categories as $expense_category_item) : ?>
                    <tr>
                      <td><?= $expense_category_no; $expense_category_no++; ?></td>
                      <td><?= $expense_category_item->cat_name; ?></td>
                      <td>
                        <a href="<?= base_url(); ?>expense_categories/<?= $expense_category_item->id; ?>/delete" onclick="return confirmation()" class="btn btn-flat bg-red"><i class="fa fa-trash"></i></a>
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
              <label>افزودن نوع مصرف</label>
              <input type="text" name="expense_category" class="form-control" required="" placeholder="نوع مصرف">
              <input type="hidden" name="form_code" value="add_expense_category">
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
