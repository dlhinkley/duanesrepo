<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */

class Dhtechnologies_Ediconnectorbase_Transporttypeselect
{

    public function toOptionArray()
    {
        return array(
            array('value' => 'FTP', 'label'=>Mage::helper('adminhtml')->__('FTP')),
            array('value' => 'LOCALFS', 'label'=>Mage::helper('adminhtml')->__('Web Server')),
        );
    }
  
}