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
	$obj = new myclass();
	session_start();
	include("includes/session_check.php");
	$RegisterID = $_SESSION['RegisterID'];
	$SelectAllOrder = $obj->sql_query("SELECT o.*, od.* FROM tbl_order AS o INNER JOIN tbl_orderdetail AS od WHERE RegisterID = '".$RegisterID."' AND o.OrderID = od.OrderID");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HASHTAG - My Order</title>
	
	<!-- INCLUDE JS_CSS -->
    <?php include("includes/js_css.php"); ?>
    <!-- INCLUDE JS_CSS -->
	
</head>

<body>

    <!-- INCLUDE HEADER -->
    <?php include("includes/header.php"); ?>
    <!-- INCLUDE HEADER -->
	
    <div id="stickyalias"></div>
    
    <!-- SCROLL TO TOP -->
    <a href="#0" class="cd-top"><i class="fa fa-angle-up"></i></a>
    <!-- SCROLL TO TOP -->
    
    <!-- PROFILE MENU -->
    <?php include("includes/profilemenu.php"); ?>
    <!-- PROFILE MENU -->
    <div id="stickyalias"></div>
   
    <section class="checkout">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 table-responsive">
                	<?php
						if(empty($SelectAllOrder))
						{
					?>
                    		<div class="emptyWish pt30">No Order Found..!!</div>
                    <?php
						}
						if(!empty($SelectAllOrder))
						{
					?>
                            <table class="table  table-checkout">
                                <thead>
                                    <tr>
                                        <th class="font18 text-darkblue">Item</th>
                                        <th class="font18 text-darkblue">Product Name</th>
                                        <th class="text-center font18 text-darkblue">Price</th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                
                                <!-- DISPLAY ORDERED PRODUCTS -->
                                <?php
                                    for($op=0;$op<count($SelectAllOrder);$op++)
                                    {
                                        $OPID = $SelectAllOrder[$op]['ProductID'];
                                        $SelectAllProduct = $obj->sql_query("SELECT p.*, pi.* FROM tbl_product AS p INNER JOIN tbl_productimage AS pi WHERE p.ProductID = '".$OPID."' AND pi.ProductID = '".$OPID."' GROUP BY pi.ProductID");
                                        for($ap=0;$ap<count($SelectAllProduct);$ap++)
                                        {
                                ?>
                                			<form id="Product_<?php echo $SelectAllProduct[$ap]['ProductID']; ?>" name="Product_<?php echo $SelectAllProduct[$ap]['ProductID']; ?>" method="post" enctype="multipart/form-data">
                                            <input type="hidden" id="ProductID" name="ProductID" value="<?php echo $SelectAllProduct[$ap]['ProductID']; ?>" />
                                           		<tbody>
                                                <tr>
                                                    <td class="col-sm-1 col-md-1 col-lg-1 media-align">
                                                        <a class="thumbnail pull-left" href="#"> <img class="media-object" src="upload_data/productactualimage/200x200/<?php echo $SelectAllProduct[$ap]['ProductActualImage']; ?>"> </a>
                                                    </td>
                                                    <td class="col-sm-8 col-md-6 media-align">
                                                        <div class="media-body">
                                                            <h4 class="media-heading"><a href="#" class = "name-product"><?php echo ucwords($SelectAllProduct[$ap]['ProductName']); ?></a></h4>
                                                            
                                                            <!-- PRODUCT SIZE -->
                                                              <div class="size pdetailsize mobile-settingpdetail">
																	<ul class="subcategory mt5">
																		<?php
																			$ProductSize =explode(",",$SelectAllProduct[$ap]['ProductSize']);
																			$StockFlag = 0;
																			for($p=0;$p<count($ProductSize);$p++)
																			{
																				$SelectSizeID = $obj->sql_query("SELECT * FROM tbl_size WHERE SizeName = '".$ProductSize[$p]."'");
																				$SelectSizeStock = $obj->sql_query("SELECT * FROM tbl_productsize_stockmanage WHERE ProductID = '".$SelectAllProduct[$ap]['ProductID']."' AND SizeID = '".$SelectSizeID[0]['SizeID']."'");
																				//echo $SelectSizeStock[0]['ProductStock']; 
																				if($SelectSizeStock[0]['ProductStock'] > 0)
																				{
																					$StockFlag = 1;
																		?>
																					<li onClick="addc_<?php echo $p; ?>_<?php echo $SelectAllProduct[$ap]['ProductID']; ?>();" id="S_<?php echo $p; ?>_<?php echo $SelectAllProduct[$ap]['ProductID']; ?>"><a href="#" id="Size_<?php echo $ProductSize[$p]; ?>_<?php echo $SelectAllProduct[$ap]['ProductID']; ?>"><?php echo strtoupper($ProductSize[$p]); ?></a></li>
																					<script>
																					   function addc_<?php echo $p; ?>_<?php echo $SelectAllProduct[$ap]['ProductID']; ?>()
																					   {
																						$('#S_<?php echo $p; ?>_<?php echo $SelectAllProduct[$ap]['ProductID']; ?>').addClass("size-active");
																						var a = $('#Size_<?php echo $ProductSize[$p]; ?>_<?php echo $SelectAllProduct[$ap]['ProductID']; ?>').html();
																						
																						document.getElementById('Size1_<?php echo $SelectAllProduct[$ap]['ProductID']; ?>').value = a;
																						var s = $("#Size1_<?php echo $SelectAllProduct[$ap]['ProductID']; ?>").val();
																						
																						var dataString = 'rid='+ s;	
																							$.ajax
																							({
																								type: "POST",
																								url: "cart_sizetestrecent",
																								cache: false,
																								data: dataString,
																								success:function(data)
																								{
																									
																								}
																							});
																						
																					   }
																					 </script>
																	   <?php
																				}
																			}
																			if($StockFlag == 0)
																			{
																		?>
																					<span style="color:red;">Product out of stock</span>
																		<?php
																			}
																		?>
																		<input type="hidden" id="Size1_<?php echo $SelectAllProduct[$ap]['ProductID']; ?>" name="Size1_<?php echo $SelectAllProduct[$ap]['ProductID']; ?>" value="">  
																	</ul>
																
																</div>
                                                            <!-- PRODUCT SIZE -->
                                                            
                                                        </div>
                                                    </td>
                                                    <td class="col-sm-1 col-md-1 text-center media-align">
                                                        <strong>
                                                        
                                                        <!-- PRODUCT PRICE -->
                                                            <div class="price">
                                                        <?php
                                                                $SelectOffer = $obj->sql_query("SELECT * FROM tbl_offer WHERE (ProductID = '".$SelectAllProduct[$ap]['ProductID']."' OR CategoryID = '".$SelectAllProduct[$ap]['CategoryID']."') AND Status = 'Active'");
                                                        ?>
                                                                <?php
                                                                    if(count($SelectOffer)>0)
                                                                    { 
                                                                        for($ro=0;$ro<count($SelectOffer);$ro++)
                                                                        {
                                                                            $OfferDiscountType = $SelectOffer[$ro]['OfferDiscountType'];
                                                                            $OfferAmount = $SelectOffer[$ro]['OfferDiscountAmount'];
                                                                            
                                                                            if(!empty($OfferDiscountType))
                                                                            {
                                                                                if($OfferDiscountType == "Rupee")
                                                                                {
                                                                                    $Price1 = $SelectAllProduct[$ap]['ProductPrice'] - $OfferAmount;
                                                                                    if(($Price1) != ($SelectAllProduct[$ap]['ProductPrice']))
                                                                                    { 
                                                                ?>
                                                                <?php
                                                                                    }
                                                                 ?>
                                                                                <span class="discount"><i class="fa fa-inr"></i><?php echo $Price1; ?> /-</span>
                                                                                <input type="hidden" name="Price1" id="Price1" value="<?php echo $Price1; ?>"/>
                                                                <?php
                                                                                }
                                                                                if($OfferDiscountType == "Percentage")
                                                                                {
                                                                                    $DiscountPrice = ($OfferAmount * $SelectAllProduct[$ap]['ProductPrice'])/100;
                                                                                    $Price1 = $SelectAllProduct[$ap]['ProductPrice'] - $DiscountPrice;
                                                                                    if(($Price1) != ($SelectAllProduct[$ap]['ProductPrice']))
                                                                                    { 
                                                                                    
                                                                ?>
                                                                <?php
                                                                                    }
                                                                ?>
                                                                                <span class="discount"><i class="fa fa-inr"></i><?php echo $Price1; ?> /-</span>
                                                                                <input type="hidden" name="Price1" id="Price1" value="<?php echo $Price1; ?>"/>
                                                                <?php
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                    else
                                                                    {
                                                                        if((!empty($SelectAllProduct[$ap]['ProductDiscountType'])) && ($SelectAllProduct[$ap]['ProductDiscountAmount'] != "00"))
                                                                        {
                                                                            $ProductDiscountType = $SelectAllProduct[$ap]['ProductDiscountType'];
                                                                            if($ProductDiscountType == "Rupee")
                                                                            {
                                                                                $Price1 = $SelectAllProduct[$ap]['ProductPrice'] - $SelectAllProduct[$ap]['ProductDiscountAmount'];
                                                                                if(($Price1) != ($SelectAllProduct[$ap]['ProductPrice']))
                                                                                { 
                                                                ?>
                                                                                
                                                               <?php 
                                                                                } 
                                                               ?>
                                                                                <span class="discount"><i class="fa fa-inr"></i><?php echo $Price1; ?> /-</span> 
                                                                                <input type="hidden" name="Price1" id="Price1" value="<?php echo $Price1; ?>"/>
                                                                                
                                                              <?php
                                                                            }
                                                                            if($ProductDiscountType == "Percentage")
                                                                            {
                                                                                $DiscountPrice = ($SelectAllProduct[$ap]['ProductDiscountAmount'] * $SelectAllProduct[$ap]['ProductPrice'])/100;
                                                                                $Price1 = $SelectAllProduct[$ap]['ProductPrice'] - $DiscountPrice;
                                                                                if(($Price1) != ($SelectAllProduct[$ap]['ProductPrice']))
                                                                                { 
                                                                ?>
                                                                <?php
                                                                                }
                                                                 ?>
                                                                                <span class="discount"><i class="fa fa-inr"></i><?php echo $Price1; ?> /-</span>
                                                                                <input type="hidden" name="Price1" id="Price1" value="<?php echo $Price1; ?>" />
                                                              <?php
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            $Price1 = $SelectAllProduct[$ap]['ProductPrice'];
                                                                ?>
                                                                            <span class="discount"><i class="fa fa-inr"></i><?php echo $Price1; ?> /-</span>
                                                                            <input type="hidden" name="Price1" id="Price1" value="<?php echo $Price1; ?>" />
                                                                            
                                                                <?php
                                                                        }
                                                                    }
                                                                ?>
                                                         <?php
                                                            //}
                                                         ?>
                                                                             
                                                        </div>
                                                        <!-- PRODUCT PRICE -->
                                                        
                                                        </strong>
                                                    </td>
                                                    <td class="col-sm-1 col-md-1 text-right media-align">
                                                        <!-- ADD TO CART BUTTON -->
                                                        
                                                             <button <?php if($StockFlag == 0){?> disabled <?php } ?> type="submit" class="btn btn-primary button-subscribe btnshadow-nor" style="width: 120px !important;" id="AddToCartMyOrder<?php echo $SelectAllOrder[$op]['ProductID']; ?>" onClick="message_show(<?php echo $SelectAllOrder[$op]['ProductID']; ?>)" name="AddToCartMyOrder<?php echo $SelectAllOrder[$op]['ProductID']; ?>">
                                                                <span class="add2cart">  BUY AGAIN </span>
                                                             </button>
                                                             
                                                        <!-- ADD TO CART BUTTON -->
                                                        
                                                        
                                                    </td>
                                                </tr>
                                            </tbody>
                                            </form>
                                <?php
                                        }
								?>
                                <!-- SCRIPT FOR ADD TO CART -->
								<script type="text/javascript" language="javascript">
                                function message_show(cid)
                                {
									var data = 'cid='+cid;
									$.notify.defaults
									({
									className: "error"
									})
									var parentdata = $('pdetailsize ul li');
									if ($('.pdetailsize ul li').hasClass("size-active")) 
									{
									var dataString = $("form#Product_"+cid).serialize();
									$.ajax
									({
										type: "POST",
										url: "cart_test",
										cache: false,
										data: dataString,
										success:function(data)
										{
											document.getElementById("Totalcart").innerHTML = data;
						
											$.notify.defaults({
												className: "success"
											})
											$.notify("Product successfully added to cart", {
												position: "bottom left"
											});
											
											item_showF(cid)
											<?php
													for($rer=0;$rer<count($SelectAllOrder);$rer++)
													{
													$ProductSizeR =explode(",",$SelectAllOrder[$rer]['ProductSize']);
													for($pr=0;$pr<count($ProductSizeR);$pr++)
													{
													?>
														if($("#S_<?php echo $pr; ?>_"+cid).hasClass("size-active"))
														{
															$("#S_<?php echo $pr; ?>_"+cid).removeClass("size-active");
														}
													<?php
													}
													}
													?>
										}
									});
									
									var ac = $('.pdetailsize ul li.size-active').find('a').text();
									$('.hiddensize').text(ac);
									console.log(ac);
									} 
									else 
									{
									$.notify("Please Select Size", 
									{
										position: "bottom left"
									});
									}
                                }
								function item_showF(cid)
								{
									var data = 'cid='+cid;
									var parentdata = $('pdetailsize ul li');
									if ($('.pdetailsize ul li').hasClass("size-active")) 
									{											
										var dataString = $("form#Product_"+cid).serialize();
										$.ajax
										({
											type: "POST",
											url: "cart_itemtest",
											cache: false,
											data: dataString,
											success:function(data)
											{
												document.getElementById("ulcart").innerHTML = data;
												$("#ulcart").show();
												window.setInterval(function() {
													 $("#ulcart").hide();
													},  5000);
											}
										});
										var ac = $('.pdetailsize ul li.size-active').find('a').text();
										$('.hiddensize').text(ac);
										console.log(ac);
									} 
								}
                                </script>
                                <!-- SCRIPT FOR ADD TO CART -->
                                <?php
                                    }
                                ?>
                                <!-- DISPLAY ORDERED PRODUCTS -->
                                
                            </table>
                    <?php
						}
					?>
                    </div>
                </div>
            </div>
    </section>
    
    
    
     <!-- REGISTER/LOGIN WITH FACEBOOK & GOOGLE + -->
    <?php include("includes/loginwithfbgp.php") ?>
    <!-- REGISTER/LOGIN WITH FACEBOOK & GOOGLE + -->
    
    <!-- LOGIN MODEL -->
    <?php include("includes/loginmodel.php"); ?>
    <!-- LOGIN MODEL -->
    
    <!-- FOOTER -->
    <?php include("includes/footer.php"); ?>
    <!-- FOOTER -->
   
   
     <!-- VALIDATION SCRIPT -->
    <script type="text/javascript" src="js/jquery.validate.js"></script>
    <!-- VALIDATION SCRIPT -->
    
    

</body>

</html>
