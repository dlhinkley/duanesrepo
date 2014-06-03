<?php
require_once('t/TestMaster.php');



$t = new Test();
$t->setDisplayWarnings();

// Empty the database
Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase::emptyOutBound();
Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase::emptyInBound();

// Reset flag on test order
$order = Mage::getModel('sales/order')->load(1);
$order->setEdiSent(0);
$order->setStatus('pending');
$order->save();


$documentSpecs = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSpecs();

$edi850 = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Format_Action_EdiSendSalesOrderOut( $documentSpecs);

print $t->ok(is_object($edi850),false);

$edi850->processEdiDocuments( "850", "Out");


// Make sure there's a 850 and ack in the outbox
$outbound = Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase::getOutBoundDocuments("997",false);


print $t->ok($outbound->getSize() == 2, "getSize", $outbound->getSize() );




print $t->summary();
$t->destroy();



	
?>