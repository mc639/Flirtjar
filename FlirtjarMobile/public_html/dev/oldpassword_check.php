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
	$OldPassword = addslashes( $_REQUEST['OldPassword']);
	$sql= $obj->sql_query("select Password from tbl_register where Password ='".$OldPassword."'");	
	if(count($sql)>0)
	{
		echo 'true';
	} 
	else
	{
		echo 'false';
	}
	exit;
?>