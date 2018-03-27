<?php
use Edogawa\Core\Autoloader;
use Edogawa\Core\App\Language;
use Edogawa\Core\Validator\ValidateURL;
use Edogawa\Core\Route\Route;
use Edogawa\Core\Session\Session;

/**
 *Include of Autoload class
 */
require __DIR__ . '/vendor/autoload.php';
/**
 *Get the variables parse by the url
 */
$param = $_GET['p'] ?? 'Site';
$param = trim($param, '');
$param = rtrim($param, '/');

$params = explode('/', $param);
/**
 * Set Json file by language
 */
$lang = Language::setLang($params);

/**
 *Include of configuration class who contains all constants which will be available in all the app
 */
require "config.php";

Session::setToken();

$param = implode('/', $params);
define('URL', $param);

ValidateURL::validate($param);

Route::run();