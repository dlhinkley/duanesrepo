<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */




class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_FTPSendReceive extends Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_SendReceiveCommon {

	public function __construct() { // returns FTPSendReceiv


		parent::__construct();
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("contructed", 10);
	}

	protected $ftp; // FTPClient


	public function  connect() { // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException  { // returns boolean

		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("" , 10);



		try {
			$this->ftp = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_FTPClient();
			$this->ftp->connect($this->address);
			$this->ftp->login($this->userName, $this->password);
			$this->ftp->pasv(true);


			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("FTP connected" , 10);
		}
		catch (Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_FTPClientException $e ) {
			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("init(): " . $e->getMessage() , 10);

			throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException("Error Creating FTP Connection. ".$e->getMessage());
		}


		return  true;

	}


	
	public function  setFileNames()  { // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException  { // returns boolean

		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("" , 10);
		$foundFiles = false;

		$this->fileNames = new Dhtechnologies_Ediconnectorbase_Model_Connector_Java_VectorFileName();

		$fileList = new Dhtechnologies_Ediconnectorbase_Model_Connector_Java_HashMapStringString(); // HashMapStringString




		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("Transport=FTP", 10);
		try {

			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("chdir inPath=" . $this->inPath, 10);

			$dirFiles = $this->ftp->nlist($this->inPath);//String[]

			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" dirFiles=" . var_export($dirFiles,true) , 10);



			foreach ( $dirFiles AS $fileName ) {

				$foundFiles = true;

				// Remove path from filename
				$fileName = basename( $fileName);

				// Only add file to list if no extension required or it matches
				if ( ! $this->isInboundExtensionMatchRequired() || $this->isInboundExtensionMatch($fileName) ) {
					
					$fn =  new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_FileName();
					
					$fn->FileNameWithPath($fileName,$this->inPath); // FileName
	
					$this->fileNames->add($fn);
					Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("add file name=" .$fn->getFileName() , 10);
				}

			}


			if ( ! $foundFiles ) {
					
				$foundFiles = false;
			}

		}
		catch (Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_FTPClientException $e ) {
			$foundFiles = false;
			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("getFileList(): " . $e->getMessage() , 10);
			throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException( "Error Getting File List via FTP. ".$e->getMessage());
		}

		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("foundFiles=" . $foundFiles , 10);

		return $foundFiles;

	}

	public function  setDocumentByString(Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_FileName $fn ) { // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException  { // returns boolean
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" start", 10);

		$documentReceived = false;//boolean

		$this->documentContent = "";


		try {

			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" document = " . $fn->getFilePath() . $fn->getFileName() , 10);


			$this->recieveViaFtp($fn);


			if ( $this->deleteFile ) {

				$this->deleteFile($fn);
			}
			else {
				
			}

		}
		catch (Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_FTPClientException $e ) {

			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( $e->getMessage() , 10);
			//print(' '. $e->getMessage() ."\n");
			throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException( "Error Receiving Document. ".$e->getMessage());
		}
		catch (Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_FTPClientException $e ) {

			throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException( "Error Determining Document Type. ".$e->getMessage());
		}

			
			
		$directory =  new Dhtechnologies_Ediconnectorbase_Model_Connector_Java_File ($this->localSaveDirectory); // File

		if ( $this->localSave && $this->localSaveDirectory != '') {

			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("setDocumentByString(): localSave Directory " . $directory->getAbsolutePath() . "\\" . $fn->getFileName(), 10);

			if (  file_put_contents($directory->getAbsolutePath() . DS . $fn->getFileName(), $this->documentContent)=== false ) {
					
					
				throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException( "Error Saving Local Document to ".$directory->getAbsolutePath() . DS . $fn->getFileName());
			}


		}
			
			
	}

	private function recieveViaFtp(Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_FileName $fn) { // throws  IOException, Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException, EdiTypeException  { // returns boolean


		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("filename=" . $fn->getFileName() , 10);

		$documentName = $fn->getFileName(); // String
		$path = $this->inPath; // String

		if ($fn->getFilePath() != null && ! $fn->getFilePath() =="") {

			$this->ftp->chdir($fn->getFilePath());
			$path = $fn->getFilePath();
		}
		else {


		}
		$tempHandle = fopen('php://temp', 'r+');


		try {


			// need binary transfer so line feeds don't get converted
		 $this->ftp->fget($tempHandle, $documentName,FTP_BINARY);
		 rewind($tempHandle);

		 $this->documentContent = stream_get_contents($tempHandle);


		}
		catch (Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_FTPClientException $e ) {

			throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException($e->getMessage() . ", Failure receiving document " . $documentName);
		}
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("Creating Reader for " . $path . " " . $documentName , 10);
	
		$this->documentSourceFileName = $documentName;

		$fileNaming =  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_FileNamingFactory::getFileNaming(); // FileNamingInterface

		$this->documentType = $fileNaming->getDocumentType($documentName, $this->documentContent );


		if (strlen($this->documentContent) < 10000) {
			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("documentContent = \n" . $this->documentContent , 10);
		} else {
			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("received document with length " .strlen($this->documentContent) , 10);
		}
		

	}

	public function  deleteFile(Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_FileName $fn)  { // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException  { // returns boolean


		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("start", 10);
		$fileDeleted = false;
		$fileToDelete = null; // String

		if ( !$fn->getFilePath() == "") {

			$fileToDelete = $fn->getFilePath() .'/'. $fn->getFileName();
		}
		else {
			$fileToDelete =  $this->inPath . $fn->getFileName();
		}


		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("deleteFile(): deleting file: " . $fileToDelete, 10);

		try {
			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("MyFTP:deleteFile -  deleting file: " . $fileToDelete, 10);

			$fileDeleted = $this->ftp->delete($fileToDelete);
		}
		catch (Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_FTPClientException $e ) {

			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("deleteFile() : " . $e->getMessage() , 10);
			throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException ("Unable to delete File: " . $fileToDelete.". ".$e->getMessage());
		}

		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("fileDeleted=" . $fileDeleted, 10);
			

		return $fileDeleted;


	}

	public function  disconnect() { // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException  { // returns void

		
		try {
		$this->ftp->close();
		}
		catch ( Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_FTPClientException $e) {
			
			// No big deal it's probly already disconnected
			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug ( "exception=".$e->getMessage(), 10 );
				
		}
	}

	/**
	 * If the path is missing a / on the end, it adds one.
	 * @param path
	 * @return
	 */
	private function suffixPath( $path) { // returns String
		
	}



	public function  testConnect() { // returns boolean
		
	}


	public function sendDocument( $fileName,  $documentData ) { // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException  { // returns boolean
			
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( "documentName=" . $fileName, 8);
		$documentSent = false;//boolean



			
		try {
			 
			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("fullPath = " . $this->outPath . $fileName , 10);
				
			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("chdir outPath=" . $this->outPath, 10);
			$this->ftp->chdir($this->outPath);
				
				
			$this->putString($fileName,$documentData);
			$documentSent = true;
				
				
		}
		catch (Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_FTPClientException $e ) {
			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( $e->getMessage() , 10);
			throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException("Error Sending Document. ".$e->getMessage());
		}
		

		$directory =  new Dhtechnologies_Ediconnectorbase_Model_Connector_Java_File ($this->localSaveDirectory); // File

		if ( $this->localSave ) {
				
			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("localSave Directory " . $directory->getAbsolutePath() . $this->localFileSeperator . $fileName, 10);

			if ( ! $directory->exists() ) {

				$directory->mkdir();
			}

			$this->writeLocalFile($directory->getAbsolutePath(),$fileName, $documentData);

		}
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("end documentSent=" . $documentSent, 10);
		return $documentSent;

	}
	private function writeLocalFile( $path,  $filename, $data) {

		$handle = fopen($path. $this->localFileSeperator . $filename,'w');

		if ( $handle === false ) {
				
			throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException("Error creating file ".$filename, 99);
		}
		$r = fwrite($handle,$data);

		if ( $r === false ) {
				
			throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException("Error writing file ".$filename, 99);
		}
		$r = fclose($handle);

		if ( $r === false ) {
				
			throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException("Error closing file ".$filename, 99);
		}

	}
	private function putString( $fileName, $data) {

		$tempHandle = fopen('php://temp', 'r+');
		fwrite($tempHandle, $data);
		rewind($tempHandle);

		$this->ftp->fput($fileName,  $tempHandle,FTP_ASCII);

	}

}
