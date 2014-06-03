<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */


class Dhtechnologies_Ediconnector856in_Model_Connector_Edi_Core_Documents_Type_Edi856In extends Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiDocumentIn {

	public function __construct(Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiDocumentDefinitionCommon $ediDocumentDefinition,Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSpecs $documentSpecs) {
		
		parent::__construct($ediDocumentDefinition,$documentSpecs);			
	}
	
	function lineDefinitionTriggers($lineDefinitionControl,$ediRow) {
			// Create a shipment field when the shipment starts, used in add post values
			//
			if ( $lineDefinitionControl->isShipmentLoop($ediRow) ) {

				$this->shipmentController->addShipment();
			}
			else if ( $lineDefinitionControl->isShipmentDetailLoop($ediRow) ) {

				$this->shipmentController->addShipmentDetail();
			}
	}
	function columnDefinitionTriggers($columnDefinitionControl,$value) {
		
		 if ( $columnDefinitionControl->hasShipmentDetailValue() ) {

			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" value=$value, hasShipmentDetailValue",10);

			$shipmentDetailMethod		= "set" . $columnDefinitionControl->getShipmentDetailValue();

			$this->shipmentController->setShipmentDetailValue( $shipmentDetailMethod, $value);
		}
		else if ( $columnDefinitionControl->hasShipmentValue() ) {

			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" value=$value, hasShipmentValue",10);

			$valueMethod		= "set". $columnDefinitionControl->getshipmentValue();

			$this->shipmentController->setShipmentValue($valueMethod, $value);

			
		}

	}	
}