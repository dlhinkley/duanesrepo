<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */


/**
 * A Class to handle EdiTransportExceptions related errors.  All errors within the 
 * EdiTransport area call this exception rather than raising a error flag and 
 * depending on logic to avoid additional operations.
 * 
 * @author Duane Hinkley
 *
 */
class Dhtechnologies_Ediconnectorbase_Model_Connector_Edi_Core_Transport_EdiTransportException extends Exception {
	
}
