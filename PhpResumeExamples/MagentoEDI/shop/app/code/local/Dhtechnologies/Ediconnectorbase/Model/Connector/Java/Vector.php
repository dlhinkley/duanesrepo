<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */

class Dhtechnologies_Ediconnectorbase_Model_Connector_Java_Vector {

    protected $vector;

    public function __construct($vector = false) {

        if ( $vector === false ) {

         $this->vector = array();
       }
        else {
        
            $this->vector = (array) $vector;
        }
    }

    public function iterator() {

        return new Dhtechnologies_Ediconnectorbase_Model_Connector_Java_VectorIterator($this->vector);
    }
    public function add($value) {

        $this->vector[] = $value;
    }
    public function size() {

        return count($this->vector);
    }
    public function get($m) {

        if ( isset($this->vector[$m])) {
            
            $out = $this->vector[$m];
        }
        else {
            
            $out = null;
        }
        return $out;
    }
    public function toString() {

        return var_dump($this->vector,true);
    }
    public function sort() {

        sort($this->vector);
    }

}
?>
