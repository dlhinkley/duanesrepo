<?php


require_once('t/TestMaster.php');
require_once("connector/edi/core/documents/type/Edi945Definition.php");






$t = new Test();
$t->setDisplayWarnings();



$documentSpecs = new DocumentSpecs();

$ediDocumentDefinition  = new Edi945Definition($documentSpecs);


print $t->ok(is_object($ediDocumentDefinition),"is_object");

print $t->ok( $ediDocumentDefinition->size() == 18,"size",$ediDocumentDefinition->size());

$ediDocumentDefinition->reset();

print $t->ok( $ediDocumentDefinition->hasNext(),"hasNext");

$ediFields = $ediDocumentDefinition->next();

print $t->ok( is_object($ediFields),"next");

// First definition isn't a orderLineLoop
print $t->ok( ! $ediFields->isOrderLineLoop(),"isOrderLineLoop");
/*
    	
    	
    	$this->recordCounter = array();
    	$this->levelCount = array();
    	
    	// Loop over record types
    	//
    	while ( $this->ediDocumentDefinition->hasNext() ) {
    		
    		
*/
print $t->summary();
$t->destroy();


?>