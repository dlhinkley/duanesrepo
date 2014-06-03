<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */


class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransport implements Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportInterface {

	protected $transport; // SendReceiveInterface

	public function __construct() {

		global $ediConfig;

		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("="  , 10);
		$this->transport = Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_SendReceiveFactory::getSendRecieve(Dhtechnologies_Ediconnectorbase_Model_Config::getEdiTransportType());


	 $this->transport->setAddress(Dhtechnologies_Ediconnectorbase_Model_Config::getClientFtpAddress());
	 $this->transport->setUsername(Dhtechnologies_Ediconnectorbase_Model_Config::getClientFtpUserName());
	 $this->transport->setPassword(Dhtechnologies_Ediconnectorbase_Model_Config::getClientFtpPassword());
	 $this->transport->setInPath(Dhtechnologies_Ediconnectorbase_Model_Config::getClientFtpInPath());
	 $this->transport->setOutPath(Dhtechnologies_Ediconnectorbase_Model_Config::getClientFtpOutPath());
	 $this->transport->setFileConfirmationSuffix(Dhtechnologies_Ediconnectorbase_Model_Config::getClientFtpConfirmationSuffix());
	 $this->transport->setFileInboundSuffix(Dhtechnologies_Ediconnectorbase_Model_Config::getClientFtpInboundSuffix());
	 $this->transport->setFileOutboundSuffix(Dhtechnologies_Ediconnectorbase_Model_Config::getClientFtpOutboundSuffix());
	 $this->transport->setLocalSave(Dhtechnologies_Ediconnectorbase_Model_Config::getClientFtpSaveLocalSent());
	 $this->transport->setLocalSaveDirectory(Dhtechnologies_Ediconnectorbase_Model_Config::getClientFtpSaveLocalSentDocumentPath());
	 $this->transport->setDeleteFile(Dhtechnologies_Ediconnectorbase_Model_Config::getClientFtpDeleteReceivedFile());
	 
	 
	}

	public function sendDocument( $fileName,  $documentData){ // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException  { // returns boolean

		$documentSent = false;

		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( "documentName=" . $fileName, 8);


		$this->transport->connect();

		$documentSent = $this->transport->sendDocument($fileName, $documentData, false);

		$this->transport->disconnect();

		return $documentSent;

	}
	public function  disconnect()  {// throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException  { // returns void

		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("", 10);
	 $this->transport->disconnect();

	}
	/**
	 * Test the ftp connection and return true or false if succeeded or failed.
	 * @return
	 * @throws Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException
	 */
	public function  testConnect() {// throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException  { // returns boolean
			

		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("", 10);

		$result = $this->transport->testConnect();//boolean

		return $result;
	}
	public function  connect(){ // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException  { // returns boolean
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("", 10);
		return $this->transport->connect();

	}

	public function receiveAllDocuments( ) { // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException  { // returns EdiDocumentRecords
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("start", 10);

		$documents =  new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_EdiDocumentRecords(); // EdiDocumentRecords
		

		if ( $this->transport->setFileNames() ) {

			$fileNames =  $this->transport->getFileNames(); // FileNames

			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(__METHOD__ . " Found ".$fileNames->size() . " files",10);

			$fileNames->reset();

			while ( $fileNames->hasNext()) {

				$fn =  $fileNames->next(); // FileName
					
				Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" FileName = " . $fn->getFileName() , 10);

				try {
					$this->transport->setDocumentByString($fn);

					Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" documentReceived " . $fn->getFileName(), 10);

					
					Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("Saving document size=". strlen($this->transport->getDocument()), 10);

					$dc =  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase::getInboundModel(); // EdiDocumentRecord
					$dc->setDocumentContent($this->transport->getDocument() );
					$dc->setDocumentMd5( md5($this->transport->getDocument() ) );
					$dc->setFilename($this->transport->getDocumentSourceFileName() );
					$dc->setDocumentType($this->transport->getDocumentType() );

					$documents->add( $dc );


				}
				catch (Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiTypeException $e) {
					
					Dhtechnologies_Ediconnectorbase_Model_Main::logException($e);
					Dhtechnologies_Ediconnectorbase_Model_Main::addError("Error determining document type:".$e->getMessage());
						
				}

			}
		}



		return $documents;
	}

	/**
	 * Takes the given document(s) and splits to multiple documents
	 * @param document
	 * @return
	 */
	protected function getMultipleDocuments( $document) {// VectorString>
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("", 10);

		$multipleDocs = new Dhtechnologies_Ediconnectorbase_Model_Connector_Java_VectorString(); // VectorString

	 $multipleDocs->add($document);

		return multipleDocs;
	}







}
