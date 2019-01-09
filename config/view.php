<?php
/**
 * Configuration for twig rendering. 
 * The html folder defaults to ./html
 */
const PARAMS = [
	'cache' => "../cache", 
	'auto_reload' => true, // disable cache
	'autoescape' => true
];

class ViewConfig {
	function __construct() {
		/**
		* @var \Twig_Loader_Filesystem
		*/
		$this->loader = new \Twig_Loader_Filesystem(__DIR__ . "/../html");
		/**
		* The renderer used in views. 
		* @var \Twig_Environment
		*/
		$this->renderer = new \Twig_Environment($this->loader, PARAMS);
	}
}

global $config;
$config->view = new ViewConfig();