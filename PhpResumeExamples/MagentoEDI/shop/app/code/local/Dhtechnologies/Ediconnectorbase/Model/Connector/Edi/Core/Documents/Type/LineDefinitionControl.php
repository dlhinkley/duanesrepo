<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */

class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_LineDefinitionControl {

	protected $lineDefinition;
	
	public function __construct(SimpleXMLElement $lineDefinition) {
		
		$this->lineDefinition = $lineDefinition;
	}
	public function isOrderDetailLoop() {
		
		if ( isset( $this->lineDefinition->orderDetailLoop ) && $this->lineDefinition->orderDetailLoop == "true" ) {
			
			$orderDetailLoop  = true;
		}
		else {
			
			$orderDetailLoop = false;
		}
		return $orderDetailLoop;
	}	
	
	/**
	 * Understands 
	 *			<conditional>
	 *				<filter>
	 *					<fieldName>HierachicalLevelCode</fieldName>
	 *					<fieldValue>S</fieldValue>
	 *				</filter>
	 *			</conditional>
	 *
	 * Enter description here ...
	 * @param EdiRow $ediRow
	 */
	
	private function isMatched($conditional,$ediRow) {
		
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( "start",10);
		$matched = false;
		
		// Single match or do we loop over matches
		if ( isset($conditional->filter)
				&& isset($conditional->filter->fieldName)
				&& isset($conditional->filter->fieldValue ) ) {
			
				$fieldName  = (string) $conditional->filter->fieldName;
				$fieldValue = (string) $conditional->filter->fieldValue;
				
				Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( " matchFieldName=$fieldName, matchFieldValue=$fieldValue, docFieldValue=".$ediRow->getValue($fieldName),10);

				
				if ( $ediRow->getValue($fieldName) == $fieldValue  ) {
	
					$matched = true;
					Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( " true",10);
				}
		}
		else {
			
			// We'll program when we get there	
		}
		return $matched;
	}
	public function isShipmentLoop($ediRow) {
		
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( "start",10);
		
		$result = $this->isTrue($this->lineDefinition->shipmentLoop, $ediRow);
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( "end",10);
		return $result;
	}
	public function isShipmentDetailLoop($ediRow) {
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( "start",10);
		
		$result = $this->isTrue($this->lineDefinition->shipmentDetailLoop, $ediRow);
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( "end",10);
		
		return $result;
		
	}
	/**
	 * Understands format of <shipmentLoop>true</shipmentLoop>
	 * or 
	 * 		<shipmentLoop>
	 *			<value>true</value>
	 *			<conditional>
	 *				<filter>
	 *					<fieldName>HierachicalLevelCode</fieldName>
	 *					<fieldValue>S</fieldValue>
	 *				</filter>
	 *			</conditional>
	 *	</shipmentLoop>
	 *
	 * Enter description here ...
	 * @param EdiRow $ediRow
	 */
	private function isTrue($lineElement,$ediRow) {
		
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( " lineElement=".var_export($lineElement,true),10);

		if ( isset( $lineElement) ) {
			
			if ( 
				
					$lineElement->value == "true"
					&& $this->isMatched($lineElement->conditional,$ediRow) ) {
						
				$isLoop  = true;
				Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( " isLoop=true",10);
						
			}
			else if ( $lineElement == "true" ) {
				
				$isLoop  = true;
				Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( " isLoop=true",10);
			}
			else {
				
				$isLoop = false;
				Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( " isLoop=false",10);				
			}
		}
		else {
			
			$isLoop = false;
			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( " isLoop=false",10);
		}
		return $isLoop;
		
		
	}
}