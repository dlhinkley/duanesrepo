<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */

class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiDocumentTypeFactory {

	public static function getEdiDocumentType($documentType, $direction, $documentSpecs) {

		$ediType = null;
		$active = Dhtechnologies_Ediconnectorbase_Model_Config::isDocumentActive($documentType,$direction);
		
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("active=$active" , 10);
		
		if (  $active ) {
			$documentSpecs->setDocumentType($documentType);
			$documentSpecs->setDirection($direction);
			
			$moduleName = self::getModuleName($documentType,$direction);
			
			$documentDefinitionFilePath = self::getDocumentDefinitionFilePath($direction,$documentType);
	
	    	$ediDocumentDefinition  = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiDocumentDefinitionCommon($documentSpecs ,$documentDefinitionFilePath,$direction,$documentType);
    	
    	
    		$typeClassName = "Dhtechnologies_".$moduleName."_Model_Connector_Edi_Core_Documents_Type_Edi".$documentType.$direction;
		
    		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("typeClassName=$typeClassName" , 10);
    		
    		$ediType = new $typeClassName($ediDocumentDefinition ,$documentSpecs);
		}
		return $ediType;
	}
	public static function getModuleName($documentType,$direction) {

		$documentPackagesList = Mage::getConfig()->getNode('global/ediconnectorbase')->documentPackages;
		$direction = strtolower($direction);
		
    	$nodeName = "edi$documentType$direction";
    	
    	if ( isset($documentPackagesList->$nodeName ) && (string) $documentPackagesList->$nodeName != "" ) {
    		
    		$moduleName = (string) $documentPackagesList->$nodeName;
    	}
    	else {
    		
    		$moduleName = "Ediconnectorbase";
    	}
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("nodeName=$nodeName, moduleName=$moduleName " , 10);
    	return $moduleName;
   	}
	private static function getDocumentDefinitionFilePath($direction,$documentType) {
		
		$calledModulePath = Dhtechnologies_Ediconnectorbase_Model_Config::getModuleDir();
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(__METHOD__."calledModulePath=$calledModulePath",10);
		
		$direction = ucfirst($direction);
		
		$moduleName = self::getModuleName($documentType,$direction);
		
		
		$thisModulePath = str_replace("Ediconnectorbase",$moduleName, $calledModulePath);
		
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(__METHOD__."thisModulePath=$thisModulePath",10);
		
		return $thisModulePath.DS."Edi".$documentType."DocumentDefinition.xml";
		
	}
}