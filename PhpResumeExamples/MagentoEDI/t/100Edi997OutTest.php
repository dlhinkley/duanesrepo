<?php


require_once('t/TestMaster.php');



$t = new Test();
$t->setDisplayWarnings();

$ack = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Data_AcknowledgementData();
$ack->setFunctionalIdCode("PO");
$ack->setGroupControlNumber("ABC");
$ack->setRejected(false);
$ack->incTransactionSets();
$ack->incTransactionSets();



$specs = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSpecs();

$edi856 = Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiDocumentTypeFactory::getEdiDocumentType("997", "Out", $specs);
//throw new Exception("break point");

print $t->ok(is_object($edi856),false);

$edi856->setDocument($ack);

$document = $edi856->getDocument();

print_r($document);
exit;
// print $t->ok($shipment != null,"object" );
// print $t->ok($shipment->size() == 3,"size",$shipment->size());
// print $t->ok($shipment->get(0)->getTrackingNumber() == "2N9","getTrackingNumber",$shipment->get(0)->getTrackingNumber());
//&& $shipment->get(0)->getTrackingNumber() == "K018293-00010","",$shipment);



//$order = new Order();
//$order->setCarrierScac("SCAC"); // test data
//$order->setOrderNumber("10000001");
//$order->setPoNum("ABCD");
//
//$edi856->setDocument2($order);
//
//$test = $edi856->getDocument();

//dataClient.sendSoSaveRq(fbOrder.toHashMap());

//System.out.println(edi856.getTracking());
//
//assertTrue(true)

print $t->summary();
$t->destroy();


?>