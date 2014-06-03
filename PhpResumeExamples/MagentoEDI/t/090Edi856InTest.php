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

$specs = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSpecs();

$specs->setEndLineDelimiter("~\r\n");

$edi856 = Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiDocumentTypeFactory::getEdiDocumentType("856", "In", $specs);
//throw new Exception("break point");

print $t->ok(is_object($edi856),false);

$edi856->setDocument($doc);

$shipment = $edi856->getShipments();

print_r($shipment);
print $t->ok(is_array($shipment) ,"array" );
print $t->ok(is_object($shipment[0]),"object 0" );
print $t->ok(is_object($shipment[1]),"object 1" );

$shipmentOne = $shipment[0];
print_r($shipmentOne);

print $t->ok($shipmentOne->size() == 1,"size",$shipmentOne->size());

print $t->ok( $shipmentOne->getTrackingNumber() == "680880770629782","getTrackingNumber",$shipmentOne->getTrackingNumber());
print $t->ok( $shipmentOne->getScacCode() 		== "FEDX","getCarrier",$shipmentOne->getScacCode());
print $t->ok( $shipmentOne->getOrderNumber()	== "20120910150138","getOrderNumber",$shipmentOne->getOrderNumber());

print $t->ok( $shipmentOne->get(0)->getQuantityShipped()	== "1","getQuanityShipped",$shipmentOne->get(0)->getQuantityShipped());
print $t->ok( $shipmentOne->get(0)->getSku()			== "MS 18676 R","getSku",$shipmentOne->get(0)->getSku());


$shipmentTwo = $shipment[1];
print_r($shipmentTwo);

print $t->ok($shipmentTwo->size() == 1,"size",$shipmentTwo->size());

print $t->ok( $shipmentTwo->getTrackingNumber() == "680880770629799","getTrackingNumber",$shipmentTwo->getTrackingNumber());
print $t->ok( $shipmentTwo->getScacCode() 		== "FEDX","getCarrier",$shipmentTwo->getScacCode());
print $t->ok( $shipmentTwo->getOrderNumber()	== "20120910150205","getOrderNumber",$shipmentTwo->getOrderNumber());

print $t->ok( $shipmentTwo->get(0)->getQuantityShipped()	== "1","getQuanityShipped",$shipmentTwo->get(0)->getQuantityShipped());
print $t->ok( $shipmentTwo->get(0)->getSku()			== "JK-19967","getSku",$shipmentTwo->get(0)->getSku());

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