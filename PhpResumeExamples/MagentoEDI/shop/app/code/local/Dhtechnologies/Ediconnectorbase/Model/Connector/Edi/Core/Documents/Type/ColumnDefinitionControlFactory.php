<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */

class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_ColumnDefinitionControlFactory {

	public static function getColumnDefinitionControl(SimpleXMLElement $lineDefinition, $documentSpecs) {
		
		$documentType = $documentSpecs->getDocumentType();
		$direction = $documentSpecs->getDirection();
		
		$className = self::getClassName($documentType,$direction);
		
    	     	
    	return new $className($lineDefinition);
    	 	
	}
	private static function getClassName($documentType,$direction) {
				
    	$columnDefinitionControlClassList = Mage::getConfig()->getNode('global/ediconnectorbase')->columnDefinitionControlClasses;
    	$nodeName = "edi$documentType$direction";
    	
    	if ( isset($columnDefinitionControlClassList->$nodeName ) && (string) $columnDefinitionControlClassList->$nodeName != "" ) {
    		
    		$moduleName = (string) $columnDefinitionControlClassList->$nodeName;
    	}
    	else {
    		
    		$moduleName = "Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_ColumnDefinitionControl";
    	}
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("nodeName=$nodeName, moduleName=$moduleName " , 10);
		
    	return $moduleName;
   	}

}