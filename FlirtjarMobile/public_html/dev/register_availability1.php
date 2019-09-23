<?php
	/*----------File Information----------*/
	#Project : Hashtag
	#File Created By : Avani Trivedi
	#File Created Date : 12 Jan 16
	#File Edited By :
	#File Edited Date :
	/*----------File Information----------*/

	session_start();
	include("includes/connection.php");
	$obj = new myclass;
	$Email1 = addslashes( $_REQUEST['HREmail']);
	$sql= $obj->sql_query("select Email from tbl_register where Email ='".$Email1."'");	
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