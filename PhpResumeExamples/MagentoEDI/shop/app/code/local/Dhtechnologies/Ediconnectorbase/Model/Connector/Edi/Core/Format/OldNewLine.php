<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */
 

class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Format_OldNewLine {

	private $oldLine; // OrderLine
	private $newLine; // OrderLine

	public function put(Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Data_OrderLine $line,Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Data_OrderLine $newline) { // returns void

		$oldLine = line;
		$newLine = newline;
		
	}

	public function getOldLine() { // returns OrderLine
		return oldLine;
	}

	public function setOldLine(Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Data_OrderLine $oldLine) { // returns void
		$this->oldLine = oldLine;
	}

	public function getNewLine() { // returns OrderLine
		return newLine;
	}

	public function setNewLine(Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Data_OrderLine $newLine) { // returns void
		$this->newLine = newLine;
	}

}
