  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php if ($search_result) : ?>
          جستجوی
          <?= $q; ?>
          براساس
          <?= ($q_category == 'full_name') ? ('نام') : ( ($q_category=='phone')?('شماره تماس'):( ($q_category=='amount')?('مبلغ'):( ($q_category=='description')?('تفصیل'):( ($q_category=='date')?('تاریخ'):( ($q_category=='bill_no')?('نمبر بل'):('ERROR') ) ) ) ) ); ?>
          به ترتیب
          <?= ($q_sort == 'ASC') ? ('اولین ها') : ('آخرین ها'); ?>
          (
            مجموع:
            <?= count($search_result); ?>
          )
          <?php else : ?>
            <button class="btn btn-flat btn-primary" data-toggle="modal" data-target="#add_modal"><i class="fa fa-plus"></i> افزودن</button>
            لیست حسابات مردم
            (<?= ($total_rows)?($total_rows):(0); ?>)
        <?php endif; ?>
      </h1>
      <ol class="breadcrumb" style="direction:rtl;">
        <li><a href="#"><i class="fa fa-dashboard"></i> خانه</a></li>
        <li class="active">حسابات مردم</li>
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
                          <option value="date" <?php if ($q_category=='date') { echo 'selected'; } ?>>تاریخ</option>
                          <option value="description" <?php if ($q_category=='description') { echo 'selected'; } ?>>تفصیل</option>
                          <option value="bill_no" <?php if ($q_category=='bill_no') { echo 'selected'; } ?>>نمبر بل</option>
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
                    <?php if ($total_creditors_amount->total_amount) : ?>
                      <p>
                        جمله رسیدات:
                        <?= $total_creditors_amount->total_amount; ?>
                      </p>
                    <?php endif; ?>
                    <?php if ($total_debtors_amount->total_amount) : ?>
                      <p>
                        جمله باقیات:
                        <?= $total_debtors_amount->total_amount; ?>
                      </p>
                    <?php endif; ?>
                  <?php endif; ?>
                    <?php if ($search_result) : ?>
                      <table class="table direction table-striped table-bordered table-hover">
                          <tr>
                              <th style="width: 10px">#</th>
                              <th>تاریخ</th>
                              <th>تفصیل</th>
                              <th>بل</th>
                              <th>نام</th>
                              <th>شماره تماس</th>
                              <th>رسید</th>
                              <th>باقی</th>
                              <th>تصحیح</th>
                              <th>حذف</th>
                          </tr>
                          <?php $people_finance_no = 1; foreach ($search_result as $search_result_item) : ?>
                              <tr>
                                  <td><?= $people_finance_no; $people_finance_no++; ?></td>
                                  <td><?= $search_result_item->date_y . '/' . $search_result_item->date_m . '/' . $search_result_item->date_d; ?></td>
                                  <td><?= $search_result_item->description; ?></td>
                                  <td><?= $search_result_item->bill_no; ?></td>
                                  <td><?= $search_result_item->full_name; ?></td>
                                  <td><?= $search_result_item->phone; ?></td>
                                  <td>
                                    <?php if ($search_result_item->category=='creditor') { echo $search_result_item->amount; } ?>
                                  </td>
                                  <td>
                                    <?php if ($search_result_item->category=='debtor') { echo $search_result_item->amount; } ?>
                                  </td>
                                  <td>
                                      <a href="#" class="btn btn-xs btn-block btn-flat bg-blue" data-toggle="modal" data-target="#edit_modal_<?= $search_result_item->id; ?>"><i class="fa fa-list"></i></a>
                                  </td>
                                  <td>
                                      <a href="<?= base_url(); ?>people-finances/<?= $search_result_item->id; ?>/delete" onclick="return confirmation();" class="btn btn-xs btn-block btn-flat bg-red"><i class="fa fa-trash"></i></a>
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
                                        <div class="row">
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>مبلغ</label>
                                              <input type="number" name="amount" class="form-control" value="<?= $search_result_item->amount; ?>" required="">
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>نوعیت</label>
                                              <select name="category" class="select2" style="width:100% !important;">
                                                <option value="creditor" <?php if ($search_result_item->category=='creditor') { echo 'selected'; } ?>>رسید</option>
                                                <option value="debtor" <?php if ($search_result_item->category=='debtor') { echo 'selected'; } ?>>باقی</option>
                                              </select>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>نمبر بل</label>
                                              <input type="number" name="bill_no" class="form-control" value="<?= $search_result_item->bill_no; ?>">
                                            </div>
                                          </div>
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

                                        <div class="form-group">
                                          <label>تفصیل</label>
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
                            <th>تاریخ</th>
                            <th>تفصیل</th>
                            <th>بل</th>
                            <th>نام</th>
                            <th>شماره تماس</th>
                            <th>رسید</th>
                            <th>باقی</th>
                            <th>تصحیح</th>
                            <th>حذف</th>
                          </tr>
                          <?php if ($people_finances) : ?>
                            <?php $people_finance_no = 1; foreach ($people_finances as $people_finance_item) : ?>
                                <tr>
                                    <td><?= $people_finance_no; $people_finance_no++; ?></td>
                                    <td><?= $people_finance_item->date_y . '/' . $people_finance_item->date_m . '/' . $people_finance_item->date_d; ?></td>
                                    <td><?= $people_finance_item->description; ?></td>
                                    <td><?= $people_finance_item->bill_no; ?></td>
                                    <td><?= $people_finance_item->full_name; ?></td>
                                    <td><?= $people_finance_item->phone; ?></td>
                                    <td>
                                      <?php if ($people_finance_item->category=='creditor') { echo $people_finance_item->amount; } ?>
                                    </td>
                                    <td>
                                      <?php if ($people_finance_item->category=='debtor') { echo $people_finance_item->amount; } ?>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-xs btn-block btn-flat bg-blue" data-toggle="modal" data-target="#edit_modal_<?= $people_finance_item->id; ?>"><i class="fa fa-list"></i></a>
                                    </td>
                                    <td>
                                        <a href="<?= base_url(); ?>people-finances/<?= $people_finance_item->id; ?>/delete" onclick="return confirmation();" class="btn btn-xs btn-block btn-flat bg-red"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>

                                <!-- start modal -->
                                <div id="edit_modal_<?= $people_finance_item->id; ?>" class="modal fade" role="dialog">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">تصحیح <?= $people_finance_item->full_name; ?></h4>
                                      </div>
                                      <?= form_open(); ?>
                                        <div class="modal-body">
                                          <div class="form-group">
                                            <label>نام</label>
                                            <input type="text" name="full_name" class="form-control" value="<?= $people_finance_item->full_name; ?>" required="">
                                          </div>
                                          <div class="form-group">
                                            <label>شماره تماس</label>
                                            <input type="text" name="phone" class="form-control" value="<?= $people_finance_item->phone; ?>">
                                          </div>
                                          <div class="row">
                                            <div class="col-md-4">
                                              <div class="form-group">
                                                <label>مبلغ</label>
                                                <input type="number" name="amount" class="form-control" value="<?= $people_finance_item->amount; ?>" required="">
                                              </div>
                                            </div>
                                            <div class="col-md-4">
                                              <div class="form-group">
                                                <label>نوعیت</label>
                                                <select name="category" class="select2" style="width:100% !important;">
                                                  <option value="creditor" <?php if ($people_finance_item->category=='creditor') { echo 'selected'; } ?>>رسید</option>
                                                  <option value="debtor" <?php if ($people_finance_item->category=='debtor') { echo 'selected'; } ?>>باقی</option>
                                                </select>
                                              </div>
                                            </div>
                                            <div class="col-md-4">
                                              <div class="form-group">
                                                <label>نمبر بل</label>
                                                <input type="number" name="bill_no" class="form-control" value="<?= $people_finance_item->bill_no; ?>">
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <div class="row">
                                              <div class="col-md-4">
                                                <label>روز</label>
                                                <select name="date_d" class="select2" style="width:100% !important;">
                                                  <?php for ($day=1; $day<=31; $day++) { ?>
                                                    <option <?php if ($people_finance_item->date_d==$day) { echo 'selected'; } ?>><?= $day; ?></option>
                                                  <?php } ?>
                                                </select>
                                              </div>
                                              <div class="col-md-4">
                                                <label>ماه</label>
                                                <select name="date_m" class="select2" style="width:100% !important;">
                                                  <option <?php if ($people_finance_item->date_m=='1') { echo 'selected'; } ?> value="1">حمل - 1</option>
                                                  <option <?php if ($people_finance_item->date_m=='2') { echo 'selected'; } ?> value="2">ثور - 2</option>
                                                  <option <?php if ($people_finance_item->date_m=='3') { echo 'selected'; } ?> value="3">جوزا - 3</option>
                                                  <option <?php if ($people_finance_item->date_m=='4') { echo 'selected'; } ?> value="4">سرطان - 4</option>
                                                  <option <?php if ($people_finance_item->date_m=='5') { echo 'selected'; } ?> value="5">اسد - 5</option>
                                                  <option <?php if ($people_finance_item->date_m=='6') { echo 'selected'; } ?> value="6">سنبله - 6</option>
                                                  <option <?php if ($people_finance_item->date_m=='7') { echo 'selected'; } ?> value="7">میزان - 7</option>
                                                  <option <?php if ($people_finance_item->date_m=='8') { echo 'selected'; } ?> value="8">عقرب - 8</option>
                                                  <option <?php if ($people_finance_item->date_m=='9') { echo 'selected'; } ?> value="9">قوس - 9</option>
                                                  <option <?php if ($people_finance_item->date_m=='10') { echo 'selected'; } ?> value="10">جدی - 10</option>
                                                  <option <?php if ($people_finance_item->date_m=='11') { echo 'selected'; } ?> value="11">دلو - 11</option>
                                                  <option <?php if ($people_finance_item->date_m=='12') { echo 'selected'; } ?> value="12">حوت - 12</option>
                                                </select>
                                              </div>
                                              <div class="col-md-4">
                                                <label>سال</label>
                                                <select name="date_y" class="select2" style="width:100% !important;">
                                                  <?php for ($year=1395; $year<=1410; $year++) { ?>
                                                    <option <?php if ($people_finance_item->date_y==$year) { echo 'selected'; } ?>><?= $year; ?></option>
                                                  <?php } ?>
                                                </select>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label>تفصیل</label>
                                            <textarea class="form-control" rows="4" name="description"><?= $people_finance_item->description; ?></textarea>
                                          </div>
                                          <input type="hidden" name="id" value="<?= $people_finance_item->id; ?>">
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
          درج حساب مردم
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
          
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>مبلغ</label>
                <input type="number" name="amount" class="form-control" required="">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>نوعیت</label>
                <select name="category" class="select2" style="width:100% !important;">
                  <option value="creditor">رسید</option>
                  <option value="debtor">باقی</option>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>نمبر بل</label>
                <input type="number" name="bill_no" class="form-control">
              </div>
            </div>
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

          <div class="form-group">
            <label>تفصیل</label>
            <textarea class="form-control" rows="4" name="description"></textarea>
            <input type="hidden" name="form_code" value="add">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-flat bg-blue">افزودن <i class="fa fa-plus"></i></button>
          <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">کنسل</button>
        </div>
      <?= form_close(); ?>
    </div>
  </div>
</div>