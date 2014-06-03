<?php 

class  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_CustomMageFtp extends Mage_System_Ftp {
	

	/**
	 * ftp_fget wrapper
	 *
	 * @param string $remoteFile
	 * @param resource $handle
	 * @param int $mode  FTP_BINARY | FTP_ASCII
	 * @param int $startPos
	 * @return bool
	 */
	public function fget($handle, $remoteFile, $mode = FTP_BINARY, $startPos = 0)
	{
		$this->checkConnected();
		return @ftp_fget($this->_conn, $handle, $remoteFile, $mode, $startPos);
	}
	/**
	 * Connect to server using connect string
	 * Connection string: ftp://user:pass@server:port/path
	 * user,pass,port,path are optional parts
	 *
	 * @param string $string
	 * @param int $timeout
	 */
	public function connect($address, $timeout = 900)
	{
		$params = $this->validateConnectionString($string);
		$port = isset($params['port']) ? intval($params['port']) : 21;
	
		$this->_conn = ftp_connect($address);
	
		if(!$this->_conn) {
			throw new Exception("Cannot connect to host: {$params['host']}");
		}
		if(isset($params['user']) && isset($params['pass'])) {
			$this->login($params['user'], $params['pass']);
		} else {
			$this->login();
		}
		if(isset($params['path'])) {
			if(!$this->chdir($params['path'])) {
				throw new Exception ("Cannot chdir after login to: {$params['path']}");
			}
		}
	}		
}


?>