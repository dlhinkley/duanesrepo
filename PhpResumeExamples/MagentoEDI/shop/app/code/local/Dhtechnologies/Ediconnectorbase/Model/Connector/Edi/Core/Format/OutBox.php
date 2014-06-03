<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */
 //require_once('java/ArrayList.php');//require_once('java/StringUtils.php');

class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Format_OutBox   {

	private $text; // ArrayListString
	private $recordId; // ArrayListInteger
	public function __construct() {

		$text = new Dhtechnologies_Ediconnectorbase_Model_Connector_Java_ArrayListString();
		$recordId = new Dhtechnologies_Ediconnectorbase_Model_Connector_Java_ArrayListInteger();
	}

	public function  addText( $string) { // returns void

	 $text->add($string);
	}	
	public function addId(Integer $string) { // returns void

	 $recordId->add($string);
	}
	/**
	 * Returns all text joined with returns
	 * @return
	 */
	public function getCombinedText() { // returns String

		return StringUtils.join( $this->text,"\n");
	}
	/**
	 * Returns all id's joined with ','
	 * @return
	 */
	public function getCombinedId() { // returns String

		return StringUtils.join( $this->recordId,",");
	}

	public function getTextSize() {

		return $text->size();
	}
}
