<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */
 
class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_FileNamingFactory {

	public function  getFileNaming() { // FileNamingInterface
		
			$fn = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_FileNaming();
		
		return $fn;
	}
}
