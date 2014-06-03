<?php
/**
 * =============================================================================
 *            ---------->  DON'T CHANGE THIS FILE <------------
 * =============================================================================
 * 
 */
 
 require(dirname(__FILE__).'/../init2.php');

 ini_set( 'display_errors', 1 );  // Display  $errors  $on  $screent
 error_reporting(E_ALL ^ E_DEPRECATED);

 require('test_class/test_class.php');
 //require('validation_class/validation_class.php');

Dhtechnologies_Ediconnectorbase_Model_Config::loadConfig("t/etc/EdiConfiguration.xml");

$t =  new Test();
$t->setDisplayWarnings();

$processEDIDocumentClient =  new ProcessEdiDocumentsClient();
$processEDIDocumentClient->processEdiDocuments();

// print $t->ok(  is_object($config), "Config");
 print $t->ok(  is_object($processEDIDocumentClient), "ProcessEDIDocumentClient");
// print $t->ok(  is_object($ediDocumentDatabase), "EDIDocumentDatabase");


$processEDIDocumentClient->processEdiDocuments();


 print $t->summary();
$t->destroy();
?>
