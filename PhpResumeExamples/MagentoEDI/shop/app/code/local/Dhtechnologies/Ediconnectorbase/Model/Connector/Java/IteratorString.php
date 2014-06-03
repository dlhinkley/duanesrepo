<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */


class Dhtechnologies_Ediconnectorbase_Model_Connector_Java_IteratorString {

    private $vector;
    private $ptr = 0;

    /**
     * 
     * Enter description here ...
     * @param array $vector
     */
    public function __construct($vector) {

        $this->vector = $vector;
        $this->ptr = -1;
    }
    public function hasNext() {

        return isset($this->vector[$this->ptr + 1]);
    }
    public function next() {

        $this->ptr++;
        return $this->vector[$this->ptr];
    }
    public function add( $string) {

        $this->vector = $string;
        $this->ptr = -1;
    }
}

?>
