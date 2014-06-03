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
 * 
<crontab>
        <jobs>
            <inchoo_birthday_send>
                <schedule><cron_expr>0 1 * * *</cron_expr></schedule>
                <run><model>ediconnectorBase/observer::processDocuments</model></run>
            </inchoo_birthday_send>
        </jobs>
</crontab>
 */
class Dhtechnologies_Ediconnectorbase_Model_Observer {
	
	public function processDocuments() {
		
		Mage::Log("Dhtechnologies_Ediconnectorbase_Model_Observer::processDocuments started");
		
		Dhtechnologies_Ediconnectorbase_Model_Main::processDocuments();
		
		Mage::Log("Dhtechnologies_Ediconnectorbase_Model_Observer::processDocuments finished");
		return $this;
	}
	
}
?>