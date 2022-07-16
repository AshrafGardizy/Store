  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php if ($search_result) : ?>
          جستجوی
          <?= $q; ?>
          براساس
          <?= ($q_category == 'full_name') ? ('نام') : ( ($q_category=='phone')?('شماره تماس'):( ($q_category=='amount')?('مبلغ'):( ($q_category=='description')?('جزئیات'):('ERROR') ) ) ); ?>
          به ترتیب
          <?= ($q_sort == 'ASC') ? ('اولین ها') : ('آخرین ها'); ?>
          (
            مجموع:
            <?= count($search_result); ?>
          )
          <?php else : ?>
            <button class="btn btn-flat btn-primary" data-toggle="modal" data-target="#add_modal"><i class="fa fa-plus"></i> افزودن</button>
            لیست بدهکاران
            (<?= ($total_rows)?($total_rows):(0); ?>)
        <?php endif; ?>
      </h1>
      <ol class="breadcrumb" style="direction:rtl;">
        <li><a href="#"><i class="fa fa-dashboard"></i> خانه</a></li>
        <li class="active">بدهکاران</li>
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
                          <option value="full_name" <?php if ($q_category=='full_name') { echo 'selected'; } ?>>نام</option>
                          <option value="phone" <?php if ($q_category=='phone') { echo 'selected'; } ?>>شماره تماس</option>
                          <option value="amount" <?php if ($q_category=='amount') { echo 'selected'; } ?>>مبلغ</option>
                          <option value="description" <?php if ($q_category=='description') { echo 'selected'; } ?>>جزئیات</option>
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
                  <?php if ($total_rows) : ?>
                    <p>
                      مجموع پول:
                      <?= $total_debtors_amount->total_amount; ?>
                    </p>
                  <?php endif; ?>
                    <?php if ($search_result) : ?>
                      <table class="table direction table-striped table-bordered table-hover">
                          <tr>
                              <th style="width: 10px">#</th>
                              <th>نام</th>
                              <th>شماره تماس</th>
                              <th>مبلغ</th>
                              <th>جزئیات</th>
                              <th>تصحیح</th>
                              <th>حذف</th>
                          </tr>
                          <?php $debtor_no = 1; foreach ($search_result as $search_result_item) : ?>
                              <tr>
                                  <td><?= $debtor_no; $debtor_no++; ?></td>
                                  <td><?= $search_result_item->full_name; ?></td>
                                  <td><?= $search_result_item->phone; ?></td>
                                  <td><?= $search_result_item->amount; ?></td>
                                  <td><?= $search_result_item->description; ?></td>
                                  <td>
                                      <a href="#" class="btn btn-xs btn-block btn-flat bg-blue" data-toggle="modal" data-target="#edit_modal_<?= $search_result_item->id; ?>"><i class="fa fa-list"></i></a>
                                  </td>
                                  <td>
                                      <a href="<?= base_url(); ?>debtors/<?= $search_result_item->id; ?>/delete" onclick="return confirmation();" class="btn btn-xs btn-block btn-flat bg-red"><i class="fa fa-trash"></i></a>
                                  </td>
                              </tr>

                              <!-- start modal -->
                              <div id="edit_modal_<?= $search_result_item->id; ?>" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      <h4 class="modal-title">تصحیح <?= $search_result_item->full_name; ?></h4>
                                    </div>
                                    <?= form_open(); ?>
                                      <div class="modal-body">
                                        <div class="form-group">
                                          <label>نام</label>
                                          <input type="text" name="full_name" class="form-control" value="<?= $search_result_item->full_name; ?>" required="">
                                        </div>
                                        <div class="form-group">
                                          <label>شماره تماس</label>
                                          <input type="text" name="phone" class="form-control" value="<?= $search_result_item->phone; ?>">
                                        </div>
                                        <div class="form-group">
                                          <label>مبلغ</label>
                                          <input type="number" name="amount" class="form-control" value="<?= $search_result_item->amount; ?>" required="">
                                        </div>
                                        <div class="form-group">
                                          <label>جزئیات</label>
                                          <textarea class="form-control" rows="4" name="description"><?= $search_result_item->description; ?></textarea>
                                        </div>
                                        <input type="hidden" name="id" value="<?= $search_result_item->id; ?>">
                                        <input type="hidden" name="form_code" value="edit">
                                      </div>
                                      <div class="modal-footer">
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
                              <th>نام</th>
                              <th>شماره تماس</th>
                              <th>مبلغ</th>
                              <th>جزئیات</th>
                              <th>تصحیح</th>
                              <th>حذف</th>
                          </tr>
                          <?php if ($debtors) : ?>
                            <?php $debtor_no = 1; foreach ($debtors as $debtor_item) : ?>
                                <tr>
                                    <td><?= $debtor_no; $debtor_no++; ?></td>
                                    <td><?= $debtor_item->full_name; ?></td>
                                    <td><?= $debtor_item->phone; ?></td>
                                    <td><?= $debtor_item->amount; ?></td>
                                    <td><?= $debtor_item->description; ?></td>
                                    <td>
                                        <a href="#" class="btn btn-xs btn-block btn-flat bg-blue" data-toggle="modal" data-target="#edit_modal_<?= $debtor_item->id; ?>"><i class="fa fa-list"></i></a>
                                    </td>
                                    <td>
                                        <a href="<?= base_url(); ?>debtors/<?= $debtor_item->id; ?>/delete" onclick="return confirmation();" class="btn btn-xs btn-block btn-flat bg-red"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>

                                <!-- start modal -->
                                <div id="edit_modal_<?= $debtor_item->id; ?>" class="modal fade" role="dialog">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">تصحیح <?= $debtor_item->full_name; ?></h4>
                                      </div>
                                      <?= form_open(); ?>
                                        <div class="modal-body">
                                          <div class="form-group">
                                            <label>نام</label>
                                            <input type="text" name="full_name" class="form-control" value="<?= $debtor_item->full_name; ?>" required="">
                                          </div>
                                          <div class="form-group">
                                            <label>شماره تماس</label>
                                            <input type="text" name="phone" class="form-control" value="<?= $debtor_item->phone; ?>">
                                          </div>
                                          <div class="form-group">
                                            <label>مبلغ</label>
                                            <input type="number" name="amount" class="form-control" value="<?= $debtor_item->amount; ?>" required="">
                                          </div>
                                          <div class="form-group">
                                            <label>جزئیات</label>
                                            <textarea class="form-control" rows="4" name="description"><?= $debtor_item->description; ?></textarea>
                                          </div>
                                          <input type="hidden" name="id" value="<?= $debtor_item->id; ?>">
                                          <input type="hidden" name="form_code" value="edit">
                                        </div>
                                        <div class="modal-footer">
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
          درج طلبکار
        </h4>
      </div>
      <?= form_open(); ?>
        <div class="modal-body">
          <div class="form-group">
            <label>نام</label>
            <input type="text" name="full_name" class="form-control" required="">
          </div>
          <div class="form-group">
            <label>شماره تماس</label>
            <input type="text" name="phone" class="form-control">
          </div>
          <div class="form-group">
            <label>مبلغ</label>
            <input type="number" name="amount" class="form-control">
          </div>
          <div class="form-group">
            <label>جزئیات</label>
            <textarea class="form-control" rows="4" name="description"></textarea>
            <input type="hidden" name="form_code" value="add">
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