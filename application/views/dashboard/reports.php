  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        گزارشات
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
              <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                  <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapse1" style="cursor:pointer;">
                    <h4 class="panel-title">
                      گزارشات مشترکین دایمی
                    </h4>
                  </div>
                  <div id="collapse1" class="panel-collapse collapse">
                    <div class="panel-body">
                      <?= form_open('reports/perm-customer-finance'); ?>
                        <div class="form-group">
                          <label>نام</label>
                          <select name="perm_cust_id" class="select2" style="width:100% !important;">
                            <?php foreach ($perm_customers as $perm_customer_item) : ?>
                              <option value="<?= $perm_customer_item->id; ?>"><?= $perm_customer_item->full_name; ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <input type="hidden" name="form_code" value="reports">
                          <button class="btn btn-flat btn-primary"><i class="fa fa-check"></i> گزارش</button>
                        </div>
                      <?= form_close(); ?>
                    </div>
                  </div>
                </div>
              </div>


              <div class="panel-group" id="system_reports">
                <div class="panel panel-default">
                  <div class="panel-heading" data-toggle="collapse" data-parent="#system_reports" href="#system_reports_body" style="cursor:pointer;">
                    <h4 class="panel-title">
                      گزارشات عملیات در سیستم
                    </h4>
                  </div>
                  <div id="system_reports_body" class="panel-collapse collapse">
                    <div class="panel-body">
                      <?= form_open('reports/perm-customer-finance'); ?>
                        <div class="form-group">
                          
                          <div class="row">
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label>سال گزارش</label>
                                      <select name="report_year" class="select2" style="width:100% !important;">
                                          <?php for ($report_year=1395; $report_year<=1410; $report_year++) : ?>
                                              <option value="<?= $report_year; ?>"><?= $report_year; ?></option>
                                          <?php endfor; ?>
                                      </select>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label>ماه گزارش</label>
                                      <select name="report_month" class="select2" style="width:100% !important;">
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
                              </div>
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label>روز گزارش</label>
                                      <select name="report_day" class="select2" style="width:100% !important;">
                                          <?php for ($report_day=1; $report_day<=31; $report_day++) : ?>
                                              <option value="<?= $report_day; ?>"><?= $report_day; ?></option>
                                          <?php endfor; ?>
                                      </select>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <label>عملیه</label>
                              <select name="perm_cust_id" class="select2" style="width:100% !important;">
                                <option value="deleted_report">حذف شده ها</option>
                                <option value="created_or_updated_report">افزوده شده ویا تصحیح شده</option>
                              </select>
                            </div>
                            <div class="col-md-6">
                              <label>جدول</label>
                              <select name="perm_cust_id" class="select2" style="width:100% !important;">
                                <option value="deleted_report">فروشات</option>
                                <option value="deleted_report">گدام</option>
                                <option value="deleted_report">مشترکین دایمی</option>
                                <option value="deleted_report">حسابات مشترکین دایمی</option>
                                <option value="deleted_report">حسابات مردم متفرقه</option>
                                <option value="deleted_report">مصارف (روزنامچه)</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <input type="hidden" name="form_code" value="system_reports">
                              <button class="btn btn-flat btn-primary"><i class="fa fa-check"></i> گزارش</button>
                            </div>
                          </div>
                        </div>
                      <?= form_close(); ?>
                    </div>
                  </div>
                </div>
              </div>


              <div class="panel-group" id="expense_reports">
                <div class="panel panel-default">
                  <div class="panel-heading" data-toggle="collapse" data-parent="#expense_reports" href="#expense_reports_body" style="cursor:pointer;">
                    <h4 class="panel-title">
                      گزارشات مصارف (روزنامچه)
                    </h4>
                  </div>
                  <div id="expense_reports_body" class="panel-collapse collapse">
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-md-4 my-4">
                          <button class="btn btn-flat card-2 btn-primary btn-block" data-toggle="modal" data-target="#monthly_expense_single_report_modal">
                            گزارش
                            ماهانه
                            (تکی)
                          </button>
                        </div>

                        <div class="col-md-4 my-4">
                          <button class="btn btn-flat card-2 btn-primary btn-block" data-toggle="modal" data-target="#monthly_expense_all_report_modal">
                            گزارش
                            ماهانه
                            (کلی)
                          </button>
                        </div>

                        <div class="col-md-4 my-4">
                            <button class="btn btn-flat card-2 btn-primary btn-block" data-toggle="modal" data-target="#monthly_expense_except_report_modal">
                                گزارش
                                ماهانه
                                (استثنا)
                            </button>
                        </div>

                        <div class="col-md-4 my-4">
                            <button class="btn btn-flat card-2 btn-primary btn-block" data-toggle="modal" data-target="#yearly_expense_single_report_modal">
                                گزارش
                                سالانه
                                (تکی)
                            </button>
                        </div>

                        <div class="col-md-4 my-4">
                            <button class="btn btn-flat card-2 btn-primary btn-block" data-toggle="modal" data-target="#yearly_expense_all_report_modal">
                                گزارش
                                سالانه
                                (کلی)
                            </button>
                        </div>

                        <div class="col-md-4 my-4">
                            <button class="btn btn-flat card-2 btn-primary btn-block" data-toggle="modal" data-target="#yearly_expense_except_report_modal">
                                گزارش
                                سالانه
                                (استثنا)
                            </button>
                        </div>

                        <div class="col-md-4 my-4">
                            <button class="btn btn-flat card-2 btn-primary btn-block" data-toggle="modal" data-target="#daily_expense_report_modal">
                                گزارش
                                روزانه
                                (کلی)
                            </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
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











<!-- daily_expense_report_modal -->
<div id="daily_expense_report_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <?= form_open('reports/daily-expense-report'); ?>
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">گزارش</h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>سال گزارش</label>
                                <select name="report_year" class="select2" style="width:100% !important;">
                                    <?php for ($report_year=1395; $report_year<=1410; $report_year++) : ?>
                                        <option value="<?= $report_year; ?>"><?= $report_year; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>ماه گزارش</label>
                                <select name="report_month" class="select2" style="width:100% !important;">
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
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>روز گزارش</label>
                                <select name="report_day" class="select2" style="width:100% !important;">
                                    <?php for ($report_day=1; $report_day<=31; $report_day++) : ?>
                                        <option value="<?= $report_day; ?>"><?= $report_day; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-flat">گزارش</button>
                    <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">کنسل</button>
                </div>
            </div>
        <?= form_close(); ?>
    </div>
</div>








<!-- monthly_expense_single_report_modal -->
<div id="monthly_expense_single_report_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <?= form_open('reports/monthly-expense-single'); ?>
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">گزارش</h4>
                </div>
                <div class="modal-body">

                  <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>سال گزارش</label>
                            <select name="report_year" class="select2" style="width:100% !important;">
                                <?php for ($report_year=1395; $report_year<=1410; $report_year++) : ?>
                                    <option value="<?= $report_year; ?>"><?= $report_year; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>ماه گزارش</label>
                            <select name="report_month" class="select2" style="width:100% !important;">
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
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>کتگوری گزارش</label>
                            <select name="expense_category_id" class="select2" style="width:100% !important;">
                                <?php foreach ($expense_categories as $expense_category_item) : ?>
                                    <option value="<?= $expense_category_item->id; ?>"><?= $expense_category_item->cat_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                  </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-flat">گزارش</button>
                    <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">کنسل</button>
                </div>
            </div>
        <?= form_close(); ?>
    </div>
</div>





<!-- monthly_expense_all_report_modal -->
<div id="monthly_expense_all_report_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <?= form_open('reports/monthly-expense-all'); ?>
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">گزارش</h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>سال گزارش</label>
                                <select name="report_year" class="select2" style="width:100% !important;">
                                    <?php for ($report_year=1395; $report_year<=1410; $report_year++) : ?>
                                        <option value="<?= $report_year; ?>"><?= $report_year; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ماه گزارش</label>
                                <select name="report_month" class="select2" style="width:100% !important;">
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
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-flat">گزارش</button>
                    <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">کنسل</button>
                </div>
            </div>
        <?= form_close(); ?>
    </div>
</div>






<!-- monthly_expense_except_report_modal -->
<div id="monthly_expense_except_report_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <?= form_open('reports/monthly-expense-except'); ?>
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">گزارش</h4>
                </div>
                <div class="modal-body">

                  <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>سال گزارش</label>
                            <select name="report_year" class="select2" style="width:100% !important;">
                                <?php for ($report_year=1395; $report_year<=1410; $report_year++) : ?>
                                    <option value="<?= $report_year; ?>"><?= $report_year; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>ماه گزارش</label>
                            <select name="report_month" class="select2" style="width:100% !important;">
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
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>کتگوری گزارش (استثنا)</label>
                            <select name="expense_category_id[]" class="select2" multiple="" style="width:100% !important;">
                                <?php foreach ($expense_categories as $expense_category_item) : ?>
                                    <option value="<?= $expense_category_item->id; ?>"><?= $expense_category_item->cat_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                  </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-flat">گزارش</button>
                    <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">کنسل</button>
                </div>
            </div>
        <?= form_close(); ?>
    </div>
</div>










<!-- yearly_expense_single_report_modal -->
<div id="yearly_expense_single_report_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <?= form_open('reports/yearly-expense-single'); ?>
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">گزارش</h4>
                </div>
                <div class="modal-body">

                    
                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label>سال گزارش</label>
                              <select name="report_year" class="select2" style="width:100% !important;">
                                  <?php for ($report_year=1395; $report_year<=1410; $report_year++) : ?>
                                      <option value="<?= $report_year; ?>"><?= $report_year; ?></option>
                                  <?php endfor; ?>
                              </select>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label>کتگوری گزارش</label>
                              <select name="expense_category_id" class="select2" style="width:100% !important;">
                                  <?php foreach ($expense_categories as $expense_category_item) : ?>
                                      <option value="<?= $expense_category_item->id; ?>"><?= $expense_category_item->cat_name; ?></option>
                                  <?php endforeach; ?>
                              </select>
                          </div>
                      </div>
                  </div>


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-flat">گزارش</button>
                    <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">کنسل</button>
                </div>
            </div>
        <?= form_close(); ?>
    </div>
</div>





<!-- yearly_expense_all_report_modal -->
<div id="yearly_expense_all_report_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <?= form_open('reports/yearly-expense-all'); ?>
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">گزارش</h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>سال گزارش</label>
                                <select name="report_year" class="select2" style="width:100% !important;">
                                    <?php for ($report_year=1395; $report_year<=1410; $report_year++) : ?>
                                        <option value="<?= $report_year; ?>"><?= $report_year; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-flat">گزارش</button>
                    <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">کنسل</button>
                </div>
            </div>
        <?= form_close(); ?>
    </div>
</div>




<!-- yearly_expense_except_report_modal -->
<div id="yearly_expense_except_report_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <?= form_open('reports/yearly-expense-except'); ?>
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">گزارش</h4>
                </div>
                <div class="modal-body">

                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label>سال گزارش</label>
                              <select name="report_year" class="select2" style="width:100% !important;">
                                  <?php for ($report_year=1395; $report_year<=1410; $report_year++) : ?>
                                      <option value="<?= $report_year; ?>"><?= $report_year; ?></option>
                                  <?php endfor; ?>
                              </select>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label>کتگوری گزارش (استثنا)</label>
                              <select name="expense_category_id[]" class="select2" multiple="" style="width:100% !important;">
                                  <?php foreach ($expense_categories as $expense_category_item) : ?>
                                      <option value="<?= $expense_category_item->id; ?>"><?= $expense_category_item->cat_name; ?></option>
                                  <?php endforeach; ?>
                              </select>
                          </div>
                      </div>
                  </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-flat">گزارش</button>
                    <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">کنسل</button>
                </div>
            </div>
        <?= form_close(); ?>
    </div>
</div>



