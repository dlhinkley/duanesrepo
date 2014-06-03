<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */

class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_Edi850Out extends Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiDocumentOut {

	private $itemNumber;
	
	public function __construct(Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiDocumentDefinitionCommon $ediDocumentDefinition, Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSpecs $documentSpecs) {

		parent::__construct ( $ediDocumentDefinition, $documentSpecs );
	}
	private function createOrderDetailFields(Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiFields $ediFields, Dhtechnologies_Ediconnectorbase_Model_Order $order) {
		$recordType = $ediFields->getRecordType ();
		
		$items = $order->getAllVisibleItems ();
		$this->itemNumber = 0;
		
		// loop over fields for each orderline
		foreach ( $items as $itemId => $orderDetail ) {
			
			$this->itemNumber++;
			
			$this->incRecordCounter ( $recordType );
			
			$ediFieldList = $ediFields->getEdiFieldList ();
			$this->incLevel ( $ediFields->getLevel () );
			
			// Loop over fields
			//
			for($m = 0; $m < $ediFieldList->getSize (); $m ++) {
				
				$ediField = $ediFieldList->getValue ( $m );
				
				$this->createField ( $order, $ediField, $this->recordCounter [$recordType], $recordType, $orderDetail );
			}
		}
	}
	protected function setMyDocument($ediFields,$lineDefinitionControl,$object) {
	
		// Don't do detail if in test mode
		if ($lineDefinitionControl->isOrderDetailLoop () &&  ! Dhtechnologies_Ediconnectorbase_Model_Config::isTestMode() ) {		
		
			$this->createOrderDetailFields ( $ediFields, $object );
		} else {
		
			$this->createMaxFields ( $ediFields, $object );
		}	
	}
	
	protected function createMyField( $order, Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiField $ediField, $recordCounter, $recordType, $orderDetail = null) {

		$value = null;
		$fieldName = $ediField->getFieldName ();
		$columnDefinitionControl = $ediField->getColumnDefinitionControl ();
		
		if ( Dhtechnologies_Ediconnectorbase_Model_Config::isTestMode() ) {
			
			// Don't do anything, just prevent the other elses from triggering
		}
		else if ($columnDefinitionControl->hasOrderValues ()) {
			
			
			$valueMethods = $columnDefinitionControl->getOrderValue ( $recordCounter );
			$value = $order;
			$found = false;

			//
			foreach ( $valueMethods as $valueMethod ) {
				
				if ($valueMethod != "") {
					$found = true;
					$methodName = "get" . $valueMethod;
					$value = $value->$methodName ();
				}
			}
			if (! $found) {
				
				$value = "";
			}
			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ( " fieldName=$fieldName, hasOrderValues value=$value", 10 );
		} 

		else if ($columnDefinitionControl->hasOrderValue ()) {
			
			$valueMethods = $columnDefinitionControl->getOrderValue ();
			
			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ( " fieldName=$fieldName, hasOrderValue valueMethods=" . var_export ( $valueMethods, true ), 10 );
			$value = $order;
			
			// takes MethodName/MethodName and calls each method as
			// $order->methodName()->methodName()
			//
			foreach ( $valueMethods as $valueMethod ) {
				
				$methodName = "get" . $valueMethod;
				
				if (method_exists ( $value, $methodName )) {
					
					$value = $value->$methodName ();
				} else {
					// get available methods
					$availableMethods = join ( ", ", get_class_methods ( $value ) );
					throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiTypeException ( "Method " . get_class ( $value ) . "::$methodName defined in configuration doesn't exist." );
				}
			}
		} 
		else if ($columnDefinitionControl->hasOrderDetailValue ()) {
			
			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ( " fieldName=$fieldName, hasOrderDetailValue", 10 );
			
			$orderDetailMethod = "get" . $columnDefinitionControl->getOrderDetailValue ();
			
			if ( $orderDetailMethod == 'getItemNumber') {
				
				$value = $this->itemNumber;
			}
			else {
				$value = $orderDetail->$orderDetailMethod ();
			}
		}
		return $value;
	}
}