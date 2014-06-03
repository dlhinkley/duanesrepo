<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */

/*
 * : 
 */

function myErrorHandler($errno, $errstr, $errfile, $errline) {
	if ( E_RECOVERABLE_ERROR===$errno ) {
		echo "Tester Error:\n";
		throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
		// return true;
	}
	return false;
}

ini_set( 'display_errors', 1 );  // Display  $errors  $on  $screent
error_reporting(E_ALL ^ E_DEPRECATED);



$appPath = realpath( dirname(__FILE__).'/../../../../../' ).'/';


require($appPath.'Mage.php');
$_SERVER['SCRIPT_NAME'] = str_replace(basename(__FILE__), 'index.php', $_SERVER['SCRIPT_NAME']);
$_SERVER['SCRIPT_FILENAME'] = str_replace(basename(__FILE__), 'index.php', $_SERVER['SCRIPT_FILENAME']);
Mage::app('admin')->setUseSessionInUrl(false);
umask(0);
Mage::getConfig()->init();



set_error_handler('myErrorHandler');

print "\n".str_repeat("*", 80)."\n\n";


Dhtechnologies_Ediconnectorbase_Model_Main::processDocuments();


//$main = new Dhtechnologies_Ediconnectorbase_Model_Main();

//$main->runTester();
