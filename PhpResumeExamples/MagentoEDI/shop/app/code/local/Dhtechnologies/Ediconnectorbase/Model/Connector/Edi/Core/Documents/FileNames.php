<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */


class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_FileNames {
 
	private $fileNames; // VectorFileName
	private $iterator; // IteratorFileName

	public function __construct(Dhtechnologies_Ediconnectorbase_Model_Connector_Java_VectorFileName $fileNames) {

		$this->fileNames = $fileNames;
		$this->iterator = $this->fileNames->iterator();
	}
	/**
	 * Resets iteration
	 * @return 
	 */
	public function  reset() { // returns void
		
		$this->iterator = $this->fileNames->iterator();
	}
	public function  hasNext() { // returns boolean
		
		return $this->iterator->hasNext();
	}
	public function next() { // returns FileName
		
		return $this->iterator->next();
	}
	public function  size() { // returns void

		return $this->fileNames->size();
	}
}
