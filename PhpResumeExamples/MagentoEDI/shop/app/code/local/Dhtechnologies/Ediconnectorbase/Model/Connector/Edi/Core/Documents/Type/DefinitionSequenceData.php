<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */


/**
 * Contains the order each edi document element should sequence in
 * @author Duane Hinkley
 *
 */
class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DefinitionSequenceData {

	private $type; // (String) $private $group; // int
	private $parentGroup; // int
	private $order; // Integer

	public  function __construct( $type, $group, $parentGroup, $order) {
 
		$this->type = (String)$type;
		$this->group = (int) $group;
		$this->parentGroup = (int) $parentGroup;
		$this->order = (Integer) $order;
	}

	public function getType() {
		return (String) $this->type;
	}

	public function  setType( $type) {
		$this->type = (String)$type;
	}

	public function getGroup() {
		return  (int) $this->group;
	}

	public function  setGroup( $group) {
		$this->group = (int)$group;
	}

	public function getParentGroup() {
		return  (int) $this->parentGroup;
	}

	public function setParentGroup( $parentGroup) {
		$this->parentGroup = (int)$parentGroup;
	}

	public function getOrder() {

		return  (Integer) $this->order;
	}

	public function setFollows($order) {
		$this->order = (int) $order;
	}

} ?>
