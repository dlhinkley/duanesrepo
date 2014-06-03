<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */

class Dhtechnologies_Ediconnector856in_Model_Connector_Edi_Core_Format_Action_EdiUpdateSalesOrderTrackingIn implements Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Format_Action_ActionInterface {

	private $ediType;

	public function __construct(Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSpecs $documentSpecs) {
		$this->documentSpecs = $documentSpecs;
	}
	public function processEdiDocuments( $documentType,  $direction) { // returns
	                                                                               // void
		$processedEdiDocument = false;
		$updatedSalesOrder = false;
		
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ( "start", 10 );
		
		$this->ediType = Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiDocumentTypeFactory::getEdiDocumentType ( $documentType, $direction, $this->documentSpecs );
		
		if (is_object ( $this->ediType )) {
			
			$this->ediType->getAcknowledgement()->setAcknowledgeCodeAccepted();
			$processedFlag = 0;
			
			$inboundDocs = Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase::getInBoundDocuments ( $documentType, $processedFlag ); // EdiDocumentRecord
			
			foreach ( $inboundDocs as $document ) {
				
				try {
					$this->ediType->setDocument ( $document->getDocumentContent () );
					
					Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ( "processing document " . $document->getDocumentFileName (), 10 );
					
					$shipments = $this->ediType->getShipments ();
				}
				catch ( Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiTypeException $e ) {
									
					Dhtechnologies_Ediconnectorbase_Model_Main::logException($e);
					Dhtechnologies_Ediconnectorbase_Model_Main::addError("Error reading $documentType. ".$e->getMessage());
						
				}
				// Loop over shipments
				foreach ( $shipments as $shipmentData ) {
					
					try {
						$this->buildShipment ( $shipmentData );
						
						Dhtechnologies_Ediconnectorbase_Model_Main::addSuccess ( "Updated shipment for order ".$shipmentData->getOrderNumber () );
						$document->setProcessedFlag ( 1 );
					}
					catch (Exception $e) { // Magento just throws normal exceptions
						
						$document->setProcessedFlag ( 0 );
						
						Dhtechnologies_Ediconnectorbase_Model_Main::logException($e);
						Dhtechnologies_Ediconnectorbase_Model_Main::addError("Error creating shipment for order  " . $shipmentData->getOrderNumber ().". ".$e->getMessage());
						$this->ediType->getAcknowledgement()->setRejected ( true );
						
					}
				}
				$this->ediType->getAcknowledgement()->incTransactionSets();
				
				// Send ack if configured
				if ($this->ediType->getEdiDocumentDefinition ()->isSendAcknowledgement ()) {
					
					$ackAction = new Dhtechnologies_Ediconnector997out_Model_Connector_Edi_Core_Format_Action_EdiSendAcknowledgementOut ( $this->documentSpecs );
					
					$ackAction->processEdiDocument ( $this->ediType->getAcknowledgement() );
				}
				$document->save ();
			}
		}
		
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ( "End", 10 );
		
		return $processedEdiDocument;
	}
	/**
	 * Build shipment and create in Magento
	 * @param Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Data_ShipmentData $shipmentData
	 */
	private function buildShipment(Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Data_ShipmentData $shipmentData) {
		
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ( "start", 10 );
		
		// If there are shipments, proceed
		$order = Mage::getModel ( 'sales/order' )->load ( $shipmentData->getOrderNumber () );
		
		
		$shippedItems = array ();
		$trackingNumbers = array ();
		
		// Organize data for createShipment
		for($m = 0; $m < $shipmentData->size (); $m ++) {
			
			$shipmentLine = $shipmentData->get ( $m );
			
			$sku = $shipmentLine->getSku ();
			
			$itemId = $this->getItemId ( $order->getAllItems (), $sku );
			
			if ($itemId) {
				
				$shippedItems [$itemId] = $shipmentLine->getQuantityShipped ();
			}
		}
		$this->createShipment ( $order, $shippedItems, $shipmentData );
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ( "End", 10 );
	}
	private function createShipment($order, $shippedItems,Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Data_ShipmentData $shipmentData) {

		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ( "start", 10 );
		
		$orderNumber = $shipmentData->getOrderNumber();
		$trackingNumber = $shipmentData->getTrackingNumber();
		$scacCode = $shipmentData->getScacCode();
		
		$comment = "";
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ("creating shipment for order $orderNumber", 10 );
		
		// See if a shipment exists
		$myorder = Mage::getModel('sales/order')->loadByIncrementId($orderNumber);
        $shipmentsCollection = $myorder->getShipmentsCollection();
   	
        // If no shipment found, create one
        if ( ! is_object($shipmentsCollection) || $shipmentsCollection->count() == 0 ) {
        			
			try {
				$shipmentIncrementId = Mage::getModel ( 'sales/order_shipment_api' )->create ( $orderNumber, $shippedItems, $comment, true, true );
			}
			catch (Mage_Api_Exception $e ) {
				
				Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ( $e->getTraceAsString(), 10 );
				throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiTypeException("Error creating shipment for order $orderNumber. ".$e->getMessage());
			}
			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ("done shipment for order $orderNumber", 10 );
        }
        else {
        	
        	$shipment = $shipmentsCollection->getFirstItem();
        	$shipmentIncrementId = $shipment->getIncrementId();
        }		
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ("shipmentIncrementId=$shipmentIncrementId", 10 );
		
        if ($shipmentIncrementId) {
			
			try {
				// Set order completed
				$myorder->setData('state', "complete");
				$myorder->setStatus("complete");
				$history = $myorder->addStatusHistoryComment('Order marked as complete automatically.', false);
				$history->setIsCustomerNotified(false);
				$myorder->save();
				
				
				$shipmentApi = Mage::getModel ( 'sales/order_shipment_api' );
				
				$allowedCarriers = $shipmentApi->getCarriers($orderNumber);
				$carrierCode 	= Dhtechnologies_Ediconnectorbase_Model_Shipping::getCarrierCode($scacCode);
				
				Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ("scacCode=$scacCode carrierCode=$carrierCode", 10 );
				
				if ( ! isset($allowedCarriers[$carrierCode]) ) {
					
					Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ( "carrier missing: ".var_export($allowedCarriers,true), 10 );
					throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiTypeException("Carrier code $carrierCode is not valid for order $orderNumber");
				}
				
				Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ("adding Tracking number $trackingNumber for order $orderNumber", 10 );
				
				$shipmentApi->addTrack ( $shipmentIncrementId, $carrierCode, "Tracking Number", $trackingNumber );
				
				Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ("done adding Tracking number $trackingNumber for order $orderNumber", 10 );
			}
			catch (Mage_Api_Exception $e ) {
				
				Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ( $e->getTraceAsString(), 10 );
				throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiTypeException("Error creating shipment for order $orderNumber. ".$e->getMessage());						
			}
		}
	
			
	
		
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ( "End", 10 );
		return $shipmentIncrementId ? true : false;
	}
	private function getItemId($items, $sku) {
		
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ( "sku=$sku start", 10 );
		
		$itemId = null;
		
		foreach ( $items as $item ) {
			
			if ($item->getSku () == $sku) {
				
				$itemId = $item->getId ();
			}
		}
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ( "itemId=$itemId End", 10 );
		return $itemId;
	}
}
?>