<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */

 

 class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Data_ShipmentDetail    {

     private $quantityShipped;
     private $sku;
 

	/**
	 * Create the object to manually initialize
	 */
	public function  getQuantityShipped() {
		return $this->quantityShipped;
	}

	public function setQuantityShipped($quantity) {
		$this->quantityShipped = $quantity;
	}

	public function  getSku() {
		return $this->sku;
	}

	public function setSku($sku) {
		$this->sku = $sku;
	}


}
