<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */

class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Tester {

	private $args;
	private $syntax = 	"Tester.php -h --help\nTester.php -n (run a normal process)\n             direction    type\n Tester.php -d in        -t 850\n";
	public function __construct() {
		
		$this->args = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Args();
		
	}
	
	public function run() {
		
		// A normal run
		if ( $this->args->flag('n') ) {
			
			print "processing start\n\n";
			Dhtechnologies_Ediconnectorbase_Model_Main::processDocuments();
			print "\nprocessing end\n";
		}
		else if ( $this->args->flag('t') &&  $this->args->flag('d')) {
			
			$documentType = $this->args->flag('t');
			$direction = $this->args->flag('d');
			
			$this->documentTest($documentType  , $direction );
		}
		else if ( $this->args->flag('h')  || $this->args->flag('help') ) {
			
			print $this->syntax;
		}
		else {
			
			print $this->syntax;
		}
	}
	private function documentTest($documentType, $direction ) {
		
		Dhtechnologies_Ediconnectorbase_Model_Config::setTestMode(true);
		Dhtechnologies_Ediconnectorbase_Model_Config::setEdiTransportType("LOCALFS");

 	 	Dhtechnologies_Ediconnectorbase_Model_Config::setClientFtpSaveLocalSent(1);
		Dhtechnologies_Ediconnectorbase_Model_Config::setClientFtpInPath($inpath);
		Dhtechnologies_Ediconnectorbase_Model_Config::setClientFtpOutPath($outpath);
		Dhtechnologies_Ediconnectorbase_Model_Config::setClientFtpSaveLocalSentDocumentPath($localsave);
		
		$format = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Format_EdiFormat();
		
		$format->startEdiDocumentProcessing($documentType,$direction);
		
	}
}