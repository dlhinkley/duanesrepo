<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */


class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_MyFTPClient {
		 
	private $ftp_conn;
	private $ftp_login;
	private $fileType;
	private $timeOut;
	private $address;
	private $username;
	private $password;
	private $directory;
	
	public function __construct($username = null,$password=null,$address=null,$directory=null) {
		
		if ( $this->username != null ) {
			
			$this->username = $username;
			$this->password = $password;
			$this->address = $address;
			$this->directory = $directory;
		}
	}
	public function connect( $address) {
		
		$this->address = $address;
		$this->ftp_conn = ftp_connect($this->address);
		
		if ( $this->ftp_conn === false ) {
			
			throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_FTPClientException("Error connecting to $this->address", 99);
		}
	}
	public function login( $username, $password) {
		
		$this->username = $username;
		$this->password = $password;
		
		$this->ftp_login = ftp_login($this->ftp_conn, $this->userName, $this->password);
		
		if ( $this->ftp_login === false ) {
			
			throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_FTPClientException("Error logining in as $this->username", 99);
		}
	}	
	public function enterLocalPassiveMode() {
		
		if (  ftp_pasv($this->ftp_conn,  true) === false) {
			
			throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_FTPClientException("Error setting passive mode", 99);
		}
		
	}
	public function setFileTypeAscii() {
		
		 $this->fileType = "ASCII";
		
	}
	public function changeWorkingDirectory( $directory) {
		
		$this->directory = $directory;
		
		if (  ftp_chdir($this->ftp_conn, $directory) ===false ) {
			
			throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_FTPClientException("Error changing directory", 99);
		}
	}
	public function setDefaultTimeout($timeout) {
		
		$this->timeOut = $timeout;
	}
	public function deleteFile( $fileName) {
		
		if ( ftp_delete($this->ftp_conn,$fileName) === false ) {
			
			throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_FTPClientException("Error deleting ".$fileName, 99);
			
		}
	}
	public function storeFile( $fileName,   $documentData ) {
		$fn = $fileName;

		$sent = file_put_contents("ftp://$this->username:$this->password@$this->address$this->directory$fn",$documentData);
		
		if (  $sent === false)  {
			
			throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_FTPClientException("Error copying ".$fileName." to $this->address/$this->directory/", 99);
		}
		
	}
	public function disconnect() {
		
		if ( $this->ftp_conn !== false && $this->ftp_conn != null) {
			
			if ( ftp_close($this->ftp_conn) === false )  {
			
			throw new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_FTPClientException("Error closing connection", 99);
		}
		
		}
		
	}
}