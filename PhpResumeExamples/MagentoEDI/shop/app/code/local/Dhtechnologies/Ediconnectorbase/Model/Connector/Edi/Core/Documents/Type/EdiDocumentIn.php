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
 * Receives an EDI Document and outputs a object
 * @author dlhinkley
 *
 */
class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiDocumentIn extends Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiDocumentCommon {

	protected $shipmentController;

	public function __construct(Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiDocumentDefinitionCommon $definition,Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSpecs $documentSpecs) {//DocumentDefinitionInterface

		parent::__construct($definition,$documentSpecs);
		
		$this->shipmentController = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_ShipmentController();
		
	}
	/**
	 * Given the edi document as a string, stores it as a hash of elements in each line
	 * @param ediContent
	 * @return
	 * @throws EdiTypeException
	 */
	public function setDocument($ediContent){ //  throws EdiTypeException

		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" ediContent=" .$ediContent,10);

		$this->setValues($ediContent);
		$this->readDocument();
	}
	protected function lineDefinitionTriggers($lineDefinitionControl,$ediRow) {

	}
	private function readDocument() {

		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" start",10);

		$readIndex = $this->ediDocumentDefinition->getReadIndex();

		// Loop over document
		//
		for ($m = 0; $m < $readIndex->size(); $m++ ) {

			$ediRow 	= $readIndex->getEdiRow($m);
			$recordType = $readIndex->getRecordType($m);
			$ediFields  = $this->ediDocumentDefinition->getEdiFields($recordType);
			$lineDefinitionControl = $ediFields->getLineDefinitionControl();

			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( " recordType=$recordType",10);

			$fields = $ediRow->getFields();
			Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( " fields=".var_export($fields,true),10);

			$this->lineDefinitionTriggers($lineDefinitionControl,$ediRow);

			$ediFieldList = $ediFields->getEdiFieldList();
			$this->incLevel( $ediFields->getLevel() );

			// Loop over fields
			//
			for ($n = 0; $n < $ediFieldList->getSize(); $n++ ) {

				$ediField 	= $ediFieldList->getValue($n);

				$this->createField( $ediField,$recordType,$ediRow);
			}
		}

	}
	/**
	 *
	 * Add values to the objects that occour on document lines that occur once
	 * as in header type document records
	 */

	/**
	 *
	 * Enter description here ...
	 * @return ShipmentDetails
	 */
	public function getShipments() {

		return $this->shipmentController->getShipments();
	}

	/**
	 *
	 * Creates records for a field
	 * @param Order $order
	 * @param EdiField $ediField
	 * @param int $recordCounter
	 * @param String $recordType
	 */
	private function createField( Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiField $ediField,$recordType, Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiRow $ediRow) {


		$fieldName 	= $ediField->getFieldName();
		$value		= $ediRow->getValue($fieldName);
		
		$columnDefinitionControl = $ediField->getColumnDefinitionControl();
			
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" fieldName=$fieldName, value=$value",10);
			
		
		// If it has an acknowlegement value.  This can happen along with another value
		// so it's in it's own if statement instead of the if else tree below
		//
		if ( $columnDefinitionControl->hasAckValue() ) {

			$ackMethod		= "set" . $columnDefinitionControl->getAckValue();
			
			$this->ack->$ackMethod($value);
		}
		$this->columnDefinitionTriggers($columnDefinitionControl,$value);
	}
	protected function columnDefinitionTriggers($columnDefinitionControl,$value) {		

	}
	public function setValues($ediContent) {

		// Put each line in a array element

		$endDelim = $this->documentSpecs->getEndLineDelimiter();

		$lines = explode($endDelim,(String) $ediContent);

		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" lines=" . var_export($lines,true),10);

		if ( count($lines) < 4 ) {
			
			throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiTypeException("Error parsing document. Verify end of line setting correct");
		} 
		// If the last element of split array is empty or nearly empty, there was a problem
//		else if ( strlen(trim(array_pop($lines))) < 2 ) {
//			
//			throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiTypeException("Error parsing document. Verify end of line setting correct");			
//		}


		for ($m = 0; $m < count($lines); $m++) {

			$lines[$m] = trim($lines[$m]); // sometimes line feeds or returns leave garbage
			
			// Skip blank lines
			if ( $lines[$m] ) {
				
				$lines[$m] =  str_replace($endDelim, "", $lines[$m]);
	
				$recordType = (String)  $this->getRecordType($lines[$m]);
	
				Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" m=" + $m + ",recordType=" + $recordType, 10);
	
				$this->ediDocumentDefinition->setValues($recordType,$lines[$m]);
			}
		}

	}
} ?>
