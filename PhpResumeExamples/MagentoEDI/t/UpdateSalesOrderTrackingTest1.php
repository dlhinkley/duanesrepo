<?php


require_once('t/TestMaster.php');


$t = new Test();
$t->setDisplayWarnings();

$config = new Dhtechnologies_Ediconnectorbase_Model_Config();



$carrierCode = Dhtechnologies_Ediconnectorbase_Model_Shipping::getCarrierCode("DMAL");

print $t->ok($carrierCode == 'dhlint', "getCarrierCode",$carrierCode);


$specs = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSpecs();

$updateOrder = new Dhtechnologies_Ediconnector945in_Model_Connector_Edi_Core_Format_Action_EdiUpdateSalesOrderTrackingIn($specs);

$shipmentLines = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Data_ShipmentLines();


$shipmentLine = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Data_ShipmentLine();

$shipmentLine->setOrderNumber("100000001");
$shipmentLine->setProductNumber("ABC-123");
$shipmentLine->setQuantityShipped("1");
$shipmentLine->setTrackingNumber("1234567890ABC0987");
$shipmentLine->setScacCode("UPSN");


$shipmentLines->add($shipmentLine);


$updateOrder->createShipments($shipmentLines);

//print $t->ok($shipment != null,"object" );
//print $t->ok($shipment->size() == 3,"size",$shipment->size());
//print $t->ok($shipment->get(0)->getTrackingNumber() == "2N9","getTrackingNumber",$shipment->get(0)->getTrackingNumber());
//&& $shipment->get(0)->getTrackingNumber() == "K018293-00010","",$shipment);




print $t->summary();
$t->destroy();


?>