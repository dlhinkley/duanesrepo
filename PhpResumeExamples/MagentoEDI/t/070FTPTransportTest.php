<?php 

/**
 * NOTE: This test requires the FTP information be set in Magento configuration for this module
 */

require_once('t/TestMaster.php');

//print Dhtechnologies_Ediconnectorbase_Model_Config::getClientFtpOutPath();

$t =  new Test();
$t->setDisplayWarnings();

$test = new TransportTest();

$test->testSenderFTP();
$test->testTransportFTP();

$test->testCreateFileToDeleteFTP();
$test->testReceiverDeleteFileFTP();

$test->testGetFileNamesFTP();
$test->testGetDocumentFTP();
$test->testGetAllDocumentsFTP();

 print $t->summary();
$t->destroy();





class TransportTest    {

	private $username ;  //  String
	private $password ;  //  String
	private $inpath ;  //  String
	private $outPath ;  //  String
	private $address ;  //  String
//	private $localSave  = new String( "C:\\workspace\\FbUpdateClient\\SentEdiDocuments\\");  //  String
//	private $saveDirectory  = new String( "C:\\workspace\\FbUpdateClient\\ReceivedEdiDocuments\\");  //  String
//	private $username  = new String( "dlhinkley");  //  String
//	private $password  = new String( "lfnyisnl");  //  String
//	private $inpath  = new String( "/disk3/home/david/EdiDropBox/");  //  String
//	private $outPath  = new String( "/disk3/home/david/InboundEdiDropBox/");  //  String
//	private $address  = new String( "dev.dhwd.com");  //  String
	private $localSave ;  //  boolean
private $saveDirectory ;  //  String
	private $randNumber;
	
//	INSERT INTO CONFIGURATION (CONFIG_NAME, CONFIG_VALUE) VALUES ('is_receive_edi_documents', '1');
//	INSERT INTO CONFIGURATION (CONFIG_NAME, CONFIG_VALUE) VALUES ('is_send_edi_documents', '1');
//	INSERT INTO CONFIGURATION (CONFIG_NAME, CONFIG_VALUE) VALUES ('ftp_client_save_local_received_1', '1');
//	INSERT INTO CONFIGURATION (CONFIG_NAME, CONFIG_VALUE) VALUES ('ftp_client_save_local_sent_1', '1');
//	INSERT INTO CONFIGURATION (CONFIG_NAME, CONFIG_VALUE) VALUES ('ftp_client_save_local_received_doc_path_1', 'C:\\workspace\\FbUpdateClient\\ReceivedEdiDocuments\\');
//	INSERT INTO CONFIGURATION (CONFIG_NAME, CONFIG_VALUE) VALUES ('ftp_client_save_local_sent_doc_path_1', 'C:\\workspace\\FbUpdateClient\\SentEdiDocuments\\');
//	INSERT INTO CONFIGURATION (CONFIG_NAME, CONFIG_VALUE) VALUES ('ftp_client_send_confirmation_file_1', '0');
//	INSERT INTO CONFIGURATION (CONFIG_NAME, CONFIG_VALUE) VALUES ('ftp_client_address_1', 'dev.dhwd.com');
//	INSERT INTO CONFIGURATION (CONFIG_NAME, CONFIG_VALUE) VALUES ('ftp_client_username_1', 'david');
//	INSERT INTO CONFIGURATION (CONFIG_NAME, CONFIG_VALUE) VALUES ('ftp_client_password_1', 'letmein2@1@');
//	INSERT INTO CONFIGURATION (CONFIG_NAME, CONFIG_VALUE) VALUES ('ftp_client_in_path_1', '/disk3/home/david/InboundEdiDropBox/');
//	INSERT INTO CONFIGURATION (CONFIG_NAME, CONFIG_VALUE) VALUES ('ftp_client_out_path_1', '/disk3/home/david/InboundEdiDropBox/');
//	INSERT INTO CONFIGURATION (CONFIG_NAME, CONFIG_VALUE) VALUES ('ftp_client_delete_received_file_1', '0');
//	INSERT INTO CONFIGURATION (CONFIG_NAME, CONFIG_VALUE) VALUES ('ftp_client_confirmation_suffix_1', '.ok');



	public function TransportTest() {
		
		global $ediConfig;
		$this->username  = Dhtechnologies_Ediconnectorbase_Model_Config::getClientFtpUserName( );  //  String
		$this->password  = Dhtechnologies_Ediconnectorbase_Model_Config::getClientFtpPassword();  //  String
		$this->inpath  = Dhtechnologies_Ediconnectorbase_Model_Config::getClientFtpInPath( );  //  String
		$this->outPath  = Dhtechnologies_Ediconnectorbase_Model_Config::getClientFtpOutPath();  //  String
		$this->address  = Dhtechnologies_Ediconnectorbase_Model_Config::getClientFtpAddress( );  //  String
		$this->localSave  = true;
		
		$this->localSaveDirectory  = Dhtechnologies_Ediconnectorbase_Model_Config::getClientFtpSaveLocalSentDocumentPath( "/Users/dlhinkley/Tmp/");  //  String	
			
		$this->randNumber = rand(9999,9999999);
		/*
		Dhtechnologies_Ediconnectorbase_Model_Config::setClientFtpAddress($this->address);
		Dhtechnologies_Ediconnectorbase_Model_Config::setClientFtpUserName($this->username);
		Dhtechnologies_Ediconnectorbase_Model_Config::setClientFtpPassword($this->password);
		Dhtechnologies_Ediconnectorbase_Model_Config::setClientFtpOutPath($this->outPath);
		Dhtechnologies_Ediconnectorbase_Model_Config::setClientFtpConfirmationSuffix("ok");		
		Dhtechnologies_Ediconnectorbase_Model_Config::setClientFtpSaveLocalSent(false);
		Dhtechnologies_Ediconnectorbase_Model_Config::setClientFtpSaveLocalSentDocumentPath($this->localSaveDirectory);	
		Dhtechnologies_Ediconnectorbase_Model_Config::setClientFtpInPath($this->inpath);
		*/
		}
	
	public function  testSenderSFTP() { // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException  { // returns void
		/*
		print("testSenderSFTP Begin");
		Dhtechnologies_Ediconnectorbase_Model_Config::setClientFtpAddress(address,"9");
		Dhtechnologies_Ediconnectorbase_Model_Config::setClientFtpUserName(username,"9");
		Dhtechnologies_Ediconnectorbase_Model_Config::setClientFtpPassword(password,"9");
		Dhtechnologies_Ediconnectorbase_Model_Config::setClientFtpOutPath(outPath,"9");
		Dhtechnologies_Ediconnectorbase_Model_Config::setClientFtpConfirmationSuffix("ok","9");		
		Dhtechnologies_Ediconnectorbase_Model_Config::setClientFtpSaveLocalSent("1","9");
		Dhtechnologies_Ediconnectorbase_Model_Config::setClientFtpSaveLocalSentDocumentPath(saveDirectory,"9");	
		Dhtechnologies_Ediconnectorbase_Model_Config::setClientFtpInPath(inpath,"9");
		 $documentSent = false;
		
		$ediDocument = "" . 	 // String
					"HR*123456789      *8839393939                    ********~\n" .
					"CD*123456789      *8839393939                    *001*LD********************~\n" .
					"CD*123456789      *8839393939                    *002*LD********************~\n" .
					"RL*898949494      *8899                          ***~\n" .
					"CD*123456789      *8839393939                    *003*PU********************~\n" .
					"RL*898949494      *77777                         ***~\n" .
					"CD*123456789      *8839393939                    *004*LD********************~\n" .
					"CD*123456789      *8839393939                    *005*LD********************~\n" .
					"ST*123456789      *8839393939                    ******~\n";
		
		$s =  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_SendReceiveFactory::getSendRecieve("SFTP","9"); // SendReceiveInterface
	 $s->setAddress(address);
	 $s->setUsername(username);
	 $s->setPassword(password);
	 $s->setOutPath(inpath);
	 $s->setLocalSave($this->localSave);
	 $s->setLocalSaveDirectory($this->localSaveDirectory);		
	 $s->setFileConfirmationSuffix(".ok");
		
		$documentSent = $s->sendDocument("EDI-SFTP-940.edi", ediDocument, false);
		
		if ( documentSent ) {
			$documentSent = $s->sendDocument("EDI-SFTP-940.edi", ediDocument, true);
		}
		
	 $s->disconnect();
		
		$this->assertTrue( documentSent );		
		*/
	}
	
	
	public function  testSenderFTP( ){ // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException  { // returns void
		global $t;
		
		print("testSenderFTP Begin");
		
		 $documentSent = false;//boolean
		
		$ediDocument = "" . 	 // String
					"HR*123456789      *8839393939                    ********~\n" .
					"CD*123456789      *8839393939                    *001*LD********************~\n" .
					"CD*123456789      *8839393939                    *002*LD********************~\n" .
					"RL*898949494      *8899                          ***~\n" .
					"CD*123456789      *8839393939                    *003*PU********************~\n" .
					"RL*898949494      *77777                         ***~\n" .
					"CD*123456789      *8839393939                    *004*LD********************~\n" .
					"CD*123456789      *8839393939                    *005*LD********************~\n" .
					"ST*123456789      *8839393939                    ******~\n";
		
		$s =  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_SendReceiveFactory::getSendRecieve("FTP"); // SendReceiveInterface
	 $s->setAddress($this->address);
	 $s->setUsername($this->username);
	 $s->setPassword($this->password);
	 $s->setOutPath($this->inpath);
	 $s->setLocalSave($this->localSave);
	 $s->setLocalSaveDirectory($this->localSaveDirectory );
	 $s->setFileConfirmationSuffix(".ok");
	 
		$s->connect();
		
		$documentSent = $s->sendDocument("EDI-FTP-940-".$this->randNumber.".edi", $ediDocument, false);
		
		if ( $documentSent ) {		
			$documentSent = $s->sendDocument("EDI-FTP-940-".$this->randNumber.".edi",  $ediDocument, true);
		}
		
	 	$s->disconnect();
		
		$t->ok( $documentSent,'test SenderFTP' );		
		
	}

	
	public function  testTransportSFTP() {// throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException  { // returns void
		
		print("testTransportSFTP Begin");
		
		 $documentSent = false;
		
		$ediDocument = "" . 	 // String
					"HR*123456789      *8839393939                    ********~\n" .
					"CD*123456789      *8839393939                    *001*LD********************~\n" .
					"CD*123456789      *8839393939                    *002*LD********************~\n" .
					"RL*898949494      *8899                          ***~\n" .
					"CD*123456789      *8839393939                    *003*PU********************~\n" .
					"RL*898949494      *77777                         ***~\n" .
					"CD*123456789      *8839393939                    *004*LD********************~\n" .
					"CD*123456789      *8839393939                    *005*LD********************~\n" .
					"ST*123456789      *8839393939                    ******~\n";
		
		$t =  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportFactory::getEdiTransport(); // EdiTransportInterface
//TODO	 $t->setTransportType("SFTP");
			
		
		$documentSent = $t->SendDocument("EDI-Transport-SFTP-940-$this->randNumber.edi", ediDocument);
				
		$this->assertTrue( documentSent );		
		
	}
		
	
	public function  testTransportFTP() { // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException  { // returns void
		global $ediConfig;
		global $t;

		//Dhtechnologies_Ediconnectorbase_Model_Config::setEdiTransportType( "FTP");
		
		 $documentSent = false;
		
		$ediDocument = "" . 	 // String
					"HR*123456789      *8839393939                    ********~\n" .
					"CD*123456789      *8839393939                    *001*LD********************~\n" .
					"CD*123456789      *8839393939                    *002*LD********************~\n" .
					"RL*898949494      *8899                          ***~\n" .
					"CD*123456789      *8839393939                    *003*PU********************~\n" .
					"RL*898949494      *77777                         ***~\n" .
					"CD*123456789      *8839393939                    *004*LD********************~\n" .
					"CD*123456789      *8839393939                    *005*LD********************~\n" .
					"ST*123456789      *8839393939                    ******~\n";
		

		
		$s =  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportFactory::getEdiTransport(); // EdiTransportInterface
		
		//TODO	 $t->setTransportType();

		
		$documentSent = $s->SendDocument("EDI-Transport-FTP-940-".$this->randNumber.".edi", $ediDocument);

		print $t->ok($documentSent,"testTransportFTP",$documentSent);
		//$this->assertTrue( $documentSent );		
		
	}
	
	
	public function  testCreateFileToDeleteSFTP() { // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException  { // returns void
		
		print("testCreateFileToDeleteSFTP Begin");
		
		 $documentSent = false;
		
		$ediDocument = "" . 	 // String
					"HR*123456789      *8839393939                    *New File*******~\n" .
					"CD*123456789      *8839393939                    *001*LD********************~\n" .
					"CD*123456789      *8839393939                    *002*LD********************~\n" .
					"RL*898949494      *8899                          ***~\n" .
					"CD*123456789      *8839393939                    *003*PU********************~\n" .
					"RL*898949494      *77777                         ***~\n" .
					"CD*123456789      *8839393939                    *004*LD********************~\n" .
					"CD*123456789      *8839393939                    *005*LD********************~\n" .
					"ST*123456789      *8839393939                    ******~\n";
		
		$s =  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_SendReceiveFactory::getSendRecieve("SFTP","9"); // SendReceiveInterface
	 $s->setAddress(address);
	 $s->setUsername(username);
	 $s->setPassword(password);
	 $s->setOutPath(outPath);
	 $s->setLocalSave($this->localSave);
	 $s->setLocalSaveDirectory($this->localSaveDirectory);		
	 $s->setFileConfirmationSuffix(".ok");
		
	 $s->connect();
	 
		$documentSent = $s->sendDocument("SFTPInbound123-$this->randNumber.edi", ediDocument, false);
		$documentSent = $s->sendDocument("SFTPInbound123_B-$this->randNumber.edi", ediDocument, false);
		
		if ( documentSent ) {
			$documentSent = $s->sendDocument("SFTPInbound123-$this->randNumber.edi", ediDocument, true);
		}
		
	 $s->disconnect();
		
		$this->assertTrue( documentSent );		
		
	}
		
	
	public function  testCreateFileToDeleteFTP() { // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException  { // returns void
		global $t;
		print("testCreateFileToDeleteFTP Begin");
		
		 $documentSent = false;
		
		$ediDocument = "" . 	 // String
					"HR*123456789      *8839393939                    ********~\n" .
					"CD*123456789      *8839393939                    *001*LD********************~\n" .
					"CD*123456789      *8839393939                    *002*LD********************~\n" .
					"RL*898949494      *8899                          ***~\n" .
					"CD*123456789      *8839393939                    *003*PU********************~\n" .
					"RL*898949494      *77777                         ***~\n" .
					"CD*123456789      *8839393939                    *004*LD********************~\n" .
					"CD*123456789      *8839393939                    *005*LD********************~\n" .
					"ST*123456789      *8839393939                    ******~\n";
		
		$s =  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_SendReceiveFactory::getSendRecieve("FTP"); // SendReceiveInterface
	 $s->setAddress($this->address);
	 $s->setUsername($this->username);
	 $s->setPassword($this->password);
	 $s->setOutPath($this->outPath);
	 $s->setLocalSave($this->localSave);
	 $s->setLocalSaveDirectory($this->localSaveDirectory);
	 $s->setFileConfirmationSuffix(".ok");
	 
		$s->connect();
		
		$documentSent = $s->sendDocument("FTPInbound123-$this->randNumber.edi", $ediDocument, false);
		$documentSent = $s->sendDocument("FTPInbound123_B-$this->randNumber.edi", $ediDocument, false);
		
		if ( $documentSent ) {		
			$documentSent = $s->sendDocument("FTPInbound123-$this->randNumber.edi", $ediDocument, true);
		}
		
	 $s->disconnect();
		
		print $t->ok( $documentSent, 'testCreateFileToDeleteFTP' );	
		
	}
	
	
	
	public function  testReceiverDeleteFileSFTP() { // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException  { // returns void
		
		print("testReceiverDeleteFileSFTP Begin");
		
		 $fileDeleted = false;
		
		
		$r =  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_SendReceiveFactory::getSendRecieve("SFTP","9"); // SendReceiveInterface
	 $r->setAddress(address);
	 $r->setUsername(username);
	 $r->setPassword(password);
	 $r->setInPath(outPath);
	 $r->setLocalSave(true);
	 $r->setLocalSaveDirectory(saveDirectory );	
	 $r->setDeleteFile(true);
				
		$fileDeleted = $r->deleteFile("SFTPInbound123-$this->randNumber.edi" );
				
	 $r->disconnect();
		
		$this->assertTrue( fileDeleted );		
		
	}
	
	
	public function  testReceiverDeleteFileFTP() { // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException  { // returns void
		global $t;
		print("testReceiverDeleteFileFTP Begin");
		
		 $fileDeleted = false;
				
		$r =  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_SendReceiveFactory::getSendRecieve("FTP"); // SendReceiveInterface
	 $r->setAddress($this->address);
	 $r->setUsername($this->username);
	 $r->setPassword($this->password);
	 $r->setInPath($this->outPath);
	 $r->setLocalSave(true);
	 $r->setLocalSaveDirectory($this->localSaveDirectory);	
	 $r->setDeleteFile(true);
				$r->connect();
				
				$fileDeleted = $r->deleteFile(new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_FileName( "FTPInbound123-$this->randNumber.edi"));
				
	 $r->disconnect();
		
	print $t->ok( $fileDeleted,'testReceiverDeleteFileFTP' );		
		
	}
	
	
	public function  testGetFileNamesSFTP() { // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException  { // returns void
	
		print("testGetFileNamesSFTP Begin");
		
		 $fileListReceived = false;
		$objectFileListResults = "";
				
		$r =  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_SendReceiveFactory::getSendRecieve("SFTP","9"); // SendReceiveInterface
	 $r->setAddress(address);
	 $r->setUsername(username);
	 $r->setPassword(password);
	 $r->setInPath(outPath);
	 $r->setLocalSave(true);
	 $r->setLocalSaveDirectory(localSave);	
	 $r->setDeleteFile(true);
		
		$fileListReceived = $r->setFileNames();
		
	 $r->disconnect();
	
		if (fileListReceived) {
			$filenames =  $r->getFileNames();  // FileNames
			
			while ( $filenames->hasNext()) {
				
				$fn =  $filenames->next(); // FileName
				$objectFileListResults .= $fn->getFileName() . "\n";
			}
			
			print("Object File List Results = \n" . objectFileListResults);
		}
		else {
			print("No Files Found Vis SFTP");	
		}
		
		$this->assertTrue( fileListReceived );
	}
	
	
	public function  testGetFileNamesFTP() { // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException  { // returns void
	
		global $t;
		
		print("testGetFileNamesFTP Begin");
		
		 $fileListReceived = false;
		$objectFileListResults = "";
				
		$r =  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_SendReceiveFactory::getSendRecieve("FTP"); // SendReceiveInterface
	 $r->setAddress($this->address);
	 $r->setUsername($this->username);
	 $r->setPassword($this->password);
	 $r->setInPath($this->outPath);
	 $r->setLocalSave(true);
	 $r->setLocalSaveDirectory($this->localSaveDirectory);	
	 $r->setDeleteFile(true);
		
	 $r->connect();
	 
		$fileListReceived = $r->setFileNames();
		
	 $r->disconnect();
		
		if ($fileListReceived) {
			$filenames =  $r->getFileNames();  // FileNames
					
			while ( $filenames->hasNext()) {
				
				$fn =  $filenames->next(); // FileName
				print $fn->getFileName() . "\n";
			}
			
		}
		else {
			print("No Files Found Vis FTP");
		}
		
		print $t->ok( $fileListReceived,'testGetFileNamesFTP' );
	}
		

	
	public function  testGetDocumentSFTP() { // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException  { // returns void
	
		print("testGetDocumentSFTP Begin");
		
		 $documentReceived = false;
						
		$r =  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_SendReceiveFactory::getSendRecieve("SFTP","9"); // SendReceiveInterface
	 $r->setAddress(address);
	 $r->setUsername(username);
	 $r->setPassword(password);
	 $r->setInPath(outPath);		
	 $r->setLocalSave(true);
	 $r->setLocalSaveDirectory(localSave);	
	 $r->setDeleteFile(false);
		
		$documentReceived = $r->setDocumentByString("SFTPInbound123_B-$this->randNumber.edi" );
		
	 $r->disconnect();
		
		if ( documentReceived ) {
			print("Document Received Via SFTP Source File Name = " . $r->getDocumentSourceFileName());
			print("Document Received Via SFTP= \n" . $r->getDocument() );	
		}
		else {
			print("No Document Found Via SFTP");
		}
		
	}	
		
	
	public function  testGetDocumentFTP() { // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException  { // returns void
	
		global $t;
		
		print("testGetDocumentFTP Begin");
		
		 $documentReceived = false;
						
		$r =  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_SendReceiveFactory::getSendRecieve("FTP"); // SendReceiveInterface
	 $r->setAddress($this->address);
	 $r->setUsername($this->username);
	 $r->setPassword($this->password);
	 $r->setInPath($this->outPath);		
	 $r->setLocalSave(true);
	 $r->setLocalSaveDirectory($this->localSaveDirectory);	
	 $r->setDeleteFile(false);
	 
		$r->connect();
		
		$fileName = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_FileName();
		$fileName->setFileName("FTPInbound123_B-$this->randNumber.edi");
		$fileName->setFilePath($this->outPath);
		
		$documentReceived = $r->setDocumentByString($fileName);
		
	 $r->disconnect();
		
		if ( $documentReceived ) {
			print("Document Received Via FTP Source File Name = " . $r->getDocumentSourceFileName());
			print("Document Received Via FTP= \n" . $r->getDocument());	
		}
		else {
			print("No Document Found Via FTP");
		}	
		
		print $t->ok( $documentReceived,'testGetDocumentFTP' );
	}
	
	/*
	public function  testGetAllDocumentsSFTP() { // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException  { // returns void
			global $ediConfig,$t;
		
		print("testGetAllDocumentsSFTP Begin");
		Dhtechnologies_Ediconnectorbase_Model_Config::setEdiTransportType("SFTP","9");
		
		 $gotDocuments = false;
		 $ediDocumentRecords;//EdiDocumentRecords
		$objectEdiDocumentContentsResults = "";
				
		$t =  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportFactory::getEdiTransport(); // EdiTransportInterface
		//TODO	 $t->setTransportType();
	 $t->connect();
		$ediDocumentRecords = $t->receiveAllDocuments();
		
		while ( $ediDocumentRecords->hasNext()) {		
			$gotDocuments = true;
			$dc =  $ediDocumentRecords->next(); // EdiDocumentRecord
			$objectEdiDocumentContentsResults .= $dc->getDocumentContent() . 
			"--------------------------------------------------------------------------------\n";
		}
		
		print("Object Document Contents Results via SFTP = \n" . objectEdiDocumentContentsResults);
		
		$this->assertTrue( $gotDocuments );
	}
	
	*/
	public function  testGetAllDocumentsFTP() { // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException  { // returns void
	
			global $ediConfig,$t;
				
		print("testGetAllDocumentsFTP Begin");
		//Dhtechnologies_Ediconnectorbase_Model_Config::setEdiTransportType("FTP");
		//Dhtechnologies_Ediconnectorbase_Model_Config::setClientFtpInPath($this->outPath);
		
		 $gotDocuments = false;
		 $ediDocumentRecords;//EdiDocumentRecords
				
		$r =  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportFactory::getEdiTransport(); // EdiTransportInterface
		//TODO	 $t->setTransportType();
		
	 	$r->connect();
	 	
		$ediDocumentRecords = $r->receiveAllDocuments();
		
		print __METHOD__ . " found " . $ediDocumentRecords->size() . " records\n";
		
		while ( $ediDocumentRecords->hasNext()) {	
				
			$gotDocuments = true;
			$dc =  $ediDocumentRecords->next(); // EdiDocumentRecord
			print  $dc->getDocumentContent() . 
			"--------------------------------------------------------------------------------\n";
		}
		
		
		print $t->ok($gotDocuments,'testGetAllDocumentsFTP' );
	}	
	
	
}