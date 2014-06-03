<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */


class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_ColumnDefinitionControl {
	
	protected $columnDefinition;
	
	public function __construct(SimpleXMLElement $columnDefinition) {
		
		$this->columnDefinition = $columnDefinition;
	}
	function getFixedValue($counter = null) {
		
	
		if ( $counter === null ) {
			
			$value = (string) $this->columnDefinition->fixedValue;
		}
		else {

			$value = (string) $this->columnDefinition->fixedValues->fixedValue[ $counter ];
		}
		return $value;
	}
	function getTestValue($counter = null) {
		
	
		if ( $counter === null ) {
			
			$value = (string) $this->columnDefinition->testValue;
		}
		else {

			$value = (string) $this->columnDefinition->testValues->testValue[ $counter ];
		}
		return $value;
	}
	function getOrderDetailValue() {
		
		return (string) $this->columnDefinition->orderDetailValue;
	}
	function getShipmentDetailValue() {
		
		return (string) $this->columnDefinition->shipmentDetailValue;
	}
	function hasFixedValue() {
		

		return ( isset($this->columnDefinition->fixedValue) && $this->columnDefinition->fixedValue != "");
	}
	function hasTestValue() {
		

		return ( isset($this->columnDefinition->testValue) && $this->columnDefinition->testValue != "");
	}
	/*
	 * 
	 */
	function hasFixedValues() {
		
		return ( isset($this->columnDefinition->fixedValues) && isset($this->columnDefinition->fixedValues->fixedValue[0]) );
	}
	function hasTestValues() {
		
		return ( isset($this->columnDefinition->testValues) && isset($this->columnDefinition->testValues->testValue[0]) );
	}
	function hasOrderDetailValue() {
		
		return ( isset($this->columnDefinition->orderDetailValue) && $this->columnDefinition->orderDetailValue != "");
	}
	function hasShipmentDetailValue() {
		
		return ( isset($this->columnDefinition->shipmentDetailValue) && $this->columnDefinition->shipmentDetailValue != "");
	}
	

	function hasOrderValue() {
		
		return ( isset($this->columnDefinition->orderValue) && $this->columnDefinition->orderValue != "");
	}
	function hasAckValue() {
		
		return ( isset($this->columnDefinition->ackValue) && $this->columnDefinition->ackValue != "");
	}
	function getAckValue() {

		return (string) $this->columnDefinition->ackValue;
	}	
	function hasShipmentValue() {
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" columnDefinition=".var_export($this->columnDefinition,true),10);
		
		return ( isset($this->columnDefinition->shipmentValue) && $this->columnDefinition->shipmentValue != "");
	}
	function getShipmentValue() {

		return (string) $this->columnDefinition->shipmentValue;
	}	
	function getOrderValue($counter = null) {
		
	
		if ( $counter === null ) {
			
			$value = (string) $this->columnDefinition->orderValue;
		}
		else {

			$value = (string) $this->columnDefinition->orderValues->orderValue[ $counter ];
		}
		return explode("/",$value);
	}
	function hasOrderValues() {
		
		return ( isset($this->columnDefinition->orderValues) && isset($this->columnDefinition->orderValues->orderValue[0]) );
	}
	

	function hasCalculatedValues() {
		
		return ( isset($this->columnDefinition->calculatedValues) && isset($this->columnDefinition->calculatedValues->calculatedValue[0]) );
	}
	
	function getCalculatedValue($counter = null) {
	
		if ( $counter === null ) {
			
			$value = (string) $this->columnDefinition->calculatedValue;
		}
		else {

			$value = (string) $this->columnDefinition->calculatedValues->calculatedValue[ $counter ];
		}
		return explode("/",$value);
				
	}
	function hasCalculatedValue() {
		
		return ( isset($this->columnDefinition->calculatedValue) && $this->columnDefinition->calculatedValue != "");
	}	
}