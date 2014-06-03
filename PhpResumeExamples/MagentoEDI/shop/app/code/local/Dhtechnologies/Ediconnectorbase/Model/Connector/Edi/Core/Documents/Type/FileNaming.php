<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */

class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_FileNaming implements  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_FileNamingInterface {

	function getDocumentType( $documentName,  $documentContent ) { // throws  EdiTypeException returns String

		$type = null;
		
		$inLineDelimiter = Dhtechnologies_Ediconnectorbase_Model_Config::getEdiInLineDelimiter();
		$endLineDelimiter = Dhtechnologies_Ediconnectorbase_Model_Config::getEdiEndLineDelimiter();
		$recordTypePosition = Dhtechnologies_Ediconnectorbase_Model_Config::getEdiRecordTypePosition();
		$recordTypeElement = Dhtechnologies_Ediconnectorbase_Model_Config::getEdiRecordTypeElement();
		
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("endLineDelimiter='$endLineDelimiter', recordTypeElement=$recordTypeElement,  recordTypePosition=$recordTypePosition" , 10);
		
		$lines = explode($endLineDelimiter,$documentContent);
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("lines=".var_export($lines,true) , 10);
		
		if ( count($lines) < 2 ) {
			
			throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiTypeException("Error reading document type.  Verify end line delimiter is set correctly for file:".$documentName);
		}
		foreach ($lines AS $line ) {
			
			$fields = explode($inLineDelimiter,$line);
			
			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("fields=".var_export($fields,true) , 10);
			// Look for the ST record
			//
			if ( isset($fields[0]) && trim($fields[0]) == $recordTypeElement ) {
				
				$type = trim($fields[ $recordTypePosition ]);
				Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("type=$type" , 10);
			}
		}
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" documentType = $type" , 10);
		
		if ( $type === null || $type == "") {
			
			throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiTypeException("Error determining document type for file: ".$documentName);			
		}
		return $type;
	}
	public function getFilename() {
		
		// If a suffix is required, use it.  Otherwise default to edi
		//
		$suffix = Dhtechnologies_Ediconnectorbase_Model_Config::getClientFtpOutboundSuffix();
		
		if ( $suffix == null || $suffix == "" ) {
			
			$suffix = 'edi';
		}
		return date("YmdHis")  .  rand(0, 999)  .   "."  .  $suffix;
	}
}