<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$autoload['packages'] = array();

$autoload['libraries'] = array(
    'session',
    'database',
    'form_validation',
    'pagination'
);

$autoload['drivers'] = array();

$autoload['helper'] = array('url', 'form', 'cookie');

$autoload['config'] = array();

$autoload['language'] = array();

$autoload['model'] = array(
    'page_model',
    'dashboard_model' => 'model'
);
