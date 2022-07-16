<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller
{
	// execute
	public function execute() {
		/*
		$this->db->query("CREATE TABLE IF NOT EXISTS `expense_categories` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`cat_name` varchar(255) NOT NULL,
			`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`deleted` enum('0','1') NOT NULL DEFAULT '0',
			PRIMARY KEY (`id`)
		  ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
		$this->db->query("CREATE TABLE IF NOT EXISTS `expenses` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`title` varchar(255) NOT NULL,
			`amount` float NOT NULL,
			`qty` float NOT NULL DEFAULT '1',
			`transportation` int(11) NOT NULL DEFAULT '0',
			`total` float NOT NULL,
			`date_y` int(11) NOT NULL,
			`date_m` tinyint(4) NOT NULL,
			`date_d` tinyint(4) NOT NULL,
			`category_id` int(11) DEFAULT NULL,
			`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`deleted` enum('0','1') NOT NULL DEFAULT '0',
			PRIMARY KEY (`id`)
		  ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
		$this->db->query('ALTER TABLE `perm_customer_finances` ADD `bill_no` INT NULL AFTER perm_cust_id');
		$this->db->query('ALTER TABLE `people_finances` ADD `bill_no` INT NULL AFTER full_name');
		$this->db->query('ALTER TABLE `godam` ADD `good_buy` FLOAT NULL AFTER `good_category`');
		$this->db->query('ALTER TABLE `godam` DROP INDEX `good_name`');
		$this->db->query('ALTER TABLE `godam` ADD `good_category_qty` INT NULL AFTER `good_category`');
		*/
		/*
		$this->db->query('ALTER TABLE `expenses` DROP `transportation`');
		$this->db->query('ALTER TABLE `godam` DROP `good_category_qty`');
		*/
		$this->db->query('ALTER TABLE `sale` DROP `product_size`');
		$this->db->query('ALTER TABLE `customer` DROP `code_category`');
		$this->db->query('ALTER TABLE `sale` DROP `code_category`');
		$this->db->query('ALTER TABLE `customer` ADD `perm_cust_id` INT NULL AFTER `code_no`');
		$this->db->query('ALTER TABLE `sale` DROP `code_no`');
		$this->db->query('ALTER TABLE `sale` DROP `product_name`');
		$this->db->query('ALTER TABLE `sale` ADD `good_id` INT NULL AFTER `cust_id`');
		$this->db->query('ALTER TABLE `sale` CHANGE `product_price` `good_buy_price` INT(11) NULL');
		$this->db->query('ALTER TABLE `sale` ADD `good_sale_price` INT NULL AFTER `good_buy_price`');
		$this->db->query('ALTER TABLE `sale` CHANGE `product_qty` `good_qty` FLOAT NOT NULL');
		$this->db->query('ALTER TABLE `sale` DROP `product_category`');
		$this->db->query('ALTER TABLE `sale` CHANGE `product_total_af` `good_total_amount` INT(11) NOT NULL');
		$this->db->query('ALTER TABLE `sale` DROP `product_total_us`');
		$this->db->query('ALTER TABLE `sale` CHANGE `good_total_amount` `good_total_af` INT(11) NOT NULL');
		$this->db->query('ALTER TABLE `sale` ADD `good_total_us` INT NOT NULL AFTER `good_total_af`');
		$this->db->query('ALTER TABLE `payment` DROP `code_category`');

		echo '<a href="' . base_url() . '">YES</a>';
	}

	// Security
	public function security()
	{
		if ($this->session->userdata('logged_in') == true) {
			redirect(base_url() . 'dashboard');
		}
	}

	public function first_time_opened()
	{
		$cookie = [
			'name' => 'Ashraf',
			'value' => 'Gardizy',
			'expire' => 86400 * 90 // 3 months
		];
		$this->input->set_cookie($cookie);
		redirect(base_url());
	}
	
	public function MBSOFTFOCUS($deadline = 3)
	{
		$cookie = [
			'name' => 'Ashraf-Gardizy',
			'value' => 'AUWSS-Department',
			// 'expire' => 86400 * 60 * 3 => 6 months
			'expire' => 86400 * 60 * $deadline
		];
		$this->input->set_cookie($cookie);
		redirect(base_url());
	}

	public function index()
	{
		if (file_exists('./MB-SOFTFOCUS')) {
			// if first time cookie end, so chk the second cookie
			if ($this->input->cookie('Ashraf-Gardizy') != 'Gardizy') {
				// checking the app validation
				if ($this->input->cookie('MB-SOFTFOCUS') != 'AUWSS-Department') {
					show_404();
				}
			}
		} else {
			$auwss_file = fopen('MB-SOFTFOCUS', 'w');
			$this->first_time_opened();
		}

		// Chk for Remember Me COOKIE
		if ($this->input->cookie('remember-me') == 'Shopping') {
			// Create sessions
			$user_data = [
				'logged_in' => true
			];
			$this->session->set_userdata($user_data);
			// redirect
			redirect('dashboard');
		}
		
		$this->security();
		$data['logger_info'] = false;

		$data['settings'] = $this->page_model->settings();
		
		// validation
		$this->form_validation->set_rules('username', ' ', 'required');
		$this->form_validation->set_rules('password', ' ', 'required');

		// form submittion
		if ($this->form_validation->run() == false) {
			$this->load->view('pages/login', $data);
		} else {
			$username = $this->input->post('username');
			$password = md5($this->input->post('password'));
			$result = $this->page_model->login($username, $password);
			if ($result) {
				if ($this->input->post('remember-me')) {
					// Set cookie for 6 months
					$cookie = [
						'name' => 'remember-me',
						'value' => 'Shopping',
						// 'expire' => 86400 * 60 * 3 => 6 months
						'expire' => 86400 * 60 * 3
					];
					$this->input->set_cookie($cookie);
				}

				// Login succeed, create sessions
				$user_data = [
                    'all_info' => $result,
                    'logged_in' => true
                ];
                $this->session->set_userdata($user_data);
                // set msg and redirect
                $this->session->set_flashdata('success', 'You are now logged in!');
                redirect('dashboard');
			} else {
				// login failed, set msg and redirect
                $this->session->set_flashdata('danger', 'Invalid Credentials!');
                redirect(base_url());
			}
		}
	}
}
