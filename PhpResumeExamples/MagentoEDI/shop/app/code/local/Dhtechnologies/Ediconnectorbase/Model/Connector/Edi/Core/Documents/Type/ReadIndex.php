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
 * 
 * Indexes documents being read so we can read them
 * sequential.  This is because some documents have records of the same
 * type that are for different orders.  Our present code groups all types
 * together and you can't tell which is for which order
 * @author dlhinkley
 *
 */
class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_ReadIndex {
	
	private $def;
	
	private $typeIndex = array();
	/**
	 * Used reading the index to keep track of which to use
	 * @var array
	 */
	private $nthTypeCounter = array();
	
	public function add($recordType) {
		
		$this->typeIndex[] = $recordType;
		//Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( "typeIndex=".var_export($this->typeIndex,true),10);
	}
	public function setDefinition($def) {
		
		$this->def = $def;
	}
	/**
	 * 
	 * return the number of index records
	 */
	public function size() {
		
		//Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( "typeIndex=".var_export($this->typeIndex,true),10);
		return count($this->typeIndex);
	}
	/**
	 * 
	 * Should only be called once sequencially as in a loop
	 * @param int $m
	 * @return EdiRow
	 */
	public function getEdiRow($m) {
			
		
		$recordType = $this->typeIndex[$m];
		
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( "m=$m, recordType=$recordType",10);
		
		// set type counter
		if ( ! isset($this->nthTypeCounter[$recordType] ) ) {
			
			$this->nthTypeCounter[$recordType] = 1;
		}
		else {
			
			$this->nthTypeCounter[$recordType] ++;
		}
		
		$recordNum = $this->nthTypeCounter[$recordType];
		
		// Get all the fields
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( "recordNum=$recordNum, fields=".var_export($this->def->keySet()->asArray(),true),10);
		
		$ediFields = $this->def->get($recordType);
		
		$ediRow = $ediFields->getRow($recordNum -1); // zero based

		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( "get_class=".get_class($ediRow),10);
		
		return $ediRow;
	}
	public function getEdiFields($m ) {
		
		
	}
	public function getRecordType($m) {
		
		return $this->typeIndex[$m];
	}
}