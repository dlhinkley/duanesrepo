<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */

class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Format_Action_EdiSendSalesOrderOut implements Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Format_Action_ActionInterface {
	private $ediType;
	public function __construct(Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSpecs $documentSpecs) {
		$this->documentSpecs = $documentSpecs;
	}
	public function processEdiDocuments($documentType, $direction) { // returns
	                                                                 // void
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ( "start", 10 );
		
		if (Dhtechnologies_Ediconnectorbase_Model_Config::isTestMode ()) {
			
			$this->sendDocument ( null, $documentType, $direction );
		} 
		else
		 {
			$orders = $this->getUnsentOrders ();
			
			foreach ( $orders as $myOrder ) {
				
				try {
					$this->sendDocument ( $myOrder, $documentType, $direction );
					
					Dhtechnologies_Ediconnectorbase_Model_Main::addSuccess ( "Sent $documentType for order " . $myOrder->getRealOrderId () );
				} 
				catch ( Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiTypeException $e ) {
					
					Dhtechnologies_Ediconnectorbase_Model_Main::logException($e);
					Dhtechnologies_Ediconnectorbase_Model_Main::addError("Error sending $documentType for order " . $myOrder->getRealOrderId ().". ".$e->getMessage());
				}
			}
		}
		
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ( "end", 10 );
	}
	private function sendDocument($myOrder, $documentType, $direction) {
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ( "start", 10 );
		
		$this->ediType = Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiDocumentTypeFactory::getEdiDocumentType ( $documentType, $direction, $this->documentSpecs );
		
		$this->ediType->setDocument ( $myOrder );
		
		if (is_object ( $this->ediType )) {
			
			$this->ediType->getAcknowledgement ()->setAcknowledgeCodeAccepted ();
			$outbound = Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase::getOutboundModel (); // EdiDocumentRecord
			
			$outbound->setDocumentType ( $documentType );
			$outbound->setDocumentContent ( $this->ediType->getDocument () );
			$outbound->setFilename ( $this->ediType->getFilename () );
			$outbound->save ();
			
			// It's null in test mode
			if ($myOrder != null) {
				
				$outbound->setSourceDocumentNum ( $myOrder->getRealOrderId () );
				$myOrder->setEdiSent ( 1 );
				$myOrder->save ();
			}
			$this->ediType->getAcknowledgement()->incTransactionSets();
				
			// Send ack if configured
			if ($this->ediType->getEdiDocumentDefinition ()->isSendAcknowledgement ()) {
				
				$ackAction = new Dhtechnologies_Ediconnector997out_Model_Connector_Edi_Core_Format_Action_EdiSendAcknowledgementOut ( $this->documentSpecs );
				
				$ackAction->processEdiDocument ( $this->ediType->getAcknowledgement () );
			}
		}
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ( "end", 10 );
	}
	private function getUnsentOrders() {
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ( "start", 10 );
		
		$statusFilter = Dhtechnologies_Ediconnectorbase_Model_Config::getSendOrderStatus();
		
		$orders = Mage::getModel ( 'sales/order' )
			->getCollection ()
			->addFieldToFilter ( 'edi_sent', '0' )
			->addFieldToFilter ( 'status', $statusFilter )
			->addAttributeToSelect ( '*' );
		
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ( "end getSize=" . $orders->getSize (), 10 );
		
		return $orders;
	}
}
?>
