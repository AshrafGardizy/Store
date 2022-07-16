<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Dashboard
$route['dashboard'] = 'dashboard';
$route['categories/(:any)/delete'] = 'dashboard/delete_category/$1';

// tests
$route['testing'] = 'dashboard/testing';

// Sales
$route['sales/(:num)/step-1'] = 'dashboard/sales_step_1/$1';
$route['sales/(:num)/step-1/cancel'] = 'dashboard/sales_step_1_cancel/$1';
$route['sales/(:num)/step-1/succeed'] = 'dashboard/sales_step_1_succeed/$1';
$route['sales/(:num)/delete/(:num)'] = 'dashboard/delete_sale/$1/$2';
$route['sales/(:num)/payment/(:num)'] = 'dashboard/sale_payment/$1/$2';
$route['sales/(:num)/payment/done'] = 'dashboard/sale_payment_done/$1';

$route['sales'] = 'dashboard/sales_list';
$route['sales/page-no-(:num)'] = 'dashboard/sales_list/$1';
$route['sales/(:num)/delete'] = 'dashboard/delete_sale_list/$1';
$route['sales/(:num)'] = 'dashboard/show_the_bill/$1';

// Godam
$route['goods'] = 'dashboard/goods_list';
$route['goods/page-no-(:num)'] = 'dashboard/goods_list/$1';
$route['goods/(:num)/delete'] = 'dashboard/delete_good/$1';

// Permanent Customers
$route['perm-customers'] = 'dashboard/perm_customers';
$route['perm-customers/page-no-(:num)'] = 'dashboard/perm_customers/$1';
$route['perm-customers/(:num)/delete'] = 'dashboard/perm_customer_delete/$1';

// People-Finances
$route['people-finances'] = 'dashboard/people_finances';
$route['people-finances/page-no-(:num)'] = 'dashboard/people_finances/$1';
$route['people-finances/(:num)/delete'] = 'dashboard/people_finance_delete/$1';

// Permanet Customers Finances
$route['perm-customers-finances'] = 'dashboard/perm_customers_finances';
$route['perm-customers-finances/page-no-(:num)'] = 'dashboard/perm_customers_finances/$1';
$route['perm-customers-finances/(:num)/delete'] = 'dashboard/perm_customers_finance_delete/$1';

// Expenses
$route['expenses'] = 'dashboard/expenses';
$route['expenses/page-no-(:num)'] = 'dashboard/expenses/$1';
$route['expenses/(:num)/delete'] = 'dashboard/expense_delete/$1';
$route['expense_categories/(:num)/delete'] = 'dashboard/expense_category_delete/$1';

// Reports
$route['reports'] = 'dashboard/reports';
$route['reports/perm-customer-finance'] = 'dashboard/report_perm_customer_finance';
// Expense Reports
$route['reports/daily-expense-report'] = 'dashboard/daily_expense_report';
$route['reports/monthly-expense-single'] = 'dashboard/monthly_expense_single_report';
$route['reports/monthly-expense-all'] = 'dashboard/monthly_expense_all_report';
$route['reports/monthly-expense-except'] = 'dashboard/monthly_expense_except_report';
$route['reports/yearly-expense-single'] = 'dashboard/yearly_expense_single_report';
$route['reports/yearly-expense-all'] = 'dashboard/yearly_expense_all_report';
$route['reports/yearly-expense-except'] = 'dashboard/yearly_expense_except_report';

// Logout
$route['logout'] = 'logout';

$route['default_controller'] = 'pages';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
