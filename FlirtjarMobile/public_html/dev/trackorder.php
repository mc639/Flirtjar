<?php
	/*----------File Information----------*/
	#Project : Hash Tag
	#File Created By : Mona Kathrotiya
	#File Created Date : 06 November 2015
	#File Edited By :
	#File Edited Date :
	/*----------File Information----------*/
	
	include ("includes/connection.php");
	$obj = new myclass();
	session_start();
	$OrderID = $_POST['OrderID'];
	
	
	 if(!empty($_SESSION["RegisterID"]))
	 {
		$SelectData = $obj->sql_query("SELECT * FROM tbl_order WHERE RegisterID = '".$_SESSION["RegisterID"]."'");	
		if(!empty($SelectData))
		{
			
			if(($OrderID) != "")
			{
				$SelectTrackOrder = $obj->sql_query("SELECT t.*,o.* FROM tbl_trackorder as t INNER JOIN tbl_order as o WHERE t.OrderID = o.OrderID AND t.TrackOrder = '".$_POST['OrderID']."' AND o.RegisterID = '".$_SESSION["RegisterID"]."' ORDER BY TrackID DESC");
				if(count($SelectTrackOrder) > 0)
				{
					$TrackStatus = $SelectTrackOrder[0]['TrackStatus'];
					$SelectStatusName = $obj->sql_query("SELECT * FROM tbl_trackstatus WHERE TrackStatusID = '".$TrackStatus."'");
					echo "Your Order Status is ".ucwords($SelectStatusName[0]['StatusName']);
					exit;
				}
				else
				{
					echo "Invalid OrderID";
					exit;
				}
			}
			
		} 
		else
		{
			echo "Invalid OrderID";
			
			exit;
		}
	 }
	
	
?>