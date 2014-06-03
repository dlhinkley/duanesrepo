<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */

 
class Dhtechnologies_Ediconnectorbase_Model_Mysql4_Ediconfiguration extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {   
        $this->_init('ediconnectorbase/ediconfiguration', 'edi_configuration_id');
    }
}
