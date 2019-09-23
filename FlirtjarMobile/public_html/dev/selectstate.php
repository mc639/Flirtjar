<?php
	include ("includes/connection.php");
	$obj = new myclass();
	
	session_start();
	$action = $_REQUEST['action'];
	
	if($_POST['id'])
	{
		$CountryID = $_POST['id'];
		$SelectState = $obj->sql_query("SELECT * FROM tbl_state WHERE CountryID = '".$CountryID."' ORDER BY StateName");
		
		echo '<option value="" disabled selected style="display: none;"> Select State </option>';
		for($i=0; $i<count($SelectState); $i++)
		{
			
			$StateID = $SelectState[$i]['StateID'];
			$StateName = $SelectState[$i]['StateName'];
			
			$SData = $obj->sql_query("SELECT * FROM tbl_state WHERE StateID = '".$StateID."'");
			
					echo  '<option value="'.$StateID.'">'.$StateName.'</option>';
			
		}
	}
	
?>