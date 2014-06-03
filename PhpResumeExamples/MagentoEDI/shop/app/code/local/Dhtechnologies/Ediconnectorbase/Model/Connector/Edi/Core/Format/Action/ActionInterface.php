<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */


interface Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Format_Action_ActionInterface  {
		
	public function __construct(Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Documents_Type_DocumentSpecs $documentSpecs);
		
	public function  processEdiDocuments( $documentType, $direction);
	
}
