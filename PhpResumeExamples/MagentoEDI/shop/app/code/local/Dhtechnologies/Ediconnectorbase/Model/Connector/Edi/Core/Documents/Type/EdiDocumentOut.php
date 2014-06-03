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
 * Receives an object and sends an EDI Document out
 * @author dlhinkley
 *
 */
class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiDocumentOut extends Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiDocumentCommon {
	
	protected $recordCounter = array();
	protected $levelCount = array();

    protected $header; //EdiRow
		
	public function __construct(Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiDocumentDefinitionCommon $ediDocumentDefinition,Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSpecs $documentSpecs) {
		
		parent::__construct($ediDocumentDefinition,$documentSpecs);			
	}

    /**
     * 
     * If the record is a detail line record, then loop over all the records
     * @param EdiFields $ediFields
     * @param Object $object
     */


    protected function createMaxFields(Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiFields $ediFields, $object) {

    		$recordType = $ediFields->getRecordType();
    		
    		// loop over fields for the max number of times the fields/record can be repeated
    		for ($n = 1; $n <= $ediFields->getMax(); $n++) {
    		
	    		// Init the counter if it doesn't exist
	    		if ( ! isset($this->recordCounter[$recordType]) ) {
	    			
	    			$this->recordCounter[$recordType] = 0;
	    		}
	    		// Increment the counter if it does exist
	    		else {
	    			
	    			$this->recordCounter[$recordType]++;
	    		}
	    		
	    		$ediFieldList = $ediFields->getEdiFieldList();
	    		$this->incLevel( $ediFields->getLevel() );
	    		
	    		// Loop over fields
	    		//
	    		for ($m = 0; $m < $ediFieldList->getSize(); $m++ ) {
	    			
	    			$ediField 	= $ediFieldList->getValue($m);
	    			
	    			$this->createField($object, $ediField,$this->recordCounter[$recordType],$recordType);			
	    		}
    		}
    }

    	
    /**
     * 
     * Creates records for a field
     * @param Object $object
     * @param EdiField $ediField
     * @param int $recordCounter
     * @param String $recordType
     */
	protected function createField( $object, Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiField $ediField, $recordCounter,$recordType, $objectDetail = null) {
		
		
    			$fieldName 	= $ediField->getFieldName();
    			
				$columnDefinitionControl = $ediField->getColumnDefinitionControl();
    			
				// Test mode values take precedence
				if ( Dhtechnologies_Ediconnectorbase_Model_Config::isTestMode() &&  $columnDefinitionControl->hasTestValues()) {
					
					$value		= $columnDefinitionControl->getTestValue( $recordCounter  );
					
					Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" fieldName=$fieldName, hasTestValues value=$value",10);
						
				}
	    		else if (Dhtechnologies_Ediconnectorbase_Model_Config::isTestMode() && $columnDefinitionControl->hasTestValue() ) {
    				
    				Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" fieldName=$fieldName, hasTestValue",10);
    				$value		= $columnDefinitionControl->getTestValue();
    			}
    			else if ( $columnDefinitionControl->hasFixedValues() ) {
    				
    				$value		= $columnDefinitionControl->getFixedValue( $recordCounter  );

    				Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" fieldName=$fieldName, hasFixedValues value=$value",10);
    			}
    			else if ( $columnDefinitionControl->hasFixedValue() ) {
    				
    				Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" fieldName=$fieldName, hasFixedValue",10);
    				$value		= $columnDefinitionControl->getFixedValue();
    			}
  			
    			else if ( $columnDefinitionControl->hasCalculatedValues() ) {
    				
    				$valueMethods = $columnDefinitionControl->getCalculatedValue( $recordCounter  );
    				Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" fieldName=$fieldName, hasCalculatedValues valueMethods=".var_export($valueMethods,true),10);
    				
    				$value = $this;
    				$found = false;
    				// takes MethodName/MethodName and calls each method as $object->methodName()->methodName()
    				//
    				foreach ($valueMethods AS $valueMethod ) {
    					
    					$methodName = "get".$valueMethod;
    				
    					$value = $value->$methodName();
    				}
    			}
    			else if ( $columnDefinitionControl->hasCalculatedValue() ) {
    				
    				$valueMethods		= $columnDefinitionControl->getCalculatedValue();
    				
    				$value = $this;
    				
    				// takes MethodName/MethodName and calls each method as $object->methodName()->methodName()
    				//
    				foreach ($valueMethods AS $valueMethod ) {
    					
    					$methodName = "get".$valueMethod;
    				
    					$value = $value->$methodName();
    				}
    				Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" fieldName=$fieldName, value=$value, hasCalculatedValue valueMethods=".var_export($valueMethods,true),10);
    			}

    			// Otherwise it's just blank
    			else {
    				
    				$value = $this->createMyField($object, $ediField, $recordCounter, $recordType,$objectDetail);
    				
    				if ( $value === null ) {
    					
    					Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" fieldName=$fieldName,  else",10);
    					$value = "";
    				}
    			}
    			$this->setValue($recordType, $recordCounter, $fieldName, $value);
    			
    			// Fields can read a ackvalue at any time
    			if ( $columnDefinitionControl->hasAckValue()  ) {
    			
    				$ackMethod		= "set" . $columnDefinitionControl->getAckValue();
  					
    				Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" ackMethod=$ackMethod,  else",10);
    				$this->ack->$ackMethod($value);
    			}
    			 
	}
	protected 	function createMyField( $object, Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiField $ediField, $recordCounter,$recordType, $objectDetail = null) {
		
	
	}
	public function setDocument( $object) {

		$this->initInterchangeControlNumber();
		
		$this->ediDocumentDefinition->reset ();
		
		$this->recordCounter = array ();
		$this->levelCount = array ();
		
		// Loop over record types
		//
		while ( $this->ediDocumentDefinition->hasNext () ) {
			
			$ediFields = $this->ediDocumentDefinition->next ();
			$lineDefinitionControl = $ediFields->getLineDefinitionControl ();
			

			$this->setMyDocument($ediFields,$lineDefinitionControl,$object);
		}
	}
	protected function setMyDocument($ediFields,$lineDefinitionControl,$object) {
		
		
	}
	/**
	 * Returns the Entire EDI Document to be sent
	 * @return
	 * @throws EdiTypeException 
	 */
	 public function getDocument(){ //  throws EdiTypeException 
		
	 	global $ediConfig;
	 	
		;
		$this->ediDocumentDefinition->reset();

		$outBox = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSequence(Dhtechnologies_Ediconnectorbase_Model_Config::getEdiEndLineDelimiter());//DocumentSequence
		$sequence = 0;
		
		while ( $this->ediDocumentDefinition->hasNext() ) {
			
			$fld = $this->ediDocumentDefinition->next();//EdiFields
			
			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" 1 fld=".$fld->getRecordType(),10);

			$line = null;//ArrayList 
			
			// Start here
			if ( $fld->isParent() ) {
			
				$line = $fld->getLines();
			}
			
			// Skip empty lines
			if ( $line == null && $fld->isRequired() ) {
				
				throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiTypeException("Record " . $fld->getRecordType() . " is required");
			}
			else if ($line != null) {
			
				Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" 2 fld=".$fld->getRecordType(),10);
				
				Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" line=" . var_export($line,true), 10);
				$orderDef = $this->ediDocumentDefinition->getOrderDefinition( $fld->getRecordType());//DefinitionSequence
				$outBox->add($line,$orderDef,$sequence);
			}
			$sequence++;
		}
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" end",10);

		return (String) $outBox->getDocument();
	}	
} ?>
