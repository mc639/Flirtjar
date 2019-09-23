<?php
	/*----------File Information----------*/
	#Project : Oilpixel
	#File Created By : Jaydeep Patel
	#File Created Date : 14 May 13
	#File Edited By :
	#File Edited Date :
	#Company Name : Virtue Web Studio
	#Company Email ID : info@virtuewebstudio.com
	#Contact No. 098799 16416
	/*----------File Information----------*/

	session_start();
	include("includes/connection.php");
	$obj = new myclass;
	$Email = addslashes( $_REQUEST['Email']);
	$sql= $obj->sql_query("select Email from tbl_register where Email ='".$Email."'");	
	if(count($sql)==0)
	{
		echo 'true';
	} 
	else
	{
		echo 'false';
	}
	exit;
?>