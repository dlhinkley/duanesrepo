<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */



interface Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_SendReceiveInterface {

	public function  setFileNames();// returns boolean
			 // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException

	public function setDocumentFileName(Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_FileName $fn) ; // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException returns boolean


	public function  deleteFile(Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_FileName $fn)  ; // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException returns boolean


	public function  disconnect()  //   void
			; // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException


	public function  setInPath( $clientFtpInPath); //returns void

	
	public function getInPath(); // returns String

	
	public function  setPassword( $clientPassword); //returns void

	
	public function getPassword(); // returns String

	
	public function  setUsername( $clientUsername); //returns void

	
	public function getUserName(); // returns String

	public function  setAddress( $clientAddress); //returns void

	public function getAddress(); // returns String

	
	public function setLocalSave( $clientLocalSave); //Boolean returns void


	public function  getLocalSave(); //returns boolean

	public function  testConnect() ; // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException returns boolean

	/**
	 * Used to indicate that the edi file with data is ready for pickup
	 * Default is ""
	 * @param clientFileConfirmationSuffix
	 */
	public function  setFileConfirmationSuffix( $clientFileConfirmationSuffix);//returns void

	public function getFileConfirmationSuffix(); // returns String

	/**
	 * Directory used to save a local copy of sent edi documents
	 * localsave must be set to true
	 * Default is empty String
	 * @param clientLocalSaveDirectory
	 */
	public function  setLocalSaveDirectory( $clientLocalSaveDirectory); //returns void

	public function getLocalSaveDirectory(); // returns String

	public function setDeleteFile( $clientDeleteFile); //Boolean returns void


	public function  getDeleteFile(); //returns boolean

	public function getFileNames(); // returns FileNames


	public function getDocument(); // returns String


	public function getDocumentSourceFileName(); // returns String


	public function getDocumentType(); // returns String

	public function sendDocument( $fileName,  $documentData)
			; // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException //returns boolean

	public function  setOutPath( $clientFtpOutPath); //returns void

	public function getOutPath(); // returns String

	public function  connect() ; // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException returns boolean


	public function  setDocumentName( $string) ; // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException returns boolean

}