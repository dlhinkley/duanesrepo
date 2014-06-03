<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */
 



class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase {
	
	/**
	 * Website number
	 */
	private function getInboundCollection() {
		
		return Mage::getModel('ediconnectorbase/inbound')->getCollection();
	}
	private function getOutboundCollection() {
		
		return Mage::getModel('ediconnectorbase/outbound')->getCollection();
	}
	public function getOutboundModel() {
		
		return Mage::getModel('ediconnectorbase/outbound');
	}
	public function getInboundModel() {
		
		return Mage::getModel('ediconnectorbase/inbound');
	}

	/**
	 * Given a coma delimited set of id's set their records to sent
	 * @param combinedId
	 */
	
	public function  setOutBoundSaved( $id, $filename) { // returns void

		$outbound = self::getOutboundModel()->load($id);
		
		$outbound->setSentflag(1);
		
		$outbound->save();

	}	
	/**
	 * Given a sent flag return the matching records to send
	 * @param sentFlag
	 * @return
	 */
	
	public function getOutBoundDocumentsSentFlag(  $sentFlag) { // returns EdiDocumentRecords
		
		$sentFlag = (integer) $sentFlag;
		
		
			$outboundDocs = self::getOutboundCollection()
			->addFieldToFilter('sentflag', $sentFlag);
		
		
			return $outboundDocs;
		}

	public function emptyInBound() {
		
		$sql = "DELETE FROM inbound_edi_documents  ";
		
		Mage::getSingleton('core/resource')->getConnection('core_write')->query($sql);
		
	}
	public function emptyOutBound() {
		
		$sql = "DELETE FROM outbound_edi_documents  ";
		
		Mage::getSingleton('core/resource')->getConnection('core_write')->query($sql);
		
	}
	public function getOutBoundDocuments(  $documentType,  $sentFlag) { // returns EdiDocumentRecords

			$outboundDocs = self::getOutboundCollection()
				->addFieldToFilter('sentflag', $sentFlag)
				->addFieldToFilter('document_type', $documentType);


		return $outboundDocs;
	}
	public function getInBoundDocuments(  $documentType,  $processedFlag) { // returns EdiDocumentRecords

			$inboundDocs = self::getInboundCollection()
				->addFieldToFilter('processed_flag', $processedFlag)
				->addFieldToFilter('document_type', $documentType);


	return $inboundDocs;
		

	}
	

	/**
	 * Return true if the document already exists.
	 * @param document
	 * @return
	 */
	public function  isDocumentExist( $document) { // returns boolean
			
			$inboundDocs = self::getInboundCollection()
			->addFieldToFilter('document_md5', md5($document));
		
		
			return ( $inboundDocs->getSize() > 0);
	}
		public function purgeInBoundEdiLogs($daysToKeep) { // returns boolean
	
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( "Start", 10);
		
		 $logPurged = false;
	
			$sql = "" .  // String
			"DELETE FROM inbound_edi_documents " .
			"  WHERE " . 
			"    DATE_ADD(DATE_CREATED,INTERVAL " . $daysToKeep . " day ) < NOW() OR " .
			"    DATE_ADD(DATE_MODIFIED,INTERVAL " . $daysToKeep . " day ) < NOW() ";

			Mage::getSingleton('core/resource')->getConnection('core_write')->query($sql);
			 
			$logPurged = true;
			

		
		return $logPurged;
		
	}
	
	public function purgeOutBoundEdiLogs($daysToKeep) { // returns boolean
		
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug( "Start", 10);
		
		 $logPurged = false;
		
			$sql = "" .  // String
			"DELETE FROM outbound_edi_documents " .
			"  WHERE " . 
			"    DATE_ADD(DATE_CREATED,INTERVAL " . $daysToKeep . " day ) < NOW() OR " .
			"    DATE_ADD(DATE_MODIFIED,INTERVAL " . $daysToKeep . " day ) < NOW() ";
						
			Mage::getSingleton('core/resource')->getConnection('core_write')->query($sql);
						
			$logPurged = true;
			
	
		
		return $logPurged;
		
	}


}

