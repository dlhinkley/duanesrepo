<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */
 
 class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Data_ShipmentData  {

	private $lines;//Vector<OrderLine> 
	private $iterator;//Iterator<OrderLine> 
    private $trackingNumber;
     private $orderNumber;
	private $scacCode;

	public function __construct() {
		
		$this->lines = new Dhtechnologies_Ediconnectorbase_Model_Connector_Java_Vector();
		$this->iterator = $this->lines->iterator();
	}

	public function setScacCode($str) {
		
		$this->scacCode = $str;
	}
	public function getScacCode() {
		
		return $this->scacCode;
	}

	public function setTrackingNumber($string) {

		$this->trackingNumber = $string;

	}
	public function  getTrackingNumber() {
		return $this->trackingNumber;

	}
	public function setOrderNumber($string) {

		$this->orderNumber = $string;
	}
	public function  getOrderNumber() {

		return $this->orderNumber;
	}
	
	/**
	 * Resets iteration
	 * @return 
	 */
	public function reset() {
		
		$this->iterator = $this->lines->iterator();
	}
	public function hasNext() {
		
		return $this->iterator->hasNext();
	}
	public function  next() {
		
		return $this->iterator->next();
	}
	public function size() {

		return (int)$this->lines->size();
	}
	public function add(Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Data_ShipmentDetail $newline) {

		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" start",10);
		
		$this->lines->add($newline);
		$this->reset();
	}
	public function  get( $m) {
		return $this->lines->get($m);
	}
}
?>
