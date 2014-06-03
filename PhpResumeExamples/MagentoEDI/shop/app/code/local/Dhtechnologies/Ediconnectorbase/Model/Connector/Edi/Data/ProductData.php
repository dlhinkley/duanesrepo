<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */
 

class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Data_ProductData {	
	
	private $sku;
	private $price;
	private $name;
	private $description;
	private $short_description;
	private $weight;
	
	public function getShortDescription() {
		
		return $this->short_description;
	}
	public function setShortDescription($str) {
		
		$this->short_description = $str;
	}
	public function getDescription() {
		
		return $this->description;
	}
	public function setDescription($str) {
		
		$this->description = $str;
	}
	public function getWeight() {
		
		return $this->weight;
	}
	public function setWeight($str) {
		
		$this->weight = $str;
	}
	public function getSku() {
		
		return $this->sku;
	}
	public function setSku($str) {
		
		$this->sku = $str;
	}
	public function getPrice() {
		
		return $this->price;
	}
	public function setPrice($str) {
		
		$this->price = $str;
	}
	public function getName() {
		
		return $this->name;
	}
	public function setName($str) {
		
		$this->name = $str;
	}
	
}
