<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */
 
class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_SendReceiveFactory {

	public function   getSendRecieve( $transportType ) { // returns SendReceiveInterface

		$sr =  null; // SendReceiveInterface
		
		if ( $transportType == "FTP" ) {
			
			$sr = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_FTPSendReceive();
			
		}
		
		// Local filesystem
		else if ( $transportType == "LOCALFS" ) {
			
			$sr = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_LocalFsSendReceive();
		}
		
		return $sr;
	}
	public function  testConnect( $transportType ) {// throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException  { // returns boolean
		
		return $this->getSendRecieve($transportType )>testConnect();
	}
}
