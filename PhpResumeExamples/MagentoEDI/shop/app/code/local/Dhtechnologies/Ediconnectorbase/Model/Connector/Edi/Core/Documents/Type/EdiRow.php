<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */


class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiRow  {

	private  $row;
	function __construct() {
		$this->row = new Dhtechnologies_Ediconnectorbase_Model_Connector_Java_HashMap();
	}
	public function getValue( $fieldName) {
		
		(String) $string = "";

		if ( $this->row->containsKey( (String)$fieldName) ) {
		
			$string = $this->row->get((String)$fieldName);
		}
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(__METHOD__ . " fieldName=" . $fieldName . ",value=" . $string , 10);
		return (String) $string;
	}
	function setValue($field, $value) {

		$this->row->put((String) $field, (String) $value);
	}
	/**
	 * 
	 * Return all field names
	 * @return array
	 */
	function getFields() {

		return $this->row->keySet()->asArray();
	}
	public function toString() {
	
		return  (String) $this->row;
	}
} ?>
