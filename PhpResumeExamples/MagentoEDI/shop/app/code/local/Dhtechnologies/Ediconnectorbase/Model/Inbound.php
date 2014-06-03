<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */

 
class Dhtechnologies_Ediconnectorbase_Model_Inbound extends Mage_Core_Model_Abstract
{
    public function __construct()
    {
        parent::_construct();
        // should these be lower case?
        $this->_init('ediconnectorbase/inbound');
    }
}
