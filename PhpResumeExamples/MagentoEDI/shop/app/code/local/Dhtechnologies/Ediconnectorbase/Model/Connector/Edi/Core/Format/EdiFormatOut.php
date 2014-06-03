<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */



class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Format_EdiFormatOut {

	private $documentsQty; // int

	public function __construct() {
	}
	
	/**
	 * Picks up all EDI Documents and inserts them in the INBOUND_EDI_DOCUMENTS
	 * Table for processing
	 *
	 * @return
	 *
	 * @throws Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Format_EdiFormatException
	 */
	public function sendAllDocuments() { 
		
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ( "start", 10 );
		              		
		$qty = $this->sendOneInEachFile ();

		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ( "end", 10 );
		return $qty;
	}
	private function sendOneInEachFile() { // throws
	                                       // Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Format_EdiFormatException
	                                       // { // returns Integer
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ( "start", 10 );
		
		$objectEdiDocumentRecordsResults =  "";
		
		$t = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransport ();
		
		$ediDocumentsToSend = Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase::getOutBoundDocumentsSentFlag ( 0 ); // EdiDocumentRecords
		
		$documentsQty = 0;
		
		$type = null; // String
		try {
			if ( count($ediDocumentsToSend) > 0 ) {
			
				$t->connect ();
			}
			$ctr = 0; // Integer
			foreach ( $ediDocumentsToSend as $outbound ) {
				
				$ctr ++;
				
				$type = $outbound->getDocumentType ();
				
				Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ( "Sending Edi $type", 10 );
				
				// Save the document
				$documentData = $outbound->getDocumentContent(); 
				
				$fileName = $outbound->getFilename() ;
				
				$t->sendDocument ( $fileName,   $documentData );
				
				Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase::setOutBoundSaved ( $outbound->getId(), $fileName );

				
				$documentsQty ++;
			}
			if ( count($ediDocumentsToSend) > 0 ) {
				
				$t->disconnect ();
			}
		} catch ( Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException $e ) {
			
			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ( $e->getMessage (), 10 );
			throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Format_EdiFormatException ( "Error Sending All Documents. ".$e->getMessage() );
		}
		
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ( "Object Document Contents Results = \n" . $objectEdiDocumentRecordsResults, 10 );
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ( "end", 10 );
		
		return $documentsQty;
	}
	
	public function getQtyDocuments() { // returns void
		return documentsQty;
	}
}