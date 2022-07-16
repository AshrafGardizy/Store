<?php
class Dashboard_model extends CI_Model
{
    public function get_settings()
    {
        $query = $this->db->get('settings');
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->row();
    }

    // change_profile_pic
    public function change_profile_pic($new_name)
    {
        $data = [
            'photo' => $new_name,
            'updated_at' => date('Y-m-d h:i:s')
        ];
        $this->db->update('settings', $data);
    }

    // update_profile
    public function update_profile($firstname, $lastname)
    {
        $data = [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'updated_at' => date('Y-m-d h:i:s')
        ];
        $this->db->update('settings', $data);
    }

    // update_username
    public function update_username($new_username)
    {
        $data = [
            'username' => $new_username,
            'updated_at' => date('Y-m-d h:i:s')
        ];
        $this->db->update('settings', $data);
    }

    // update_password
    public function update_password($new_password)
    {
        $data = [
            'password' => $new_password,
            'updated_at' => date('Y-m-d h:i:s')
        ];
        $this->db->update('settings', $data);
    }

    // set_category
    public function set_category($category)
    {
        $data = [
            'category' => $category
        ];
        $this->db->insert('product_category', $data);
    }

    // delete_category
    public function delete_category($id)
    {
        $this->db->where('id', $id);
        $data = [
            'deleted' => '1',
            'updated_at' => date('Y-m-d h:i:s')
        ];
        $this->db->update('product_category', $data);
    }

    // update_settings
    public function update_settings($store_logo)
    {
        $data = [
            'store_name' => $this->input->post('store_name'),
            'store_slogan' => $this->input->post('store_slogan'),
            'store_logo' => $store_logo,
            'store_phone' => $this->input->post('store_phone'),
            'store_address' => $this->input->post('store_address'),
            'us_in_bill' => $this->input->post('us_in_bill'),
            'one_us' => $this->input->post('one_us'),
            'af_value' => $this->input->post('af_value'),
            'code_no' => $this->input->post('code_no'),
            'bill_note' => $this->input->post('bill_note'),
            'sundries_price' => $this->input->post('sundries_price'),
            'discount_amount' => $this->input->post('discount_amount'),
            'enable_godam' => $this->input->post('enable_godam'),
            'updated_at' => date('Y-m-d h:i:s')
        ];
        $this->db->update('settings', $data);
    }

    // add_new_sale
    public function add_new_sale($code_no, $sale_date)
    {
        // chk if the sale is to perm_customer or sundries
        if ($this->input->post('cust_name')) {
            $data = [
                'code_no' => $code_no,
                'perm_cust_id' => NULL,
                'cust_name' => $this->input->post('cust_name'),
                'cust_phone' => $this->input->post('cust_phone'),
                'sale_date' => $sale_date
            ];
        }
        if ($this->input->post('perm_cust_id')) {
            $data = [
                'code_no' => $code_no,
                'perm_cust_id' => $this->input->post('perm_cust_id'),
                'cust_name' => NULL,
                'cust_phone' => NULL,
                'sale_date' => $sale_date
            ];
        }
        $this->db->insert('customer', $data);
        return $this->db->insert_id();
    }

    // chk_sale_duplication
    public function chk_sale_duplication($code_no)
    {
        $this->db->where('deleted', '0');
        $this->db->where('code_no', $code_no);
        $query = $this->db->get('customer');
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->row();
    }

    // increase_code_no
    public function increase_code_no($code_no)
    {
        $increased = $code_no + 1;
        $this->db->where('code_no', $code_no);
        $data = [
            'code_no' => $increased,
            'updated_at' => date('Y-m-d h:i:s')
        ];
        $this->db->update('settings', $data);
    }

    // delete_customer
    public function delete_customer($cust_id)
    {
        $this->db->where('id', $cust_id);
        $this->db->delete('customer');
    }

    // cancel_increase_code_no
    public function cancel_increase_code_no($code_no)
    {
        $this->db->where('code_no', $code_no + 1);
        $data = [
            'code_no' => $code_no,
            'updated_at' => date('Y-m-d h:i:s')
        ];
        $this->db->update('settings', $data);
        return true;
    }

    // get_customer
    public function get_customer($cust_id)
    {
        $this->db->where('deleted', '0');
        $this->db->where('id', $cust_id);
        $query = $this->db->get('customer');
        if (empty($query->num_rows())) {
            return false;
        }
        // chk if it is the perm_cust join with perm_customers else return itself
        if (!$query->row()->perm_cust_id) {
            return $query->row();
        } else {
            // join
            $this->db->select('customer.id, customer.code_no, customer.perm_cust_id, customer.sale_date, perm_customers.full_name, perm_customers.phone, perm_customers.description');
            $this->db->where('perm_customers.deleted', '0');
            $this->db->where('customer.deleted', '0');
            $this->db->join('perm_customers', 'customer.perm_cust_id=perm_customers.id');
            $query = $this->db->get('customer');
            if (empty($query->num_rows())) {
                return false;
            }
            return $query->row();
        }
    }

    // set_sale_step_1
    public function set_sale_step_1($cust_id, $good_id, $good_qty, $good_buy_price, $good_price, $good_total_af, $good_total_us)
    {
        $data = [
            'cust_id' => $cust_id,
            'good_id' => $good_id,
            'good_qty' => $good_qty,
            'good_buy_price' => $good_buy_price,
            'good_sale_price' => $good_price,
            'good_total_af' => $good_total_af,
            'good_total_us' => $good_total_us
        ];
        $this->db->insert('sale', $data);
    }

    // get_goods
    public function get_goods($cust_id)
    {
        $this->db->select('sale.id, sale.cust_id, sale.good_id, sale.good_buy_price, sale.good_sale_price, sale.good_qty, sale.good_total_af, sale.good_total_us, godam.good_name, godam.good_category');
        $this->db->where('sale.deleted', '0');
        $this->db->where('godam.deleted', '0');
        $this->db->where('sale.cust_id', $cust_id);
        $this->db->join('godam', 'sale.good_id=godam.id');
        $query = $this->db->get('sale');
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->result();
    }

    // update_sale
    public function update_sale($sale_id, $good_total_af, $good_total_us)
    {
        $this->db->where('deleted', '0');
        $this->db->where('id', $sale_id);
        $data = [
            'good_id' => $this->input->post('good_id'),
            'good_qty' => $this->input->post('good_qty'),
            'good_sale_price' => $this->input->post('good_price'),
            'good_total_af' => $good_total_af,
            'good_total_us' => $good_total_us,
            'updated_at' => date('Y-m-d h:i:s')
        ];
        $this->db->update('sale', $data);
    }

    // delete_sale
    public function delete_sale($sale_id)
    {
        $this->db->where('id', $sale_id);
        $this->db->delete('sale');
    }

    // set_payment
    public function set_payment($cust_id, /*$code_category, */$code_no, $af_value)
    {
        $sundries_price = (int) ($this->input->post('sundries_price')) ? ($this->input->post('sundries_price')) : ('0');
        $discount_amount = (int) ($this->input->post('discount_amount')) ? ($this->input->post('discount_amount')) : ('0');
        $product_total = (int) $this->input->post('good_total');
        $product_total_af = ($sundries_price + $product_total) - ($discount_amount);
        $product_total_us = ($product_total_af) / ($af_value);
        $paid_amount_af = (int) $this->input->post('paid_amount');
        $paid_amount_us = ($paid_amount_af) / ($af_value);
        $remain_amount_af = $product_total_af - $paid_amount_af;
        $remain_amount_us = ($remain_amount_af) / ($af_value);
        $data = [
            'cust_id' => $cust_id,
            'code_no' => $code_no,
            'sundries_price' => $sundries_price,
            'sundries_reason' => $this->input->post('sundries_reason'),
            'discount_amount' => $discount_amount,
            'product_total_af' => $product_total_af,
            'product_total_us' => $product_total_us,
            'paid_amount_af' => $paid_amount_af,
            'paid_amount_us' => $paid_amount_us,
            'remain_amount_af' => $remain_amount_af,
            'remain_amount_us' => $remain_amount_us
        ];
        $this->db->insert('payment', $data);
        return $this->db->insert_id();
    }

    // get_payment
    public function get_payment($payment_id)
    {
        $this->db->where('id', $payment_id);
        $this->db->where('deleted', '0');
        $query = $this->db->get('payment');
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->row();
    }

    // set_payment_done
    public function set_payment_done($payment_id)
    {
        $this->db->where('id', $payment_id);
        $this->db->where('deleted', '0');
        $data = [
            'status' => 'done',
            'updated_at' => date('Y-m-d h:i:s')
        ];
        $this->db->update('payment', $data);
    }

    // get_sale_lists
    public function get_sale_lists($limit = false, $offset = false)
    {
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->select('customer.id, customer.code_no, customer.cust_name, customer.cust_phone, customer.sale_date, payment.paid_amount_af, payment.remain_amount_af, perm_customers.full_name, perm_customers.phone');
        $this->db->where('payment.deleted', '0');
        $this->db->where('customer.deleted', '0');
        $this->db->where('payment.status', 'done');
        $this->db->order_by('customer.id', 'DESC');
        $this->db->join('payment', 'customer.id=payment.cust_id');
        $this->db->join('perm_customers', 'customer.perm_cust_id=perm_customers.id', 'left');
        $query = $this->db->get('customer');
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->result();
    }

    // get_total_sale_lists
    public function get_total_sale_lists()
    {
        $this->db->select('customer.id, customer.code_no, customer.cust_name, customer.cust_phone, customer.sale_date, payment.paid_amount_af, payment.remain_amount_af, perm_customers.full_name, perm_customers.phone');
        $this->db->where('payment.deleted', '0');
        $this->db->where('customer.deleted', '0');
        $this->db->where('payment.status', 'done');
        $this->db->order_by('customer.id', 'DESC');
        $this->db->join('payment', 'customer.id=payment.cust_id');
        $this->db->join('perm_customers', 'customer.perm_cust_id=perm_customers.id', 'left');
        $query = $this->db->get('customer');
        if (empty($query->num_rows())) {
            return false;
        }
        return count($query->result());
    }

    // delete_sale_list
    public function delete_sale_list($cust_id)
    {
        $this->db->trans_start();
            $data = [
                'deleted' => '1',
                'updated_at' => date('Y-m-d h:i:s')
            ];
            // update customer
            $this->db->where('id', $cust_id);
            $this->db->update('customer', $data);
            // update sale
            $this->db->where('cust_id', $cust_id);
            $this->db->update('sale', $data);
            // update payment
            $this->db->where('cust_id', $cust_id);
            $this->db->update('payment', $data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === false) {
            return false;
        }
        return true;
    }

    // update_paid_amount
    public function update_paid_amount($cust_id, $paid_amount_af_final, $paid_amount_us_final, $remain_amount_af_final, $remain_amount_us_final)
    {
        $this->db->where('deleted', '0');
        $this->db->where('cust_id', $cust_id);
        $this->db->where('status', 'done');
        $data = [
            'paid_amount_af' => $paid_amount_af_final,
            'paid_amount_us' => $paid_amount_us_final,
            'remain_amount_af' => $remain_amount_af_final,
            'remain_amount_us' => $remain_amount_us_final,
            'updated_at' => date('Y-m-d h:i:s')
        ];
        $this->db->update('payment', $data);
    }

    // get_search
    public function get_search($table)
    {
        $q = $this->input->post('q');
        $q_category = $this->input->post('q_category');
        $q_sort = $this->input->post('q_sort');
        $this->db->select('customer.id, customer.code_no, customer.cust_name, customer.cust_phone, customer.sale_date, payment.paid_amount_af, payment.remain_amount_af, perm_customers.full_name, perm_customers.phone');
        $this->db->where('payment.deleted', '0');
        $this->db->where('customer.deleted', '0');
        $this->db->where('payment.status', 'done');
        $this->db->like($table . '.' . $q_category, $q);
        $this->db->order_by('customer.id', $q_sort);
        $this->db->join('payment', 'customer.id=payment.cust_id');
        $this->db->join('perm_customers', 'customer.perm_cust_id=perm_customers.id', 'left');
        $query = $this->db->get('customer');
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->result();
    }

    //                      .::GODAM::.
    // chk_good_duplication
    public function chk_good_duplication($good_name, $good_id = false)
    {
        if ($good_id) $this->db->where('id !=', $good_id);
        $this->db->where('deleted', '0');
        $this->db->where('good_name', $good_name);
        $query = $this->db->get('godam');
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->row();
    }

    // add_new_good
    public function add_new_good($good_name, $good_total_no, $good_category, $good_buy)
    {
        $data = [
            'good_name' => $good_name,
            'good_total_no' => $good_total_no,
            'good_category' => $good_category,
            'good_buy' => $good_buy
        ];
        $this->db->insert('godam', $data);
    }

    // get_godam_good
    public function get_godam_good($good_id)
    {
        $this->db->where('deleted', '0');
        $this->db->where('id', $good_id);
        $query = $this->db->get('godam');
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->row();
    }

    // get_total_good_lists
    public function get_total_good_lists()
    {
        $this->db->where('deleted', '0');
        $query = $this->db->get('godam');
        if (empty($query->num_rows())) {
            return false;
        }
        return count($query->result());
    }

    // get_good_lists
    public function get_good_lists($limit = false, $offset = false)
    {
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->where('deleted', '0');
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('godam');
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->result();
    }

    // update_good
    public function update_good($good_id)
    {
        $this->db->where('deleted', '0');
        $this->db->where('id', $good_id);
        $data = [
            'good_name' => $this->input->post('good_name'),
            'good_total_no' => $this->input->post('good_total_no'),
            'good_category' => $this->input->post('good_category'),
            'good_buy' => $this->input->post('good_buy'),
            'updated_at' => date('Y-m-d h:i:s')
        ];
        $this->db->update('godam', $data);
    }

    // delete_goods
    public function delete_good($good_id)
    {
        $this->db->where('deleted', '0');
        $this->db->where('id', $good_id);
        $data = [
            'deleted' => '1'
        ];
        $this->db->update('godam', $data);
    }

    // search_godam
    public function search_godam()
    {
        $q = $this->input->post('q');
        $q_category = $this->input->post('q_category');
        $q_sort = $this->input->post('q_sort');
        $this->db->where('deleted', '0');
        $this->db->like($q_category, $q);
        $this->db->order_by('id', $q_sort);
        $query = $this->db->get('godam');
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->result();
    }

    // decrease_godam_good
    public function decrease_godam_good($good_id, $good_qty)
    {
        $good_qty_final = (float) $good_qty;
        $this->db->query("UPDATE godam SET good_total_no=good_total_no - $good_qty_final WHERE deleted='0' AND id='$good_id'");
    }


    //                      .::People Finances::.
    // get_total_people_finances
    public function get_total_people_finances()
    {
        $this->db->where('deleted', '0');
        $query = $this->db->get('people_finances');
        if (empty($query->num_rows())) {
            return false;
        }
        return count($query->result());
    }

    // get_people_finances
    public function get_people_finances($limit = false, $offset = false)
    {
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->where('deleted', '0');
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('people_finances');
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->result();
    }

    // add_people_finance
    public function add_people_finance()
    {
        $bill_no = ($this->input->post('bill_no')) ? ($this->input->post('bill_no')) : (NULL);
        $data = [
            'full_name' => $this->input->post('full_name'),
            'bill_no' => $bill_no,
            'phone' => $this->input->post('phone'),
            'amount' => $this->input->post('amount'),
            'category' => $this->input->post('category'),
            'date_y' => $this->input->post('date_y'),
            'date_m' => $this->input->post('date_m'),
            'date_d' => $this->input->post('date_d'),
            'description' => $this->input->post('description')
        ];
        $this->db->insert('people_finances', $data);
        return $this->db->insert_id();
    }

    // search_people_finances
    public function search_people_finances()
    {
        $q = $this->input->post('q');
        $q_category = $this->input->post('q_category');
        $q_sort = $this->input->post('q_sort');
        $this->db->where('deleted', '0');
        if ($q_category == 'date') {
            $q = trim($q);
            $dates = explode('/', $q);
            if (count($dates) == 1) {
                $this->db->where('date_y', $dates[0]);
            } elseif (count($dates) == 2) {
                $this->db->where('date_y', $dates[0]);
                $this->db->where('date_m', $dates[1]);
            } elseif (count($dates) == 3) {
                $this->db->where('date_y', $dates[0]);
                $this->db->where('date_m', $dates[1]);
                $this->db->where('date_d', $dates[2]);
            }
        } elseif ($q_category == 'bill_no') {
            $this->db->where($q_category, $q);
        } else {
            $this->db->like($q_category, $q);
        }
        $this->db->order_by('id', $q_sort);
        $query = $this->db->get('people_finances');
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->result();
    }

    // update_people_finance
    public function update_people_finance($id)
    {
        $bill_no = ($this->input->post('bill_no')) ? ($this->input->post('bill_no')) : (NULL);
        $this->db->where('id', $id);
        $this->db->where('deleted', '0');
        $data = [
            'full_name' => $this->input->post('full_name'),
            'bill_no' => $bill_no,
            'phone' => $this->input->post('phone'),
            'amount' => $this->input->post('amount'),
            'category' => $this->input->post('category'),
            'date_y' => $this->input->post('date_y'),
            'date_m' => $this->input->post('date_m'),
            'date_d' => $this->input->post('date_d'),
            'description' => $this->input->post('description'),
            'updated_at' => date('Y-m-d h:i:s')
        ];
        $this->db->update('people_finances', $data);
    }

    // people_finance_delete
    public function people_finance_delete($id)
    {
        $this->db->where('deleted', '0');
        $this->db->where('id', $id);
        $data = [
            'deleted' => '1',
            'updated_at' => date('Y-m-d h:i:s')
        ];
        $this->db->update('people_finances', $data);
    }

    // get_total_creditors_amount
    public function get_total_creditors_amount()
    {
        $query = $this->db->query("SELECT SUM(amount) total_amount FROM people_finances WHERE deleted='0' AND category='creditor'");
        return $query->row();
    }
    // get_total_debtors_amount
    public function get_total_debtors_amount()
    {
        $query = $this->db->query("SELECT SUM(amount) total_amount FROM people_finances WHERE deleted='0' AND category='debtor'");
        return $query->row();
    }


    //                      .::Permanent Customers::.
    // get_total_perm_customers
    public function get_total_perm_customers()
    {
        $this->db->where('deleted', '0');
        $query = $this->db->get('perm_customers');
        if (empty($query->num_rows())) {
            return false;
        }
        return count($query->result());
    }

    // get_perm_customers
    public function get_perm_customers($limit = false, $offset = false)
    {
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->where('deleted', '0');
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('perm_customers');
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->result();
    }

    // get_perm_customer
    public function get_perm_customer($id)
    {
        $this->db->where('deleted', '0');
        $this->db->where('id', $id);
        $query = $this->db->get('perm_customers');
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->row();
    }

    // add_perm_customer
    public function add_perm_customer()
    {
        $data = [
            'full_name' => $this->input->post('full_name'),
            'phone' => $this->input->post('phone'),
            'description' => $this->input->post('description')
        ];
        $this->db->insert('perm_customers', $data);
        return $this->db->insert_id();
    }

    // search_perm_customers
    public function search_perm_customers()
    {
        $q = $this->input->post('q');
        $q_category = $this->input->post('q_category');
        $q_sort = $this->input->post('q_sort');
        $this->db->where('deleted', '0');
        $this->db->like($q_category, $q);
        $this->db->order_by('id', $q_sort);
        $query = $this->db->get('perm_customers');
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->result();
    }

    // update_perm_customer
    public function update_perm_customer($id)
    {
        $this->db->where('id', $id);
        $this->db->where('deleted', '0');
        $data = [
            'full_name' => $this->input->post('full_name'),
            'phone' => $this->input->post('phone'),
            'description' => $this->input->post('description'),
            'updated_at' => date('Y-m-d h:i:s')
        ];
        $this->db->update('perm_customers', $data);
    }

    // perm_customer_delete
    public function perm_customer_delete($id)
    {
        $this->db->where('deleted', '0');
        $this->db->where('id', $id);
        $data = [
            'deleted' => '1',
            'updated_at' => date('Y-m-d h:i:s')
        ];
        $this->db->update('perm_customers', $data);
    }

    // chk_perm_customer_duplication
    public function chk_perm_customer_duplication($full_name)
    {
        $this->db->where('deleted', '0');
        $this->db->where('full_name', $full_name);
        $query = $this->db->get('perm_customers');
        if (empty($query->num_rows())) {
            return false;
        }
        return true;
    }

    //                      .::Permanent Customers Finances::.
    
    // get_total_perm_customers_finances
    public function get_total_perm_customers_finances()
    {
        $this->db->where('deleted', '0');
        $query = $this->db->get('perm_customer_finances');
        if (empty($query->num_rows())) {
            return false;
        }
        return count($query->result());
    }

    // get_perm_customers_finances
    public function get_perm_customers_finances($limit = false, $offset = false)
    {
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->select("perm_customer_finances.id AS id, full_name, phone, amount, perm_customer_finances.description AS description, bill_no, category, date_y, date_m, date_d");
        $this->db->where('perm_customer_finances.deleted', '0');
        $this->db->where('perm_customers.deleted', '0');
        $this->db->order_by('perm_customer_finances.id', 'DESC');
        $this->db->join('perm_customers', 'perm_customers.id=perm_customer_finances.perm_cust_id');
        $query = $this->db->get('perm_customer_finances');
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->result();
    }

    // add_perm_customer_finance
    public function add_perm_customer_finance()
    {
        $bill_no = ($this->input->post('bill_no')) ? ($this->input->post('bill_no')) : (NULL);
        $data = [
            'perm_cust_id' => $this->input->post('perm_cust_id'),
            'bill_no' => $bill_no,
            'amount' => $this->input->post('amount'),
            'description' => $this->input->post('description'),
            'category' => $this->input->post('category'),
            'date_y' => $this->input->post('date_y'),
            'date_m' => $this->input->post('date_m'),
            'date_d' => $this->input->post('date_d')
        ];
        $this->db->insert('perm_customer_finances', $data);
        return $this->db->insert_id();
    }

    // search_perm_customers_finances
    public function search_perm_customers_finances()
    {
        $q = $this->input->post('q');
        $q_category = $this->input->post('q_category');
        $q_sort = $this->input->post('q_sort');
        $this->db->select("perm_customer_finances.id AS id, full_name, phone, amount, perm_customer_finances.description AS description, bill_no, category, date_y, date_m, date_d");
        $this->db->where('perm_customer_finances.deleted', '0');
        if ($q_category == 'full_name' || $q_category == 'phone') {
            $this->db->like('perm_customers.' . $q_category, $q);
        } elseif ($q_category == 'date') {
            $q = trim($q);
            $dates = explode('/', $q);
            if (count($dates) == 1) {
                $this->db->where('date_y', $dates[0]);
            } elseif (count($dates) == 2) {
                $this->db->where('date_y', $dates[0]);
                $this->db->where('date_m', $dates[1]);
            } elseif (count($dates) == 3) {
                $this->db->where('date_y', $dates[0]);
                $this->db->where('date_m', $dates[1]);
                $this->db->where('date_d', $dates[2]);
            }
        } elseif ($q_category == 'bill_no') {
            $this->db->where($q_category, $q);
        } else {
            $this->db->like('perm_customer_finances.' . $q_category, $q);
        }
        $this->db->order_by('perm_customer_finances.id', $q_sort);
        $this->db->join('perm_customers', 'perm_customers.id=perm_customer_finances.perm_cust_id');
        $query = $this->db->get('perm_customer_finances');
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->result();
    }

    // update_perm_customer_finance
    public function update_perm_customer_finance($id)
    {
        $bill_no = ($this->input->post('bill_no')) ? ($this->input->post('bill_no')) : (NULL);
        $this->db->where('id', $id);
        $this->db->where('deleted', '0');
        $data = [
            'bill_no' => $bill_no,
            'amount' => $this->input->post('amount'),
            'description' => $this->input->post('description'),
            'category' => $this->input->post('category'),
            'date_y' => $this->input->post('date_y'),
            'date_m' => $this->input->post('date_m'),
            'date_d' => $this->input->post('date_d'),
            'updated_at' => date('Y-m-d h:i:s')
        ];
        $this->db->update('perm_customer_finances', $data);
    }

    
    // get_perm_cust_total_creditors_amount
    public function get_perm_cust_total_creditors_amount()
    {
        $query = $this->db->query("SELECT SUM(amount) total_amount FROM perm_customer_finances WHERE deleted='0' AND category='creditor'");
        return $query->row();
    }
    // get_perm_cust_total_debtors_amount
    public function get_perm_cust_total_debtors_amount()
    {
        $query = $this->db->query("SELECT SUM(amount) total_amount FROM perm_customer_finances WHERE deleted='0' AND category='debtor'");
        return $query->row();
    }

    // perm_customers_finance_delete
    public function perm_customers_finance_delete($id)
    {
        $this->db->where('deleted', '0');
        $this->db->where('id', $id);
        $data = [
            'deleted' => '1',
            'updated_at' => date('Y-m-d h:i:s')
        ];
        $this->db->update('perm_customer_finances', $data);
    }

    //                 .:: Report ::.
    // get_perm_customer_finances
    public function get_perm_customer_finances($id)
    {
        $this->db->select("perm_customer_finances.id AS id, full_name, phone, amount, perm_customer_finances.description AS description, bill_no, category, date_y, date_m, date_d");
        $this->db->where('perm_customer_finances.deleted', '0');
        $this->db->where('perm_customers.deleted', '0');
        $this->db->where('perm_cust_id', $id);
        $this->db->order_by('perm_customer_finances.id', 'DESC');
        $this->db->join('perm_customers', 'perm_customers.id=perm_customer_finances.perm_cust_id');
        $query = $this->db->get('perm_customer_finances');
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->result();
    }
    // get_total_creditor_perm_customer_finances
    public function get_total_creditor_perm_customer_finances($id)
    {
        $query = $this->db->query("SELECT SUM(amount) total_amount FROM perm_customer_finances WHERE deleted='0' AND category='creditor' AND perm_cust_id='$id'");
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->row();
    }
    // get_total_debtor_perm_customer_finances
    public function get_total_debtor_perm_customer_finances($id)
    {
        $query = $this->db->query("SELECT SUM(amount) total_amount FROM perm_customer_finances WHERE deleted='0' AND category='debtor' AND perm_cust_id='$id'");
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->row();
    }


    //                        .::Expenses::.
    // get_total_expenses
    public function get_total_expenses()
    {
        $this->db->where('deleted', '0');
        $query = $this->db->get('expenses');
        if (empty($query->num_rows())) {
            return false;
        }
        return count($query->result());
    }
    // get_expenses
    public function get_expenses($limit = false, $offset = false)
    {
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->select('expenses.id, expense_categories.id AS cat_id, expense_categories.cat_name, title, amount, qty, total, date_y, date_m, date_d, expenses.category_id');
        $this->db->where('expenses.deleted', '0');
        $this->db->where('expense_categories.deleted', '0');
        $this->db->order_by('expenses.id', 'DESC');
        $this->db->join('expense_categories', 'expenses.category_id=expense_categories.id');
        $query = $this->db->get('expenses');
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->result();
    }
    // expense_delete
    public function expense_delete($id)
    {
        $this->db->where('deleted', '0');
        $this->db->where('id', $id);
        $data = [
            'deleted' => '1',
            'updated_at' => date('Y-m-d h:i:s')
        ];
        $this->db->update('expenses', $data);
    }

    // get_expenses_by_category
    public function get_expenses_by_category($cat_id)
    {
        $this->db->where('deleted', '0');
        $this->db->where('category_id', $cat_id);
        $query = $this->db->get('expenses');
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->result();
    }

    // get_finances_by_perm_customer
    public function get_finances_by_perm_customer($id)
    {
        $this->db->where('deleted', '0');
        $this->db->where('perm_cust_id', $id);
        $query = $this->db->get('perm_customer_finances');
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->result();
    }

    // expense_category_delete
    public function expense_category_delete($id)
    {
        $this->db->where('deleted', '0');
        $this->db->where('id', $id);
        $data = [
            'deleted' => '1',
            'updated_at' => date('Y-m-d h:i:s')
        ];
        $this->db->update('expense_categories', $data);
    }

    // get_tbl_rows
    public function get_tbl_rows($tbl_name, $sort = 'ASC')
    {
        $this->db->where('deleted', '0');
        $this->db->order_by($tbl_name . '.id', $sort);
        $query = $this->db->get($tbl_name);
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->result();
    }

    // chk_expense_category_duplication
    public function chk_expense_category_duplication($cat_name)
    {
        $this->db->where('deleted', '0');
        $this->db->where('cat_name', $cat_name);
        $query = $this->db->get('expense_categories');
        if (empty($query->num_rows())) {
            return false;
        }
        return true;
    }

    // add_expense_category
    public function add_expense_category()
    {
        $data = [
            'cat_name' => $this->input->post('expense_category')
        ];
        $this->db->insert('expense_categories', $data);
        return $this->db->insert_id();
    }

    // add_expense
    public function add_expense()
    {
        $amount = (float) $this->input->post('amount');
        $qty = (float) $this->input->post('qty');
        $total_expense = ($amount) * ($qty);
        $data = [
            'title' => $this->input->post('title'),
            'amount' => $amount,
            'qty' => $qty,
            'total' => $total_expense,
            'date_y' => $this->input->post('date_y'),
            'date_m' => $this->input->post('date_m'),
            'date_d' => $this->input->post('date_d'),
            'category_id' => $this->input->post('expense_category')
        ];
        $this->db->insert('expenses', $data);
        return $this->db->insert_id();
    }

    // update_expense
    public function update_expense($id)
    {
        $amount = (float) $this->input->post('amount');
        $qty = (float) $this->input->post('qty');
        $total_expense = ($amount) * ($qty);

        $this->db->where('id', $id);
        $this->db->where('deleted', '0');
        $data = [
            'title' => $this->input->post('title'),
            'amount' => $amount,
            'qty' => $qty,
            'total' => $total_expense,
            'date_y' => $this->input->post('date_y'),
            'date_m' => $this->input->post('date_m'),
            'date_d' => $this->input->post('date_d'),
            'category_id' => $this->input->post('expense_category')
        ];
        $this->db->update('expenses', $data);
    }

    // search_expenses
    public function search_expenses()
    {
        $q = $this->input->post('q');
        $q_category = $this->input->post('q_category');
        $q_sort = $this->input->post('q_sort');
        if ($q_category == 'date') {
            $q = trim($q);
            $dates = explode('/', $q);
            if (count($dates) == 1) {
                $this->db->where('date_y', $dates[0]);
            } elseif (count($dates) == 2) {
                $this->db->where('date_y', $dates[0]);
                $this->db->where('date_m', $dates[1]);
            } elseif (count($dates) == 3) {
                $this->db->where('date_y', $dates[0]);
                $this->db->where('date_m', $dates[1]);
                $this->db->where('date_d', $dates[2]);
            }
        } else {
            $this->db->like('expenses.' . $q_category, $q);
        }
        $this->db->order_by('expenses.id', $q_sort);
        $this->db->select('expenses.id, expense_categories.id AS cat_id, expense_categories.cat_name, title, amount, qty, total, date_y, date_m, date_d, expenses.category_id');
        $this->db->where('expenses.deleted', '0');
        $this->db->where('expense_categories.deleted', '0');
        $this->db->join('expense_categories', 'expenses.category_id=expense_categories.id');
        $query = $this->db->get('expenses');
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->result();
    }

    //              .::Reports::.
    // daily_expenses_report
    public function daily_expenses_report($report_year, $report_month, $report_day)
    {
        $this->db->select('expenses.id, expense_categories.id AS cat_id, expense_categories.cat_name, title, amount, qty, total, date_y, date_m, date_d, expenses.category_id');
        $this->db->where('expenses.deleted', '0');
        $this->db->where('expense_categories.deleted', '0');
        $this->db->where('date_y', $report_year);
        $this->db->where('date_m', $report_month);
        $this->db->where('date_d', $report_day);
        $this->db->join('expense_categories', 'expenses.category_id=expense_categories.id');
        $query = $this->db->get('expenses');
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->result();
    }
    // monthly_expense_single_report
    public function monthly_expense_single_report($year, $month, $category)
    {
        $this->db->select('expenses.id, expense_categories.id AS cat_id, expense_categories.cat_name, title, amount, qty, total, date_y, date_m, date_d, expenses.category_id');
        $this->db->where('expenses.deleted', '0');
        $this->db->where('expense_categories.deleted', '0');
        $this->db->where('date_y', $year);
        $this->db->where('date_m', $month);
        $this->db->where('expense_categories.id', $category);
        $this->db->join('expense_categories', 'expenses.category_id=expense_categories.id');
        $query = $this->db->get('expenses');
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->result();
    }
    // monthly_expense_all_report
    public function monthly_expense_all_report($year, $month)
    {
        $this->db->select('expenses.id, expense_categories.id AS cat_id, expense_categories.cat_name, title, amount, qty, total, date_y, date_m, date_d, expenses.category_id');
        $this->db->where('expenses.deleted', '0');
        $this->db->where('expense_categories.deleted', '0');
        $this->db->where('date_y', $year);
        $this->db->where('date_m', $month);
        $this->db->join('expense_categories', 'expenses.category_id=expense_categories.id');
        $query = $this->db->get('expenses');
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->result();
    }
    // monthly_expense_except_report
    public function monthly_expense_except_report($year, $month, $category_id)
    {
        $this->db->select('expenses.id, expense_categories.id AS cat_id, expense_categories.cat_name, title, amount, qty, total, date_y, date_m, date_d, expenses.category_id');
        $this->db->where('expenses.deleted', '0');
        $this->db->where('expense_categories.deleted', '0');
        $this->db->where('date_y', $year);
        $this->db->where('date_m', $month);
        $this->db->where_not_in('expense_categories.id', $category_id);
        $this->db->join('expense_categories', 'expenses.category_id=expense_categories.id');
        $query = $this->db->get('expenses');
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->result();
    }
    // get_expense_categories_in
    public function get_expense_categories_in($expense_category_id)
    {
        $this->db->where('deleted', '0');
        $this->db->where_in('id', $expense_category_id);
        $query = $this->db->get('expense_categories');
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->result();
    }
    // yearly_expense_single_report
    public function yearly_expense_single_report($year, $category)
    {
        $this->db->select('expenses.id, expense_categories.id AS cat_id, expense_categories.cat_name, title, amount, qty, total, date_y, date_m, date_d, expenses.category_id');
        $this->db->where('expenses.deleted', '0');
        $this->db->where('expense_categories.deleted', '0');
        $this->db->where('date_y', $year);
        $this->db->where('expense_categories.id', $category);
        $this->db->join('expense_categories', 'expenses.category_id=expense_categories.id');
        $query = $this->db->get('expenses');
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->result();
    }
    // yearly_expense_all_report
    public function yearly_expense_all_report($year)
    {
        $this->db->select('expenses.id, expense_categories.id AS cat_id, expense_categories.cat_name, title, amount, qty, total, date_y, date_m, date_d, expenses.category_id');
        $this->db->where('expenses.deleted', '0');
        $this->db->where('expense_categories.deleted', '0');
        $this->db->where('date_y', $year);
        $this->db->join('expense_categories', 'expenses.category_id=expense_categories.id');
        $query = $this->db->get('expenses');
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->result();
    }
    // yearly_expense_except_report
    public function yearly_expense_except_report($year, $category_id)
    {
        $this->db->select('expenses.id, expense_categories.id AS cat_id, expense_categories.cat_name, title, amount, qty, total, date_y, date_m, date_d, expenses.category_id');
        $this->db->where('expenses.deleted', '0');
        $this->db->where('expense_categories.deleted', '0');
        $this->db->where('date_y', $year);
        $this->db->where_not_in('expense_categories.id', $category_id);
        $this->db->join('expense_categories', 'expenses.category_id=expense_categories.id');
        $query = $this->db->get('expenses');
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->result();
    }


    //                  .::Dates::.
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
}
