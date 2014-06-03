<?php

// base class with member properties and methods 
class Test { 

   var $error = false; 
   var $test_ctr = 0; 
   var $pad_width = 80;
   var $num_errors = 0;

/*  ok($this eq $that, $test_name);

This simply evaluates any expression (C<$this eq $that is just a
simple example) and uses that to determine if the test succeeded or
failed.  A true expression passes, a false one fails.  Very simple.

For example:

    ok( $exp{9} == 81,                   'simple exponential' );
    ok( Film->can('db_Main'),            'set_db()' );
    ok( $p->tests == 4,                  'saw tests' );
    ok( !grep !defined $_, @items,       'items populated' );

(Mnemonic:  "This is ok.")

$test_name is a very short description of the test that will be printed
out.  It makes it very easy to find a test in your script when it fails
and gives others an idea of your intentions.  $test_name is optional,
but we B<very strongly encourage its use.

Should an ok() fail, it will produce some diagnostics:

    not ok 18 - sufficient mucus
    #     Failed test 18 (foo.t at line 42)


sub ok ($;$) {
    my($test, $name) = @_;
    $Test->ok($test, $name);
}

*/
   function Test() {
   
      $this->makeSessionDirectory();
      
      //$_SERVER["REMOTE_ADDR"] = '127.0.0.1';
      //$_SERVER['SERVER_NAME'] = `hostname`;
   }
   function destroy() {
   
      $home = getenv('HOME');
      $pid =  getmypid();
      $path = "$home/$pid";
   
      if ( file_exists($path) ) {

         exec("rm -rf $path");
      }
      
   }
   function makeSessionDirectory() {
   
      $home = getenv('HOME');
      $pid =  getmypid();
      $path = "$home/$pid";
      if ( ! file_exists($path) ) {
      
         mkdir($path);
      }
      session_save_path($path);
   }
   function setDisplayWarnings() {

          ini_set ( 'display_errors', 1 );  // Display errors on screent
   }
   function clrDisplayWarnings() {

       ini_set ( 'display_errors', 0 );  // Display errors in log file
   }
   function ok( $test, $name , $report = false) { 

	   return $this->_report($name,$test , $report);
   } 

   function _report($name, $result , $report) {

	   if ( $result ) {

		   $out = $this->_report_pass($name);
	   }
	   else {
		   $out = $this->_report_fail($name);

		   if ( is_array($report) || is_object($report) ) {

                      $out .= "Error: \n" . var_export($report,true);
                   }
                   else {
                   
                      $out .= "Error: \n$report\n";
                   }
	   }
	   return $out;
   }
   function _report_pass($name) {

       $this->test_ctr++;
	   return str_pad("$this->test_ctr: $name", $this->pad_width, ". ") . " PASS\n";
   }

   function _report_fail($name) {

       $this->test_ctr++;
	   $this->_flag_error();
	   return str_pad("$this->test_ctr: $name", $this->pad_width, ". ") . " FAILED\n";
   }
   function _flag_error() { 
       
      $this->error = true; 
      $this->num_errors++;
   } 
   function summary() {
   
      return "Tests:  $this->test_ctr\nErrors: $this->num_errors\n";
   }
    
} // end
?>