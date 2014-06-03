<?php
/*
 * ------------------------------------------------------------------------------------------
 * Copyright DH Technologies, Inc., 2012-2013.  All Rights Reserved.
 * http://www.dhitconsulting.com
 * For details on this license please visit  the product homepage at the URL above.
 * THE ABOVE NOTICE MUST REMAIN INTACT.
 * ------------------------------------------------------------------------------------------
 */

$installer = $this;
 
$installer->startSetup();

 
$installer->run("
DROP TABLE IF EXISTS {$this->getTable('outbound_edi_documents')};
create table {$this->getTable('outbound_edi_documents')}  
				  (
				  outbound_edi_documents_id int(11) NOT NULL AUTO_INCREMENT,
				  sequence integer not null,  
				  website varchar(50),  
				  document_content blob not null,  
				  document_type varchar(25),  
				  filename varchar(256),  
				  source_document_num varchar(25),  
				  target_document_num varchar(25),  					
				  sentflag smallint default 0,  		
				  sentmessage varchar(1000),  
				  error_flag smallint default 0,  
				  error_message varchar(1000),  
				  date_modified timestamp,  
				  date_created timestamp,  
  				PRIMARY KEY (outbound_edi_documents_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8  AUTO_INCREMENT=1;

DROP TABLE IF EXISTS {$this->getTable('inbound_edi_documents')};
create table {$this->getTable('inbound_edi_documents')}  
				  (
				  inbound_edi_documents_id int(11) NOT NULL AUTO_INCREMENT,
				  sequence integer not null,  
				  website varchar(50),  
				  document_md5 varchar(100) not null,  
				  document_content blob not null,  
				  document_type varchar(25),  
				  filename varchar(256),
				  source_document_num varchar(25),  
				  target_document_num varchar(25),  					
				  processed_flag smallint default 0,  		
				  processed_message varchar(1000),  
				  error_flag smallint default 0,  
				  error_message varchar(1000),  
				  date_modified timestamp,  
				  date_created timestamp,
  				PRIMARY KEY (inbound_edi_documents_id),
  				UNIQUE KEY source_document_num (source_document_num)
) ENGINE=InnoDB DEFAULT CHARSET=utf8  AUTO_INCREMENT=1;
DROP TABLE IF EXISTS {$this->getTable('edi_configuration')};
create table {$this->getTable('edi_configuration')}  
				  (
				  edi_configuration_id int(11) NOT NULL AUTO_INCREMENT,
				  config_name VARCHAR( 100 ) NOT NULL ,
				  config_value VARCHAR( 100 ) NOT NULL,
  				PRIMARY KEY (edi_configuration_id),
  				UNIQUE KEY config_name (config_name)
) ENGINE = MYISAM ;
DELETE FROM {$this->getTable('edi_configuration')};
INSERT INTO {$this->getTable('edi_configuration')} (config_name, config_value) VALUES ('INTERCHANGE_CONTROL_NUMBER','1');
ALTER TABLE  {$this->getTable('sales_flat_order')} ADD  edi_sent SMALLINT( 5 ) NOT NULL DEFAULT  '0';
				  
 ");


$installer->endSetup();
