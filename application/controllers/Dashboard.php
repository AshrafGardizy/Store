<?php
class Dashboard extends CI_Controller
{
    // test
    public function test()
    {
        // importing the database
        if (file_exists('assets/store.sql')) {
            $lines = file('assets/store.sql');
            $statement = '';
            foreach ($lines as $line) {
                $statement .= $line;
                if (substr(trim($line), -1) === ';') {
                    $this->db->simple_query($statement);
                    $statement = '';
                }
            }
        } else {
            echo 'not exists';
        }
    }
    // testing
    public function testing()
    {
        $db_name = 'backup-' . $this->db->database . '-' . time() . '.sql';
        $this->load->dbutil();
        $prefs = [
            'format' => 'txt'
        ];
        $backup = $this->dbutil->backup($prefs);
        $this->load->helper('file');
        write_file($db_name, $backup);
        write_file($db_name, '# Powered By Ashraf Gardizy', 'a');
        $this->load->helper('download');
        force_download('./' . $db_name, null);
    }
    // backup
    public function backup()
    {
        $this->security();

        // validation
		$this->form_validation->set_rules('form_code', ' ', 'required');

        // form submittion
        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('danger', ' ');
            redirect(base_url() . 'dashboard');
        } else {
            $filename = $this->input->post('backup');
            $final_filename = $filename . '-' . $this->db->database . '-' . time() . '.sql';
            $this->load->dbutil();
            $prefs = [
                'format' => 'txt'
            ];
            $backup = $this->dbutil->backup($prefs);
            $this->load->helper('file');
            write_file($final_filename, $backup);
            write_file($final_filename, '# Powered By Ashraf Gardizy', 'a');
            $this->load->helper('download');
            force_download('./' . $final_filename, null);
        }
    }


    // security
    public function security()
    {
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('danger', 'متاسفانه شما وارد نشده اید!');
            redirect(base_url());
        }
    }

    // jalali_today
    public function jalali_today($date = false)
    {
        if ($date == 'year') {
            $today = $this->gregorian_to_jalali(date('Y'), date('m'), date('d'));
            return $today[0];
        } elseif ($date == 'month') {
            $today = $this->gregorian_to_jalali(date('Y'), date('m'), date('d'));
            return $today[1];
        } elseif ($date == 'day') {
            $today = $this->gregorian_to_jalali(date('Y'), date('m'), date('d'));
            return $today[2];
        } else {
            return $this->gregorian_to_jalali(date('Y'), date('m'), date('d'));
        }
    }

    // index
    public function index()
    {
        $this->security();
        $data['settings'] = $this->model->get_settings();
        $data['categories'] = $this->model->get_tbl_rows('product_category');
        $data['jalali_today'] = $this->jalali_today();

        // validation
		$this->form_validation->set_rules('form_code', ' ', 'required');

        // form submittion
        if ($this->form_validation->run() === false) {
            $this->load->view('layout/header', $data);
            $this->load->view('layout/nav');
            $this->load->view('dashboard/index');
            $this->load->view('layout/footer');
        } else {
            // Upload Image
            if ($_POST['form_code'] == 'profile-pic') {
                $fileExt = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
                $new_name = time() . 'profile-pic.' . $fileExt;
                $config['file_name'] = $new_name;
                $config['upload_path'] = './assets/images/profile-pic';
                $config['allowed_types'] = 'gif|png|jpg';
                $config['max_size'] = '8192';
                $config['file_ext_tolower'] = true;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload()) {
                    $data = [
                        'upload_data' => $this->upload->data()
                    ];
                    $photo = $new_name;
                } else {
                    $errors = [
                        'error' => $this->upload->display_errors()
                    ];
                    $photo = 'noimage.png';
                }
                // model
                $this->model->change_profile_pic($new_name);
            }
            // Profile
            if ($_POST['form_code'] == 'profile') {
                $firstname = $this->input->post('firstname');
                $lastname = $this->input->post('lastname');
                // model
                $this->model->update_profile($firstname, $lastname);
            }
            // Change Username
            if ($_POST['form_code'] == 'change_username') {
                $cur_username = $this->input->post('cur_username');
                $new_username = $this->input->post('new_username');
                $conf_username = $this->input->post('conf_username');
                if (($cur_username != $data['settings']->username) || ($new_username != $conf_username)) {
                    $this->session->set_flashdata('danger', ' ');
                    redirect(base_url() . 'dashboard');
                }
                // model
                $this->model->update_username($new_username);
            }
            // Change Password
            if ($_POST['form_code'] == 'change_password') {
                $cur_password = md5($this->input->post('cur_password'));
                $new_password = md5($this->input->post('new_password'));
                $conf_password = md5($this->input->post('conf_password'));
                if (($cur_password != $data['settings']->password) || ($new_password != $conf_password)) {
                    $this->session->set_flashdata('danger', ' ');
                    redirect(base_url() . 'dashboard');
                }
                // model
                $this->model->update_password($new_password);
            }
            // Add Category
            if ($_POST['form_code'] == 'add_category') {
                $category = $this->input->post('category');
                // model
                $this->model->set_category($category);
            }
            // Change Settings
            if ($_POST['form_code'] == 'change_settings') {
                // Upload the LOGO
                if ($_FILES['userfile']['name']) {
                    $fileExt = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
                    $new_name = time() . 'logo.' . $fileExt;
                    $config['file_name'] = $new_name;
                    $config['upload_path'] = './assets/images/logo';
                    $config['allowed_types'] = 'gif|png|jpg';
                    $config['max_size'] = '8192';
                    $config['file_ext_tolower'] = true;
                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload()) {
                        $data = [
                            'upload_data' => $this->upload->data()
                        ];
                        $photo = $new_name;
                    } else {
                        $errors = [
                            'error' => $this->upload->display_errors()
                        ];
                        $photo = $data['settings']->store_logo;
                    }
                } else {
                    $photo = $data['settings']->store_logo;
                }
                // model
                $this->model->update_settings($photo);
            }
            // Add Sales
            if ($_POST['form_code'] == 'add_new_sale') {
                $code_no = $data['settings']->code_no;

                // Chk DUPLICATION for code_no in sale TBL
                // if the result was true; it means its duplicated, if not continue
                $duplication_result = $this->model->chk_sale_duplication($code_no);

                if ($duplication_result) {
                    $this->session->set_flashdata('danger', ' ');
                    redirect(base_url() . 'dashboard');
                } else {
                    $date_d = $this->input->post('date_d');
                    $date_m = $this->input->post('date_m');
                    $date_y = $this->input->post('date_y');
                    $sale_date = $date_y . '/' . $date_m . '/' . $date_d;
                    // Save in DB
                    $cust_id = $this->model->add_new_sale($code_no, $sale_date);

                    // Increase the code_no in settings
                    $this->model->increase_code_no($code_no);

                    // Redirect
                    redirect('sales/' . $cust_id . '/step-1');
                }
            }
            // Add Goods
            if ($_POST['form_code'] == 'add_new_good') {
                for ($goods_input = 0; $goods_input <= 9; $goods_input++) {
                    // form data
                    $good_name = $this->input->post('good_name')[$goods_input];
                    $good_total_no = $this->input->post('good_total_no')[$goods_input];
                    $good_category = $this->input->post('good_category')[$goods_input];
                    $good_buy = $this->input->post('good_buy')[$goods_input];
                    if ($good_name == '') {
                        redirect(base_url() . 'goods');
                    }
                    // chk $good_name for duplication
                    $duplication_result = $this->model->chk_good_duplication($good_name);
                    if ($duplication_result) {
                        $this->session->set_flashdata('danger', ' ');
                        redirect(base_url() . 'goods');
                    } else {
                        // Save in DB
                        $result = $this->model->add_new_good($good_name, $good_total_no, $good_category, $good_buy);
                    }
                }
            }
            $this->session->set_flashdata('success', ' ');
            redirect(base_url() . 'dashboard');
        }
    }

    function gregorian_to_jalali($gy,$gm,$gd,$mod='')
    {
        date_default_timezone_set('Asia/kabul');
        $g_d_m=array(0,31,59,90,120,151,181,212,243,273,304,334);
        if($gy>1600){
            $jy=979;
            $gy-=1600;
        }else{
            $jy=0;
            $gy-=621;
        }
        $gy2=($gm>2)?($gy+1):$gy;
        $days=(365*$gy) +((int)(($gy2+3)/4)) -((int)(($gy2+99)/100)) +((int)(($gy2+399)/400)) -80 +$gd +$g_d_m[$gm-1];
        $jy+=33*((int)($days/12053)); 
        $days%=12053;
        $jy+=4*((int)($days/1461));
        $days%=1461;
        if($days > 365){
            $jy+=(int)(($days-1)/365);
            $days=($days-1)%365;
        }
        $jm=($days < 186)?1+(int)($days/31):7+(int)(($days-186)/30);
        $jd=1+(($days < 186)?($days%31):(($days-186)%30));
        return($mod=='')?array($jy,$jm,$jd):$jy.$mod.$jm.$mod.$jd;
    }
    function jalali_to_gregorian($jy,$jm,$jd,$mod=''){
        date_default_timezone_set('Asia/kabul');
        if($jy>979){
            $gy=1600;
            $jy-=979;
        }else{
            $gy=621;
        }
        $days=(365*$jy) +(((int)($jy/33))*8) +((int)((($jy%33)+3)/4)) +78 +$jd +(($jm<7)?($jm-1)*31:(($jm-7)*30)+186);
        $gy+=400*((int)($days/146097));
        $days%=146097;
        if($days > 36524){
            $gy+=100*((int)(--$days/36524));
            $days%=36524;
            if($days >= 365)$days++;
        }
        $gy+=4*((int)($days/1461));
        $days%=1461;
        if($days > 365){
            $gy+=(int)(($days-1)/365);
            $days=($days-1)%365;
        }
        $gd=$days+1;
        foreach(array(0,31,(($gy%4==0 and $gy%100!=0) or ($gy%400==0))?29:28 ,31,30,31,30,31,31,30,31,30,31) as $gm=>$v){
            if($gd<=$v)break;
            $gd-=$v;
        }
        return($mod=='')?array($gy,$gm,$gd):$gy.$mod.$gm.$mod.$gd;
    }

    // delete_category
    public function delete_category($id)
    {
        $this->security();
        $this->model->delete_category($id);
        $this->session->set_flashdata('success', ' ');
        redirect(base_url() . 'dashboard');
    }

    // sales_step_1
    public function sales_step_1($cust_id)
    {
        $this->security();
        $data['settings'] = $this->model->get_settings();
        $data['categories'] = $this->model->get_tbl_rows('product_category');

        $data['customer'] = $this->model->get_customer($cust_id);
        $data['code_no'] = $data['customer']->code_no;

        $data['goods'] = $this->model->get_goods($cust_id);

        $data['godam_goods'] = $this->model->get_good_lists();

        // validation
		$this->form_validation->set_rules('good_id[]', ' ', 'required');

        // form submittion
        if ($this->form_validation->run() === false) {
            $this->load->view('layout/header', $data);
            $this->load->view('layout/nav');
            $this->load->view('dashboard/sale-step-1');
            $this->load->view('layout/footer');
        } else {
            for ($sale_input = 0; $sale_input <= 9; $sale_input++) {
                $good_id = $this->input->post('good_id')[$sale_input];
                $good_qty = $this->input->post('good_qty')[$sale_input];
                $good_price = $this->input->post('good_price')[$sale_input];
                if (!$good_qty) {
                    redirect('sales/' . $cust_id . '/step-1/succeed');
                }
                $godam_good = $this->model->get_godam_good($good_id);
                $good_buy_price = $godam_good->good_buy;
                $good_total_af = ($this->input->post('good_price')[$sale_input]) * ($this->input->post('good_qty')[$sale_input]);
                $good_total_us = ($good_total_af) / ($data['settings']->af_value);
                $this->model->set_sale_step_1($cust_id, $good_id, $good_qty, $good_buy_price, $good_price, $good_total_af, $good_total_us);
            }
            redirect('sales/' . $cust_id . '/step-1/succeed');
        }
    }

    // sales_step_1_cancel
    public function sales_step_1_cancel($cust_id)
    {
        $this->security();
        $customer = $this->model->get_customer($cust_id);
        $result = $this->model->cancel_increase_code_no($customer->code_no);
        if ($result) {
            $this->model->delete_customer($cust_id);
            $this->session->set_flashdata('success', 'sale_canceled');
            redirect(base_url() . 'dashboard');
        }
    }

    // sales_step_1_succeed
    public function sales_step_1_succeed($cust_id)
    {
        $this->security();
        $data['settings'] = $this->model->get_settings();
        $data['categories'] = $this->model->get_tbl_rows('product_category');

        $data['customer'] = $this->model->get_customer($cust_id);

        $data['goods'] = $this->model->get_goods($cust_id);

        $data['godam_goods'] = $this->model->get_good_lists();

        // $data['code_category'] = $data['customer']->code_category;
        $data['code_no'] = $data['customer']->code_no;
    
        // validation
		$this->form_validation->set_rules('form_code', ' ', 'required');

        // form submittion
        if ($this->form_validation->run() === false) {
            $this->load->view('layout/header', $data);
            $this->load->view('layout/nav');
            $this->load->view('dashboard/sale-step-1-succeed');
            $this->load->view('layout/footer');
        } else {
            // Update Sale
            if ($_POST['form_code'] == 'update_sale') {
                $good_total_af = ($this->input->post('good_price')) * ($this->input->post('good_qty'));
                $good_total_us = ($good_total_af) / ($data['settings']->af_value);
                $sale_id = $this->input->post('sale_id');
                $this->model->update_sale($sale_id, $good_total_af, $good_total_us);
                redirect('sales/' . $cust_id . '/step-1/succeed');
            }
            // Print
            if ($_POST['form_code'] == 'print') {
                $af_value = $data['settings']->af_value;
                $payment_id = $this->model->set_payment($cust_id, $data['code_no'], $af_value);
                $this->session->set_flashdata('success', ' ');
                redirect('sales/' . $cust_id . '/payment/' . $payment_id);
            }
        }
    }

    // sale_payment
    public function sale_payment($cust_id, $payment_id)
    {
        $this->security();
        $data['settings'] = $this->model->get_settings();
        $data['categories'] = $this->model->get_tbl_rows('product_category');

        $data['customer'] = $this->model->get_customer($cust_id);

        $data['goods'] = $this->model->get_goods($cust_id);

        $data['payment'] = $this->model->get_payment($payment_id);

        $data['code_no'] = $data['customer']->code_no;
    
        // validation
		$this->form_validation->set_rules('form_code', ' ', 'required');

        // form submittion
        if ($this->form_validation->run() === false) {
            $this->load->view('layout/header', $data);
            $this->load->view('layout/nav');
            $this->load->view('dashboard/sale-payment');
            $this->load->view('layout/footer');
        } else {
        }
    }

    // sale_payment_done
    public function sale_payment_done($cust_id, $payment_id)
    {
        $this->security();
        $this->model->set_payment_done($payment_id);

        die('doing');
        $settings = $this->model->get_settings();
        // chk for enable_godam
        if ($settings->enable_godam) {
            $goods = $this->model->get_goods($cust_id);
            foreach ($goods as $good_item) {
                $this->model->decrease_godam_good($good_item->good_id, $good_item->good_qty);
            }
        }
        $this->session->set_flashdata('success', ' ');
        redirect('sales');
    }

    // delete_sale
    public function delete_sale($cust_id, $sale_id)
    {
        $this->security();
        $this->model->delete_sale($sale_id);
        redirect(base_url() . 'sales/' . $cust_id . '/step-1/succeed');
    }

    // sales_list
    public function sales_list($offset = 0)
    {
        $this->my_pagination('sales', $this->model->get_total_sale_lists(), 1000, 2, 'page-no-');

        $this->security();
        $data['settings'] = $this->model->get_settings();
        $data['categories'] = $this->model->get_tbl_rows('product_category');

        $data['sale_lists'] = $this->model->get_sale_lists(1000, $offset);

        $data['total_rows'] = $this->model->get_total_sale_lists();

        $data['search_result'] = false;
        $data['q'] = false;
        $data['q_category'] = false;
        $data['q_sort'] = false;

        // validation
        $this->form_validation->set_rules('form_code', ' ', 'required');

        // form submittion
        if ($this->form_validation->run() === false) {
            $this->load->view('layout/header', $data);
            $this->load->view('layout/nav');
            $this->load->view('dashboard/sale-lists');
            $this->load->view('layout/footer');
        } else {
            if ($this->input->post('form_code') == 'pay_remain') {
                $cust_id = $this->input->post('cust_id');
                $paid_amount_af = (int) $this->input->post('paid_amount_af');
                $pay_remain = (int) $this->input->post('pay_remain');
                $remain_amount_af = (int) $this->input->post('remain_amount_af');
                $paid_amount_af_final = ($pay_remain) + ($paid_amount_af);
                $paid_amount_us_final = ($paid_amount_af_final) / ($data['settings']->af_value);
                $remain_amount_af_final = ($remain_amount_af) - ($pay_remain);
                $remain_amount_us_final = $remain_amount_af_final / ($data['settings']->af_value);
                // model
                $this->model->update_paid_amount($cust_id, $paid_amount_af_final, $paid_amount_us_final, $remain_amount_af_final, $remain_amount_us_final);
                redirect('sales/' . $cust_id);
            } elseif ($this->input->post('form_code') == 'search') {
                $data['q'] = $this->input->post('q');
                $data['q_category'] = $this->input->post('q_category');
                $data['q_sort'] = $this->input->post('q_sort');
                if ($this->input->post('q_category') == 'remain_amount_af') {
                    $result = $this->model->get_search('payment');
                } else {
                    $result = $this->model->get_search('customer');
                }
                if (!$result) {
                    $this->session->set_flashdata('danger', ' ');
                    redirect('sales');
                }
                $data['search_result'] = $result;
                $this->load->view('layout/header', $data);
                $this->load->view('layout/nav');
                $this->load->view('dashboard/sale-lists');
                $this->load->view('layout/footer');
            }
        }
    }

    // delete_sale_list
    public function delete_sale_list($cust_id)
    {
        $this->security();
        $this->model->delete_sale_list($cust_id);
        $this->session->set_flashdata('success', ' ');
        redirect(base_url() . 'sales');
    }

    // show_the_bill
    public function show_the_bill($cust_id)
    {
        $this->security();
        $data['settings'] = $this->model->get_settings();
        $data['categories'] = $this->model->get_tbl_rows('product_category');

        $data['customer'] = $this->model->get_customer($cust_id);

        $data['goods'] = $this->model->get_goods($cust_id);

        $data['payment'] = $this->model->get_payment($cust_id);

        $data['code_no'] = $data['customer']->code_no;

        $this->load->view('layout/header', $data);
        $this->load->view('layout/nav');
        $this->load->view('dashboard/bill');
        $this->load->view('layout/footer');
    }

    // goods_list
    public function goods_list($offset = 0)
    {
        $this->my_pagination('goods', $this->model->get_total_good_lists(), 1000, 2, 'page-no-');

        $this->security();
        $data['settings'] = $this->model->get_settings();
        $data['categories'] = $this->model->get_tbl_rows('product_category');

        $data['good_lists'] = $this->model->get_good_lists(1000, $offset);

        $data['total_rows'] = $this->model->get_total_good_lists();

        $data['search_result'] = false;
        $data['q'] = false;
        $data['q_category'] = false;
        $data['q_sort'] = false;

        // validation
        $this->form_validation->set_rules('form_code', ' ', 'required');

        // form submittion
        if ($this->form_validation->run() === false) {
            $this->load->view('layout/header', $data);
            $this->load->view('layout/nav');
            $this->load->view('dashboard/good-lists');
            $this->load->view('layout/footer');
        } else {
            if ($this->input->post('form_code') == 'edit') {
                $good_id = $this->input->post('good_id');
                $good_name = $this->input->post('good_name');
                // chk $good_name for duplication
                $duplication_result = $this->model->chk_good_duplication($good_name, $good_id);
                if ($duplication_result) {
                    $this->session->set_flashdata('danger', ' ');
                    redirect(base_url() . 'goods');
                }
                // model
                $this->model->update_good($good_id);
                $this->session->set_flashdata('success', ' ');
                redirect('goods');
            } elseif ($this->input->post('form_code') == 'search') {
                $data['q'] = $this->input->post('q');
                $data['q_category'] = $this->input->post('q_category');
                $data['q_sort'] = $this->input->post('q_sort');
                $result = $this->model->search_godam();
                if (!$result) {
                    $this->session->set_flashdata('danger', ' ');
                    redirect('goods');
                }
                $data['search_result'] = $result;
                $this->load->view('layout/header', $data);
                $this->load->view('layout/nav');
                $this->load->view('dashboard/good-lists');
                $this->load->view('layout/footer');
            }
        }
    }

    // delete_good
    public function delete_good($good_id)
    {
        $this->security();
        $this->model->delete_good($good_id);
        $this->session->set_flashdata('success', ' ');
        redirect('goods');
    }


    // people_finances
    public function people_finances($offset = 0)
    {
        $this->my_pagination('people-finances', $this->model->get_total_people_finances(), 1000, 2, 'page-no-');

        $this->security();
        $data['settings'] = $this->model->get_settings();
        $data['categories'] = $this->model->get_tbl_rows('product_category');

        $data['people_finances'] = $this->model->get_people_finances(1000, $offset);

        $data['total_creditors_amount'] = $this->model->get_total_creditors_amount();
        $data['total_debtors_amount'] = $this->model->get_total_debtors_amount();

        $data['total_rows'] = $this->model->get_total_people_finances();

        $data['search_result'] = false;
        $data['q'] = false;
        $data['q_category'] = false;
        $data['q_sort'] = false;

        // validation
        $this->form_validation->set_rules('form_code', ' ', 'required');

        // form submittion
        if ($this->form_validation->run() === false) {
            $this->load->view('layout/header', $data);
            $this->load->view('layout/nav');
            $this->load->view('dashboard/people-finances');
            $this->load->view('layout/footer');
        } else {
            if ($this->input->post('form_code') == 'edit') {
                $id = $this->input->post('id');
                $this->model->update_people_finance($id);
                $this->session->set_flashdata('success', ' ');
                redirect('people-finances');
            } elseif ($this->input->post('form_code') == 'search') {
                $data['q'] = $this->input->post('q');
                $data['q_category'] = $this->input->post('q_category');
                $data['q_sort'] = $this->input->post('q_sort');
                $result = $this->model->search_people_finances();
                if (!$result) {
                    $this->session->set_flashdata('danger', ' ');
                    redirect('people-finances');
                }
                $data['search_result'] = $result;
                $this->load->view('layout/header', $data);
                $this->load->view('layout/nav');
                $this->load->view('dashboard/people-finances');
                $this->load->view('layout/footer');
            } elseif ($this->input->post('form_code') == 'add') {
                $this->model->add_people_finance();
                $this->session->set_flashdata('success', ' ');
                redirect('people-finances');
            }
        }
    }

    // people_finance_delete
    public function people_finance_delete($id)
    {
        $this->security();
        $this->model->people_finance_delete($id);
        $this->session->set_flashdata('success', ' ');
        redirect('people-finances');
    }
    
    public function my_pagination($base_url, $total_rows, $per_page, $uri_segment, $prefix)
    {
        // Pagination Config
        $config['base_url'] = base_url() . $base_url;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['uri_segment'] = $uri_segment;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'بعدی';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = 'قبلی';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['num_links'] = 1;
        $config['first_link'] = '<i class="fa fa-angle-double-right"></i> اول';
        $config['last_link'] = 'آخر <i class="fa fa-angle-double-left"></i>';
        $config['prefix'] = $prefix;
        $this->pagination->initialize($config);
    }

    // perm_customers
    public function perm_customers($offset = 0)
    {
        $this->my_pagination('perm-customers', $this->model->get_total_perm_customers(), 1000, 2, 'page-no-');

        $this->security();
        $data['settings'] = $this->model->get_settings();
        $data['categories'] = $this->model->get_tbl_rows('product_category');

        $data['perm_customers'] = $this->model->get_perm_customers(1000, $offset);

        $data['total_rows'] = $this->model->get_total_perm_customers();

        $data['search_result'] = false;
        $data['q'] = false;
        $data['q_category'] = false;
        $data['q_sort'] = false;

        // validation
        $this->form_validation->set_rules('form_code', ' ', 'required');

        // form submittion
        if ($this->form_validation->run() === false) {
            $this->load->view('layout/header', $data);
            $this->load->view('layout/nav');
            $this->load->view('dashboard/perm-customers');
            $this->load->view('layout/footer');
        } else {
            if ($this->input->post('form_code') == 'edit') {
                $id = $this->input->post('id');
                // model
                $this->model->update_perm_customer($id);
                $this->session->set_flashdata('success', ' ');
                redirect('perm-customers');
            } elseif ($this->input->post('form_code') == 'search') {
                $data['q'] = $this->input->post('q');
                $data['q_category'] = $this->input->post('q_category');
                $data['q_sort'] = $this->input->post('q_sort');
                $result = $this->model->search_perm_customers();
                if (!$result) {
                    $this->session->set_flashdata('danger', ' ');
                    redirect('perm-customers');
                }
                $data['search_result'] = $result;
                $this->load->view('layout/header', $data);
                $this->load->view('layout/nav');
                $this->load->view('dashboard/perm-customers');
                $this->load->view('layout/footer');
            } elseif ($this->input->post('form_code') == 'add') {
                // chk for duplication of per_customer
                $duplication = $this->model->chk_perm_customer_duplication($this->input->post('full_name'));
                if (!$duplication) {
                    $this->model->add_perm_customer();
                    $this->session->set_flashdata('success', ' ');
                }
                $this->session->set_flashdata('danger', ' ');
                redirect('perm-customers');
            }
        }
    }

    // expense_delete
    public function expense_delete($id)
    {
        $this->security();
        $this->model->expense_delete($id);
        $this->session->set_flashdata('success', ' ');
        redirect('expenses');
    }

    // expense_category_delete
    public function expense_category_delete($id)
    {
        $this->security();
        // chk if any expense setted to this (id)
        $result = $this->model->get_expenses_by_category($id);
        if (!$result) {
            $this->model->expense_category_delete($id);
            $this->session->set_flashdata('success', ' ');
        } else {
            $this->session->set_flashdata('danger', ' ');
        }
        redirect('expenses');
    }

    // perm_customers_finances
    public function perm_customers_finances($offset = 0)
    {
        $this->my_pagination('perm-customers-finances', $this->model->get_total_perm_customers_finances(), 1000, 2, 'page-no-');

        $this->security();
        $data['settings'] = $this->model->get_settings();
        $data['categories'] = $this->model->get_tbl_rows('product_category');

        $data['perm_customer_finances'] = $this->model->get_perm_customers_finances(1000, $offset);

        $data['total_creditors_amount'] = $this->model->get_perm_cust_total_creditors_amount();
        $data['total_debtors_amount'] = $this->model->get_perm_cust_total_debtors_amount();

        $data['total_rows'] = $this->model->get_total_perm_customers_finances();

        $data['perm_customers'] = $this->model->get_perm_customers();

        $data['search_result'] = false;
        $data['q'] = false;
        $data['q_category'] = false;
        $data['q_sort'] = false;

        // validation
        $this->form_validation->set_rules('form_code', ' ', 'required');

        // form submittion
        if ($this->form_validation->run() === false) {
            $this->load->view('layout/header', $data);
            $this->load->view('layout/nav');
            $this->load->view('dashboard/perm-customers-finances');
            $this->load->view('layout/footer');
        } else {
            if ($this->input->post('form_code') == 'edit') {
                $id = $this->input->post('id');
                // model
                $this->model->update_perm_customer_finance($id);
                $this->session->set_flashdata('success', ' ');
                redirect('perm-customers-finances');
            } elseif ($this->input->post('form_code') == 'search') {
                $data['q'] = $this->input->post('q');
                $data['q_category'] = $this->input->post('q_category');
                $data['q_sort'] = $this->input->post('q_sort');
                $result = $this->model->search_perm_customers_finances();
                if (!$result) {
                    $this->session->set_flashdata('danger', ' ');
                    redirect('perm-customers-finances');
                }
                $data['search_result'] = $result;
                $this->load->view('layout/header', $data);
                $this->load->view('layout/nav');
                $this->load->view('dashboard/perm-customers-finances');
                $this->load->view('layout/footer');
            } elseif ($this->input->post('form_code') == 'add') {
                $this->model->add_perm_customer_finance();
                $this->session->set_flashdata('success', ' ');
                redirect('perm-customers-finances');
            }
        }
    }

    // perm_customer_delete
    public function perm_customer_delete($id)
    {
        $this->security();
        // chk if any finance setted to this (id)
        $result = $this->model->get_finances_by_perm_customer($id);
        if (!$result) {
            $this->model->perm_customer_delete($id);
            $this->session->set_flashdata('success', ' ');
        } else {
            $this->session->set_flashdata('danger', ' ');
        }
        redirect('perm-customers');
    }

    // perm_customers_finance_delete
    public function perm_customers_finance_delete($id)
    {
        $this->security();
        $this->model->perm_customers_finance_delete($id);
        $this->session->set_flashdata('success', ' ');
        redirect('perm-customers-finances');
    }

    // reports
    public function reports()
    {
        $this->security();
        $data['settings'] = $this->model->get_settings();
        $data['categories'] = $this->model->get_tbl_rows('product_category');

        $data['perm_customers'] = $this->model->get_perm_customers();

        $data['expense_categories'] = $this->model->get_tbl_rows('expense_categories');

        // validation
        $this->form_validation->set_rules('form_code', ' ', 'required');

        // form submittion
        if ($this->form_validation->run() === false) {
            $this->load->view('layout/header', $data);
            $this->load->view('layout/nav');
            $this->load->view('dashboard/reports');
            $this->load->view('layout/footer');
        } else {
            die;
        }
    }



    //                      .:: Expenses ::.
    // expenses
    public function expenses($offset = 0)
    {
        $this->security();
        $data['settings'] = $this->model->get_settings();
        $data['categories'] = $this->model->get_tbl_rows('product_category');

        $data['total_rows'] = $this->model->get_total_expenses();

        $this->my_pagination('expenses', $data['total_rows'], 1000, 2, 'page-no-');

        $data['expenses'] = $this->model->get_expenses(1000, $offset);
        $data['expense_categories'] = $this->model->get_tbl_rows('expense_categories');

        $data['search_result'] = false;
        $data['q'] = false;
        $data['q_category'] = false;
        $data['q_sort'] = false;

        // validation
        $this->form_validation->set_rules('form_code', ' ', 'required');

        // form submittion
        if ($this->form_validation->run() === false) {
            $this->load->view('layout/header', $data);
            $this->load->view('layout/nav');
            $this->load->view('dashboard/expenses');
            $this->load->view('layout/footer');
        } else {
            if ($this->input->post('form_code') == 'edit') {
                $id = $this->input->post('id');
                // model
                $this->model->update_expense($id);
                $this->session->set_flashdata('success', ' ');
                redirect('expenses');
            } elseif ($this->input->post('form_code') == 'search') {
                $data['q'] = $this->input->post('q');
                $data['q_category'] = $this->input->post('q_category');
                $data['q_sort'] = $this->input->post('q_sort');
                $result = $this->model->search_expenses();
                if (!$result) {
                    $this->session->set_flashdata('danger', ' ');
                    redirect('expenses');
                }
                $data['search_result'] = $result;
                $this->load->view('layout/header', $data);
                $this->load->view('layout/nav');
                $this->load->view('dashboard/expenses');
                $this->load->view('layout/footer');
            } elseif ($this->input->post('form_code') == 'add') {
                $this->model->add_expense();
                $this->session->set_flashdata('success', ' ');
                redirect('expenses');
            } elseif ($this->input->post('form_code') == 'add_expense_category') {
                // chk for duplication
                $duplication = $this->model->chk_expense_category_duplication($this->input->post('expense_category'));
                if (!$duplication) {
                    $this->model->add_expense_category();
                    $this->session->set_flashdata('success', ' ');
                }
                $this->session->set_flashdata('danger', ' ');
                redirect('expenses');
            }
        }
    }


    //                  .::Reports::.
    // report_perm_customer_finance
    public function report_perm_customer_finance()
    {
        $this->security();
        $data['settings'] = $this->model->get_settings();
        $data['categories'] = $this->model->get_tbl_rows('product_category');

        // form data
        $perm_cust_id = $this->input->post('perm_cust_id');

        // get perm_customer
        $data['perm_customer'] = $this->model->get_perm_customer($perm_cust_id);
        // get perm_customer finances
        $data['perm_customer_finances'] = $this->model->get_perm_customer_finances($perm_cust_id);
        if (!$data['perm_customer_finances']) {
            $this->session->set_flashdata('danger', ' ');
            redirect('reports');
        }
        // get total credit of perm_customer finances
        $data['total_creditor_perm_customer_finances'] = $this->model->get_total_creditor_perm_customer_finances($perm_cust_id);
        if (!$data['total_creditor_perm_customer_finances']) {
            $this->session->set_flashdata('danger', ' ');
            redirect('reports');
        }
        // get total debt of perm_customer finances
        $data['total_debtor_perm_customer_finances'] = $this->model->get_total_debtor_perm_customer_finances($perm_cust_id);
        if (!$data['total_debtor_perm_customer_finances']) {
            $this->session->set_flashdata('danger', ' ');
            redirect('reports');
        }

        // validation
        $this->form_validation->set_rules('form_code', ' ', 'required');

        // form submittion
        if ($this->form_validation->run() === false) {
            redirect('reports');
        } else {
            $this->load->view('layout/header', $data);
            $this->load->view('layout/nav');
            $this->load->view('dashboard/report_perm_customer_finance');
            $this->load->view('layout/footer');
        }
    }

    // daily_expense_report
    public function daily_expense_report()
    {
        $this->security();
        $data['settings'] = $this->model->get_settings();
        $data['categories'] = $this->model->get_tbl_rows('product_category');

        // validation
        $this->form_validation->set_rules('report_year', ' ' , 'required');
        // form submittion
        if ($this->form_validation->run() == false) redirect(base_url() . 'reports');

        // input variables
        $data['report_year'] = $this->input->post('report_year');
        $data['report_month'] = $this->input->post('report_month');
        $data['report_day'] = $this->input->post('report_day');

        // model method
        $data['expenses'] = $this->model->daily_expenses_report($data['report_year'], $data['report_month'], $data['report_day']);

        if ($data['expenses']) {
            $this->load->view('layout/header', $data);
            $this->load->view('layout/nav');
            $this->load->view('dashboard/expenses/daily_expenses_report');
            $this->load->view('layout/footer');
        } else {
            $this->session->set_flashdata('danger', ' ');
            redirect(base_url() . 'reports');
        }
    }
    // monthly_expense_single_report
    public function monthly_expense_single_report()
    {
        $this->security();
        $data['settings'] = $this->model->get_settings();
        $data['categories'] = $this->model->get_tbl_rows('product_category');

        // validation
        $this->form_validation->set_rules('report_year', ' ' , 'required');
        // form submittion
        if ($this->form_validation->run() == false) redirect(base_url() . 'reports');

        // input variables
        $data['report_year'] = $this->input->post('report_year');
        $data['report_month'] = $this->input->post('report_month');
        $data['expense_category_id'] = $this->input->post('expense_category_id');

        // model method
        $data['expenses'] = $this->model->monthly_expense_single_report($data['report_year'], $data['report_month'], $data['expense_category_id']);

        if ($data['expenses']) {
            $this->load->view('layout/header', $data);
            $this->load->view('layout/nav');
            $this->load->view('dashboard/expenses/monthly_expense_single_report');
            $this->load->view('layout/footer');
        } else {
            $this->session->set_flashdata('danger', ' ');
            redirect(base_url() . 'reports');
        }
    }
    // monthly_expense_all_report
    public function monthly_expense_all_report()
    {
        $this->security();
        $data['settings'] = $this->model->get_settings();
        $data['categories'] = $this->model->get_tbl_rows('product_category');

        // validation
        $this->form_validation->set_rules('report_year', ' ' , 'required');
        // form submittion
        if ($this->form_validation->run() == false) redirect(base_url() . 'reports');

        // input variables
        $data['report_year'] = $this->input->post('report_year');
        $data['report_month'] = $this->input->post('report_month');

        // model method
        $data['expenses'] = $this->model->monthly_expense_all_report($data['report_year'], $data['report_month']);

        if ($data['expenses']) {
            $this->load->view('layout/header', $data);
            $this->load->view('layout/nav');
            $this->load->view('dashboard/expenses/monthly_expense_all_report');
            $this->load->view('layout/footer');
        } else {
            $this->session->set_flashdata('danger', ' ');
            redirect(base_url() . 'reports');
        }
    }
    // monthly_expense_except_report
    public function monthly_expense_except_report()
    {
        $this->security();
        $data['settings'] = $this->model->get_settings();
        $data['categories'] = $this->model->get_tbl_rows('product_category');

        // validation
        $this->form_validation->set_rules('report_year', ' ' , 'required');
        // form submittion
        if ($this->form_validation->run() == false) redirect(base_url() . 'reports');

        // input variables
        $data['report_year'] = $this->input->post('report_year');
        $data['report_month'] = $this->input->post('report_month');
        $data['expense_category_id'] = $this->input->post('expense_category_id');

        $expense_category_id = '';
        if ($data['expense_category_id']) {
            for ($x=0; $x<count($data['expense_category_id']); $x++) {
                if ($x == (count($data['expense_category_id'])-1)) {
                    $expense_category_id .= "" . $data['expense_category_id'][$x] . "";
                } else {
                    $expense_category_id .= "" . $data['expense_category_id'][$x] . ", ";
                }
            }
        } else {
            $expense_category_id = '-1';
        }

        // model method
        $data['expenses'] = $this->model->monthly_expense_except_report($data['report_year'], $data['report_month'], $expense_category_id);
        $data['expense_categories'] = $this->model->get_expense_categories_in($expense_category_id);

        if ($data['expenses']) {
            $this->load->view('layout/header', $data);
            $this->load->view('layout/nav');
            $this->load->view('dashboard/expenses/monthly_expense_except_report');
            $this->load->view('layout/footer');
        } else {
            $this->session->set_flashdata('danger', ' ');
            redirect(base_url() . 'reports');
        }
    }
    // yearly_expense_single_report
    public function yearly_expense_single_report()
    {
        $this->security();
        $data['settings'] = $this->model->get_settings();
        $data['categories'] = $this->model->get_tbl_rows('product_category');

        // validation
        $this->form_validation->set_rules('report_year', ' ' , 'required');
        // form submittion
        if ($this->form_validation->run() == false) redirect(base_url() . 'reports');

        // input variables
        $data['report_year'] = $this->input->post('report_year');
        $data['expense_category_id'] = $this->input->post('expense_category_id');

        // model method
        $data['expenses'] = $this->model->yearly_expense_single_report($data['report_year'], $data['expense_category_id']);

        if ($data['expenses']) {
            $this->load->view('layout/header', $data);
            $this->load->view('layout/nav');
            $this->load->view('dashboard/expenses/yearly_expense_single_report');
            $this->load->view('layout/footer');
        } else {
            $this->session->set_flashdata('danger', ' ');
            redirect(base_url() . 'reports');
        }
    }
    // yearly_expense_all_report
    public function yearly_expense_all_report()
    {
        $this->security();
        $data['settings'] = $this->model->get_settings();
        $data['categories'] = $this->model->get_tbl_rows('product_category');

        // validation
        $this->form_validation->set_rules('report_year', ' ' , 'required');
        // form submittion
        if ($this->form_validation->run() == false) redirect(base_url() . 'reports');

        // input variables
        $data['report_year'] = $this->input->post('report_year');

        // model method
        $data['expenses'] = $this->model->yearly_expense_all_report($data['report_year']);

        if ($data['expenses']) {
            $this->load->view('layout/header', $data);
            $this->load->view('layout/nav');
            $this->load->view('dashboard/expenses/yearly_expense_all_report');
            $this->load->view('layout/footer');
        } else {
            $this->session->set_flashdata('danger', ' ');
            redirect(base_url() . 'reports');
        }
    }
    // yearly_expense_except_report
    public function yearly_expense_except_report()
    {
        $this->security();
        $data['settings'] = $this->model->get_settings();
        $data['categories'] = $this->model->get_tbl_rows('product_category');

        // validation
        $this->form_validation->set_rules('report_year', ' ' , 'required');
        // form submittion
        if ($this->form_validation->run() == false) redirect(base_url() . 'reports');

        // input variables
        $data['report_year'] = $this->input->post('report_year');
        $data['expense_category_id'] = $this->input->post('expense_category_id');

        $expense_category_id = '';
        if ($data['expense_category_id']) {
            for ($x=0; $x<count($data['expense_category_id']); $x++) {
                if ($x == (count($data['expense_category_id'])-1)) {
                    $expense_category_id .= "" . $data['expense_category_id'][$x] . "";
                } else {
                    $expense_category_id .= "" . $data['expense_category_id'][$x] . ", ";
                }
            }
        } else {
            $expense_category_id = '-1';
        }

        // model method
        $data['expenses'] = $this->model->yearly_expense_except_report($data['report_year'], $expense_category_id);
        $data['expense_categories'] = $this->model->get_expense_categories_in($expense_category_id);

        if ($data['expenses']) {
            $this->load->view('layout/header', $data);
            $this->load->view('layout/nav');
            $this->load->view('dashboard/expenses/yearly_expense_except_report');
            $this->load->view('layout/footer');
        } else {
            $this->session->set_flashdata('danger', ' ');
            redirect(base_url() . 'reports');
        }
    }
}
