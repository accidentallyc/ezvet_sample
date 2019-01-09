<?php
// global config cause - in a rush
$config =  new StdClass();
require_once './config/bootstrap.php';

//@TODO stub this products into a db 
// ######## please do not alter the following code ########
$products = array(
	array("name" => "Sledgehammer", "price" => 125.75),
	array("name" => "Axe", "price" => 190.50),
	array("name" => "Bandsaw", "price" => 562.13),
	array("name" => "Chisel", "price" => 12.9),
	array("name" => "Hacksaw", "price" => 18.45)
);
// ##################################################

/**
* In memory db stub.
*/
$stub_db_data = [];
for ($i=0; $i < count($products); $i++) { 
	$product = $products[$i];
	$stub_db_data[$product['name']] = $product;
}


/*
* Hydrate the cart from the current session
*/
$cart = new \Model\Cart;
if( array_key_exists ('cart',$_SESSION)) {
	$cart->hydrate($_SESSION['cart']);
} else {
	$cart->hydrate([]);
}

/**
* Set up the routes.
* @TODO move this configuration to the routes folder
*/
$router = new \Klein\Klein();

/*
* Hompage
*/
$router->respond('GET', '/', function () {
	global $config, $products, $cart;
    return $config->view->renderer->render("main.html",[ 
    	'products' => $products, 
    	'cart' => $cart->items ,
    	'total' => $cart->getTotal()
    ]);
});

/*
* Product page
*/
$router->respond('GET', '/product/[:name]', function ($req) {
	global $config, $products, $cart, $stub_db_data;
	$name = $req->name;
	$product = $stub_db_data[$name];
    return $config->view->renderer->render("product.html",[ 
    	'product' => $product, 
    	'cart' => $cart->items ,
    	'total' => $cart->getTotal()
    ]);
});


/**
* Route for static files inside 
* the asset's folder.
*/
$router->respond('GET', '/asset/[:name].[css|js:ext]?', function ($req,$res) {
	$name = $req->param('name');
	$ext = $req->param('ext');
	return $res->file("/asset/$name.$ext");
});

/**
* Remove from cart
* @TODO this endpoint should other actions
*/
$router->respond('POST', '/cart/[:name]', function ($req,$res, $service) {
	global $config, $products, $cart;
	$name = $req->name;
	$cart->remove($name);
	$_SESSION['cart'] = $cart->items;

	return $res->redirect('/');
});

/**
* Add to cart
*/
$router->respond('POST', '/cart', function ($req,$res, $service) {
	global $config, $products, $cart;
	$name = $req->param('product');
	$price = $req->param('price');
	$cart->add(["name" => $name, "price" => $price ]);
	$_SESSION['cart'] = $cart->items;
	return $res->redirect('/');
});

/**
* Route for static files inside 
* the asset's folder.
*/
$router->respond('POST', '/logout', function ($req,$res, $service) {
	session_unset();
	return $res->redirect('/');
});

$router->dispatch();