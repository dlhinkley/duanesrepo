<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */
 
//require_once('java/HashMap.php');

class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSpecs {
	private $inLineDelimiter;  //  String
	private $endLineDelimiter;  //  String
	private $recordTypePosition = 1; // Integer
	private $quoteCharacter;  //  String
	private $documentType;
	private $direction;
	
	public function __construct() {
		
		$this->inLineDelimiter  =  "*";  //  String
	 	$this->endLineDelimiter  =  "~\n";  //  String
		$this->quoteCharacter  =  "";  //  String
		
	}

	/**
	 * @return the $documentType
	 */
	public function getDocumentType() {
		return $this->documentType;
	}

	/**
	 * @return the $direction
	 */
	public function getDirection() {
		return $this->direction;
	}

	/**
	 * @param field_type $documentType
	 */
	public function setDocumentType($documentType) {
		$this->documentType = $documentType;
	}

	/**
	 * @param field_type $direction
	 */
	public function setDirection($direction) {
		$this->direction = $direction;
	}

	/**
	 * The column position of the record type in the document
	 * @param recordTypePosition
	 */
	 public function setRecordTypePosition( $recordTypePosition) { // returns void
		$this->recordTypePosition = (int) $recordTypePosition;
	}
	 public function getInLineDelimiter() { // returns String
		return $this->inLineDelimiter;
	}
	 public function  setInLineDelimiter( $inLineDelimiter) { // returns void
		$this->inLineDelimiter = $inLineDelimiter;
	}
	 public function getEndLineDelimiter() { // returns String
		return $this->endLineDelimiter;
	}
	 public function  setEndLineDelimiter( $endLineDelimiter) { // returns void
		$this->endLineDelimiter = $endLineDelimiter;
	}
	 public function  getRecordTypePosition() { // returns void
		
		return $this->recordTypePosition;
	}
	/**
	 * Loads specs from configuration table
	 */
	 public function  loadSpecs() { // returns void
		 Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("=" .  10);
		 global $ediConfig;
		 
		$this->setEndLineDelimiter(Dhtechnologies_Ediconnectorbase_Model_Config::getEdiEndLineDelimiter());
		$this->setInLineDelimiter( Dhtechnologies_Ediconnectorbase_Model_Config::getEdiInLineDelimiter());
		$this->setQuoteCharacter( 	Dhtechnologies_Ediconnectorbase_Model_Config::getEdiQuoteCharacter( ) );
		$this->setRecordTypePosition( Dhtechnologies_Ediconnectorbase_Model_Config::getEdiRecordTypePosition());		
	}
	public function setQuoteCharacter( $string) { // returns void

		$this->quoteCharacter = $string;
	}
	public function getQuoteCharacter() { // returns String
		return $this->quoteCharacter;
	}

	
}
