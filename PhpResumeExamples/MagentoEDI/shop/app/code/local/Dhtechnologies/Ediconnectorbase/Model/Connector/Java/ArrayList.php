<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */


class Dhtechnologies_Ediconnectorbase_Model_Connector_Java_ArrayList {

    private $array = array();

    public function __construct($value = array()) {

        $this->array = $value;
    }
    public function add($value) {

        $this->array[] = $value;
    }
    public function asArray() {

        return (array) $this->array;
    }
    public function size() {

        return count($this->array);
    }
    public function toString() {

        return var_export($this->array,true);
    }
    public function toArray() {

        return (array)  $this->array;
    }
    public function get($m) {

        return $this->array[$m];
    }
}
?>
