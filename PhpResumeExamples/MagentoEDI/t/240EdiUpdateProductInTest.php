<?php


require_once('t/TestMaster.php');



$t = new Test();
$t->setDisplayWarnings();

$doc = file_get_contents("t/documents/testfiles/832.edi");


// Empty the database
Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase::emptyOutBound();
Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase::emptyInBound();


// Put the document in the database
$inbound = Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase::getInboundModel();

$inbound->setDocumentType("832");
$inbound->setDocumentContent($doc);
$inbound->save();


$specs = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSpecs();
$specs->setEndLineDelimiter("~\r\n");

$edi832 = new Dhtechnologies_Ediconnector832in_Model_Connector_Edi_Core_Format_Action_EdiUpdateProductIn($specs);
//throw new Exception("break point");

print $t->ok(is_object($edi832),false);

$edi832->processEdiDocuments( "832", "In");


// Make sure there's a ack in the outbox
$outbound = Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase::getOutBoundDocuments("997",false);

print $t->ok($outbound->getSize() == 1, "getSize", $outbound->getSize() );

// Make sure the document is marked processed
$inbound = Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase::getInBoundDocuments("832",true);

print $t->ok($inbound->getSize() == 1, "getSize", $inbound->getSize() );


print $t->summary();
$t->destroy();


?>