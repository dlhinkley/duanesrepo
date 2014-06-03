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
 * Controls the document order.  Certain elements have to be nested within others.  This
 * makes sure that happens
 * @author Duane Hinkley
 *
 */
class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSequenceList extends Dhtechnologies_Ediconnectorbase_Model_Connector_Java_Vector {
	/**
	 * Given a record type, return the order definition for that type
	 * @param recordType
	 * @return
	 */
	public function getOrderDefinition(  $recordType) { // returns DefinitionSequence

		$orderDefinition =  null; // DefinitionSequence
		 $m = 0;
		while ( $orderDefinition == null && $m < $this->size()  ) {
			
			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" type=".$this->get($m)->getType(),10);
			
			if ( $this->get($m)->getType() == $recordType) {
				
				$orderDefinition = $this->get($m);
			}
			$m++;;
		}
		return $orderDefinition;
	}
}
