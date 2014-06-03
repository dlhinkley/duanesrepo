<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */


class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DependencySetData {

	private $usedField; // (String) 
        private $requiredField; // 
        function __construct($usedField, $requiredField) {

		$this->usedField = (String) $usedField;
		$this->requiredField = (String) $requiredField;
	}

	public function getUsedField() {
		return (String) $this->usedField;
	}

	public function setUsedField($usedField) {
		$this->usedField = (String) $usedField;
	}

	public function getRequiredField() {
		return (String) $this->requiredField;
	}

	public function setRequiredField($requiredField) {
		$this->requiredField = (String) $requiredField;
	}

} ?>
