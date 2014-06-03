<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */
 

class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_FileName {

	private $fileName;  //  String
	private $filePath;  //  String
	
	public function __construct( $inFileName = null) {
		
		
		$this->fileName  =$inFileName;  //  String
		$this->filePath  =  "";  //  String
	}
	
	public function FileNameWithPath( $inFileName,  $inFilePath) {

		$this->fileName = $inFileName;
		$this->filePath = $inFilePath;
	}

	public function getFileName() {		 // returns String
		return $this->fileName;
	}

	public function  setFileName( $inFileName) { // returns void
		$this->fileName = $inFileName;
	}

	public function getFilePath() { // returns String
		return $this->filePath;
	}

	public function  setFilePath( $filePath) { // returns void
		$this->filePath = $filePath;
	}
		
}