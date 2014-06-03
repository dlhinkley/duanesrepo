<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */



class Dhtechnologies_Ediconnectorbase_Model_Main {



	public function processDocuments() {

		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("start");
		
		$active = Dhtechnologies_Ediconnectorbase_Model_Config::isBaseActive();
		
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("active=$active");
		
		if ( $active ) {
			
		
			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("active start");
			
			$e = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Format_EdiFormat();
				
		
			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("active init");
			
			$e->startEdiDocumentProcessing();
		
			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("active processed");
		}
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("end");
	}
	public function runTester() {
		
		$inpath = Mage::getBaseDir('tmp') . DS.'ediconnector'.DS.'in';
		$outpath = Mage::getBaseDir('tmp') . DS.'ediconnector'.DS.'out';
		$localsave = Mage::getBaseDir('tmp') . DS.'ediconnector'.DS.'local';
		
		@mkdir ( $inpath,0777,true);
		@mkdir ( $outpath,0777,true);
		@mkdir ( $localsave,0777,true);
		
		// Clean out directory
		$files = glob($localsave.DS."*");
		array_map('unlink', $files);
		
		
		$test = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Tester();
		$test->run();
		
		
	}
	public function logDebug($message,$l=0) {


			// Indent number of levels
			$level = debug_backtrace();
			$pad = str_repeat(". ", count($level));
			$method = $level[1]['class'] . "::" . $level[1]['function'];
			$method = str_replace("Dhtechnologies_Ediconnectorbase_", "", $method);// Make the name shorter
			$message = "$pad$method $message";

			Mage::log($message,null,'ediconnector.log');
	}

	public function addError($message) {
		
		$inbox = Mage::getModel('adminnotification/inbox');
		$severity = Mage_AdminNotification_Model_Inbox::SEVERITY_MAJOR;
		$inbox->add($severity, "EdiConnector Error",$message, "", true);		
	}
	public function addSuccess($message) {
		
		$inbox = Mage::getModel('adminnotification/inbox');
		$severity = Mage_AdminNotification_Model_Inbox::SEVERITY_NOTICE;
		$inbox->add($severity, "EdiConnector Success",$message, "", true);		
	}

	public function logException(Exception $e) {
		
		self::logDebug("Exception: " .get_class($e). ". Error: " . $e->getMessage(),1);
		
		Mage::logException($e);
	}
	
	
}
?>
