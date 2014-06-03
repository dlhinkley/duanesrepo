<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */


class Dhtechnologies_Ediconnectorbase_Model_Connector_Java_File {
	
	private $file;
	
	public function __construct($file) {
		
		$this->file = $file;
	}
	public function exists() {
		
		return file_exists($this->file ) ;
	}
	public function mkdir() {
		return mkdir($this->file);
	}
	public function getAbsolutePath() {
		
		return  realpath($this->file);
	}
}