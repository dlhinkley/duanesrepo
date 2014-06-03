<?php 

require_once('t/TestMaster.php');

//require_once("connector/edi/core/format/EdiFormat.php");




$t = new Test();
$t->setDisplayWarnings();



	 $root  =  "src/connector/edi/core/transport/testfiles/" ;  //  
	 $inpath  =  "t/documents/remote/in/" ;  //  
	 $outpath  =  "t/documents/remote/out/" ;  //  
	 $localSave  =   "t/documents/local/";  //  String
	 
	 
	 // Setup test files
	 deleteAll("t/documents/remote/in/");
	 deleteAll("t/documents/remote/out/");
	 
	 copy("t/documents/testfiles/846.edi","t/documents/remote/in/846.edi");
	 copy("t/documents/testfiles/856.edi","t/documents/remote/in/866.edi");
	 
	// Empty the database
	Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase::emptyOutBound();
	Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase::emptyInBound();
	
	// Reset flag on test order
	$order = Mage::getModel('sales/order')->load(1);
	$order->setEdiSent(0);
	$order->setStatus('pending');
	$order->save();
		 	 
	 
	 
	 
	 //Dhtechnologies_Ediconnectorbase_Model_Config::setInPath($inpath);
	 //Dhtechnologies_Ediconnectorbase_Model_Config::setLocalSave(true);
	// Dhtechnologies_Ediconnectorbase_Model_Config::set->setLocalFileSeperator(new String("/"));
	 Dhtechnologies_Ediconnectorbase_Model_Config::setClientFtpSaveLocalSent($localSave);		
	 Dhtechnologies_Ediconnectorbase_Model_Config::setClientFtpConfirmationSuffix("ok");
	 //$this->transport->setAddress(Dhtechnologies_Ediconnectorbase_Model_Config::setClientFtpAddress());
	 //$this->transport->setUsername(Dhtechnologies_Ediconnectorbase_Model_Config::setClientFtpUserName());
	 //$this->transport->setPassword(Dhtechnologies_Ediconnectorbase_Model_Config::setClientFtpPassword());
 	 Dhtechnologies_Ediconnectorbase_Model_Config::setClientFtpInPath($inpath);
 	 Dhtechnologies_Ediconnectorbase_Model_Config::setClientFtpOutPath($outpath);
 	 Dhtechnologies_Ediconnectorbase_Model_Config::setClientFtpSaveLocalSent(true);
 	 Dhtechnologies_Ediconnectorbase_Model_Config::setClientFtpSaveLocalSentDocumentPath($localSave);
	 //$this->transport->setDeleteFile(Dhtechnologies_Ediconnectorbase_Model_Config::setClientFtpDeleteReceivedFile());
	 

// Test Local FS initilization
$e = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Format_EdiFormatIn();
Dhtechnologies_Ediconnectorbase_Model_Config::setEdiTransportType("LOCALFS");

print $t->ok(is_object($e),'local fs init');

// Process local file system documents
$e->receiveAllDocuments();

print $t->ok(is_object($e),'process docs');


// Check the outbox for the appropriate documents
$inbound = Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase::getInBoundDocuments("846",false);

print $t->ok($inbound->getSize() == 1, "getSize", $inbound->getSize() );

$inbound = Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase::getInBoundDocuments("856",false);

print $t->ok($inbound->getSize() == 1, "getSize", $inbound->getSize() );



print $t->summary();
$t->destroy();

	
	
//}