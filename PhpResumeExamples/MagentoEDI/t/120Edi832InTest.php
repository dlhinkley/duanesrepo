<?php


require_once('t/TestMaster.php');

$t = new Test();
$t->setDisplayWarnings();



$doc = file_get_contents("t/documents/testfiles/832.edi");

$specs = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSpecs();

$specs->setEndLineDelimiter("~\r\n");


$edi832 = Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiDocumentTypeFactory::getEdiDocumentType("832", "In", $specs);
//throw new Exception("break point");

print $t->ok(is_object($edi832),false);

$edi832->setDocument($doc);

$productList = $edi832->getProductList();

print_r($productList);
print $t->ok(is_object($productList ),"object" );
print $t->ok($productList->size() == 54,"size",$productList->size());

print $t->ok($productList->get(0)->getSku() == "AS 27222","Sku",$productList->get(0)->getSku());
print $t->ok($productList->get(0)->getName() == "KALORIK SILVER MEAT SLICER","Name", $productList->get(0)->getName());
print $t->ok($productList->get(0)->getDescription() == "KALORIK SILVER MEAT SLICER","Description",$productList->get(0)->getDescription());
print $t->ok($productList->get(0)->getShortDescription() == "KALORIK SILVER MEAT SLICER","ShortDescription", $productList->get(0)->getShortDescription());
print $t->ok($productList->get(0)->getWeight() == 11.25,"Weight", $productList->get(0)->getWeight());
print $t->ok($productList->get(0)->getPrice() == 80.3,"Price",$productList->get(0)->getPrice());

print $t->ok($productList->get(7)->getSku() == "BL 24088 Y","Sku",$productList->get(7)->getSku());

print $t->ok($productList->get(53)->getSku() == "WCL 32964","Sku",$productList->get(53)->getSku());

print $t->summary();
$t->destroy();


?>