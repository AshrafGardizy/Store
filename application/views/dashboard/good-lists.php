  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php if ($search_result) : ?>
          جستجوی
          <?= $q; ?>
          براساس
          <?= ($q_category == 'good_name') ? ('نام جنس') : ( ($q_category=='good_category')?('واحد'):( ($q_category=='good_total_no')?('تعداد در گدام'):( ($q_category=='good_buy')?('قیمت خرید'):('ERROR') ) ) ); ?>
          به ترتیب
          <?= ($q_sort == 'ASC') ? ('اولین ها') : ('آخرین ها'); ?>
          (
            مجموع:
            <?= count($search_result); ?>
          )
          <?php else : ?>
            لیست اجناس گدام
            (<?= $total_rows; ?>)
        <?php endif; ?>
      </h1>
      <ol class="breadcrumb" style="direction:rtl;">
        <li><a href="#"><i class="fa fa-dashboard"></i> خانه</a></li>
        <li class="active">اجناس گدام</li>
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
                          <option value="good_name" <?php if ($q_category=='good_name') { echo 'selected'; } ?>>نام جنس</option>
                          <option value="good_category" <?php if ($q_category=='good_category') { echo 'selected'; } ?>>واحد</option>
                          <option value="good_total_no" <?php if ($q_category=='good_total_no') { echo 'selected'; } ?>>تعداد در گدام</option>
                          <option value="good_buy" <?php if ($q_category=='good_buy') { echo 'selected'; } ?>>قیمت خرید</option>
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
                              <th>نام جنس</th>
                              <th>تعداد در گدام</th>
                              <th>واحد</th>
                              <th>قیمت خرید</th>
                              <th>مجموع قیمت</th>
                              <th>تصحیح</th>
                              <th>حذف</th>
                          </tr>
                          <?php $good_no = 1; foreach ($search_result as $search_result_item) : ?>
                              <tr>
                                  <td><?= $good_no; $good_no++; ?></td>
                                  <td><?= $search_result_item->good_name; ?></td>
                                  <td><?= $search_result_item->good_total_no; ?></td>
                                  <td><?= $search_result_item->good_category; ?></td>
                                  <td><?= $search_result_item->good_buy; ?></td>
                                  <td><?= (float) ($search_result_item->good_total_no) * (float) ($search_result_item->good_buy); ?></td>
                                  <td>
                                      <a href="#" class="btn btn-xs btn-block btn-flat bg-blue" data-toggle="modal" data-target="#edit_modal_<?= $search_result_item->id; ?>"><i class="fa fa-list"></i></a>
                                  </td>
                                  <td>
                                      <a href="<?= base_url(); ?>goods/<?= $search_result_item->id; ?>/delete" onclick="return confirmation();" class="btn btn-xs btn-block btn-flat bg-red"><i class="fa fa-trash"></i></a>
                                  </td>
                              </tr>

                              <!-- start modal -->
                              <div id="edit_modal_<?= $search_result_item->id; ?>" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      <h4 class="modal-title">تصحیح <?= $search_result_item->good_name; ?></h4>
                                    </div>
                                    <?= form_open(); ?>
                                      <div class="modal-body">
                                        <div class="form-group">
                                          <label>نام جنس</label>
                                          <input type="text" name="good_name" class="form-control" value="<?= $search_result_item->good_name; ?>" required="">
                                        </div>
                                        <div class="form-group">
                                          <label>تعداد جنس</label>
                                          <input type="text" name="good_total_no" class="form-control" value="<?= $search_result_item->good_total_no; ?>" required="">
                                        </div>
                                        <div class="form-group">
                                          <label>واحد جنس</label>
                                          <select name="good_category" class="select2" style="width:100% !important;">
                                            <?php foreach ($categories as $category_item) : ?>
                                                <option <?php if ($category_item->category==$search_result_item->good_category) { echo 'selected'; } ?>><?= $category_item->category; ?></option>
                                            <?php endforeach; ?>
                                          </select>
                                        </div>
                                        <div class="form-group">
                                          <label>قیمت خرید</label>
                                          <input type="text" name="good_buy" class="form-control" value="<?= $search_result_item->good_buy; ?>">
                                        </div>
                                      </div>
                                      <div class="modal-footer">
                                        <input type="hidden" name="good_id" value="<?= $search_result_item->id; ?>">
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
                              <th>نام جنس</th>
                              <th>تعداد در گدام</th>
                              <th>واحد</th>
                              <th>قیمت خرید</th>
                              <th>مجموع قیمت</th>
                              <th>تصحیح</th>
                              <th>حذف</th>
                          </tr>
                          <?php if ($good_lists) : ?>
                            <?php $total_good_buy_amount = 0; $good_no = 1; foreach ($good_lists as $good_list_item) : ?>
                                <tr>
                                    <td><?= $good_no; $good_no++; ?></td>
                                    <td><?= $good_list_item->good_name; ?></td>
                                    <td><?= $good_list_item->good_total_no; ?></td>
                                    <td><?= $good_list_item->good_category; ?></td>
                                    <td><?= $good_list_item->good_buy; ?></td>
                                    <td>
                                      <?php
                                        $total_good_buy_amount += (float) ($good_list_item->good_total_no) * (float) ($good_list_item->good_buy);
                                        echo (float) ($good_list_item->good_total_no) * (float) ($good_list_item->good_buy);
                                      ?>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-xs btn-block btn-flat bg-blue" data-toggle="modal" data-target="#edit_modal_<?= $good_list_item->id; ?>"><i class="fa fa-list"></i></a>
                                    </td>
                                    <td>
                                        <a href="<?= base_url(); ?>goods/<?= $good_list_item->id; ?>/delete" onclick="return confirmation();" class="btn btn-xs btn-block btn-flat bg-red"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>

                                <!-- start modal -->
                                <div id="edit_modal_<?= $good_list_item->id; ?>" class="modal fade" role="dialog">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">تصحیح <?= $good_list_item->good_name; ?></h4>
                                      </div>
                                      <?= form_open(); ?>
                                        <div class="modal-body">
                                          <div class="form-group">
                                            <label>نام جنس</label>
                                            <input type="text" name="good_name" class="form-control" value="<?= $good_list_item->good_name; ?>" required="">
                                          </div>
                                          <div class="form-group">
                                            <label>تعداد جنس</label>
                                            <input type="text" name="good_total_no" class="form-control" value="<?= $good_list_item->good_total_no; ?>" required="">
                                          </div>
                                          <div class="form-group">
                                            <label>واحد جنس</label>
                                            <select name="good_category" class="select2" style="width:100% !important;">
                                              <?php foreach ($categories as $category_item) : ?>
                                                  <option <?php if ($category_item->category==$good_list_item->good_category) { echo 'selected'; } ?>><?= $category_item->category; ?></option>
                                              <?php endforeach; ?>
                                            </select>
                                          </div>
                                          <div class="form-group">
                                            <label>قیمت خرید</label>
                                            <input type="text" name="good_buy" class="form-control" value="<?= $good_list_item->good_buy; ?>">
                                          </div>
                                        </div>
                                        <div class="modal-footer">
                                          <input type="hidden" name="good_id" value="<?= $good_list_item->id; ?>">
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
                                <tr>
                                  <th colspan="4"></th>
                                  <th colspan="2" class="text-center">
                                    جمله قیمت ها:
                                    <?= $total_good_buy_amount; ?>
                                  </th>
                                  <th colspan="2"></th>
                                </tr>
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
