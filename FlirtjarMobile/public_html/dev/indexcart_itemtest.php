<?php
	/*----------File Information----------*/
	#Project : HASHTAG
	#File Created By : Mona Bera
	#File Created Date : 18 Jan 2016
	#File Edited By :
	#File Edited Date :
	/*----------File Information----------*/
	
	include("includes/connection.php");
	include("includes/encrypt.php");
	session_start();
	$obj = new myclass();
	$ProductID = $_POST['ProductID'];
	if(empty($_POST['quantity']))
	{
		$Qty = 1;
	}
	else
	{
		$Qty = $_POST['quantity'];
	}
	
	if($_POST['Price1'])
	{
		$Price = $_POST['Price1'];
	}
	else
	{
		$Price = $_POST['Price'];
	}
	if(!empty($_SESSION['RSize']))
	{
		$Size = $_SESSION['RSize'];	
	}
	if(!empty($_SESSION['FSize']))
	{
		$Size = $_SESSION['FSize'];	
	}
	
	
	$RegisterID = $_SESSION['RegisterID'];
	$Date = date('y-m-d'); 
	
	$Cart = "cart";
	 $SelectProductData1 = $obj->sql_query("SELECT * FROM tbl_product WHERE ProductID = '".$ProductID."'");
                                                $SelectProductImage1 = $obj->sql_query("SELECT * FROM tbl_productimage WHERE ProductID = '".$ProductID."'");
												
												 
                                                                        $a = Encrypt('myPass123', $SelectProductData1[0]['ProductID']);
  
	echo '<button type="button" class="close" data-dismiss="dropdown" aria-hidden="true" onclick="hide_cart()">×</button>
			<li>
                <span class = "img-cart">
                   <img src="upload_data/productimage/thumb/'.$SelectProductImage1[0]['ImageName'].'" alt="Two-Faced T-Shirt">
                </span>
                <span>'.ucwords($SelectProductData1[0]['ProductName']).'</span>
					
				<span class = "price-cartpopup"><i class="fa fa-rupee"></i>'.$Price.'</i></span>
			</li> 
			<center>
				<br>
				<a href="cart"> 
					<input type="button" class="btn btn-primary button-subscribe btnshadow-nor" value="View Cart" onclick="window.location = cart">
				</a>
			</center>';
	exit;
	?>