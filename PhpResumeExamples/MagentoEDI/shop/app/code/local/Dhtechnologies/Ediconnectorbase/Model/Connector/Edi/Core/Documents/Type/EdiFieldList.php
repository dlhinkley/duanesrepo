<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */

class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiFieldList   {

	private $list;//Vector<EdiField> 
	private $it;//Iterator<EdiField> 

	function __construct() {
		$this->list = new Dhtechnologies_Ediconnectorbase_Model_Connector_Java_Vector();
	}
	function addValue(Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiField $field) {//EdiField
		
		$this->list->add($field);
		
	}
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $pos
	 * @return EdiField
	 */
	function getValue($pos) { //EdiField
		
		 $value = null;//EdiField
		
		if ( $this->list->size() >= $pos + 1) {
			
			$value = $this->list->get($pos);
		}
		return $value;
	}
	function getSize() {
		
		return (int) $this->list->size();
	}

	/**
	 * Given the field position, return the name
	 * @param m
	 * @return
	 */
	function getFieldName($position) {

		//Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" start",10);
		
		$name = null;
		
		$m = 0;
		while ( $name == null && $m < $this->list->size() ) {
			
			 $ediField = $this->list->get($m);//EdiField

			//Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("  getPosition=".$ediField->getPosition(),10);
			
			 if ( $ediField->getPosition() == (int) $position) {
				
				$name = $ediField->getFieldName();
			}
			$m++;
		}
		//Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" end name=$name, position=$position list->size=".$this->list->size(),10);
		
		return (String) $name;
	}
	public function toString() {
		
		return  (String) $this->list;
	}
} ?>
