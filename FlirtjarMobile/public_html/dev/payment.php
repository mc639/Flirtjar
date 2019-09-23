  <?php
	/*----------File Information----------*/
	#Project : Hash Tag
	#File Created By : Avani Trivedi 
	#File Created Date : 19 Jan 2016
	#File Edited By :
	#File Edited Date :
	/*----------File Information----------*/
	
	include ("includes/connection.php");
	include("includes/encrypt.php");
	$obj = new myclass();
	session_start();
	
	require_once('includes/class.phpmailer.php');
	$RegisterID = $_SESSION['RegisterID'];
	$FinalPrice = $_SESSION['totalcartprice'];
	
	if(empty($_GET['AID']))
	{
		$SelectAddressNoAid = $obj->sql_query("SELECT * FROM tbl_newaddress WHERE RegisterID = '".$RegisterID."' AND SetAsDefault = 'True'");
		$AID = $SelectAddressNoAid[0]['AID'];	
	}
	else
	{
		$AID = $_GET['AID'];	
	}
		
	date_default_timezone_set('asia/calcutta');
	$OrderDate = date('Y-m-d');
	$OrderTime = date('h:i:s A');
	
	$autoincrement = $obj->sql_query("SHOW TABLE STATUS LIKE 'tbl_order'");
	$AutoId = 1000+$autoincrement[0]['Auto_increment'];
	
	$SelectCartData = $obj->sql_query("SELECT * FROM tbl_cart WHERE RegisterID = '".$RegisterID."' ");
	for($i=0;$i<count($SelectCartData);$i++)
	{
		$total += $SelectCartData[$i]['Quantity']*$SelectCartData[$i]['Price'];
	}
	
	$InsertOrder = $obj->sql_query("INSERT INTO tbl_order (OrderID, OrderReference, RegisterID, TotalPrice, AID, OrderDate, OrderTime, PaymentStatus, OrderStatus) 
	VALUES ('', '".$AutoId."', '".$RegisterID."', '".$FinalPrice."', '".$AID."', '".$OrderDate."', '".$OrderTime."', 'Unpaid', 'Undelivered')");
	
	$_SESSION['LastInsertID'] = mysql_insert_id();
	$TrackOrder = "HASH".$AutoId.$_SESSION['LastInsertID'];
	
	$InsertTrackOrder = $obj->sql_query("INSERT INTO tbl_trackorder (TrackID, OrderID, TrackOrder, OrderDate, TrackStatus) VALUES ('', '".$_SESSION['LastInsertID']."', '".$TrackOrder."', '".$OrderDate."', 'Order Received')");
	
	if(isset($_SESSION['checkoutcart']))
		{
			foreach($_SESSION['checkoutcart'] as $key=>$value)
			{ 
				if(!empty($key))
				{
					$ProductID = $value['ProductID'];
					$Price = $value['ProductPrice'];
					$Quantity = $value['Qty'];
					$ProductSize = $value['ProductSize'];
					$MobileDevice = $value['MobileDevice'];
					
					/* TEMPORARY COMENTED */
					$InsertOrderDetail = $obj->sql_query("INSERT INTO tbl_orderdetail (OrderDetailID, OrderID, ProductID, Price, Quantity, ProductSize , MobileDevice) VALUES ('', '".$_SESSION['LastInsertID']."', '".$ProductID."', '".$Price."', '".$Quantity."', '".$ProductSize."', '".$MobileDevice."') ");
					/* TEMPORARY COMENTED */
				}
			}
		}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hashtag - Checkout</title>
    <?php include("includes/js_css.php"); ?>
    <!-- Resource style -->
    
    <script src="js/jquery.creditCardValidator.js"></script>
    <style>
form #card_number {
background-image: url(img/images.png), url(img/images.png);
  background-position: 2px -121px, 260px -61px;
  background-size: 120px 361px, 120px 361px;
  background-repeat: no-repeat;
  padding-left: 54px;
  width: 225px;
}
form #card_number.visa {
  background-position: 2px -163px, 260px -61px;
}
form #card_number.visa_electron {
  background-position: 2px -205px, 260px -61px;
}
form #card_number.mastercard {
  background-position: 2px -247px, 260px -61px;
}
form #card_number.maestro {
  background-position: 2px -289px, 260px -61px;
}
form #card_number.discover {
  background-position: 2px -331px, 260px -61px;
}
form #card_number.valid.visa {
  background-position: 2px -163px, 260px -87px;
}
form #card_number.valid.visa_electron {
  background-position: 2px -205px, 260px -87px;
}
form #card_number.valid.mastercard {
  background-position: 2px -247px, 260px -87px;
}
form #card_number.valid.maestro {
  background-position: 2px -289px, 260px -87px;
}
form #card_number.valid.discover {
  background-position: 2px -331px, 260px -87px;
}
.log{
	padding-left:114px;
	font-size:12px;
	margin-top:10px;
}

    </style>
    
</head>

<body>
	<!-- HEADER -->
    <?php include("includes/header.php"); ?>
    <!-- HEADER -->
    
    <div id="stickyalias"></div>
    <a href="#0" class="cd-top"><i class="fa fa-angle-up"></i></a>
    <!-- BREADCRUMB -->
    <section class="headingdisplay">
        <div class="container">
            <div class="row">
                <div class="col-md-6 ">
                    <h1 class="pull-left">Payment</h1>
                </div>
                <div class="col-md-6 ">
                    <ul class="breadcrumb pull-right">
                        <li><a href="index">Home</a></li>
                        <li><a class="active"><i class="fa fa-angle-right pr5 breakdivsion"></i>Payment</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- BREADCRUMB -->
    
    <!-- MENU -->
    <section class="multistep-breadcrumb">
        <div class="container">
            <div class="row">
                <nav>
                    <ol class="cd-breadcrumb triangle">
                        <li><a href="login-step">Enter Email Address</a></li>
                        <li><a href="address-step">Delivery Address</a></li>
                        <li><a href="checkout"><em>Order Summary</em></a></li>
                        <li class="current"><a><em>Payment Details</em></a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <!-- MENU -->
    
    
    <section class="checkout">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 table-responsive">
                    <h3>Your Order Is Confirmed..!!</h3>
                </div>
            </div>
        </div>
    </section>
    
    <div>
        <center>
        	<form method="POST" name="customerData" action="ccavRequestHandler.php">
				<input type="hidden" name="tid" id="tid" readonly />
                <input type="hidden" name="merchant_id" value="83245"/>
                <input type="hidden" name="order_id" value="<?php echo $_SESSION['LastInsertID']; ?>"/>
                <input type="hidden" name="amount" value="<?php echo $FinalPrice; ?>"/>
                <input type="hidden" name="currency" value="INR"/>
                <input type="hidden" name="redirect_url" value="http://10.0.0.15/hashtagnew/sucess.php"/>
                <input type="hidden" name="cancel_url" value="http://10.0.0.15/hashtagnew/cancel.php"/>
                <input type="hidden" name="language" value="EN"/>
                <?php 
				$SelectAddressDetail = $obj->sql_query("SELECT * FROM tbl_newaddress WHERE AID = '".$AID."'");
				?>
		       	<input type="hidden" name="billing_name" value="<?php echo $SelectAddressDetail[0]['Fname']; ?>"/>
                <input type="hidden" name="billing_address" value="<?php echo $SelectAddressDetail[0]['Address']; ?>"/>
                <input type="hidden" name="billing_city" value="<?php echo $SelectAddressDetail[0]['City']; ?>"/><input type="hidden" name="billing_state" value="<?php echo $SelectAddressDetail[0]['State']; ?>"/><input type="hidden" name="billing_zip" value="<?php echo $SelectAddressDetail[0]['Pincode']; ?>"/>
                <?php
                $SelectCountryName = $obj->sql_query("SELECT * FROM tbl_country WHERE CountryID = '".$SelectAddressDetail[0]['Country']."'");
                ?>
                <input type="hidden" name="billing_country" value="<?php echo $SelectCountryName[0]['CountryName']; ?>"/>
                <input type="hidden" name="billing_tel" value="<?php echo $SelectAddressDetail[0]['Phone']; ?>"/>
            
                <?php echo $SelectBilingEmail = $obj->sql_query("SELECT * FROM tbl_register WHERE RegisterID = '".$RegisterID."'"); ?>
                <input type="hidden" name="billing_email" value="<?php echo $SelectBilingEmail[0]['Email']; ?>"/>
            
            	<INPUT TYPE="submit" value="CheckOut" class="btn btn-primary button-subscribe btnshadow-nor btn-shopping-item btn-bluehover">
		       
	      </form>
            <?php
                $a = Encrypt('myPass123', $AID);
            ?>
            <a href="sucess/<?php echo $a; ?>" class="btn btn-primary button-subscribe btnshadow-nor btn-shopping-item btn-bluehover"> OK </a>
            
            <a href="cancel/<?php echo $a; ?>" class="btn btn-primary button-subscribe btnshadow-nor btn-shopping-item btn-bluehover"> CANCEL </a>
        </center>
	</div>

    <!-- PDF & MAIL -->
<?php 

	$SelectDetail = $obj->sql_query("SELECT od.*,o.* FROM tbl_orderdetail as od LEFT JOIN 
	tbl_order as o ON od.OrderID = o.OrderID WHERE o.OrderID ='".$_SESSION['LastInsertID']."' ORDER BY o.OrderID DESC");
	$SelectAddress = $obj->sql_query("SELECT * FROM tbl_newaddress WHERE AID = '".$AID."'");
	
	$ShippingFirstName = stripslashes($SelectAddress[0]['Fname']);
	$ShippingLastName = stripslashes($SelectAddress[0]['Lname']);
	$ShippingAddress1 = stripslashes($SelectAddress[0]['Address']);
	$ShippingCity = $SelectAddress[0]['City'];
	$ShippingState = $SelectAddress[0]['State'];
	$ShippingCountryID = $SelectAddress[0]['Country'];
	$SelectCountry = $obj->sql_query("SELECT * FROM tbl_country WHERE CountryID ='".$ShippingCountryID."'");
	$ShippingCountryName = $SelectCountry[0]['CountryName'];
	$ShippingPhone = $SelectAddress[0]['Phone'];
	$ShippingZip = $SelectAddress[0]['Pincode'];
	$OrderReference = $SelectDetail[0]['OrderReference'];
	
	
	$SelectEmail = $obj->sql_query("SELECT * FROM tbl_register WHERE RegisterID = '".$RegisterID."'");
	
	$ShippingEmail = $SelectEmail[0]['Email'];
	
	$TotalPrice = $SelectDetail[0]['TotalPrice'];

	
	
	$filename = "HashTag_invoice_HASH";
	$CurrMonth = date("m");
	
	if($CurrMonth > 03)
	{
		$CurrYear = date("Y");
		$CurrYear.= date("y")+1;
	}
	else
	{
		$CurrYear = date("Y")-1;
		$CurrYear.= date("y");
	}
	
	$filename = $filename.$CurrYear.$OrderReference;
	$InvoiceNo = "HASH".$CurrYear.$OrderReference;
	
	$InvoiceName = $filename.'.pdf';
	$Update = $obj->sql_query("UPDATE tbl_order SET Invoice='".$InvoiceName."' WHERE OrderID = '".$_SESSION['LastInsertID']."'");
    ob_start();
	
   ?>
<table width="50%" cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td valign="top" align="left"><table width="590" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td valign="top" colspan="5" style="padding-bottom:10px;"><!--<img src="images/logo.png" alt="" />--></td>
        </tr>
        <tr>
          <td valign="top" colspan="5" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; line-height:24px;"><p><strong>Hashtag Web Shop</strong><br />
            Address Line 1, Ahmedabad - 380006, Gujarat, India<br>
            Tel.: +91 00 00000000  Email: hello@hashtagshop.in </p></td>
        </tr>
        <tr>
          <td valign="top" colspan="5" height="30"></td>
        </tr>
        <tr>
          <td valign="top" colspan="5" style="border-bottom:5px #585858 solid; font-family:Arial, Helvetica, sans-serif;"><h1>RETAIL INVOICE <span style="font-weight:normal;font-family:Arial, Helvetica, sans-serif"> #<?php echo $InvoiceNo; ?></span></h1></td>
        </tr>
        <tr>
          <td valign="top" colspan="5" height="20"></td>
        </tr>
        <tr>
          <td colspan="3" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:16px;"><strong>Shipping Information</strong></td>
          <td colspan="2" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:16px;"><strong></strong></td>
        </tr>
        <tr>
          <td colspan="3" valign="top" align="left" width="200" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; line-height:24px;"><strong><?php echo $ShippingFirstName.' '.$ShippingLastName; ?></strong><br>
            <?php echo $ShippingAddress1.'<br>'.$ShippingAddress2; ?><br />
            <?php echo $ShippingCity.' - '.$ShippingZip; ?><br>
            <?php echo $ShippingState.' - '.$ShippingCountryName; ?></td>
          <td colspan="2" valign="top" align="left" width="160" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; line-height:24px;"><br>
            <br>
            <br>
          </td>
        </tr>
        <tr>
          <td valign="top" colspan="5" style="border-bottom:5px #585858 solid;">&nbsp;</td>
        </tr>
        <tr>
          <td width="160" height="50" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; border-bottom:5px #585858 solid;">ORDER</td>
          <td width="137" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; border-bottom:5px #585858 solid;">ORDER DETAILS</td>
          <td width="65" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; border-bottom:5px #585858 solid;">QANTITY</td>
          <td width="124" align="right" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; border-bottom:5px #585858 solid;">UNIT PRICE</td>
          <td width="104" align="right" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; border-bottom:5px #585858 solid;">TOTAL</td>
        </tr>
			<?php
			
            for($i=0;$i<count($SelectDetail);$i++)
            {
			
				$Quantity = $SelectDetail[$i]['Quantity'];
                $Price = $SelectDetail[$i]['Price'];
				$ProductSize = $SelectDetail[$i]['ProductSize'];
				$MobileDevice = $SelectDetail[$i]['MobileDevice'];
                $OrderRef = $SelectDetail[$i]['OrderReference'];
                $OrderDate = $SelectDetail[$i]['OrderDate'];
            ?>
            <tr>
              <td valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; padding:20px 0; line-height:30px;">ORDER ID:<strong><?php echo $OrderRef; ?></strong><br>
                ORDER DATE:<strong><?php echo date("d-m-Y",strtotime($OrderDate)); ?></strong><br>
                INVOICE NO.:<strong><?php echo $InvoiceNo; ?></strong><br>
                INVOICE DATE:<strong><?php echo date("d-m-Y",strtotime($OrderDate)); ?></strong></td>
              <td valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; padding:20px 0; line-height:30px;"><strong></strong><br>
               <?php if(!empty($ProductSize)){ ?> SIZE: <?php } else {?> MOBILE DEVICE <?php } ?><strong><?php if(!empty($ProductSize)){ echo $ProductSize; } else { echo $MobileDevice; } ?></strong><br>
                <small></small><br>
                <strong></strong></td>
              <td align="center" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; padding:20px 0; line-height:30px;"><strong><?php echo $Quantity; ?></strong></td>
              <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; padding:20px 0; line-height:30px;"><strong><?php echo $CSymbol.' '.$Price;?></strong></td>
              <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; padding:20px 0; line-height:30px;"><strong>&nbsp;&nbsp;<?php echo $CSymbol.' '.$Price * $Quantity.'.00'; ?></strong></td>
            </tr>
            <?php
            }
            ?>
        <tr>
          <td colspan="3" align="right" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; border:5px #585858 solid; border-right:none; border-left:none; border-bottom:none;">DISCOUNT</td>
          <td colspan="2"  align="right" valign="middle" style="font-family:Arial, Helvetica, sans-serif; border:5px #585858 solid; border-right:none; border-left:none; border-bottom:none; font-size:20px;"><?php echo $CSymbol.' '.$Discount; ?></td>
        </tr>
        <tr>
          <td style="border:5px #585858 solid; border-right:none; border-top:none; border-left:none;" valign="middle" height="50">&nbsp;</td>
          <td colspan="2" align=" right" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; border:5px #585858 solid; border-right:none; border-left:none; border-top:none;">GRAND TOTAL </td>
          <td colspan="2"  align="right" valign="middle" style="font-family:Arial, Helvetica, sans-serif; border:5px #585858 solid; border-right:none; border-left:none; font-size:30px; border-top:none;"><strong><?php echo $CSymbol.' '.$TotalPrice; ?></strong></td>
        </tr>
        <tr>
          <td height="50" align="left" colspan="5" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">This is a computer generated invoice. No signature required.</td>
        </tr>
        <tr>
          <td colspan="5" align="left" valign="bottom" style="font-family:Arial, Helvetica, sans-serif; font-size:16px;"><h1 style="margin-top:40px;">THANK YOU<span style="font-weight:normal;font-family:Arial, Helvetica, sans-serif;"> FOR YOUR ORDER!</span></h1></td>
        </tr>
        <tr>
          <td colspan="5" align="left" valign="bottom" style="font-family:Arial, Helvetica, sans-serif; font-size:16px;"><h1 style="margin-top:40px;"><span style="font-weight:normal;font-family:Arial, Helvetica, sans-serif;"> TRACK YOUR ORDER WITH - </span><?php echo "HASH".$OrderRef.$_SESSION['LastInsertID']; ?></h1></td>
        </tr>
      </table></td>
  </tr>
</table>
	<?php
   $content = ob_get_clean();

    require_once('html2pdf/html2pdf.class.php');
    try
    {
		$html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(5, 5, 5, 5));
		
        $html2pdf->pdf->SetDisplayMode('fullpage');
		
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		
        $html2pdf->Output("upload_data/invoice_pdf/$filename.pdf",'F');

		
    }
    catch(HTML2PDF_exception $e)
	{
        echo $e;
		exit;
    }
	
	$subject = "HashTag - Order Confirmed";
	$toemail = "$ShippingEmail";
	$mailbody = "MAIL TO ORDER";
	$attachment = "upload_data/invoice_pdf/$filename.pdf";
	$mail = new PHPMailer(); // defaults to using php "mail()"
	$mail->SetFrom("sendmail@hashtagshop.in", "HashTag");
	$mail->AddReplyTo("$ShippingEmail","$ShippingFirstName");
	$address = "$ShippingEmail";
	$mail->AddAddress($address, "");
	$mail->Subject    = "$subject";
	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; //optional, comment out and test
	$mail->MsgHTML($mailbody);
	$mail->addAttachment($attachment, "$filename.pdf");
	$mail->IsSMTP();
	$mail->CharSet = "ISO-8859-1";
	$mail->SMTPAuth = true;
	$mail->Host = "mail.hashtagshop.in";
	$mail->Port = "587";
	$mail->Username = 'sendmail@hashtagshop.in';
	$mail->Password = 'hshop!@#';
	$mail->Send();

?>
<!-- PDF & MAIL -->




<?php
$DeleteWishlist = $obj->sql_query("DELETE w FROM tbl_wishlist w INNER JOIN tbl_cart ON tbl_cart.ProductID = w.ProductID WHERE tbl_cart.RegisterID = '".$_SESSION['RegisterID']."' AND w.RegisterID = '".$_SESSION['RegisterID']."'");
unset($_SESSION['wishlist']);
?>

<?php 
$DeleteCart = $obj->sql_query("DELETE FROM tbl_cart WHERE RegisterID = '".$_SESSION['RegisterID']."'");
unset($_SESSION['CountCart']);
unset($_SESSION['cart']);
unset($_SESSION['checkoutcart']);
?>
    
    <div class="seperator"></div>
    
     <!-- REGISTER/LOGIN WITH FACEBOOK & GOOGLE + -->
    <?php include("includes/loginwithfbgp.php") ?>
    <!-- REGISTER/LOGIN WITH FACEBOOK & GOOGLE + -->
    
    <!-- LOGIN MODEL -->
    <?php include("includes/loginmodel.php"); ?>
    <!-- LOGIN MODEL -->
    
    <!-- FOOTER -->
	<?php include("includes/footer.php"); ?>
    <!-- FOOTER -->
</body>

</html>
