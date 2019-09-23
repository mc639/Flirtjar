<?php
	/*----------File Information----------*/
	#Project : HashTag
	#File Created By : Mona Bera
	#File Created Date : 12 February 2016
	#File Edited By :
	#File Edited Date :
	/*----------File Information----------*/
	
	include ("includes/connection.php");
	$obj = new myclass();

	session_start();
	
	if(!empty($_POST['totalprice']))
	{
		$totalcartprice = $_POST['totalprice'];
		$_SESSION['totalcartprice']=$totalcartprice; 
	}
	
	
	
	if(!empty($_POST['Fprice']))
	{
		$Fprice = $_POST['Fprice'];
		$_SESSION['totalcartprice'] = $Fprice;
		//echo $_SESSION['totalcartprice'];
	}
	
?>