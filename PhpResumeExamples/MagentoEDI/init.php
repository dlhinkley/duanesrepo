<?php
require_once('Config.php');
require_once('ProcessEDIDocumentClient.php');
require_once('Database/EDIDocumentDatabase.php');

$config =  new Config();

$processEDIDocumentClient =  new ProcessEDIDocumentClient();

$ediDocumentDatabase =  new EDIDocumentDatabase();

?>