<?php
require_once('t/TestMaster.php');

require_once("connector/edi/core/documents/type/DocumentSpecs.php");
require_once("connector/edi/core/documents/type/Edi850.php");


// Don't use since we're not using new order

$t = new Test();
$t->setDisplayWarnings();


$doc = <<<END
ISA*00*          *00*          *01*007919277A     *02*JLCO           *110128*1117*U*00401*000001238*0*P*>~
GS*PO*007919277A*JLCO*20110128*1117*1238*X*004010~
ST*850*32608~
BEG*00*NE*8177*9823*20110128~
DTM*002*20110131~
TD5****M~
N1*ST*Sample Customer *9*0079192770200*2~
N3*4531 Main St~
N4*N. CHARLESTON*SC*29405~
N1*BT*Sample Customer *9*0079192770000~
N1*VN*FRESH PACK PRODUCE*9*JLCO~
PO1**40*CA*20**UA*00000000000000*IN*40890~
PID*F****TRI-COLOR PEPPER~
PO4*8*3 CT**0**10**0.85*****0~
CTT*1*40~
SE*14*32608~
GE*42*1238~
IEA*1*000001238~
END;


$specs = new DocumentSpecs();

$edi850 = new Edi850($specs);

print $t->ok(is_object($edi850),false);

$order = new NewOrders();


print $t->ok(is_object($order),false);



$order = $order->getNewOrder();

print $t->ok($order != null,"getNewOrder",$order);


$edi850->setDocument2($order);

$test = $edi850->getDocument();
print $t->ok($test != null,"",$test);
print "$test\n\n";
//dataClient.sendSoSaveRq(fbOrder.toHashMap());

//System.out.println(edi945.getTracking());
//
//assertTrue(true)

print $t->summary();
$t->destroy();



	
?>