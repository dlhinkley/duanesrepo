<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */
 

class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Format_EdiConfigAction {

	private $sequenceNum = 0;// int
	private $documentType;  //  String
	private $actionType;  //  String
	private $processCodes;  //  String
	private $direction;
	
	public function __construct(Mage_Core_Model_Config_Element  $actionDefinition) {
		$this->sequenceNum =  (string) $actionDefinition->sequenceNum;
		$this->documentType =  (string) $actionDefinition->documentType;
		$this->actionType =  (string) $actionDefinition->actionType;
		$this->processCodes =  (string) $actionDefinition->processCodes;
		$this->direction =  (string) $actionDefinition->direction;
		
	}
	
	public function getSequenceNum() {//returns int
		return $this->sequenceNum;
	}
	
	public function setSequenceNum(int $inSequenceNum) { // returns void
		$this->sequenceNum = $inSequenceNum;
	}	
	
	public function getDocumentType() {		 // returns String
		return $this->documentType;
	}

	public function  setDocumentType( $inDocumentType) { // returns void
		$this->documentType = $inDocumentType;
	}

	public function getActionType() { // returns String
		return $this->actionType; 
	}
	
	public function  setActionType( $inActionType) { // returns void
		$this->actionType = $inActionType;
	}
	
	public function getProcessCodes() { // returns String
		return $this->processCodes; 
	}
	
	public function  setProcessCodes( $inProcessCodes) { // returns void
		$this->processCodes = $inProcessCodes;
	}
	public function getDirection() {
		
		return $this->direction;
	}
	
}