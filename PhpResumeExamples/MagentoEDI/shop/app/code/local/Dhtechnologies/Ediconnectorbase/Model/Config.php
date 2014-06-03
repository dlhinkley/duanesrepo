<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */


class Dhtechnologies_Ediconnectorbase_Model_Config {

	private static $testMode = false;
	
	/**
	 * @return the $testMode
	 */
	public static function isTestMode() {
		return Dhtechnologies_Ediconnectorbase_Model_Config::$testMode;
	}

	/**
	 * @param boolean $testMode
	 */
	public static function setTestMode($testMode) {
		Dhtechnologies_Ediconnectorbase_Model_Config::$testMode = $testMode;
	}

	public static function getModuleDir() {

		return Mage::getConfig()->getModuleDir('etc', 'Dhtechnologies_Ediconnectorbase');
	}
	
	/**
	 *
	 * Enter description here ...
	 * @return ConfigActionIterator
	 */
	

	public static function getEdiInboundLogDaysToKeep() {


		return  (string) Mage::getStoreConfig('ediconnector/ediconnectorgeneral/inbound_logs_days_to_keep');
	}
	
	public static function getEdiEndLineDelimiter() {

		$endLine =  (String) Mage::getStoreConfig('ediconnector/ediconnectorgeneral/end_line_delimiter');
		

		
		return  self::hex2chr($endLine );
	}
	public static function hex2chr($string) {
		
		$delimiter = "";
		$hexSets = str_split($string,2);
		
		foreach ( $hexSets AS $hex) {
			
			$ascii = hexdec ($hex);
			$delimiter .= chr($ascii);
		}
		return $delimiter;
	}
	public static function getEdiInLineDelimiter() {

		return  (string) Mage::getStoreConfig('ediconnector/ediconnectorgeneral/in_line_delimiter');
	}
	public static function getSendOrderStatus() {

		$status =  (string) Mage::getStoreConfig('ediconnector/ediconnector850out/send_order_status');

		$status = strtolower($status);
		
		return $status;	
	}
	public static function isDocumentActive($documentType,$direction) {

		$direction = strtolower($direction);
		
		return (int) Mage::getStoreConfig("ediconnector/ediconnector$documentType$direction/active");
	}
	public static function isBaseActive() {
		
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("start");
		
		return (int) Mage::getStoreConfig('ediconnector/ediconnectorgeneral/active');
	}
	public static function getDateFormat() {

		$dateFormat = (string) Mage::getStoreConfig('ediconnector/ediconnectorgeneral/date_format');
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" dataFormat=$dateFormat",10);
		
		
		return $dateFormat ;
	}
	public static function getLongDateFormat() {

		return  (string) Mage::getStoreConfig('ediconnector/ediconnectorgeneral/long_date_format');
	}
	public static function getTimeFormat() {

		return  (string) Mage::getStoreConfig('ediconnector/ediconnectorgeneral/time_format');
	}
	public static function getLongTimeFormat() {

		return  (string) Mage::getStoreConfig('ediconnector/ediconnectorgeneral/long_time_format');
	}
	public static function isEdiEachDocInOwnFile() {
		// not programmed for this to be changeable yet
		return true;
	}
	public static function getEdiRecordTypePosition() {

		return  (int) Mage::getStoreConfig('ediconnector/ediconnectorgeneral/record_type_position');
	}

	public static function getEdiRecordTypeElement() {
	
		return  (string) Mage::getStoreConfig('ediconnector/ediconnectorgeneral/record_type_element');
	}
	
	
	public static function getEdiQuoteCharacter() {

		return "'";
	}
	
	public static function getEdiOutboundLogDaysToKeep() {

		return  (string) Mage::getStoreConfig('ediconnector/ediconnectorgeneral/outbound_logs_days_to_keep');
		
	}
	


	public static function getEdiTransportType(){

		return  (string) Mage::getStoreConfig('ediconnector/ediconnectorgeneral/transport_type');
	}
	public static function getClientFtpDeleteReceivedFile() {

			$delete = (string) Mage::getStoreConfig('ediconnector/ediconnectorgeneral/delete_received_file');
			return ($delete == 1);
	}




	public static function setEdiTransportType( $str) { 
		self::setStoreConfig('ediconnector/ediconnectorgeneral/transport_type',$str);
	
	}

	public static function setClientFtpOutPath( $str) {				
		
		self::setStoreConfig('ediconnector/ediconnectorgeneral/ftp_out_path',$str);
	}
	
	public static function setClientFtpConfirmationSuffix( $str) { 				
		
		self::setStoreConfig('ediconnector/ediconnectorgeneral/confirmation_suffix',$str);
	}
	public static function setClientFtpSaveLocalSent( $bool) { 
		
		self::setStoreConfigFlag('ediconnector/ediconnectorgeneral/save_local_sent',$bool);
		
	}
	public static function setClientFtpSaveLocalSentDocumentPath( $str) {				
		
		self::setStoreConfig('ediconnector/ediconnectorgeneral/save_local_sent_document_path',$str);
	}
	public static function setClientFtpInPath( $str) { 				
		
		self::setStoreConfig('ediconnector/ediconnectorgeneral/ftp_in_path',$str);
	}

	private static function setStoreConfigFlag($path,$value) {
		
		if ( $value === true ) {
			
			self::setStoreConfig($path, '1');
		}
		else {
			
			self::setStoreConfig($path, '0');
		}
	}
    private static  function setStoreConfig($path,$value)
    {
        return Mage::app()->getStore(null)->setConfig($path,$value);
    }
	public static function getClientFtpAddress() {  
		
		return  (string) Mage::getStoreConfig('ediconnector/ediconnectorgeneral/ftp_address');
	}
	public static function getClientFtpUserName() { 
		
		return  (string) Mage::getStoreConfig('ediconnector/ediconnectorgeneral/ftp_username');
	}
	public static function getClientFtpPassword() { 
		
		return  (string) Mage::getStoreConfig('ediconnector/ediconnectorgeneral/ftp_password');
	}
	public static function getClientFtpOutPath() { 
		
		return  (string) Mage::getStoreConfig('ediconnector/ediconnectorgeneral/ftp_out_path');
	}
	public static function getClientFtpConfirmationSuffix() {
		
		return  (string) Mage::getStoreConfig('ediconnector/ediconnectorgeneral/confirmation_suffix');
	}
	public static function getClientFtpInboundSuffix() {
		
		return  (string) Mage::getStoreConfig('ediconnector/ediconnectorgeneral/inbound_suffix');
	}
	public static function getClientFtpOutboundSuffix() {
		
		return  (string) Mage::getStoreConfig('ediconnector/ediconnectorgeneral/outbound_suffix');
	}
	public static function getClientFtpSaveLocalSent() {
		$send = (string) Mage::getStoreConfig('ediconnector/ediconnectorgeneral/save_local_sent');
		return ($send == 1);
	}
	public static function getClientFtpSaveLocalSentDocumentPath() { 
		
		return  (string) Mage::getStoreConfig('ediconnector/ediconnectorgeneral/save_local_sent_document_path');
	}
	public static function getClientFtpInPath() {  
		
		return  (string) Mage::getStoreConfig('ediconnector/ediconnectorgeneral/ftp_in_path');
	}

}