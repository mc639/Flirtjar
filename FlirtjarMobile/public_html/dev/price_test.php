<?php
	/*----------File Information----------*/
	#Project : HASHTAG
	#File Created By : Mona Bera
	#File Created Date : 18 Jan 2016
	#File Edited By :
	#File Edited Date :
	/*----------File Information----------*/
	
	include("includes/connection.php");
	session_start();
	$obj = new myclass();
	$Option =(implode(",",$_POST['Option']));
	echo $Option;
?>
