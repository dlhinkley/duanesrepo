<?php 
require_once('t/TestMaster.php');
require_once('connector/edi/core/documents/type/DocumentSpecs.php');
require_once('connector/edi/core/documents/type/Edi810.php');

require_once('connector/main/GlobalHardErrorException.php');




class Edi810Test  {

//	
//	 void testEdi204() {
//						
//		Edi850 $edi850 = new Edi850(new DocumentSpecs());
//		Edi850HoRecord $ho = new Edi850HoRecord(new DocumentSpecs());
//		
//	 $ho->setTradingPartnerId("123456789");
//	 $ho->setPurchaseOrderNumber("3456");		
//						
//	 $edi850->setHoRecord(ho);
//		
//		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("TradingPartnerId: " . $ho->getTradingPartnerId(),10);
//		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("DepositorOrderNumber: " . $ho->getPurchaseOrderNumber(),10);
//		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("RecordType: " . $ho->getRecordType(),10);		
//		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("ho Record Line: " . $ho->getRecord(),10);
//		
//		//First Line
//		Edi850Line $line1 = new Edi850Line(new DocumentSpecs());
//		Edi850LiRecord $li1 = new Edi850LiRecord(new DocumentSpecs());
//		Edi850RlRecord $rl1 = new Edi850RlRecord(new DocumentSpecs());
//		
//	 $li1->setTradingPartnerId("123456789");
//	 $li1->setPurchaseOrderNumber("3333333");
//	 $li1->setRecordType("LI");		
//		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("LI Record Line 1: " . $li1->getRecord(),10);
//		
//	 $line1->setLiRecord(li1);
//		
//	 $rl1->setTradingPartnerId("898949494");
//	 $rl1->setPurchaseOrderNumber("8899");
//	 $rl1->setRecordType("RL");
//		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("RL Record Line 1: " . $rl1->getRecord(),10);
//		
//	 $line1->setRlRecord(rl1);
//		
//	 $edi850->addLine(line1);
//		
//		//Second Line
//		Edi850Line $line2 = new Edi850Line(new DocumentSpecs());
//		Edi850LiRecord $li2 = new Edi850LiRecord(new DocumentSpecs());
//		Edi850RlRecord $rl2 = new Edi850RlRecord(new DocumentSpecs());
//		
//	 $li2->setTradingPartnerId("123456789");
//	 $li2->setPurchaseOrderNumber("88393454393939");
//	 $li2->setRecordType("LI");		
//		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("LI Record Line 2: " . $li2->getRecord(),10);
//		
//	 $line2->setLiRecord(li2);
//				
//	 $rl2->setTradingPartnerId("333343");
//	 $rl2->setPurchaseOrderNumber("45454");
//	 $rl2->setRecordType("RL");
//		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("RL Record Line 2: " . $rl2->getRecord(),10);
//		
//	 $line2->setRlRecord(rl2);
//		
//	 $edi850->addLine(line2);
//		
//		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("EdiLines: \n"  . $edi850->getEdiLines() ,10);
//		
//		
//		Edi850StRecord $st = new Edi850StRecord(new DocumentSpecs());
//		
//	 $st->setTradingPartnerId("123456789");
//	 $st->setPurchaseOrderNumber("343433");
//	 $st->setRecordType("ST");		
//		//st->setInLineDelimiter("*");
//		//st.setdocumentSpecs.getEndLineDelimiter()("~");
//				
//	 $edi850->setStRecord(st);
//				
//		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("ST Record Line: " . $st->getRecord(),10);
//		
//		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("edi850: "  . $edi850->getDocument() ,10);
//		
//		assertTrue( true );		
//		
//	}
//	
//	
//	 void testParseEdi850() {
//	
//		String $inEdi850Document = "" . 	
//								"HO*123456789      *3456                  *********************************~\n" .
//								"LI*123456789      *1111111               *********************************************************~\n" .
//								"LI*123456789      *2222222               *********************************************************~\n" .
//								"RL*898949494      *8899                  ***~\n" .
//								"LI*123456789      *3333333               *********************************************************~\n" .
//								"RL*333343         *45454                 ***~\n" .
//								"LI*123456789      *4444444               *********************************************************~\n" .
//								"LI*123456789      *5555555               *********************************************************~\n" .
//								"ST*123456789      *343433                ***~\n";
//		
//		
//		
//		Edi850 $edi850 = new Edi850(new DocumentSpecs());
//		
//	 $edi850->setDocumentByString(inEdi850Document);
//	
//		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("Source Edi850Document from String: \n"  . inEdi850Document ,10);
//		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("Target Edi850Document from Object: \n"  . $edi850->getDocument() ,10);
//		
//		assertTrue( $edi850->getDocument().equals(inEdi850Document) );
//	}
	/*
	public function  testGetDocument() { // throws  EdiTypeException  { // returns void
		
		//$g =  "1"; // Strin
		$specs =  new DocumentSpecs(); // DocumentSpecs
	 $specs->loadSpecs();
		//specs->setInLineDelimiter("|");
		//specs->setEndLineDelimiter("\n");
	 $specs->setTradingPartnerId("ABCD1234");
		
		$edi810 =  new Edi810($specs); // Edi810
		
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("Edi810Test.testGetDocument TestData=".TestData.getSalesOrder2(), 10);		
		$order = TestData.getSalesOrder2(); // Order
	 $order->setStatus("Fulfilled");
		
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("Edi810Test.testGetDocument fbOrder=".fbOrder.toHashMap(), 10);
		
	 $edi810->setDocument(fbOrder,null);
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("Edi810Test.setDocument done",10);
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("Edi810Test.getDocument = " . $edi810->getDocument(),10);
		
	}
	*/
	
	public function  testParseSpsEdi850() {// throws  EdiTypeException, GlobalHardErrorException  { // returns void
	
		 $inEdi850Document = new String("620TSTBIONUTRIT|08088638|HO|00|SA||20091021||||||||||||008863|||||||||||||||||\n" .
				"620TSTBIONUTRIT|08088638|HT|02|3|2||30||31|||||02.0%, 30, NET 31 DOI|\n" .
				"620TSTBIONUTRIT|08088638|DH|002|20091022|||\n" .
				"620TSTBIONUTRIT|08088638|CH|BD|GUDENKAUF|847 914-3786|||\n" .
				"620TSTBIONUTRIT|08088638|CH|WH|WALGREENS-MT VERNON|(618) 244-9100|||\n" .
				"620TSTBIONUTRIT|08088638|HA|BT|9|0089650630000|WALGREEN||P.O. BOX 4025||||DANVILLE|IL|61834|US|||||||\n" .
				"620TSTBIONUTRIT|08088638|HA|ST|9|008965063W008|WALGREENS-MT VERNON||5100 LAKE TERRACE N E||||MT. VERNON|IL|62864||||||||\n" .
				"620TSTBIONUTRIT|08088638|RH|ZZ||WHI\n" .
				"620TSTBIONUTRIT|08088638|HN|SCHEDULE APPT FOR NON NCS OR PREFERRED CARRIERS ON\n" .
				"620TSTBIONUTRIT|08088638|HN|INTERNET APPT SCHEDULING AT VENDOR.WALGREENS.COM\n" .
				"620TSTBIONUTRIT|08088638|MH|LB|0.34|FT|0.02\n" .
				"620TSTBIONUTRIT|08088638|LI|001|269785||644225727832|||||||||||||PWR CRNCH BAR TRIPLE CHOC   1.4OZ||1|CA|79.2||||||||||||||||||||||||||||||||||||\n" .
				"620TSTBIONUTRIT|08088638|LI|002|269786||644225727795|||||||||||||PWR CRNCH BAR PEANT BTR CRM 1.4OZ||1|CA|79.2||||||||||||||||||||||||||||||||||||\n" .
				"620TSTBIONUTRIT|08088638|LI|003|269787||644225727382|||||||||||||PWR CRNCH BAR FRNCH VAN CRM 1.4OZ||1|CA|79.2||||||||||||||||||||||||||||||||||||\n" .
				"620TSTBIONUTRIT|08088638|ST||3|\n");
		
		 $specs = new DocumentSpecs();//DocumentSpecs
	 $specs->setEndLineDelimiter(new String(""));
	 $specs->setInLineDelimiter(new String("|"));
	 $specs->setRecordTypePosition(3);
		println("specs initialized");
		
		 $edi850 = new Edi850($specs);//Edi850
		println("Edi850 initialized");
	 $edi850->setDocumentByString($inEdi850Document);
		//edi850.getHoRecord().getRecord();
		 $doc = $edi850->getDocument();//String
		$doc = $doc->trim();

		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("Source Edi850Document from String: \nx"  . $inEdi850Document->trim() . "x",10);
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("Target Edi850Document from Object: \nx"  . $doc . "x",10);
		//assertTrue( $doc->equals( $inEdi850Document->trim() ) );
		
		 $order = $edi850->getSalesOrder();//Order
		
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("getShipToAddressField=" . $order->getShipToAddressField(),10);
		assertTrue( $order->getShipToAddressField().equals("5100 LAKE TERRACE N E") );
		
		// $result = sendSoSaveRq($order->toHashMap());//String
		
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("result=" . result,10);
		assertTrue(! $result->equals(""));
		
		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug("Error Message=" . $connector->main.Error.getMessage(),10);
		assertTrue(! $connector->main.Error.isError());
		
	}
	
}





$t =  new Test();
$t->setDisplayWarnings();

$test = new Edi810Test($t);

$testMethods = get_class_methods($test);

foreach ($testMethods AS $method) {
	
	if ( $method != get_class($test) ) {
	
		$test->$method();
	}
}
 print $t->summary();
$t->destroy();
