<?php

function myErrorHandler($errno, $errstr, $errfile, $errline) {
  if ( E_RECOVERABLE_ERROR===$errno ) {
    echo "'catched' catchable fatal error\n";
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
    // return true;
  }
  return false;
}
function deleteAll($path) {
	
	$files = glob("$path/*"); // get all file names
	foreach($files as $file){ // iterate files
		if(is_file($file))
			unlink($file); // delete file
	}
}

function println($string) { print $string."\n"; }

		
 //require(dirname(__FILE__).'/../init2.php');
//Dhtechnologies_Ediconnectorbase_Model_Config::setEdiRecordTypePosition(1);

 ini_set( 'display_errors', 1 );  // Display  $errors  $on  $screent
 error_reporting(E_ALL ^ E_DEPRECATED);

 require('test_class/test_class.php');
 //require('validation_class/validation_class.php');


require('shop/app/Mage.php');
$_SERVER['SCRIPT_NAME'] = str_replace(basename(__FILE__), 'index.php', $_SERVER['SCRIPT_NAME']);
$_SERVER['SCRIPT_FILENAME'] = str_replace(basename(__FILE__), 'index.php', $_SERVER['SCRIPT_FILENAME']);
Mage::app('admin')->setUseSessionInUrl(false);
umask(0);
Mage::getConfig()->init();

set_error_handler('myErrorHandler');

print "\n".str_repeat("*", 80)."\n\n";


class TestMaster {
	
	public function TestMaster($t) {
		
		$this->t = $t;
	}
	
}