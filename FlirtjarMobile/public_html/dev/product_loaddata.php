<?php
	/*----------File Information----------*/
	#Project : MDecor
	#File Created Date : 20 January 15
	#File Edited Date :
	/*----------File Information----------*/

	include ("includes/connection.php");
	$obj = new myclass();
	
	session_start();
	
	if($_POST['ParentCategoryID'])
	{
		$CategoryID = $_POST['ParentCategoryID'];
			$SelectProduct = $obj->sql_query("select p.*,c.* from tbl_product as p INNER JOIN tbl_category as c where p.CategoryID = c.CategoryID AND (c.CategoryID = '".$CategoryID."' OR c.ParentCategoryID = '".$CategoryID."')");
			
			echo '<option selected="selected" value=""> Select </option>';
			for($i=0; $i<count($SelectProduct); $i++)
			{
				$ProductID = $SelectProduct[$i]['ProductID'];
				$ProductName = $SelectProduct[$i]['ProductName'];
				
				echo  '<option value="'.$ProductID.'">'.$ProductName.'</option>';
			}
	}
?>