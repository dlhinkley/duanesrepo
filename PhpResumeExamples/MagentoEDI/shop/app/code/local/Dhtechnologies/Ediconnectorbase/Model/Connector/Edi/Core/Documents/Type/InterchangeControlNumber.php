<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */


class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_InterchangeControlNumber {


        public function __construct() {

        }
		public function getNextNumber() {

			//$ediConfiguration =  Mage::getModel('ediconnectorbase/ediconfiguration')->getCollection()
			//->addFieldToFilter('config_name', 'INTERCHANGE_CONTROL_NUMBER');	
			$ediConfiguration =  Mage::getModel('ediconnectorbase/ediconfiguration')->load(1);

			$number = (int) $ediConfiguration->getConfigValue();
			
			$number++;
			
			if ( $number > 9999999999 ) {
				
				$number = 0;
			}
			
			$ediConfiguration->setConfigValue($number);
			$ediConfiguration->save();
			
			
			return str_pad($number, 9, "0", STR_PAD_LEFT);
		}

} ?>
