<?php
require('test_class/test_class.php');

require('shop/app/Mage.php');
$_SERVER['SCRIPT_NAME'] = str_replace(basename(__FILE__), 'index.php', $_SERVER['SCRIPT_NAME']);
$_SERVER['SCRIPT_FILENAME'] = str_replace(basename(__FILE__), 'index.php', $_SERVER['SCRIPT_FILENAME']);
Mage::app('admin')->setUseSessionInUrl(false);
umask(0);
Mage::getConfig()->init();

//print_r(Mage::getConfig());
//exit;


$t = new Test();
$t->setDisplayWarnings();




try {
    
    
	$order = Mage::getModel('sales/order')->load(1);

	$items = $order->getAllItems();
	$_totalData = $order->getData();
	$_grand = $_totalData['grand_total'];
	//$custname = $_totalData->getCustomerName();
	$itemcount=count($items);
    
} catch (Exception $e) {
    Mage::printException($e);
}
print $t->ok($_grand == 6.00,'total',$_grand);
print $t->ok($itemcount == 1, 'item count',$itemcount);


	$main = Mage::getModel('EdiconnectorBase/Main');
	$main->runCron();
	
print $t->summary();
$t->destroy();



	
?>