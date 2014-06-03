<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */




/**
 * Used to put the documents in order to output them according to the 
 * defined tree structure
 * @author Duane Hinkley
 *
 */
class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSequence {

	private $box; //HashMap
	private $endLineDelimiter;//String

        function __construct( $endLineDelimiter) {

            $this->box = new Dhtechnologies_Ediconnectorbase_Model_Connector_Java_HashMap();
            $this->endLineDelimiter = $endLineDelimiter;
            
        }
	function add($line, $orderDef, $sequence) {

		// Builds a key to use for sorting as group, parentGroup, record index, and definition sequence
		for ( $m = 0; $m < $line->size(); $m++ ) {
			
			$key = null;
			
			if ( $orderDef->getOrder() == null ) {
				
				$key = sprintf("%02d%02d%02d%02d",$orderDef->getGroup(), $orderDef->getParentGroup(),(int)  $sequence, $m);
			}
			else {
				
				$key = sprintf("%02d%02d%02d%02d",$orderDef->getGroup(), $orderDef->getParentGroup(), $m, $orderDef->getOrder());
			}
			
			$this->box->put($key, $line->get($m));
		}
	}
	/**
	 * Outputs the document in the order specified by the keys used when adding lines
	 * @return
	 */
	public function getDocument() {

		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" start",10);

		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" keySet=".var_export($this->box->keySet(),true),10);
		
		// put the keys in a hash set so we can get the order 
	    $order = $this->box->keySet()->asArray();//Vector
	    sort($order);
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" order->size=" , count($order), 10);
		
		$lines = array();
		
		
		foreach($order AS $key) {
						                        
			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" key=" . $key . ",line=" . $this->box->get($key), 10);
			
			$lines[] = $this->box->get($key);
		}
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" end",10);
		
		return (String) join($this->endLineDelimiter,$lines) .$this->endLineDelimiter;
	}

}

?>