<?php


//("java/Filter.php");
//require_once("java/HashMap.php");
//require_once("connector/edi/core/documents/type/EdiFields.php");
//require_once("connector/edi/core/documents/type/DocumentSpecs.php");
//require_once("connector/edi/core/documents/type/Edi850Definition.php");

require_once('t/TestMaster.php');



$t = new Test();
$t->setDisplayWarnings();

$definition = array(
    array("1", "Field1", "ID", "3", "M"), // Description:   Code uniquely identifying a transaction set.
    array("2", "Field2", "AN", "9", "O"), // Description:   Identifying control number that must be unique within the transaction set  functional group assigned by the originator for a transaction set
);
$documentSpecs = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSpecs();

    	$ediDocumentDefinition  = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiDocumentDefinitionCommon($documentSpecs ,"Edi850");
//new EdiFields("ST",$this->stDefinition,$specs,true,1,1,$this)

$xml = "<lineDefinition>
		<recordType>ST</recordType>
		<columnDefinition>
			
				<column>
					<position>1</position>
					<fieldName>Element</fieldName>
					<type>A</type>
					<minLength>2</minLength>
					<maxLength>2</maxLength>
					<required>M</required>
				</column>
				<column>
					<position>2</position>
					<fieldName>TransactionSetIdentifierCode</fieldName>
					<type>ID</type>
					<minLength>3</minLength>
					<maxLength>3</maxLength>
					<required>M</required>
				</column>
				<column>
					<position>3</position>
					<fieldName>TransactionSetControlNumber</fieldName>
					<type>A</type>
					<minLength>4</minLength>
					<maxLength>9</maxLength>
					<required>M</required>
				</column>
			
		</columnDefinition>
		<required>true</required>
		<min>1</min>
		<max>1</max>
		<group>3</group>
		<parentGroup>2</parentGroup>
		<order>null</order>
	</lineDefinition>
";
	$lineDefinition = new SimpleXMLElement($xml);
			
	$field = new Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_EdiFields($lineDefinition,$documentSpecs);

//$field = new EdiFields("ST",new Edi850Definition($specs),$documentSpecs,true,1,2,$t);


print $t->ok(is_object($field),"",false);

$test = $field->getSize();
print $t->ok($test == 0,"getSize",$test);


$field->setValue(0, "Field1", "TEST");
$field->setValue(0, "Field2", "TEST");
/*

$test = $field->getNumberOfFields();
print $t->ok($test == 2,"getNumberOfFields",$test);

*/
$test = $field->getParent();
print $t->ok($test == null,"getParent",$test);

$test = $field->isParent();
print $t->ok($test,"isParent",$test);

$field->setParent(99);
$test = $field->getParent();
print $t->ok($test == 99,"getParent",$test);

$test = $field->isParent();
print $t->ok(!$test,"isParent",$test);

$test = $field->getRecordType();
print $t->ok($test == "ST","getRecordType",$test);

$ediRow = $field->getRow(0);
$test = $ediRow->getValue("Field1");
print $t->ok($test == "TEST","getRow",$test);
/*
$filter = new Filter();
$filter->put("Field1", "TEST");
$ediRow = $field->getRowByFilter($filter);
$test = $ediRow->getValue("Field1");
print $t->ok($test == "TEST","getRowByFilter",$test);
*/

$test = $field->getValue(0, "Field1");
print $t->ok($test == "TEST","getValue",$test);

$test = $field->isRequired();
print $t->ok($test ,"isRequired",$test);

$field->setRequired2(false);
$test = $field->isRequired();
print $t->ok(!$test ,"isRequired",$test);


$field->setRequired2(true);
$test = $field->isRequired();
print $t->ok($test ,"isRequired",$test);

// don't know how to check
//$field->setRequired("Field2", "O");
//$ediRow = $field->getRow(0);
//$test = $ediRow->getValue("Field2");


print $t->ok($test == "TEST","getRow",$test);

//$set = new HashMap();
//$set->put("A","1");
//$set->put("B","2");
//$field->setRequiredValues("Field1",$set);



//$lines = $field->getLines();
//print $t->ok(count($lines) == 0,"getLines",$lines);
//
//print $t->ok($lines[0] != null && $lines[0] != "","getLines",$lines[0]);


print $t->summary();
$t->destroy();




//	@Test
//	 testEdi204() {
//						
//		Edi850 edi850 = new Edi850(new DocumentSpecs());
//		Edi850HoRecord ho = new Edi850HoRecord(new DocumentSpecs());
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
//		Edi850Line line1 = new Edi850Line(new DocumentSpecs());
//		Edi850LiRecord li1 = new Edi850LiRecord(new DocumentSpecs());
//		Edi850RlRecord rl1 = new Edi850RlRecord(new DocumentSpecs());
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
//		Edi850Line line2 = new Edi850Line(new DocumentSpecs());
//		Edi850LiRecord li2 = new Edi850LiRecord(new DocumentSpecs());
//		Edi850RlRecord rl2 = new Edi850RlRecord(new DocumentSpecs());
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
//		Edi850StRecord st = new Edi850StRecord(new DocumentSpecs());
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
//		Edi850 edi850 = new Edi850(new DocumentSpecs());
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
//		DocumentSpecs specs = new DocumentSpecs();
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
//		DocumentSpecs specs = new DocumentSpecs();
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