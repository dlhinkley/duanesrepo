<?php 

require_once('t/TestMaster.php');

//require_once("connector/edi/core/format/EdiFormat.php");




$t = new Test();
$t->setDisplayWarnings();

	 $address = Dhtechnologies_Ediconnectorbase_Model_Config::getClientFtpAddress();
	 $username = Dhtechnologies_Ediconnectorbase_Model_Config::getClientFtpUserName();
	 $password = Dhtechnologies_Ediconnectorbase_Model_Config::getClientFtpPassword();
	 $inPath = Dhtechnologies_Ediconnectorbase_Model_Config::getClientFtpInPath();
	 $outPath = Dhtechnologies_Ediconnectorbase_Model_Config::getClientFtpOutPath();
	 $fileConfirmationSuffix = Dhtechnologies_Ediconnectorbase_Model_Config::getClientFtpConfirmationSuffix();
	 $localSave = Dhtechnologies_Ediconnectorbase_Model_Config::getClientFtpSaveLocalSent();
	 $localSaveDirectory = Dhtechnologies_Ediconnectorbase_Model_Config::getClientFtpSaveLocalSentDocumentPath();

	 print " $address - $username - $password - $inPath - $outPath\n";
	 
	 if ( ! $address || ! $username || ! $password || ! $inPath || ! $outPath ) {
	 	
	 	throw new Exception("Must be configured in magento before running this test");
	 }
	 

		
		// Clean out directory
// Delete all files in the folder logs
$conn_id = ftp_connect($address);

if ( $conn_id === false ) {
	
	throw new Exception("Error logging in");
}
// login with username and password
$login_result = ftp_login($conn_id, $username, $password);
	 
// Delete inbound files	 
ftp_chdir($conn_id, $inPath);
$files = ftp_nlist($conn_id, ".");
foreach ($files as $file)
{
    ftp_delete($conn_id, $file);
}

// Delete outbound files
ftp_chdir($conn_id, $outPath);
$files = ftp_nlist($conn_id, ".");
foreach ($files as $file)
{
    ftp_delete($conn_id, $file);
}
ftp_nb_put($conn_id, "$inPath/832.edi", "t/documents/testfiles/832.edi", FTP_BINARY);




// Empty the database
Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase::emptyOutBound();
Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase::emptyInBound();

// Run the test
Dhtechnologies_Ediconnectorbase_Model_Main::processDocuments();

	 

// Make sure there's a ack in the outbox
$outbound = Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase::getOutBoundDocuments("997",true);

print $t->ok($outbound->getSize() == 1, "getSize", $outbound->getSize() );

// Make sure the document is marked processed
$inbound = Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Database_EdiDocumentDatabase::getInBoundDocuments("832",true);

print $t->ok($inbound->getSize() == 1, "getSize", $inbound->getSize() );

// Make sure there's a ack in outbound and nothing in inbound

$filename = $outbound->getFilename();

$doc = file_get_contents("ftp://$username:$password@$address/$outPath/$filename");

print $t->ok($doc,"ack sent" );

// this don't work
$success = file_get_contents("ftp://$username:$password@$address/$inPath/832.edi");
print $t->ok(! $success,"832 deleted" );


ftp_close($conn_id);

print $t->summary();
$t->destroy();

	
	
//}