<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */



class Dhtechnologies_Ediconnectorbase_Model_Connector_Java_ArrayListString {

    private $array;

    public function __construct() {

        $this->array = array();
    }
    public function add( $value) {

        $this->array[] = $value;
    }
    public function asArray() {

        return (array) $this->array;
    }
    public function size() {

        return count($this->array);
    }
    public function toString() {

        return var_dump($this->array,true);
    }
    public function toArray() {

        return $this->array;
    }
    public function get($m) {

        return $this->array[$m];
    }
}
?>
