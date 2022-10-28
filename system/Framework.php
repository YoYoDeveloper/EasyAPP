<?php

/**
* @package      EasyAPP Framework
* @version      v1.2.8
* @author       YoYo
* @copyright    Copyright (c) 2022, script-php.ro
* @link         https://script-php.ro
*/

require PATH . 'System/Config.php'; // framework config

$config = new System\Config(PATH);

if($config->session) {
    session_start();
}

if(defined('DIR_APP')) {
    $config->dir_app = DIR_APP;
    $config->dir_controller = $config->dir_app . 'controller/';
    $config->dir_model = $config->dir_app . 'model/';
    $config->dir_language = $config->dir_app . 'language/';
    $config->dir_view = $config->dir_app . 'view/';
}

if($config->debug) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

include rtrim($config->dir_system, '\\/ ') . DIRECTORY_SEPARATOR . 'Autoloader.php';

$loader = new System\Autoloader();

$loader->load([
    'namespace' => 'System\Framework',
    'directory' => $config->dir_framework,
    'recursive' => true
]);

$loader->load([
    'namespace' => 'System\Library',
    'directory' => $config->dir_library,
    'recursive' => true
]);

include $config->dir_system . 'Controller.php';
include $config->dir_system . 'Model.php';

require $config->dir_app . 'config.php'; // app config
require $config->dir_app . 'helper.php'; // custom functions

$registry = new System\Framework\Registry();

$registry->set('config', $config);
$registry->set('db', new System\Framework\DB($config->db_hostname,$config->db_database,$config->db_username,$config->db_password,$config->db_port)); // database connection
$registry->set('hooks', new System\Framework\Hook($registry));
$registry->set('util', new System\Framework\Util($registry));
$registry->set('mail', new System\Framework\Mail($registry));
$registry->set('load', new System\Framework\Load($registry));
$registry->set('url', new System\Framework\Url($registry));

$request = new System\Framework\Request($registry);
$registry->set('request', $request);

$language = new System\Framework\Language($registry);
// $language->directory('ro-ro');
$registry->set('language', $language);

$router = new System\Framework\SimpleRouter($registry);
$router->loadPage();

$request->end_session();