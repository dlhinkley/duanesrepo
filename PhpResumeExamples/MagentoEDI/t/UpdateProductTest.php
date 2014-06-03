<?php


require_once('t/TestMaster.php');


$t = new Test();
$t->setDisplayWarnings();




$specs = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSpecs();

$updateProduct = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Format_Action_EdiUpdateProductIn($specs);

print $t->ok(is_object($updateProduct),'create object');

$productList = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Data_ProductList();


$productData = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Data_ProductData();

$productData->setSku("ABC-123");
$productData->setPrice("2.34");
$productData->setName("Widget Master");

$productList->add($productData);


$productData->setSku("XYZ-789");
$productData->setPrice("4.34");
$productData->setName("Do Hicky");
$productData->setDescription("Do Hicky Bob");
$productData->setShortDescription("Do ");
$productData->setWeight('1');


$productList->add($productData);


$updateProduct->updateProductList($productList);

//print $t->ok($shipment != null,"object" );
//print $t->ok($shipment->size() == 3,"size",$shipment->size());
//print $t->ok($shipment->get(0)->getTrackingNumber() == "2N9","getTrackingNumber",$shipment->get(0)->getTrackingNumber());
//&& $shipment->get(0)->getTrackingNumber() == "K018293-00010","",$shipment);




print $t->summary();
$t->destroy();


?>