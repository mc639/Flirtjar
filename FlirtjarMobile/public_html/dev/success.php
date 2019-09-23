<?php
	/*----------File Information----------*/
	#Project : HashTag
	#File Created By : Avani Trivedi 
	#File Created Date : 11 Nov 2016
	#File Edited By :
	#File Edited Date :
	/*----------File Information----------*/
	
	include ("includes/connection.php");
	include("includes/encrypt.php");
	include("priceinwords.php");
	$obj = new myclass();
	session_start();
	require_once('includes/class.phpmailer.php');
	$cod = $_GET['cod']; 
	$Discount = $_REQUEST['Discount'];
	$Dis = ($_SESSION['FinalP'] - $_SESSION['totalcartprice'] ); 
	
	
		/*  INSERT QUERY IN ORDER AND ORDER DETAIL PAGE */
			date_default_timezone_set('asia/calcutta');
			$OrderDate = date('Y-m-d');
			$OrderTime = date('h:i:s A');
			
			$autoincrement = $obj->sql_query("SHOW TABLE STATUS LIKE 'tbl_order'");
			$AutoId = 1000+$autoincrement[0]['Auto_increment'];
			$AID = $_SESSION['ADDRESSID'];
			$FinalPrice = $_SESSION['totalcartprice'];
			//echo $FinalPrice; exit;
			$RegisterID = $_SESSION['RegisterID'];
			
			$InsertOrder = $obj->sql_query("INSERT INTO tbl_order (OrderID, OrderReference, RegisterID, TotalPrice, VATPercentage, VATPrice, AID, OrderDate, OrderTime, PaymentStatus, OrderStatus,  CashOnDelivery) 
			VALUES ('', '".$AutoId."', '".$RegisterID."', '".$FinalPrice."', '".$_SESSION['TAXINSERT']."', '".$_SESSION['TAXRATEINSERT']."', '".$AID."', '".$OrderDate."', '".$OrderTime."', 'Unpaid', 'Undelivered', '')");

			$_SESSION['LastInsertID'] = mysql_insert_id();
			$TrackOrder = "HASH".$AutoId;
			$InsertTrackOrder = $obj->sql_query("INSERT INTO tbl_trackorder (TrackID, OrderID, TrackOrder, OrderDate, TrackStatus) VALUES ('', '".$_SESSION['LastInsertID']."', '".$TrackOrder."', '".$OrderDate."', '1')");

			$SelectCartData = $obj->sql_query("SELECT * FROM tbl_cart WHERE RegisterID = '".$RegisterID."' ");
			for($od=0;$od<count($SelectCartData);$od++)
			{
				$ProductID = $SelectCartData[$od]['ProductID'];
				$Price = $SelectCartData[$od]['ProductPrice'];
				$Quantity = $SelectCartData[$od]['Quantity'];
				$ProductSize = $SelectCartData[$od]['Size'];
				$MobileDevice = $SelectCartData[$od]['MobileDevice'];
				$InsertOrderDetail = $obj->sql_query("INSERT INTO tbl_orderdetail (OrderDetailID, OrderID, ProductID, Price, Quantity, ProductSize , MobileDevice) VALUES ('', '".$_SESSION['LastInsertID']."', '".$ProductID."', '".$Price."', '".$Quantity."', '".$ProductSize."', '".$MobileDevice."') ");
			}
		/*  INSERT QUERY IN ORDER AND ORDER DETAIL PAGE */
	
	
	
	
	
	
	if($cod == 'yes')
	{	
		$SelectOrderID = $obj->sql_query("SELECT * FROM tbl_order WHERE OrderID = '".$_SESSION['LastInsertID']."'");
		for($se=0;$se<count($SelectOrderID);$se++)
		{
			$OrderID = $SelectOrderID[$se]['OrderID'];
			$UpdatePaymentStatus = $obj->sql_query("UPDATE tbl_order SET PaymentStatus = 'Unpaid', CashOnDelivery = 'yes' WHERE OrderID = '".$_SESSION['LastInsertID']."'");
		}
		$PaymentMethod = "Cash On Delivery";
	}
	
	else
	{
		$Discount = $Dis;
		$PaymentMethod = "Online Payment";
		$SelectOrderID = $obj->sql_query("SELECT * FROM tbl_order WHERE OrderID = '".$_SESSION['LastInsertID']."'");
		for($se=0;$se<count($SelectOrderID);$se++)
		{
			$OrderID = $SelectOrderID[$se]['OrderID'];
			$UpdatePaymentStatus = $obj->sql_query("UPDATE tbl_order SET PaymentStatus = 'paid' WHERE OrderID = '".$_SESSION['LastInsertID']."'");
			$SelectPID = $obj->sql_query("SELECT * FROM tbl_orderdetail WHERE OrderID = '".$OrderID."'");
			for($cp=0;$cp<count($SelectPID);$cp++)
			{
				$ProductID = $SelectPID[$cp]['ProductID'];
				$Quantity = $SelectPID[$cp]['Quantity'];
				$SelectProductForCount = $obj->sql_query("SELECT * FROM tbl_product WHERE ProductID = '".$ProductID."'");
				$ProductSoldCount = $SelectProductForCount[0]['ProductSoldCount'];
				$ProductSoldCount = $ProductSoldCount + 1;
				$UpdateProductSoldCount = $obj->sql_query("UPDATE tbl_product SET ProductSoldCount = '".$ProductSoldCount."' WHERE ProductID = '".$ProductID."' ");
				
				
				/* Decrement of Product stock */
				$PSize = strtolower($SelectPID[$cp]['ProductSize']);
				$SelectSize = $obj->sql_query("SELECT * FROM tbl_size WHERE SizeName = '".$PSize."'");
				$SizeID = $SelectSize[0]['SizeID'];
				$SelectProductSize = $obj->sql_query("SELECT * FROM tbl_productsize_stockmanage WHERE ProductID = '".$ProductID."' AND SizeID = '".$SizeID."'");
				$ProductStock = $SelectProductSize[0]['ProductStock'];
				if($ProductStock != 0)
				{
					$ProductStock = ($ProductStock - $Quantity);
					$UpdateProductStock = $obj->sql_query("UPDATE tbl_productsize_stockmanage SET ProductStock = '".$ProductStock."' WHERE ProductID = '".$ProductID."' AND SizeID = '".$SizeID."'");
				}
				/* Decrement of Product stock */
			}
		}
	}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>HashTag - Payment Complete</title>
    
    <?php include("includes/js_css.php"); ?>
     
</head>

<body>
	<!-- HEADER -->
    <?php include("includes/header.php"); ?>
    <!-- HEADER -->
    
    <div id="stickyalias"></div>
    
    <!-- ICON FOR GO BOTTOM TO TOP -->
    <a href="#0" class="cd-top"><i class="fa fa-angle-up"></i></a>
    <!-- ICON FOR GO BOTTOM TO TOP -->
    
    <!-- BREADCRUM DIV -->
    <section class="headingdisplay margin-top120">
        <div class="container">
            <div class="row">
                <div class="col-md-6 ">
                    <h1 class="pull-left"></h1>
                </div>
                <div class="col-md-6 ">
                    <ul class="breadcrumb pull-right">
                      
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- BREADCRUM DIV -->
    
    <!-- CONTENT DIV -->
    <section class="checkout">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 table-responsive">
                    <h3>Your Payment Process Is Sucessfully Done..!!</h3>
                </div>
            </div>
        </div>
    </section>
    <!-- CONTENT DIV -->
    
    <!-- DELETE FROM CART -->
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
    <!-- DELETE FROM CART -->
    
   
    
   <!-- PDF & MAIL -->
<?php 
	
	$SelectDetail = $obj->sql_query("SELECT od.*,o.* FROM tbl_orderdetail as od LEFT JOIN tbl_order as o ON od.OrderID = o.OrderID WHERE o.OrderID ='".$_SESSION['LastInsertID']."' ORDER BY o.OrderID DESC");
	$SelectAddress = $obj->sql_query("SELECT * FROM tbl_newaddress WHERE AID = '".$SelectDetail[0]['AID']."'");
	
	$ShippingFirstName = stripslashes($SelectAddress[0]['Fname']);
	$ShippingLastName = stripslashes($SelectAddress[0]['Lname']);
	$ShippingAddress1 = stripslashes($SelectAddress[0]['Address']);
	$ShippingAddress2 = $SelectAddress[0]['Landmark'];
	$ShippingCity = $SelectAddress[0]['City'];
	$ShippingState = $SelectAddress[0]['State'];
	$ShippingCountryID = $SelectAddress[0]['Country'];
	$SelectCountry = $obj->sql_query("SELECT * FROM tbl_country WHERE CountryID ='".$ShippingCountryID."'");
	$ShippingCountryName = $SelectCountry[0]['CountryName'];
	$ShippingPhone = $SelectAddress[0]['Phone'];
	$ShippingZip = $SelectAddress[0]['Pincode'];
	$OrderReference = $SelectDetail[0]['OrderReference'];
	
	
	$SelectEmail = $obj->sql_query("SELECT * FROM tbl_register WHERE RegisterID = '".$_SESSION['RegisterID']."'");
	
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
	$OrderRef = $SelectDetail[0]['OrderReference'];
	$InvoiceName = $filename.'.pdf';
	$InvoiceAddfile = 'HASH_'.$OrderReference.'_shiping.pdf';
	$InvoiceAdd = 'HASH_'.$OrderReference.'_shiping';
	$Update = $obj->sql_query("UPDATE tbl_order SET Invoice='".$InvoiceName."' , AddressPDF = '".$InvoiceAddfile."' WHERE OrderID = '".$_SESSION['LastInsertID']."'");
    ob_start(); 
   ?>
	<table align="center" border="0px" width="100%" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000;border:1px solid #ddd; border-bottom:1px #ddd; border-left:1px #ddd; border-right:1px #ddd;">
		<tr>
			<td colspan="6" style="padding:10px 0px;text-align:center;font-size:20px;font-weight:600;background:#000;color:#fff;"><strong>TAX/RETAIL INVOICE</strong></td>
		</tr>
		<tr>
			<td width="20%" rowspan="5" align="center" valign="middle" style="border-bottom:1px solid #ddd;"><img src="img/logoa-small.png"/></td>
			<td width="13%" style="padding:5px; padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd;"><strong> Invoice Date :</strong></td>
			<td width="8%" style="padding:5px; padding-left:5px; border-bottom:1px #ddd;"><?php echo date("d-m-Y",strtotime($OrderDate)); ?></td>
			<td width="29%" colspan="3" style="padding:5px; padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd;"><strong>Address :</strong></td>
		</tr>
		<tr>
			<td width="13%" style="padding:5px; padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd;"><strong>Invoice No :</strong></td>
			<td width="8%" style="padding:5px; padding-left:5px; border-bottom:1px #ddd;"><?php echo $InvoiceNo; ?></td>
			<td colspan="3" rowspan="2" valign="top" style="padding:5px; padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd;"><strong>Hashtag Web Shop</strong> <br />
			6/A Virnagar Society, <br />
			Opp. Kiranpark & IDBI Bank,<br />
			Bhimjipura Cross Roads, <br />
			New Vadaj,<br />
			Ahmedabad - 380013
			</td>
		</tr>
		<tr>
			<td width="13%" style="padding:5px; padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd;"><strong>Payment Type :</strong></td>
			<td width="8%" style="padding:5px; padding-left:5px; border-bottom:1px #ddd;"><?php echo $PaymentMethod; ?></td>
		</tr>

		<tr>
			<td width="13%" style="padding:5px; padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd;"><strong>Order Date :</strong></td>
			<td width="8%" style="padding:5px; padding-left:5px; border-bottom:1px #ddd;"><?php echo date("d-m-Y",strtotime($OrderDate)); ?></td>
			<td width="29%" style="padding:5px; padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd;"><strong>Vat No. :</strong></td>
			<td colspan="2" style="padding:5px; padding-left:5px; border-bottom:1px #ddd;">123456789</td>
		</tr>
		<tr>
			<td width="13%" style="padding:5px; padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd;"><strong>Order No. :</strong></td>
			<td width="8%" style="padding:5px; padding-left:5px; border-bottom:1px #ddd;"><?php echo $OrderRef; ?></td>
			<td width="29%" style="padding:5px; padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd;"><strong>CST No. :</strong></td>
			<td colspan="2" style="padding:5px; padding-left:5px; border-bottom:1px #ddd;">123456654</td>
		</tr>
		<tr>
			<td colspan="3" style="padding-left:5px; padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd; padding:5px;"> <strong>Bill To: </strong></td>
			<td colspan="3" style="padding-left:5px; padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd; padding:5px;"> <strong>Delivery Adress: </strong></td>
		</tr>
		<tr>
			<td colspan="3" style="padding-left:5px; padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd; padding:5px;"> <strong><?php echo $ShippingFirstName.' '.$ShippingLastName; ?></strong><br>
            <?php echo $ShippingAddress1.'<br>'.$ShippingAddress2; ?><br />
            <?php echo '<br>'.$ShippingCity.' - '.$ShippingZip; ?><br>
            <?php 
				$StateNametbl = $obj->sql_query("SELECT * FROM tbl_state WHERE StateID = '".$ShippingState."'");
				$State = $StateNametbl[0]['StateName'];
				echo '<br>'.$State.' - '.$ShippingCountryName; 
			?></td>
			<td colspan="3" style="padding-left:5px; padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd; padding:5px;"> <strong><?php echo $ShippingFirstName.' '.$ShippingLastName; ?></strong><br>
            <?php echo $ShippingAddress1.'<br>'.$ShippingAddress2; ?><br />
            <?php echo '<br>'.$ShippingCity.' - '.$ShippingZip; ?><br>
            <?php 
				$StateNametbl = $obj->sql_query("SELECT * FROM tbl_state WHERE StateID = '".$ShippingState."'");
				$State = $StateNametbl[0]['StateName'];
				echo '<br>'.$State.' - '.$ShippingCountryName; 
			?></td>
		</tr>
		<tr>
			<td colspan="6" align="center" style="padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd; padding:5px;"><strong>NON CODE ORDER</strong></td>
		</tr>
		<tr>
			<td colspan="2" style="padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd; padding:5px;"><strong>Product Name</strong></td>
			<td style="padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd; padding:5px;"><strong><?php if(!empty($ProductSize)){ ?> Size <?php } else {?> Mobile Device <?php } ?></strong></td>
			<td style="padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd; padding:5px;"><strong>Quantity</strong></td>
			<td width="11%" style="padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd; padding:5px;"><strong>Unit Price</strong></td>
			<td style="padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd; padding:5px;" width="19%"><strong>Amount</strong></td>
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
			$SelectProductName = $obj->sql_query("SELECT * FROM tbl_product WHERE ProductID = '".$SelectDetail[$i]['ProductID']."'");
			$ProductName = $SelectProductName[0]['ProductName'];
		?>
			<tr>
				<td colspan="2" style="padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd; padding:5px;"><?php echo $ProductName; ?></td>
				<td style="padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd; padding:5px;"><?php if(!empty($ProductSize)){ echo $ProductSize; } else { echo $MobileDevice; } ?></td>
				<td style="padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd; padding:5px;"><?php echo $Quantity; ?></td>
				<td style="padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd; padding:5px;"><?php echo $Price;?></td>
				<td style="padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd; padding:5px;"><?php echo $Price * $Quantity.'.00'; ?></td>
			</tr>
		<?php
		}
		?>
		<tr>
			<td colspan="4" valign= "top" style="border-bottom:1px #ddd; border-left:1px #ddd; padding:5px;"><strong>Rupee In Words:</strong> <br/> </td>
			<td style="border-bottom:1px #ddd; border-left:1px #ddd; padding:5px;">DISCOUNT</td>
			<td style="border-bottom:1px #ddd; border-left:1px #ddd; padding:5px;"><?php if(!empty($Discount)){ echo $Discount; } else { echo "0.00"; } ?></td>
		</tr>
		<tr>
			<td colspan="4" rowspan="3" valign= "top" style="border-bottom:1px #ddd; border-left:1px #ddd; padding:5px;"><?php $objw = new toWords($TotalPrice);
    echo $objw->words; ?> Only.</td>
			<td style="border-bottom:1px #ddd; border-left:1px #ddd; padding:5px;">Total</td>
			<td style="border-bottom:1px #ddd; border-left:1px #ddd; padding:5px;"><?php echo $TotalPrice; ?></td>
		</tr>
		<tr>
		<?php
			$SelectVat = $obj->sql_query("SELECT * FROM tbl_vat");
			if($ShippingState == "12")
			{
				$Tax = $SelectVat[0]['PercentageInGujarat'];
			}
			else
			{
				$Tax = $SelectVat[0]['OutOfGujarat'];
			}
			$TaxPrice = (($TotalPrice * 100) / (100 + $Tax));
			$TaxRate = $TotalPrice - $TaxPrice;
		?>
			<td style="border-bottom:1px #ddd; border-left:1px #ddd; padding:5px;">VAT</td>
			<td style="border-bottom:1px #ddd; border-left:1px #ddd; padding:5px;"><?php echo round($TaxRate,2); ?></td>
		</tr>
		<tr>
			<td style="border-bottom:1px #ddd; border-left:1px #ddd; padding:5px;"><strong>GRAND TOTAL</strong></td>
			<td style="border-bottom:1px #ddd; border-left:1px #ddd; padding:5px;"><?php echo $TotalPrice; ?></td>
		</tr>
		<tr>
			<td colspan="6" style="border-bottom:1px #ddd; border-left:1px #ddd; padding:5px;">Please note this a computer and hence does not need signature.</td>
		</tr>
		<tr>
			<td colspan="6" style="border-bottom:1px #ddd; border-left:1px #ddd; padding:5px;">TRACK YOUR ORDER WITH - <strong><?php echo "HASH".$OrderRef; ?></strong></td>
		</tr>
		<tr>
			<td colspan="6" style="border-bottom:1px #ddd; border-left:1px #ddd; padding:5px;">If you have any quries or want to know more about our products kindly contact our customer service at :<br />hello@hashtagshop.in or Call on: +91 9913456456</td>
		</tr>
		<tr>
			<td colspan="6" style="border-bottom:1px #ddd; border-left:1px #ddd; padding:5px;">Subject to Ahmedabad Jurisdiction</td>
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
	/* ADDRESS PDF */
	ob_start();
	
	?>
	<table align="center" border="0px" width="100%" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000;border:1px solid #ddd; border-bottom:1px #ddd; border-left:1px #ddd; border-right:1px #ddd;">
		<tr>
			<td colspan="6" style="padding:10px 0px;text-align:center;font-size:20px;font-weight:600;background:#000;color:#fff;"><strong>YOUR ORDER SHIPPING DETAILS</strong></td>
		</tr>
		<tr>
			<td width="20%" rowspan="5" align="center" valign="middle" style="border-bottom:1px solid #ddd;"><img src="img/logoa-small.png"/></td>
			<td width="13%" style="padding:5px; padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd;"><strong> Invoice Date :</strong></td>
			<td width="8%" style="padding:5px; padding-left:5px; border-bottom:1px #ddd;"><?php echo date("d-m-Y",strtotime($OrderDate)); ?></td>
			<td width="29%" colspan="3" style="padding:5px; padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd;"><strong>Address :</strong></td>
		</tr>
		<tr>
			<td width="13%" style="padding:5px; padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd;"><strong>Invoice No :</strong></td>
			<td width="8%" style="padding:5px; padding-left:5px; border-bottom:1px #ddd;"><?php echo $InvoiceNo; ?></td>
			<td colspan="3" rowspan="2" valign="top" style="padding:5px; padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd;"><strong>Hashtag Web Shop</strong> <br />
			6/A Virnagar Society, <br />
			Opp. Kiranpark & IDBI Bank,<br />
			Bhimjipura Cross Roads, <br />
			New Vadaj,<br />
			Ahmedabad - 380013
			</td>
		</tr>
		<tr>
			<td width="13%" style="padding:5px; padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd;"><strong>Payment Type :</strong></td>
			<td width="8%" style="padding:5px; padding-left:5px; border-bottom:1px #ddd;"><?php echo $PaymentMethod; ?></td>
		</tr>

		<tr>
			<td width="13%" style="padding:5px; padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd;"><strong>Order Date :</strong></td>
			<td width="8%" style="padding:5px; padding-left:5px; border-bottom:1px #ddd;"><?php echo date("d-m-Y",strtotime($OrderDate)); ?></td>
			<td width="29%" style="padding:5px; padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd;"><strong>Vat No. : <span style="padding:5px; padding-left:5px; border-bottom:1px #ddd;"></span></strong>123456789</td>
			<td width="30%" colspan="2" style="padding:5px; padding-left:5px; border-bottom:1px #ddd;">&nbsp;</td>
		</tr>
		<tr>
			<td width="13%" style="padding:5px; padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd;"><strong>Order No. :</strong></td>
			<td width="8%" style="padding:5px; padding-left:5px; border-bottom:1px #ddd;"><?php echo $OrderRef; ?></td>
			<td width="29%" style="padding:5px; padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd;"><strong>CST No. :<span style="padding:5px; padding-left:5px; border-bottom:1px #ddd;"></span></strong>123456654</td>
			<td colspan="2" style="padding:5px; padding-left:5px; border-bottom:1px #ddd;">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="3" style="padding-left:5px; padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd; padding:5px;"> <strong>Bill To: </strong></td>
			<td colspan="3" style="padding-left:5px; padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd; padding:5px;"> <strong>Delivery Adress: </strong></td>
		</tr>
		<tr>
			<td colspan="3" style="padding-left:5px; padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd; padding:5px;"> <strong><?php echo $ShippingFirstName.' '.$ShippingLastName; ?></strong><br>
            <?php echo $ShippingAddress1.'<br>'.$ShippingAddress2; ?><br />
            <?php echo '<br>'.$ShippingCity.' - '.$ShippingZip; ?><br>
            <?php 
				$StateNametbl = $obj->sql_query("SELECT * FROM tbl_state WHERE StateID = '".$ShippingState."'");
				$State = $StateNametbl[0]['StateName'];
				echo '<br>'.$State.' - '.$ShippingCountryName; 
			?></td>
			<td colspan="3" style="padding-left:5px; padding-left:5px; border-bottom:1px #ddd; border-left:1px #ddd; padding:5px;"> <strong><?php echo $ShippingFirstName.' '.$ShippingLastName; ?></strong><br>
            <?php echo $ShippingAddress1.'<br>'.$ShippingAddress2; ?><br />
            <?php echo '<br>'.$ShippingCity.' - '.$ShippingZip; ?><br>
            <?php 
				$StateNametbl = $obj->sql_query("SELECT * FROM tbl_state WHERE StateID = '".$ShippingState."'");
				$State = $StateNametbl[0]['StateName'];
				echo '<br>'.$State.' - '.$ShippingCountryName; 
			?></td>
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
		
        $html2pdf->Output("upload_data/address_pdf/$InvoiceAdd.pdf",'F');
		
		
    }
    catch(HTML2PDF_exception $e)
	{
        echo $e;
		exit;
    }
	/* ADDRESS PDF */
	
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
	
	
	
	/* Mail to Admin*/
	$subject = "HashTag - Order Confirmed";
	$toemail = "$AdminEmail";
	$mailbody = "MAIL TO ORDER";

	$attachment = "upload_data/invoice_pdf/$filename.pdf";
	
	$mail = new PHPMailer(); // defaults to using php "mail()"

	$mail->SetFrom("sendmail@hashtagshop.in", "HashTag");
	$mail->AddReplyTo("$AdminEmail","$AdminUserName");
	$address = "$AdminEmail";
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
	/* Mail to Admin*/
		
	
	
	
?>
<!-- PDF & MAIL -->
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
    
    <!-- INDEX PAGE JS -->
    <?php //include("includes/index_js.php"); ?>
    <!-- INDEX PAGE JS -->
    
     <!-- VALIDATION SCRIPT -->
    <script type="text/javascript" src="js/jquery.validate.js"></script>
    <!-- VALIDATION SCRIPT -->
	
   
    
    
</body>

</html>
