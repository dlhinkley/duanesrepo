<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */


class Utils {
	
	public function join(ArrayListString $values, $glue) {
		
		$phpString = array();
		foreach ($values AS $value ) {
			
			$phpString[] = $value;
		}
		
		return  join($glue,$phpString);
	}
	public function replace( $subject, $search, $replace) {
		
		return  str_replace($search, $replace, $subject);
	}
}

?>