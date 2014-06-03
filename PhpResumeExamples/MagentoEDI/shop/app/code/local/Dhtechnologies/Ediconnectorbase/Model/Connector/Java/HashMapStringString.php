<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */


class Dhtechnologies_Ediconnectorbase_Model_Connector_Java_HashMapStringString {

    private $map = array();
    public function __construct() {
        
        
    }
    public function keySet() {

       return new Dhtechnologies_Ediconnectorbase_Model_Connector_Java_SetString(array_keys($this->map));
    }
    public function containsKey( $key) {

        return (boolean) (array_key_exists($key, $this->map));
    }
    public function toString() {

        return var_export($this->map,true);
    }
    public function put( $key, $value) {

        $this->map[$key] = $value;
    }
    public function get( $key) {

        $value = null;

        if ( isset($this->map[$key]) ) {

            $value = $this->map[$key];
        }
        return $value;
    }
    public function size() {

        return count($this->map);
    }

}
?>
