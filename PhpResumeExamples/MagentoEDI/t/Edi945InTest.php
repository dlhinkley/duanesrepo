<?php


require_once('t/TestMaster.php');
require_once("connector/edi/core/documents/type/Edi945In.php");






$t = new Test();
$t->setDisplayWarnings();

/*
$doc = <<<END
ISA*00*          *00*          *02*JLCO           *12*3193950321     *110128*1301*U*00503*000009322*0*P*>
GS*SW*JLCO*3193950321*20110128*1301*9322*X*005030
ST*945*0001
W06**CO-122910-0010-03423*20110128*J1670245**HARRIS SHOW
N1*CA*ABF Freight Systems
G62*17*20110128
W27*LT*ABFS
G72*504*ZZ******75.0000
G72*4*ZZ******16.5000
G72*999*ZZ******91.5000
SE*9*0001
ST*945*0002
W06**CO-011011-0003-00116*20110128*J1670215**1322582
N1*CA*ABF Freight Systems
G62*17*20110128
W27*LT*ABFS
G72*504*ZZ******75.0000
G72*4*ZZ******16.5000
G72*999*ZZ******91.5000
SE*9*0002
ST*945*0003
W06**CO-011011-0008-00016*20110128*J1670243**J STOPINSKI
N1*CA*ABF Freight Systems
G62*17*20110128
W27*LT*ABFS
G72*504*ZZ******75.0000
G72*4*ZZ******16.5000
G72*999*ZZ******91.5000
SE*9*0003
ST*945*0004
W06**CO-011011-0014-00060*20110128*J1670254**0231100
N1*CA*ABF Freight Systems
G62*17*20110128
W27*LT*ABFS
G72*504*ZZ******75.0000
G72*4*ZZ******16.5000
G72*999*ZZ******91.5000
SE*9*0004
ST*945*0005
W06**CO-011011-0016-00400*20110128*J1670241**IVE2308
N1*CA*ABF Freight Systems
G62*17*20110128
W27*LT*ABFS
G72*504*ZZ******75.0000
G72*4*ZZ******16.5000
G72*999*ZZ******91.5000
SE*9*0005
GE*70*9322
IEA*1*000009322
END;
*/
$doc = <<<END
ISA*00*
GS*SW*5139907700*2038334001*20021104*1405*31*X*005010
ST*945*000310001
W06*N*123456*20020916*2114
N1*BT*TEST CUSTOMER*9*0733940588254
N1*ST*TEST CUSTOMER*9*0733940588254
G62*11*20020916
W27*M*NALX*1
N9*2I*K018293-00010*TEST ITEM1
W12*CL*120*120****IN*339408*19284*6600*A3*L
LX*2N9*2I*K018273-00033*TEST ITEM2
W12*CL*400*400****IN*100021*82943*20000*A3*L
LX*3N9*2I*K082738-00041*TEST ITEM3
W12*CL*400*400****IN*133848*930345*20000*A3*L
W03*920*46600*01
SE*17*000310001
GE*1*31
IEA*1*000000031
END;


$specs = new DocumentSpecs();

$edi945 = new Edi945In($specs);
//throw new Exception("break point");

print $t->ok(is_object($edi945),false);

$edi945->setDocument($doc);

$shipment = $edi945->getShipmentLines();
print_r($shipment);
print $t->ok($shipment != null,"object" );
print $t->ok($shipment->size() == 3,"size",$shipment->size());
print $t->ok($shipment->get(0)->getTrackingNumber() == "2N9","getTrackingNumber",$shipment->get(0)->getTrackingNumber());
//&& $shipment->get(0)->getTrackingNumber() == "K018293-00010","",$shipment);



//$order = new Order();
//$order->setCarrierScac("SCAC"); // test data
//$order->setOrderNumber("10000001");
//$order->setPoNum("ABCD");
//
//$edi945->setDocument2($order);
//
//$test = $edi945->getDocument();

//dataClient.sendSoSaveRq(fbOrder.toHashMap());

//System.out.println(edi945.getTracking());
//
//assertTrue(true)

print $t->summary();
$t->destroy();


?>