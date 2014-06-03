<?php


require_once('t/TestMaster.php');



$t = new Test();
$t->setDisplayWarnings();


$doc = <<<END
ISA*00*          *00*          *12*3058843131     *ZZ*TEAMWEB        *120911*1621*U*00401*856000106*0*P*>~
GS*SH*3058843131*TEAMWEB*20120911*1620*106*X*004010~
ST*856*0332~
BSN*00*20120910150138*20120911*153836~
HL*1**S~
TD5**2*FEDX~
REF*SI*680880770629782~
DTM*011*20120910~
HL*2**O~
PRF*000002435~
HL*3**I~
LIN*0001*VP*MS 18676 R~
SN1**1*EA~
CTT*3~
SE*13*0332~
ST*856*0333~
BSN*00*20120910150205*20120911*153839~
HL*1**S~
TD5**2*FEDX~
REF*SI*680880770629799~
DTM*011*20120910~
HL*2**O~
PRF*000002434~
HL*3**I~
LIN*0001*VP*JK-19967~
SN1**1*EA~
CTT*3~
SE*13*0333~
GE*2*106~
IEA*1*856000106~
END;

$doc = file_get_contents("t/documents/testfiles/856.edi");


// Empty the database
Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase::emptyOutBound();
Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase::emptyInBound();


// Put the document in the database
$inbound = Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase::getInboundModel();

$inbound->setDocumentType("856");
$inbound->setDocumentContent($doc);
$inbound->save();


$specs = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSpecs();
$specs->setEndLineDelimiter("~\r\n");

$edi856 = new Dhtechnologies_Ediconnector856in_Model_Connector_Edi_Core_Format_Action_EdiUpdateSalesOrderTrackingIn($specs);
//throw new Exception("break point");

print $t->ok(is_object($edi856),false);

$edi856->processEdiDocuments( "856", "In");


// Make sure there's a ack in the outbox
$outbound = Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase::getOutBoundDocuments("997",false);

print $t->ok($outbound->getSize() == 1, "getSize", $outbound->getSize() );

// Make sure the document is marked processed
$inbound = Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase::getInBoundDocuments("846",true);

print $t->ok($inbound->getSize() == 1, "getSize", $inbound->getSize() );


print $t->summary();
$t->destroy();


?>