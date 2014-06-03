<?php


//require_once(dirname(__FILE__)."/Dependency.php");

//require_once(dirname(__FILE__)."/Test.php");



$t = new Test();
$t->setDisplayWarnings();


$e = new Dependency();

print $t->ok(is_object($e),false);

$e->add("Field1", "A");
$e->add("Field1", "B");
$test = $e->getDependencies("A");

//
//
print $t->ok($test->get(0) == "Field1","1",$test);
//


print $t->summary();
$t->destroy();




//	@Test
//	 testEdi204() {
//						
//		Edi850 edi850 = new Edi850(new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSpecs());
//		Edi850HoRecord ho = new Edi850HoRecord(new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSpecs());
//		
//		ho.setTradingPartnerId("123456789");
//		ho.setPurchaseOrderNumber("3456");		
//						
//		edi850.setHoRecord(ho);
//		
//		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" TradingPartnerId: " + ho.getTradingPartnerId(),10);
//		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" DepositorOrderNumber: " + ho.getPurchaseOrderNumber(),10);
//		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" RecordType: " + ho.getRecordType(),10);		
//		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" ho Record Line: " + ho.getRecord(),10);
//		
//		//First Line
//		Edi850Line line1 = new Edi850Line(new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSpecs());
//		Edi850LiRecord li1 = new Edi850LiRecord(new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSpecs());
//		Edi850RlRecord rl1 = new Edi850RlRecord(new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSpecs());
//		
//		li1.setTradingPartnerId("123456789");
//		li1.setPurchaseOrderNumber("3333333");
//		li1.setRecordType("LI");		
//		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" LI Record Line 1: " + li1.getRecord(),10);
//		
//		line1.setLiRecord(li1);
//		
//		rl1.setTradingPartnerId("898949494");
//		rl1.setPurchaseOrderNumber("8899");
//		rl1.setRecordType("RL");
//		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" RL Record Line 1: " + rl1.getRecord(),10);
//		
//		line1.setRlRecord(rl1);
//		
//		edi850.addLine(line1);
//		
//		//Second Line
//		Edi850Line line2 = new Edi850Line(new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSpecs());
//		Edi850LiRecord li2 = new Edi850LiRecord(new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSpecs());
//		Edi850RlRecord rl2 = new Edi850RlRecord(new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSpecs());
//		
//		li2.setTradingPartnerId("123456789");
//		li2.setPurchaseOrderNumber("88393454393939");
//		li2.setRecordType("LI");		
//		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" LI Record Line 2: " + li2.getRecord(),10);
//		
//		line2.setLiRecord(li2);
//				
//		rl2.setTradingPartnerId("333343");
//		rl2.setPurchaseOrderNumber("45454");
//		rl2.setRecordType("RL");
//		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" RL Record Line 2: " + rl2.getRecord(),10);
//		
//		line2.setRlRecord(rl2);
//		
//		edi850.addLine(line2);
//		
//		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" EdiLines: \n"  + edi850.getEdiLines() ,10);
//		
//		
//		Edi850StRecord st = new Edi850StRecord(new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSpecs());
//		
//		st.setTradingPartnerId("123456789");
//		st.setPurchaseOrderNumber("343433");
//		st.setRecordType("ST");		
//		//st.setInLineDelimiter("*");
//		//st.setdocumentSpecs.getEndLineDelimiter()("~");
//				
//		edi850.setStRecord(st);
//				
//		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" ST Record Line: " + st.getRecord(),10);
//		
//		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" edi850: "  + edi850.getDocument() ,10);
//		
//		assertTrue( true );		
//		
//	}
//	
//	@Test
//	 testParseEdi850() {
//	
//		(String) $inEdi850Document = "" + 	
//								"HO*123456789      *3456                  *********************************~\n" +
//								"LI*123456789      *1111111               *********************************************************~\n" +
//								"LI*123456789      *2222222               *********************************************************~\n" +
//								"RL*898949494      *8899                  ***~\n" +
//								"LI*123456789      *3333333               *********************************************************~\n" +
//								"RL*333343         *45454                 ***~\n" +
//								"LI*123456789      *4444444               *********************************************************~\n" +
//								"LI*123456789      *5555555               *********************************************************~\n" +
//								"ST*123456789      *343433                ***~\n";
//		
//		
//		
//		Edi850 edi850 = new Edi850(new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSpecs());
//		
//		edi850.setDocument(inEdi850Document);
//	
//		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" Source Edi850Document from String: \n"  + inEdi850Document ,10);
//		Dhtechnologies_Ediconnectorbase_Model_Main::logDebug(" Target Edi850Document from Object: \n"  + edi850.getDocument() ,10);
//		
//		assertTrue( edi850.getDocument().equals(inEdi850Document) );
//	}
//	@Test
//	public function testThis() {
//
//		assertTrue(true);
//	}
//	@Test
//	public function testThisBBBPartner() throws ErrorException {
//		(String) $inEdi850Document = "832ALLWILDSALES|DQ63521|HO|00|SA||20100923||||||||||||045017|||||||||||||||||\n" +
//				"832ALLWILDSALES|DQ63521|DH|010|20100925|||\n" +
//				"832ALLWILDSALES|DQ63521|HA|BY|92|0199|COLUMBIA 199||||||||||||||||\n" +
//				"832ALLWILDSALES|DQ63521|LI|||5GCFB-1-SCU|897149001643|||||||||||||||44|EA|45||||||||||||||||||||||||||||||||||||\n" +
//				"832ALLWILDSALES|DQ63521|ST||1|\n";
//
//		(String) $num = "9";
//		DocumentSpecs specs = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSpecs();
//		specs.setEndLineDelimiter("");
//		specs.setInLineDelimiter("|");
//		specs.setRecordTypePosition(3);
//				
//		Edi850 edi850 =new Edi850(specs,dataClient,num);
//		System.out.println("Edi850 initialized");
//		edi850.setDocument(inEdi850Document);	
//		
//		Vector<Order> fbOrderList = edi850.getSalesOrder();	
//		Order fbOrder = fbOrderList.firstElement();
//		
//		isValid(fbOrder);
//	}
//	@Test
//	public function testTargetPartner() throws ErrorException {
//		(String) $inEdi850Document = "95OALLWILDSALE1|DHtlHGn7R|HO|00|DS||20101004||||||||||||67434|||||||||||NS|G2|||||\n" +
//"95OALLWILDSALE1|DHtlHGn7R|DH|001|20101012|||\n" +
//"95OALLWILDSALE1|DHtlHGn7R|DH|006|20101004|||\n" +
//"95OALLWILDSALE1|DHtlHGn7R|HA|BT|||Target.com Accounts Payable||TNC 3110|PO Box 9493|||Minneapolis|MN|55440|US|||||||\n" +
//"95OALLWILDSALE1|DHtlHGn7R|HA|ST|||Jane Cordisco||204 Wilmar Drive||||Pittsburgh|PA|15238|US|Jane Cordisco|412-963-0863|||||\n" +
//"95OALLWILDSALE1|DHtlHGn7R|HA|SO|||Nina Hotkowski||5009 Venice Road||||Pittsburgh|PA|15209|US|||||||\n" +
//"95OALLWILDSALE1|DHtlHGn7R|RH|OQ|602-1962098-2821048|\n" +
//"95OALLWILDSALE1|DHtlHGn7R|RH|D7|36|\n" +
//"95OALLWILDSALE1|DHtlHGn7R|RH|WS|TAH8|\n" +
//"95OALLWILDSALE1|DHtlHGn7R|RH|L1|MESSAGE|$this shipment completes your order\n" +
//"95OALLWILDSALE1|DHtlHGn7R|MH||INTERCHANGE||000000036\n" +
//"95OALLWILDSALE1|DHtlHGn7R|MH||FUNCTIONALGROUP||11\n" +
//"95OALLWILDSALE1|DHtlHGn7R|MH||TRANSACTION||960561354\n" +
//"95OALLWILDSALE1|DHtlHGn7R|LI|1|10154450|5CFB-1-PSU|897149001216|||||||||||||Penn State University Wild Sales Beanbag Toss||1|EA|60|PE|||||||||||||||||||||||||||||||||||\n" +
//"95OALLWILDSALE1|DHtlHGn7R|ST||1|1\n";
//
//		(String) $num = "9";
//		DocumentSpecs specs = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSpecs();
//		specs.setEndLineDelimiter("");
//		specs.setInLineDelimiter("|");
//		specs.setRecordTypePosition(3);
//				
//		Edi850 edi850 =new Edi850(specs,dataClient,num);
//		System.out.println("Edi850 initialized");
//		edi850.setDocument(inEdi850Document);	
//		
//		Vector<Order> fbOrderList = edi850.getSalesOrder();	
//		Order fbOrder = fbOrderList.firstElement();
//		
//		isValid(fbOrder);
//	}
	
?>