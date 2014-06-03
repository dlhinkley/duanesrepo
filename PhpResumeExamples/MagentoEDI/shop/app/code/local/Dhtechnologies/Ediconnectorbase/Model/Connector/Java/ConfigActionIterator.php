<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */

class Dhtechnologies_Ediconnectorbase_Model_Connector_Java_ConfigActionIterator {

    private $actionDefinition;
    private $ptr = 0;

    /**
     * 
     * Enter description here ...
     * @param array $actionDefinition
     */
    public function __construct($actionDefinition) {

        $this->actionDefinition = $actionDefinition;
        $this->ptr = -1;
    }
    public function hasNext() {

        return isset($this->actionDefinition[$this->ptr + 1]);
    }
    public function next() {

        $this->ptr++;
        return new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_EdiConfigAction($this->actionDefinition[$this->ptr]);
    }
    public function add($string) {

        $this->actionDefinition = $string;
        $this->ptr = -1;
    }
}

?>
