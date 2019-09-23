<?php
	/*----------File Information----------*/
	#Project : HASHTAG
	#File Created By : Mona Bera
	#File Created Date : 13 Jan 2016
	#File Edited By :
	#File Edited Date :
	/*----------File Information----------*/
	
	include("includes/connection.php");
	$obj = new myclass();
	
	session_start();
	
	$wid = $_POST['wid'];
	$DeleteWishlistItem = $obj->sql_query("DELETE FROM tbl_wishlist WHERE ProductID = '".$wid."'");
	if($DeleteWishlistItem)
	{
		echo "1";
	}
	else
	{
    	echo "0";
 	}
?>