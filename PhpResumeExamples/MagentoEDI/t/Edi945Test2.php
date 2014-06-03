<?php


require_once(dirname(__FILE__)."/Edi945.php");


require_once(dirname(__FILE__)."/Test.php");





$t = new Test();
$t->setDisplayWarnings();


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

$edi945 = new Edi945($specs);

print $t->ok(is_object($edi945),false);

$edi945->setDocument($doc);

$shipmentLines = $edi945->getShipment();

print $t->ok($shipmentLines->size() == 3,'size',$shipmentLines->size());


print $t->summary();
$t->destroy();


?>