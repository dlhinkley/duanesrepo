<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */


class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_LocalFsSendReceive extends Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_SendReceiveCommon {

	public function __construct() { // returns FTPSendReceiv

		parent::__construct();
		
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("contructed", 10);
	}



	public function  connect() { // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException  { // returns boolean

		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("" , 10);


		return  true;

	}

	public function  setFileNames()  { // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException  { // returns boolean

		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("" , 10);
		$foundFiles = false;

		$this->fileNames = new Dhtechnologies_Ediconnectorbase_Model_Connector_Java_VectorFileName();

		$fileList = new Dhtechnologies_Ediconnectorbase_Model_Connector_Java_HashMapStringString(); // HashMapStringString


		$handle = opendir($this->inPath);
		$dirFiles = array();
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != ".." && $entry != "CVS") {
				
				$dirFiles[] = $entry;
			}
		}
		closedir($handle);
			
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("inPath=".$this->inPath. " dirFiles=" . var_export($dirFiles,true), 10);

		if ( $dirFiles === false ) {

			throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException("Error Getting File List via LocalFS");

		}
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" dirFiles=" . var_export($dirFiles,true) , 10);


			
		foreach ( $dirFiles AS $fileName ) {

			$foundFiles = true;
			
			// Only add file to list if no extension required or it matches
			if ( ! $this->isInboundExtensionMatchRequired() || $this->isInboundExtensionMatch($entry) ) {
					
				$fn =  new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_FileName();
				$fn->FileNameWithPath($fileName,$this->inPath); // FileName
				$this->fileNames->add($fn);
				Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" add file name=" .$fn->getFileName() , 10);
			}
		}
			

		if ( ! $foundFiles ) {

			$foundFiles = false;
			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("getFileList:  No File To Pickup via LOCALFS", 10);
			//TODO Caused by an empty directory which is not really an error
			//An incorrect directory name could cause this, which would be an error
			throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException("Error No File To Pickup via LocalFS");
		}

			

		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("foundFiles=" . $foundFiles , 10);

		return $foundFiles;

	}

	public function  setDocumentByString(Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_FileName $fn ) { // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException  { // returns boolean
		
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" start", 10);

		$documentReceived = false;//boolean

		$this->documentContent = "";


			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" document = " . $fn->getFilePath() . $fn->getFileName() , 10);



			$documentReceived = @file_get_contents($fn->getFilePath() . $fn->getFileName() );

			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" documentReceived=".$documentReceived,10);
			
			if ( $documentReceived === false ) {
				throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException( "Error Receiving Document");
			}
			else {
				
				$this->documentContent = $documentReceived;
				$this->documentSourceFileName = $fn->getFileName();
				
				$fileNaming =  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_FileNamingFactory::getFileNaming(); // FileNamingInterface
		
				$this->documentType = $fileNaming->getDocumentType($fn->getFileName(), $this->documentContent );
				
			}

			$documentReceived = $this->documentContent;

			if ( $documentReceived && $this->deleteFile ) {

				$documentReceived = $this->deleteFile($fn);
			}


			
			
		$directory =  new Dhtechnologies_Ediconnectorbase_Model_Connector_Java_File ($this->localSaveDirectory); // File

		if ( $this->localSave && $this->localSaveDirectory != '') {

			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("setDocumentByString(): localSave Directory " . $directory->getAbsolutePath() . DS . $fn->getFileName(), 10);

			if (  file_put_contents($directory->getAbsolutePath() . DS . $fn->getFileName(), $this->documentContent)=== false ) {
					
					
				throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException( "Error Saving Local Document to ".$directory->getAbsolutePath() . DS . $fn->getFileName());
			}


		}
			
		return $documentReceived;
			
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

		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("  deleting file: " . $fileToDelete, 10);

		$fileDeleted = unlink($fileToDelete);

		if ( $fileDeleted === false ) {

			throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException( "Unable to delete File: " . $fileToDelete);
		}
			

		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("fileDeleted=" . $fileDeleted, 10);
			

		return $fileDeleted;


	}

	public function  disconnect() { // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException  { // returns void
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

		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( "fileName=" . $fileName, 8);
		$documentSent = false;//boolean

			
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("fullPath = " . $this->outPath . $fileName , 10);



		

		$wrote = file_put_contents($this->outPath.DS.$fileName,$documentData);
			
		if ( $wrote === false ) {

			throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException("Error ending Document");
		}
		$documentSent = true;
		
			
		$directory =  new Dhtechnologies_Ediconnectorbase_Model_Connector_Java_File ($this->localSaveDirectory); // File

		if ( $this->localSave ) {

			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("localSave Directory " . $directory->getAbsolutePath() . $this->localFileSeperator . $fileName, 10);

			if ( ! $directory->exists() ) {

				$directory->mkdir();
			}

			$this->writeLocalFile($directory->getAbsolutePath(),$fileName, $documentData);

		}
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("documentSent=" . $documentSent, 10);
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


}
