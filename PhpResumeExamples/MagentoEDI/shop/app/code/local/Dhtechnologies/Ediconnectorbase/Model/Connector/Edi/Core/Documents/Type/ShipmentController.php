<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */

/**
 * 
 * Controls multiple shipments per document
 * @author dlhinkley
 *
 */
class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_ShipmentController {
	
	private $shipments = array();
	private $numShipments = 0;
		
	public function __construct() {
		
		
	}
	
	public function addShipment() {
					
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( " start",10);
		$this->numShipments++;
		
		$this->shipments[ $this->numShipments - 1 ] = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Data_ShipmentData();
			

	}

	public function addShipmentDetail() {
		
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( " start",10);
		$this->shipments[ $this->numShipments - 1]->add( new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Data_ShipmentDetail() );
	}
	public function setShipmentDetailValue($shipmentDetailMethod, $value) {
		
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( " start",10);
		$lastRec = $this->shipments[ $this->numShipments - 1] ->size() - 1;
		$this->shipments[ $this->numShipments - 1] ->get( $lastRec )->$shipmentDetailMethod( $value );
	}
	public function setShipmentValue($valueMethod, $value)  {
		
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( " start",10);
		$this->shipments[$this->numShipments - 1 ]->$valueMethod($value);
	}
	public function getShipments() {
		
		return $this->shipments;
	}
	public function closeShipments() {

		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( " start",10);

		
	}
}