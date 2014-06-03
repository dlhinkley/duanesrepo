<?php


require_once('t/TestMaster.php');


$t = new Test();
$t->setDisplayWarnings();




$specs = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSpecs();

$updateInventory = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Format_Action_EdiUpdateInventoryIn($specs);

print $t->ok(is_object($updateInventory),'create object');

$inventoryList = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Data_InventoryList();


$inventoryData = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Data_InventoryData();

$inventoryData->setSku("ABC-123");
$inventoryData->setQuantity("1");


$inventoryList->add($inventoryData);


$updateInventory->updateInventoryList($inventoryList);

//print $t->ok($shipment != null,"object" );
//print $t->ok($shipment->size() == 3,"size",$shipment->size());
//print $t->ok($shipment->get(0)->getTrackingNumber() == "2N9","getTrackingNumber",$shipment->get(0)->getTrackingNumber());
//&& $shipment->get(0)->getTrackingNumber() == "K018293-00010","",$shipment);




print $t->summary();
$t->destroy();


?>