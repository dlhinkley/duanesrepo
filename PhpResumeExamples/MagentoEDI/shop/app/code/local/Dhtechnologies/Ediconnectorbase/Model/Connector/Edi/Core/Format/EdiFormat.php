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
 * This is the main traffic cop for the EDI code.  This determines what action
 * will be performed and in what direction the action will go, send or receive
 * @author David Ewing
 *
 */
class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Format_EdiFormat  {

	private $documentSpecs;


	public function __construct() {

		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("start");
		
		$this->documentSpecs = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSpecs();

		$this->documentSpecs->setEndLineDelimiter( Dhtechnologies_Ediconnectorbase_Model_Config::getEdiEndLineDelimiter() );
		$this->documentSpecs->setInLineDelimiter( Dhtechnologies_Ediconnectorbase_Model_Config::getEdiInLineDelimiter() );
		$this->documentSpecs->setRecordTypePosition( Dhtechnologies_Ediconnectorbase_Model_Config::getEdiRecordTypePosition() );
		$this->documentSpecs->setQuoteCharacter( Dhtechnologies_Ediconnectorbase_Model_Config::getEdiQuoteCharacter() );

		$this->ediConfigActions = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Format_EdiConfigActions();
		
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("end");
	}

	public function  startEdiDocumentProcessing($documentType = false, $direction = false) { // throws  GlobalHardErrorException, WebClientErrorException  { // returns void

		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("start" , 10);

		$sequenceNum = 0;


		if ( Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase::purgeInBoundEdiLogs(Dhtechnologies_Ediconnectorbase_Model_Config::getEdiInboundLogDaysToKeep()) ) {
			
			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( "purgeInBoundEdiLogs(" . Dhtechnologies_Ediconnectorbase_Model_Config::getEdiInboundLogDaysToKeep() . ")", 10);
		}
		if ( Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase::purgeOutBoundEdiLogs(Dhtechnologies_Ediconnectorbase_Model_Config::getEdiOutboundLogDaysToKeep()) ) {
			
			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( "purgeOutBoundEdiLogs(" . Dhtechnologies_Ediconnectorbase_Model_Config::getEdiOutboundLogDaysToKeep() . ")" , 10);
		}
		
		$formaterIn =  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Format_EdiFormatInFactory::getEdiFormatIn(); // EdiFormatInInterface
		
		
		$receive = false;//boolean
		
		try {
			
		 	$documentQty = $formaterIn->receiveAllDocuments();
		 	
		 	if ( $documentQty > 0 ) {
			
		 		Dhtechnologies_Ediconnectorbase_Model_Main::addSuccess ( "Received $documentQty documents." );
		 	}
		}
		catch ( Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Format_EdiFormatException $e ) {

					Dhtechnologies_Ediconnectorbase_Model_Main::logException($e);
					Dhtechnologies_Ediconnectorbase_Model_Main::addError("Error recieving documents. ".$e->getMessage());
		}


		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( "retrieving ediConfigActions", 10);

		if ( Dhtechnologies_Ediconnectorbase_Model_Config::isTestMode() ) {
			
			$this->processTestAction($documentType,$direction);
		}
		else {
			
			$this->processAllActions();	
		}


		$formaterOut =  new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Format_EdiFormatOut(); // EdiFormatOut

		try {
		 
			$documentQty = $formaterOut->sendAllDocuments();
			
			if ( $documentQty > 0 ) {
			
				Dhtechnologies_Ediconnectorbase_Model_Main::addSuccess ( "Sent $documentQty documents." );
			}
		}
		catch (Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Format_EdiFormatException $e ) {

					Dhtechnologies_Ediconnectorbase_Model_Main::logException($e);
					Dhtechnologies_Ediconnectorbase_Model_Main::addError("Error sending documents. ".$e->getMessage());
		}
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("end");
		
	}
	private function processAllActions() {
		
		foreach ($this->ediConfigActions->getActionList() AS $action ) {
		
		
			$sequenceNum = $action->getSequenceNum();
			$documentType = $action->getDocumentType();
			$actionType = $action->getActionType();
			$processCodes = $action->getProcessCodes();
			$direction = ucfirst( $action->getDirection());
			/*
			 $actions .= "Seq Num = " . $sequenceNum .
			" Document Type = " . $documentType .
			" Action Type = " . $actionType . "\n";
			*/
			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( "documentType=$documentType, actionType=$actionType", 10);
				
			$this->processEdiDocuments($documentType, $actionType, $direction);
		}		
	}
	private function processTestAction($documentTypeIn, $directionIn ) {
		
			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( "start documentTypeIn=".$documentTypeIn." ,directionIn=".$directionIn, 10);
			
		foreach ($this->ediConfigActions->getActionList() AS $action ) {
		
		
			$sequenceNum = $action->getSequenceNum();
			$documentType = $action->getDocumentType();
			$actionType = $action->getActionType();
			$processCodes = $action->getProcessCodes();
			$direction = ucfirst( $action->getDirection());
			
			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( "checking documentType=$documentType,direction=$direction ", 10);
			if ( $documentTypeIn == $documentType && strtolower($directionIn) == strtolower($direction) ) {
				
				$this->processEdiDocuments($documentType, $actionType, $direction);
				
			}

			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( "end=", 10);
				
		}
		
	}

	private function processEdiDocuments( $documentType,  $actionType,  $direction  ) { // throws  GlobalHardErrorException, WebClientErrorException  { // returns void


		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("Begin " .
					  "DocumentType=" . $documentType .  "," .
					  "Action Type=" . $actionType .",", 10);


		$active = Dhtechnologies_Ediconnectorbase_Model_Config::isDocumentActive($documentType,$direction);
		
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("active=$active" , 10);
		
		if (  $active ) {
			
			// ex. Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Format_Action_EdiSalesOrderOut
			//
			$methodName = $actionType;
	
			$ediDocument =  new $methodName($this->documentSpecs); // 
			$ediDocument->processEdiDocuments($documentType,$direction);
				
		}
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("EdiFormat.processEdiDocuments: End" , 10);
	}

}