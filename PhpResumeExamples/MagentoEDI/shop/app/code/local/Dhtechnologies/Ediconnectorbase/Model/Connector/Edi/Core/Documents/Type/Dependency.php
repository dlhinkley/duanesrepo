<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */


class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_Dependency {

	private $set;//<DependencySet>

        function __construct() {

            $this->set = new Dhtechnologies_Ediconnectorbase_Model_Connector_Java_Vector();
        }
	function add($usedField, $requiredField) {
		
		$this->set->add( new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DependencySetData((String) $usedField,(String) $requiredField) );
	}
	/**
	 * Given a fieldName, return the fields that if filed, make the fieldName reqquired
	 * @param fieldName
	 * @return
	 */
	function getDependencies($fieldName) {

		$dependencies = new Dhtechnologies_Ediconnectorbase_Model_Connector_Java_Vector();
		
		for ( $m = 0; $m < $this->set->size(); $m++) {
			
			// If the requiredField name exist, add to the list
			//
			$this->dependency = $this->set->get($m); //DependencySet
			
			if ( $this->dependency->getRequiredField() == $fieldName ) {
				
				$dependencies->add( $this->dependency->getUsedField() );
			}
		}
		return $dependencies; //Vector
	}

} ?>
