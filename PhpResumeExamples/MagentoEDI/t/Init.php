<?php
/**
 * =============================================================================
 *            ---------->  DON'T CHANGE THIS FILE <------------
 * =============================================================================
 * 
 */
 
 require(dirname(__FILE__).'/../init.php');

 ini_set( 'display_errors', 1 );  // Display  $errors  $on  $screent
 error_reporting(E_ALL ^ E_DEPRECATED);

 require('test_class/test_class.php');
 require('validation_class/validation_class.php');


$t =  new Test();
$t->setDisplayWarnings();


 print $t->ok(  is_object($config), "Config");
 print $t->ok(  is_object($processEDIDocumentClient), "ProcessEDIDocumentClient");
 print $t->ok(  is_object($ediDocumentDatabase), "EDIDocumentDatabase");


$processEDIDocumentClient->processEdiDocuments();


 print $t->summary();
$t->destroy();
?>
