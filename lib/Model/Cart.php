<?php
namespace Model;

/**
* The cart model contains all the information
* regardin the cart. This class can hydrate
* from an array;
*/
class Cart {
	/**
	* Given an array, load the items into the cart
	*/
	public function hydrate($items) {
		$this->items = $items;

		/**
		* What is this map for? Map of items inside the
		* cart, so we can easily remove it or get to it
		*/
		$this->map = [];
		for ($i=0; $i < count($items); $i++) { 
			$item = $items[$i];
			$item['display_price'] = round($item['price'], 2);
			$this->map[$item['name']] = $item;
		}
	}

	/**
	* Adds an item into a cart if it does not exist
	* else adds the qty by 1
	*
	* @param $item_name The name of the item (which we are using as an id)
	*/
	public function add($item) {
		if( !isset($this->map[ $item['name'] ]) ) {
			$item['qty'] = 1;
			var_dump($item);
			$this->map[ $item['name'] ] = $item;
		} else {
			$this->map[ $item['name'] ]['qty'] += 1; 
		}

		var_dump($this->map);
		$this->items = array_values($this->map);
	}

	/**
	* Deducts an items qty by 1
	* if it is zero, it is removed
	*
	* @param $item_name The name of the item (which we are using as an id)
	*/
	public function remove($item_name) {
		$this->map[$item_name]['qty'] -= 1;
		if( $this->map[$item_name]['qty'] == 0 ) {
			unset($this->map[$item_name]);
		}
		$this->items = array_values($this->map);
		var_dump($this->items);
	}

	public function getTotal() {
		$total = 0;
		for ($i=0; $i < count($this->items); $i++) { 
			$item = $this->items[$i];
			$total += ($item['price'] * $item['qty']);
		}	
		return $total;
	}
}