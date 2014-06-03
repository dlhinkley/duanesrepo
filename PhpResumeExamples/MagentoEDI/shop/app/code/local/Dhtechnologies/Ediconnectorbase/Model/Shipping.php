<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */

class Dhtechnologies_Ediconnectorbase_Model_Shipping extends Mage_Shipping_Model_Shipping
{

	/**
	 * Given scacCode, return the carrier code
	 * @param string $scacCode
	 * @return string
	 */
	public static function getCarrierCode($scacCode) {

		$code = false;
		
		$carriers = Mage::getStoreConfig('carriers');

		foreach ($carriers as $carrierCode => $carrierConfig) {

			
			if ( isset($carrierConfig['scac']) && $carrierConfig['scac'] == $scacCode ) {
				
				$code = $carrierCode;
			}
		}
		return $code;
	}


}