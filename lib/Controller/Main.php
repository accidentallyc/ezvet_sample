<?php
/**
 * This file will load all the configurations
 * needed for the application to run 
 * 
 */

namespace Controller;

class Main {
	function handle () {
		global $config;
		retur $config->view->renderer->render("main.html",[]);
	}
}