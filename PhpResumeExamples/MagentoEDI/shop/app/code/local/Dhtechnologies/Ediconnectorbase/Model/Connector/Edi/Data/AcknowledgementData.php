<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */
 

class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Data_AcknowledgementData {
	
	private $functionalIdCode;
	private $groupControlNumber;
	private $rejected = false;
	private $transactionSets = 0;
	private $acknowledgeCode;
	
	/**
	 * @return the $acknowledgeCode
	 */
	public function getAcknowledgeCode() {
		return $this->acknowledgeCode;
	}

	/**
	 * @param field_type $acknowledgeCode
	 */
	public function setAcknowledgeCode($acknowledgeCode) {
		$this->acknowledgeCode = $acknowledgeCode;
	}
	/**
	 * @param field_type $acknowledgeCode
	 */
	public function setAcknowledgeCodeAccepted() {
		$this->acknowledgeCode = "A";
	}
	public function setAcknowledgeCodeRejected() {
		$this->acknowledgeCode = "R";
	}
	
	/**
	 * @return the $rejected
	 */
	public function getRejected() {
		return $this->rejected;
	}



	/**
	 * @param number $transactionSets
	 */
	public function setTransactionSets($transactionSets) {
		$this->transactionSets = $transactionSets;
	}



	public function isRejected() {
		
		return $this->rejected;
	}
	public function setRejected($bool) {
		
		$this->rejected = $bool;

		
		if ( $this->rejected ) {
			
			$this->acknowledgeCode = "R";
		}
		else {
			
			$this->acknowledgeCode = "A";
		}
	}
	public function incTransactionSets() {
		
		$this->transactionSets++;
	}
	public function getTransactionSets() {
		
		return $this->transactionSets;
	}
	public function setGroupControlNumber($str) {
		
		$this->groupControlNumber = $str;
	}
	public function getGroupControlNumber() {
		
		return $this->groupControlNumber;
	}
	public function setFunctionalIdCode($str) {
		
		$this->functionalIdCode = $str;
	}
	public function getFunctionalIdCode() {
		
		return $this->functionalIdCode;
	}

}