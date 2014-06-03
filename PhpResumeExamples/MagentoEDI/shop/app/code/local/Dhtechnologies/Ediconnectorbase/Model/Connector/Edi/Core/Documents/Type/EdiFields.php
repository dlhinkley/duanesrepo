<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */


class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiFields {

	private $documentSpecs; // DocumentSpecs
	private $min; // int
	private $max; // int
	private $require; // (boolean)
	private $recordType; // (String) $
	private $dependency;
	/**
	 * Stores values by first element number then fields
	 */
	private $ediRows; // EdiRows
	private $ediFieldList; // EdiFieldList
	private $doc; // EdiDocumentInterface
	private $numberOfFields; // int
	private $parent; // (String) $
	private $requiredValues;
	private $orderLineLoop;
	private $lineDefinitionControl;


	/**
	 * Given the name of the definition, create the object
	 * @param string
	 * @param definition
	 * @throws EdiTypeException
	 */
	

	public function __construct(SimpleXMLElement $lineDefinition,$documentSpecs){ //  throws EdiTypeException

		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" start lineDefinition=".var_export($lineDefinition,true),10);
		
		$this->requiredValues = new Dhtechnologies_Ediconnectorbase_Model_Connector_Java_HashMap();
		$this->recordType = (String)$lineDefinition->recordType;
		$this->min = $lineDefinition->min;
		$this->max = $lineDefinition->max;
		$this->require = $lineDefinition->required;
		$this->numberOfFields = count($lineDefinition->columnDefinition->column);
		$this->documentSpecs = $documentSpecs;
		$this->dependency  = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_Dependency();
		$this->level = (int) $lineDefinition->level;
		$this->lineDefinitionControl = Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_LineDefinitionControlFactory::getLineDefinitionControl($lineDefinition, $documentSpecs);
		$this->init( $lineDefinition->columnDefinition);

	}
	public function getLineDefinitionControl() {
		
		return $this->lineDefinitionControl;
	}
	public function getLevel() {
		
		return $this->level;
	}

	function getRecordType() {
		return (String) $this->recordType;
	}
	function setRecordType( $recordType) {
		$this->recordType = (String) $recordType;
	}
	/**
	 * 
	 * Enter description here ...
	 * @return EdiFieldList
	 */
	public function getEdiFieldList() {
		
		return $this->ediFieldList;
	}
	private function init(SimpleXMLElement $definition){ // throws EdiTypeException String[][]


		$this->ediRows = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiRows();

		$this->ediFieldList = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiFieldList();

		// Initialize the hash to hold the edi field definition
		$ctr = 0;
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" definition->column=".var_export($definition->column,true),10);
		
		// Puts the definition into a definition object.  Puts the position of the
		
		foreach ($definition->column AS $columnDefinition ) {
			
			$def = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiField($columnDefinition,$this->documentSpecs);//EdiField
			$position = $def->getPosition();//Integer
				
			// Make sure no positions are skipped
			if ( $ctr != $position ) {

				throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiTypeException("Field " . $def->getFieldName() . " of record " . $this->recordType . " position error.");
			}
			// Put the definition in the hash
			$this->ediFieldList->addValue($def);
				
			$ctr++;	
			// Add the hash to the vector incase we have more than one set of values
		}
	}
	/**
	 * Given a field name and the requried code, add it to the fields definition
	 * @param fieldName
	 * @param requiredCode
	 */
	public function setRequired( $fieldName, $requiredCode) {

		for ( $m = 0; $m < $this->ediFieldList->getSize(); $m++) {
				
			// If it's found, update it
			if ( $this->ediFieldList->getFieldName($m) != null && $this->ediFieldList->getFieldName($m) == (String)$fieldName) {

				$this->ediFieldList->getValue($m)->setRequired((String) $requiredCode);
			}
		}
	}

	
	/**
	 * Given a delimited edi line, store it
	 * @param ediDetail
	 * @return
	 * @throws EdiTypeException
	 */

	function setFields($line){ //  throws EdiTypeException

		$flds = explode($this->documentSpecs->getInLineDelimiter(),(String) $line);

		$this->setFields2($flds);
	}
	public function getMax() {
		
		return $this->max;
	}
	/**
	 * 
	 * Enter description here ...
	 * @param array $flds
	 */
	private function setFields2($flds){ //  throws EdiTypeException


		$field = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiRow();//EdiRow

		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" size=" . count($flds) . ",line=" . var_export($flds,true), 10);

		for ( $m = 0; $m < count($flds); $m++) {
				
			$fieldName = (String) $this->ediFieldList->getFieldName($m );

			$field->setValue($fieldName,$flds[$m]);
				
			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" m=$m , fieldName=$fieldName, flds[m]=$flds[$m] , field->getValue(m)=" . $field->getValue($m), 10);
		}
		$this->ediRows->addRow($field);

	}
	function setValue($recordNumber, $fieldName, $value){ //  throws EdiTypeException

		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" recordNumber=" . $recordNumber . ",fieldName=" . $fieldName . ",value=" . $value,10);


		
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" size=" . $this->ediRows->size() . ", recordNumber=" . $recordNumber,10);

		if ( $this->ediRows->size() < $recordNumber + 1) {
			$newRow = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiRow();//EdiRow
			$newRow->setValue("RecordType", $this->recordType);
			$this->ediRows->addRow( $newRow);
				
				
		}

		// Only one record unless there are multiple lines
		$this->ediRows->getRow( $recordNumber )->setValue($fieldName, $value);

	}
	function getValue($recordNumber, $fieldName){ //  throws EdiTypeException

		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" recordNumber=$recordNumber fieldName=$fieldName",10);

		$value = null;

		$row = $this->ediRows->getRow( (int) $recordNumber );

		if ( $row != null && is_object($row)) {

			$value = $row->getValue( (String)$fieldName);
		}
		return $value;
	}


	/**
	 * Return the fields combined with delimiters
	 * @return
	 * @throws EdiTypeException
	 */
	function getLines(){ //  throws EdiTypeException ArrayList

		$lines = new Dhtechnologies_Ediconnectorbase_Model_Connector_Java_ArrayList();	//ArrayList

		for( $m = 0; $m < $this->ediRows->size(); $m++) {
			
				
			$line = new Dhtechnologies_Ediconnectorbase_Model_Connector_Java_ArrayList();//ArrayList

			$pos = 0;
			while ( $pos < $this->numberOfFields ) {

				$ediFld = $this->ediFieldList->getValue($pos);//EdiField

				$value = null;//(String)
				$row = null;//EdiRow

				if ( $ediFld != null ) {

					$row = $this->ediRows->getRow( $m );
					$value = $row->getValue( $ediFld->getFieldName() );
				}

				

				Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" before pos=" . $pos . ",numberOfFields=" . $this->numberOfFields . ",value=" . $value, 10);


				if ( $value != null ) {
						
					$value = str_pad($value, $ediFld->getMinLength());
					$value = str_replace("\\u0D", "",$value);
					$value = str_replace("\n", "",$value);
					$value = str_replace("\r", "",$value);
				}
				// format implied doubles
				// if matches format 1.12
				if ( $ediFld->getType() == "N2" &&  preg_match('/^\d+\.\d\d+$/',$value) ) {
					
						$value = preg_replace('/^(\d+)\.(\d\d)\d*$/', '$1$2', $value); 
						
						$value = str_pad($value, $ediFld->getMinLength(),'0',STR_PAD_LEFT);
				}
				//                                else {
				//
				//                                        $value = str_pad(" " , $ediFld->getMinLength());
				//                                }
				Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" after value=" . $value, 10);
				
				// If the value is not filled in, and it's required, it's an error
				if ( ( $value == null || $value == "" ) && $ediFld != null && $ediFld->isRequired() ) {
						
					$message = "Record " . $this->recordType . " is missing field " . $ediFld->getFieldName();
					
					throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiTypeException($message);
				}
				// If the value is not filled in and it is required based on a dependency, it's an error
				else if ( ( $value == null || $value == "" ) && $ediFld != null && $this->isRequiredByDependency($row,$ediFld) ) {
						
					throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiTypeException( "Record " . $this->recordType . " field " . $ediFld->getFieldName() . " is required by dependency");
				}
				// If the value is filled but not one of the required values, it's an error
				else if (  $this->isMissingRequiredValues($ediFld->getFieldName(),$value) ) {
						
					throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiTypeException( "Record " . $this->recordType . " field " . $ediFld->getFieldName() . " must have " . $this->getRequiredValues( $ediFld->getFieldName() ) );
				}
				else if ($value == null || $value == "") {
					$line->add("");
					Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("value is null or blank", 10);
				}
				else if ( $ediFld->getType() == "NO" && ! $this->isInteger($value) ) {
						
					throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiTypeException("Record " . $this->recordType . " field " . $ediFld->getFieldName() . " is not a valid integer");
				}
				else if ( $ediFld->getType() == "N2" && ! preg_match('/^\d+$/',$value) ) {
						
					throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiTypeException("Record " . $this->recordType . " field " . $ediFld->getFieldName() . " is not a valid implied double");
				}
				else if ( $ediFld->getType() == "R" && ! $this->isDouble($value) ) {
						
					throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiTypeException("Record " . $this->recordType . " field " . $ediFld->getFieldName() . " is not a valid double");
				}

				// If it's too long, chop it off and save it
				else if ( $value != null && strlen( $value) > $ediFld->getMaxLength() ) {
						
					$value = substr($value,0,$ediFld->getMaxLength());
					$line->add($value );
				}
				else {
					$line->add($value );
				}

				$pos++;
			}
			$holdLine = (string) join($line->toArray(), $this->documentSpecs->getInLineDelimiter() );

			if ( strlen($holdLine) > 0 ) {

				$lines->add($holdLine);
			}
		}
		$out = null;
		if ( $lines->size() > 0 ) {
				
		}
		else if ( $this->require) {
				
			throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiTypeException("Element " . $this->recordType . " is required.");
		}

		return 	$lines;
	}
	private function isMissingRequiredValues($fieldName, $value) {

		$missing = false;

		$this->requiredValues = $this->getRequiredValues((String) $fieldName);

		// If a value is provided, there are required values and the value is not in the required values, it's missing
		if ( $value != null
		&& ! $value == ""
		&&  $this->requiredValues != null
		&& ! $this->requiredValues->containsKey( (String)$value) ) {
				
			$missing = true;
		}

		return (boolean) $missing;
	}
	private function isRequiredByDependency($row, $ediFld) {

		$this->dependencies = $this->dependency->getDependencies($ediFld->getFieldName());
		$required = false;
		$m = 0;
		while  ( ! $required && $m < $this->dependencies->size() ) {
				
			$usedField = (String) $this->dependencies->get($m);
				
			// If the field is used, it's required
			//
			if ( $row->getValue($usedField) != null && ! $row->getValue($usedField) == "" ) {

				$required = true;
			}
			$m++;
		}

		return (boolean) $required;
	}

	private function isDouble($value) {

		return is_double($value);
	}
	private function isInteger($value) {


		return is_integer($value);
	}


	public function  getRowByFilter( $filter) {//EdiRow Filter

		$found = null;
		$m = 0;
		while ( $found == null && $m < $this->ediRows->size() ) {
				
			$field = $this->ediRows->getRow($m);
				
			if ( $this->matches($field,$filter) )  {

				$found = $field;
			}
				
			$m++;
		}
		return $found;
	}

	// Return the given row number.  Zero based.
	/**
	 * 
	 * Given a row number, return that row
	 * @param int $m
	 * @return EdiRow
	 */
	public function  getRow( $m) {//EdiRow

		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" size=" . $this->ediRows->size() . ",m=" . $m, 10);
		$row = null;

			
		$row = $this->ediRows->getRow($m);

		return $row;

	}
	private function matches($field, $filter) {

		$it = $filter->iterator();
		$matches = 0;

		while ( $it->hasNext() ) {
				
			$fieldName = (String) $it->next();
			$matchValue = (String) $filter->get($fieldName);
				
			if ( $field->getValue($fieldName) == $matchValue  ) {

				$matches++;
			}
		}
		return ($matches == $filter->size() );
	}

	function isRequired() {

		return (boolean) $this->require;
	}
	function isParent() {

		// If there is no parent  present then it is the parent
		return ($this->parent == null || $this->parent == "");
	}
	function getParent() {
		return (String) $this->parent;
	}
	function setParent($parent) {
		$this->parent = (String) $parent;
	}
	public function getSize() {

		return  (int) $this->ediRows->size();
	}
	/**
	 * Set's a field dependency.  If the usedField is used, then the requiredField is required
	 * @param usedField
	 * @param requiredField
	 */
	function setDependency( $usedField,  $requiredField) {

		$this->dependency->add((String)$usedField, (String)$requiredField);
	}
	/**
	 * Set the required values for a field
	 * @param fieldName
	 * @param values
	 */
	private function setRequiredValues($fieldName,$values) {

		$this->requiredValues->put((String) $fieldName,new Dhtechnologies_Ediconnectorbase_Model_Connector_Java_Vector( $values ));
	}
	/**
	 * Get the required values for a field
	 * @param fieldName
	 * @return
	 */
	private function getRequiredValues($fieldName) {

		$values = null;

		if ( $this->requiredValues != null && $this->requiredValues->containsKey((String) $fieldName) ) {
				
			$values = $this->requiredValues->get((String) $fieldName);
		}
		return $values;
	}
	public function setRequired2($required) {

		$this->require = (boolean) $required;
	}
	/**
	 * Sets the definition after having been previously set.
	 * @param definition
	 * @throws EdiTypeException
	 */
	public function setDefinition($definition){ //  throws EdiTypeException

		init($definition);
	}
	public function toString() {

		return (String) $this->ediRows;
	}

} ?>
