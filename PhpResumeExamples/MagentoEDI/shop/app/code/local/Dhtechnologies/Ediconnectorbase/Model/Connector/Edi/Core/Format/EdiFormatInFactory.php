<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */
 


class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Format_EdiFormatInFactory {

	public function   getEdiFormatIn() {//EdiFormatInInterface
	
			$formatIn = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Format_EdiFormatIn();
		return $formatIn;
	}
}
