<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */

class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Format_EdiConfigActions {

	private $configActionList;

	public function __construct() {

		$this->actionList = array();

		// Read the actionList from config.xml for this and related modules
		//
		$this->configActionList = Mage::getConfig()->getNode('global/ediconnectorbase')->actionList;
		

		// Loop over each document number and direction, using the ones we have defined
		//
        foreach ($this->configActionList->children() as $actionDefinition) {
			

				Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( "actionDefinition=" . var_export($actionDefinition,true), 10);


				$ediConfigAction = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Format_EdiConfigAction($actionDefinition);
						
				$this->actionList[ $ediConfigAction->getSequenceNum() ] = $ediConfigAction;


		}
		ksort($this->actionList); // sort by sequence
	}
	/**
	 *
	 * Enter description here ...
	 * @return array
	 */
	public function getActionList() {

		return $this->actionList;
	}
}