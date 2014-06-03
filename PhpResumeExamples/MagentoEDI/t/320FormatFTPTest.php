<?php 

require_once('t/TestMaster.php');

//require_once("connector/edi/core/format/EdiFormat.php");




$t = new Test();
$t->setDisplayWarnings();


// Test FTP Initilization
Dhtechnologies_Ediconnectorbase_Model_Config::setEdiTransportType("FTP");
 	 	
$e = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Format_EdiFormat();

// Process local file system documents
$e->startEdiDocumentProcessing();

print $t->ok(is_object($e),'process docs');



// // Check the outbox for the appropriate documents
// $inbound = Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase::getInBoundDocuments("846",true);

// print $t->ok($inbound->getSize() == 1, "846 getSize", $inbound->getSize() );


// $inbound = Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase::getInBoundDocuments("856",true);

// print $t->ok($inbound->getSize() == 1, "856 getSize", $inbound->getSize() );


// // Check the outbox for the appropriate documents
// $outbound = Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase::getOutBoundDocuments("997",false);

// print $t->ok($outbound->getSize() == 3, "getSize", $outbound->getSize() );


// $outbound = Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase::getOutBoundDocuments("850",false);

// print $t->ok($outbound->getSize() == 1, "getSize", $outbound->getSize() );



print $t->summary();
$t->destroy();

	
	
//}