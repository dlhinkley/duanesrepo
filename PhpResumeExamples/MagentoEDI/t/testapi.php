<?php 
/*
$proxy = new SoapClient('http://magento.local/magentoEDI/shop/api/soap/?wsdl');
$sessionId = $proxy->login('api', 'fishey');
 
$filters = array(
    'sku' => array('like'=>'%')
);
 
$products = $proxy->call($sessionId, 'customer_group.list', array($filters));
 
var_dump($products);
*/
$dir = realpath(dirname(__FILE__).'/../shop/lib/').'/';
      ini_set("display_errors", 1);
error_reporting(E_ALL);
set_include_path('shop/lib/Zend/');
require_once('shop/app/Mage.php');
define("XMLRPC_DEBUG", 1);
 

$client = new Zend_XmlRpc_Client('http://magento.local/magentoEDI/shop/api/xmlrpc/');

// If somestuff requires api authentification,
// we should get session token
$session = $client->call('login', array('api', 'fishey'));
$group_name = 'testagain2';
$tax_id = 3;

$result = $client->call('call', array($session, 'customer_group.create',array($group_name,$tax_id)));
print_r($result);
// If you don't need the session anymore
$client->call('endSession', array($session));
?>