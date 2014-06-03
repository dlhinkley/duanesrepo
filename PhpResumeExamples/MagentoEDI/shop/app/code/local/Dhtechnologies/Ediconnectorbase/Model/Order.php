<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */

class Dhtechnologies_Ediconnectorbase_Model_Order extends Mage_Sales_Model_Order
{

    public function getScacCode()
    {
        $scacCode = $this->getData('shipping_scac_code');
        if (is_null($scacCode)) {
            $scacCode = false;
            /**
             * $method - carrier_method
             */
            $method = $this->getShippingMethod(true);
            

        }
        $scacCode= Mage::getStoreConfig('carriers/' . $method->getCarrierCode() . '/scac');
        Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("scacCode=$scacCode, CarrierCode=".$method->getCarrierCode(),10);

        return $scacCode;
    }
    public function getOrderGrandTotal() {
    	
    	return $this->getGrandTotal();
    }
 	public function getNumberItems() {
 		
 		$items = $this->getAllItems();
 		
 		return count($items);
 	}

}