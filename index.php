<?php

// ######## please do not alter the following code ########
$products = array(
	array("name" => "Sledgehammer", "price" => 125.75),
	array("name" => "Axe", "price" => 190.50),
	array("name" => "Bandsaw", "price" => 562.13),
	array("name" => "Chisel", "price" => 12.9),
	array("name" => "Hacksaw", "price" => 18.45)
);
// ##################################################

$config =  new StdClass();
require_once './config/bootstrap.php';

$router = new \Klein\Klein();

$router->respond('GET', '/', function () {
	global $config;
    return $config->view->renderer->render("main.html",[]);
});

$router->dispatch();