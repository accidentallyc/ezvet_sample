<?php
/**
 * This file will load all the configurations
 * needed for the application to run  * 
 */

namespace config;

require_once __DIR__ . "/../vendor/autoload.php" ;
require_once __DIR__ . "/view.php";
require_once __DIR__ . "/session.php";


spl_autoload_register(function ($class_name) {
	include __DIR__ . "/../lib/$class_name.php";
});