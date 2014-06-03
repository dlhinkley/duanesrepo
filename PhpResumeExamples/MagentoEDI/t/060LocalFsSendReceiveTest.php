<?php 
require_once('t/TestMaster.php');

//require_once("connector/edi/core/format/EdiFormat.php");




$t = new Test();
$t->setDisplayWarnings();


	 $root  =  "src/connector/edi/core/transport/testfiles/" ;  //  
	 $inpath  =  "t/documents/remote/in/" ;  //  
	 $outpath  =  "t/documents/remote/out/" ;  //  
	 $localSave  =   "t/documents/local/";  //  

			
		$s =  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_SendReceiveFactory::getSendRecieve("LOCALFS"); // SendReceiveInterface
		
		print $t->ok( is_object($s),"factory" );				

	 $s->connect();
	 $s->setLocalFileSeperator("/");
	 $s->setOutPath($outpath );
	print "here\n";	
	 $s->setInPath($inpath);
	 $s->setLocalSave(true);
	 $s->setLocalSaveDirectory($localSave);		
	 $s->setFileConfirmationSuffix("ok");

	 $ediDocument = "This is test text";
	 $documentSent = $s->sendDocument("testdocument1.txt", $ediDocument , false);
		
		print $t->ok( file_exists("t/documents/local/testdocument1.txt"),"sendDocument1 local" );				
		print $t->ok( file_exists("t/documents/remote/out/testdocument1.txt"),"sendDocument1 remote" );				
		
		$documentSent = $s->sendDocument("testdocument2.txt", $ediDocument, true);
	
		print $t->ok( file_exists("t/documents/local/testdocument2.txtok"),"sendDocument2 local" );				
		//print $t->ok( file_exists("t/documents/remote/out/testdocument2.txt"),"sendDocument2 remote" );				
		print $t->ok( file_exists("t/documents/remote/out/testdocument2.txtok"),"sendDocument2 remote" );				
		
				
		$fn = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_FileName();
		
		//$fn->FileNameWithPath("testdocument1.txt",$outpath);
	 	//$s->deleteFile($fn);
	 	
		$fn->FileNameWithPath("testdocument1.txt","t/documents/local/");
	 	$s->deleteFile($fn);
	 	
	 	 
	 	$fn->FileNameWithPath("testdocument2.txtok",$outpath);
	 	$s->deleteFile($fn);
	 	 
	 	
		$fn->FileNameWithPath("testdocument2.txtok","t/documents/local/");
	 	$s->deleteFile($fn);
	 	
	 	$s->disconnect();
		


	
	//public function  testSetDocument()  { // returns void
	
		$s =  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_SendReceiveFactory::getSendRecieve("LOCALFS"); // SendReceiveInterface
	 $s->setInPath($inpath );
		
		 $document = false;
		try {
			
			$document = $s->setDocumentByString(new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_FileName("missingdocument.txt"));
		} 
		catch (Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException $e ) {

			//// This is meant to faile
		}
		
		print $t->ok( $document !== true,"setDocumentByString" );	
		try {
			
			$fn = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_FileName();
			$fn->FileNameWithPath("testread.txt", $inpath);
			
			$document = $s->setDocumentByString($fn);
		} 
		catch (Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException $e ) {

		 //$e->printStackTrace();
		}
		
		print $t->ok( $document,"setDocument" );				
//	}

	
//	public function  testSetFileNames() // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException  { // returns void
		
		$s =  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_SendReceiveFactory::getSendRecieve("LOCALFS"); // SendReceiveInterface
	 $s->setInPath($inpath );
		
	 $s->connect();
		
		 $fileListReceived = false;
				
		
		$fileListReceived = $s->setFileNames();
		
	 $s->disconnect();
	
		print $t->ok($fileListReceived,"setFileNames");
	//}

	
	//public function  testTestConnect() // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException  { // returns void
	//	$s =  SendReceiveFactory::getSendRecieve("LOCALFS"); // SendReceiveInterface
	// $s->setInPath(inpath );
		
	//	$this->assertTrue( $s->testConnect() );
	//}

	
	//public function  testDeleteFile() // throws  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException  { // returns void
		
		$s =  Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_SendReceiveFactory::getSendRecieve("LOCALFS"); // SendReceiveInterface
		
		print $t->ok( $s != null,"deleteFile" );				
	
	 $s->connect();
	 $s->setInPath($inpath );
		;	
		// Hey, we need this file.
		//assertTrue($s->deleteFile("read.txt"));
		
	 $s->disconnect();
		
	//}



print $t->summary();
$t->destroy();

	
