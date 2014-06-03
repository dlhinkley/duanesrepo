<?php require_once('Format/EDIFormat.php');


/**
 *  $untitledModel -  $class->ProcessEDIDocumentClient.php
 *
 * $Id: ProcessEDIDocumentClient.php,v 1.4 2012/08/11 15:40:01 dlhinkley Exp $dlhinkley Exp $
 *
 * This  $file  $is  $part  $of  $untitledModel.
 *
 * Automatically  $generated  $on 07.08.2012, 13:57:40  $with ArgoUML PHP  $module 
 * (last  $revised $Date: 2012/08/11 15:40:01 $)
 *
 * @author  $firstname  $and  $lastname  $of  $author, <author@example.org>
 */



/*  $user  $defined  $includes */
//  $section 127-0-1-1--618a6fbb:138fd78a9c8:-8000:0000000000000DC3-includes  $begin
//  $section 127-0-1-1--618a6fbb:138fd78a9c8:-8000:0000000000000DC3-includes  $end

/*  $user  $defined  $constants */
//  $section 127-0-1-1--618a6fbb:138fd78a9c8:-8000:0000000000000DC3-constants  $begin
//  $section 127-0-1-1--618a6fbb:138fd78a9c8:-8000:0000000000000DC3-constants  $end

/**
 * Short  $description  $of  class ProcessEDIDocumentClient
 *
 * @access  public
 * @author  $firstname  $and  $lastname  $of  $author, <author@example.org>
 */
 class ProcessEDIDocumentClient
{
    // --- ASSOCIATIONS ---
    //  $generateAssociationEnd : 

    // --- ATTRIBUTES ---

    // --- OPERATIONS ---

    /**
     * Short  $description  $of  $method ProcessEDIDocumentClient
     *
     * @access  public
     * @author  $firstname  $and  $lastname  $of  $author, <author@example.org>
     * @return  $mixed
     */
     public  function ProcessEDIDocumentClient()
    {
        //  $section 127-0-1-1--618a6fbb:138fd78a9c8:-8000:0000000000000DC4  $begin
        //  $section 127-0-1-1--618a6fbb:138fd78a9c8:-8000:0000000000000DC4  $end
    }

    /**
     * Starts  $the  $processing  $of  $edi  $documents
     * Creates EDIFormat  class
     *
     * @access  public
     * @author  $firstname  $and  $lastname  $of  $author, <author@example.org>
     * @return  $mixed
     */
     public  function processEdiDocuments()
    {
		$ediFormat =  new EDIFormat();
		
		 try {
			
			$ediFormat->startEDIDocumentProcessing();
			
		}
		 catch (MagentoEDIFormatException $e ) {
			
			
		}
    	//  $section 127-0-1-1--618a6fbb:138fd78a9c8:-8000:0000000000000DCC  $begin
        //  $section 127-0-1-1--618a6fbb:138fd78a9c8:-8000:0000000000000DCC  $end
    }

} /*  $end  $of  class ProcessEDIDocumentClient */

?>