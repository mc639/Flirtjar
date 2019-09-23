
<?php
	/*----------File Information----------*/
	#Project : Hash Tag
	#File Created By : Avani Trivedi 
	#File Created Date : 19 Aug 2015
	#File Edited By :
	#File Edited Date :
	/*----------File Information----------*/
	
	include("includes/connection.php");
	$obj = new myclass;
	session_start();
	$action = $_POST['action'];
	$Email=$_REQUEST['HeaderEmail'];
	$Password = $_REQUEST['HeaderPassword'];
	
	
	if(!empty($_GET['from']))
	{ 
	  $from = $_GET['from'];
	  $_SESSION['RedirectTo'] = $from;
	}

	if($action == "Login")
	{
		$sql = $obj->sql_query("SELECT * FROM tbl_register WHERE BINARY Email= BINARY '".mysql_real_escape_string($Email)."' AND BINARY Password = BINARY '".mysql_real_escape_string($Password)."'");
		if(count($sql)==1)
		{	
			session_start();
			$_SESSION["RegisterID"] = $sql[0]['RegisterID'];
			$_SESSION["FullName"] = $sql[0]['FirstName'];
			$registereduser = $sql[0]['FullName'];
			$registereduserid = $sql[0]['RegisterID'];
			$_SESSION['on_off1_member'] = 1;
			$Date = date('y-m-d');
			
			
			/* FOR CART */
			foreach($_SESSION['cart'] as $key=>$value)
			{
				if(!empty($key))
				{
					$SelectForCart = $obj->sql_query("SELECT * FROM tbl_cart WHERE RegisterID = '".$_SESSION["RegisterID"]."' AND ProductID = '".$value['ProductID']."' AND Size = '".$value['Size']."'");
					if(count($SelectForCart) > 0)
					{
						$Quat = $value['Qty'] + $SelectForCart[0]['Quantity'];
						$Update = $obj->sql_query("UPDATE tbl_cart SET Quantity = '".$Quat."', ProductPrice = '".$value['Price']."' WHERE RegisterID = '".$_SESSION["RegisterID"]."' AND ProductID = '".$value['ProductID']."' AND Size = '".$value['Size']."'");
					}
					else
					{
						$insert = $obj->sql_query("INSERT INTO tbl_cart (CartID, RegisterID, ProductID, Quantity, Size, ProductPrice, Date) VALUES ('', '".$_SESSION["RegisterID"]."', '".$value['ProductID']."', '".$value['Qty']."', '".$value['Size']."', '".$value['Price']."', '".$Date."')");
						$checkoutcart =	array(
						'ProductID' => $value['ProductID'],
						'ProductPrice' => $value['Price'],
						'ProductSize' => $value['Size'],
						'Qty' => $value['Qty']
						);
						$_SESSION['checkoutcart'][0] = array();
						$_SESSION['checkoutcart'][$i+1] = $checkoutcart;
					}
				}
				unset($_SESSION['cart'][$key]);
			}
			/* FOR CART */
			
			/* FOR WISHLIST */
				if(!empty($_SESSION['wishlist']))
				{
					foreach($_SESSION['wishlist'] as $key=>$value)
					{
						if(!empty($key))
						{
							
							$insert = $obj->sql_query("INSERT INTO tbl_wishlist (WishListID, RegisterID, ProductID, Date) VALUES ('', '".$_SESSION["RegisterID"]."', '".$value['ProductID']."', '".$Date."')");
						}
								unset($_SESSION['wishlist'][$key]);	
					}	
				}
			/* FOR WISHLIST */
				
		}
			
		if(count($sql)>0)
		{
			$_SESSION['RegisterID'] = $sql[0]['RegisterID'];
			echo '1';
			exit;
		}
		
	}
	else
	{
		echo '0';
		exit;
	}
	
?>