<?php


require_once('t/TestMaster.php');

$t = new Test();
$t->setDisplayWarnings();


$doc = <<<END
ISA*00*          *00*          *12*3058843131     *ZZ*TEAMWEB        *120911*1718*U*00401*846000233*0*P*>~
GS*IB*3058843131*TEAMWEB*20120911*1718*233*X*004010~
ST*846*0234~
BIA*00*DD*20120911164614*20120911~
N1*SU*TEAM INTERNATIONAL GROUP~
LIN*1*VP*AS 27222~
QTY*33*386*EA~
LIN*2*VP*AS 29091 AZ~
QTY*33*0*EA~
LIN*3*VP*AS 29091 R~
QTY*33*10*EA~
LIN*4*VP*BL 16909~
QTY*33*353*EA~
LIN*5*VP*BL 16911 AZ~
QTY*33*216*EA~
LIN*6*VP*BL 16911 MY~
QTY*33*184*EA~
LIN*7*VP*BL 16911 R~
QTY*33*274*EA~
LIN*8*VP*BL 24088 L~
QTY*33*0*EA~
CTT*8~
SE*21*0234~
GE*1*233~
IEA*1*846000233~
END;
$doc = file_get_contents("t/documents/testfiles/846.edi");

$specs = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSpecs();

$specs->setEndLineDelimiter("~\r\n");


$edi846 = Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiDocumentTypeFactory::getEdiDocumentType("846", "In", $specs);
//throw new Exception("break point");

print $t->ok(is_object($edi846),false);

$edi846->setDocument($doc);

$inventoryList = $edi846->getInventoryList();

print_r($inventoryList);
print $t->ok(is_object($inventoryList ),"object" );
print $t->ok($inventoryList->size() == 8,"size",$inventoryList->size());

print $t->ok($inventoryList->get(0)->getSku() == "AS 27222","Sku",$inventoryList->get(0)->getSku());
print $t->ok($inventoryList->get(0)->getQuantity() == "386","Quantity",$inventoryList->get(0)->getQuantity());

print $t->ok($inventoryList->get(7)->getSku() == "BL 24088 L","Sku",$inventoryList->get(0)->getSku());
print $t->ok($inventoryList->get(7)->getQuantity() == "0","Quantity",$inventoryList->get(0)->getQuantity());

print $t->summary();
$t->destroy();


?>