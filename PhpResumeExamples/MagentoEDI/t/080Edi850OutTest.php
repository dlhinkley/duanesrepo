<?php
require_once('t/TestMaster.php');



$t = new Test();
$t->setDisplayWarnings();




$documentSpecs = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSpecs();

$edi850 = Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiDocumentTypeFactory::getEdiDocumentType("850", "Out", $documentSpecs);

print $t->ok(is_object($edi850),false);
$order = Mage::getModel('sales/order')->load(1);

$edi850->setDocument($order);

$test = $edi850->getDocument();
print "Document=\n$test\n";

print $t->ok(strlen($test) > 0 ,"",$test);



print $t->summary();
$t->destroy();



	
?>