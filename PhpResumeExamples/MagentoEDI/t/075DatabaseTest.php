<?php 

require_once('t/TestMaster.php');

//require_once("connector/edi/core/format/EdiFormat.php");




$t = new Test();
$t->setDisplayWarnings();

$db = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase();

$db->purgeInBoundEdiLogs(5);
$db->purgeOutBoundEdiLogs(5);

print $t->summary();
$t->destroy();

	
	
//}