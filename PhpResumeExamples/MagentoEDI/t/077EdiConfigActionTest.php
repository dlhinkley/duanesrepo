<?php 

require_once('t/TestMaster.php');

//require_once("connector/edi/core/format/EdiFormat.php");




$t = new Test();
$t->setDisplayWarnings();

$action = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Format_EdiConfigActions();


print $t->summary();
$t->destroy();

	
	
//}