<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */

 class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiRows {

	 private $rows;
	 
         function __construct() {
             
             $this->rows = new Dhtechnologies_Ediconnectorbase_Model_Connector_Java_Vector();
         }
	 function addRow( Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiRow $ediRow) {
 	
	 	$this->rows->add($ediRow);
	 	Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( " new size=".$this->rows->size(),10);
	 }

	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $recordNumber
	 * @return EdiRow
	 */
	public function  getRow($recordNumber) {

            Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" recordNumber=$recordNumber",10);
            
		return $this->rows->get((int)$recordNumber);
	}

	public function size() {

		return (int) $this->rows->size();
	}
	public function  toString() {
		
		return (String) $this->rows;
	}
} ?>
