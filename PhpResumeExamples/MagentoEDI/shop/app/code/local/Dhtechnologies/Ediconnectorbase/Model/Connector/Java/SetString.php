<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */

class Dhtechnologies_Ediconnectorbase_Model_Connector_Java_SetString {

	private $set;
	
    function __construct($array) {
        
    	$this->set = $array;
    }
    function iterator() {
    	
    	return new Dhtechnologies_Ediconnectorbase_Model_Connector_Java_IteratorString($this->set);
    }
}
?>
