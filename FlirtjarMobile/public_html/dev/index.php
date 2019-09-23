<?php
	/*----------File Information----------*/
	#Project : HASHTAG
	#File Created By : Mona Bera
	#File Created Date : 11 Jan 2016
	#File Edited By :
	#File Edited Date :
	/*----------File Information----------*/
	
	include("includes/connection.php");
	$obj = new myclass();
	session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HASHTAG</title>
    
    <!-- INCLUDE JS_CSS -->
    <?php include("includes/js_css.php"); ?>
    <!-- INCLUDE JS_CSS -->
</head>

<body>
	
    <!-- INDEX PAGE HEADER -->
    <?php include("includes/index_header.php"); ?>
    <!-- INDEX PAGE HEADER -->
    
    <!-- SCROLL TO TOP -->
    <a href="#0" class="cd-top"><i class="fa fa-angle-up"></i></a>
    <!-- SCROLL TO TOP -->
    
  	<!-- NEW ARRIVALS -->
    <section class="featured-item" id="page2" style = "background: url('img/ffd265ce7dcc0719877217fab0ea1504.jpg');background-repeat: repeat;background-position: top center;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class = ""><span class = "fancy">New Arrivals</span></h1>
                </div>
            </div>
            <div class="row product-slider">
                <div class="col-md-12">
                    <div id="owl-carousel-secondary" class="owl-carousel product-main-page product-main-home-hover">
                        
                        <!-- RECENTLY ADDED ITEMS -->
                        <?php
							$RecentlyAddedProducts = $obj->sql_query("SELECT * FROM tbl_product WHERE Status = 'Active' ORDER BY ProductID DESC limit 8");
							for($r=0;$r<count($RecentlyAddedProducts);$r++)
							{
								$PID = $RecentlyAddedProducts[$r]['ProductID'];
								{
						?>
                                <div class="item" id="Recent<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>">
                                <form id="Product_<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>" name="Product_<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>" method="post" enctype="multipart/form-data">
                                <input type="hidden" id="ProductID" name="ProductID" value="<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>" />
                                    <div class="item-main" style="position: relative;">
                                        <div class="item-inner">
                                            <div class="box-images">
                                            	<?php
												$RAPID = Encrypt('myPass123', $RecentlyAddedProducts[$r]['ProductID']);
												$RACID = Encrypt('myPass123', $RecentlyAddedProducts[$r]['CategoryID']);
												?>
                                                <a href="product-detail/<?php  echo $RAPID; ?>/<?php  echo $RACID; ?>/<?php  echo str_replace(" ","-",$RecentlyAddedProducts[$r]['ProductName']); ?>"  class="product-image">
                                                    <img data-src="upload_data/productactualimage/large/<?php echo $RecentlyAddedProducts[$r]['ProductActualImage']; ?>" class="img-face lazy-hidden" alt="img" width="300" height="200">
                                                    <img data-src="upload_data/producthoverimage/large/<?php echo $RecentlyAddedProducts[$r]['ProductHoverImage']; ?>" alt="img" class="img-face-back lazy-hidden" width="300" height="200">
                                                </a>
												<?php
                                                $SelectWishList = $obj->sql_query("SELECT * FROM tbl_wishlist WHERE ProductID = '".$RecentlyAddedProducts[$r]['ProductID']."' AND RegisterID = '".$_SESSION['RegisterID']."'");
                                                ?>
                                                    <div class="wishlist-tooltip">
                                                    <span class="icon-fav wishlist-tooltip"><a class="link-wishlist <?php if($SelectWishList){?>text-red <?php } else { ?> text-gray <?php } ?>" id ="wishlist<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>" onClick="AddToWishlist(<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>)" ><i class="fa fa-heart"></i></a></span>
                                                    <span class="saveToWish">Save as Wishlist</span>
                                                    </div>
                                                    <div class="qiuck-tooltip">
														<span class="icon-fav quick-tooltip"><a href="javascript:void(0);" data-toggle="modal" data-target="#product-quick-veiw-modal<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>" class="link-wishlist text-gray" onClick = "QuickView(<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>);"><i class="fa fa-eye"></i></a></span>
														<span class="qiuckview">Qiuck View</span>
													</div>
                                               
												<script type="text/javascript" language="javascript">
													function AddToWishlist(fid)
													{
														<?php
															if(empty($_SESSION['RegisterID']))
															{
														?>
																$('#login-overlay').modal('show');
														<?php
															}
															else
															{
														?>		
																var dataString = 'fid='+ fid;	
																$.ajax({
																type: "POST",
																url: "addtowishlist",
																data: dataString,
																cache: false,
																success: function(data){
																	if(data == 1)
																	{
																		$.notify.defaults({
																			className: "success"
																		})
																		$.notify("ADDED TO WISHLIST", {
																			position: "bottom left"
																		});
																		$("#wishlist"+fid).removeClass("text-gray");
																		$("#wishlist"+fid).addClass("text-red");
																	}
																	if(data == 2)
																	{
																		$.notify.defaults({
																			className: "error"
																		})
																		$.notify("ALREADY IN WISHLIST", {
																			position: "bottom left"
																		});
																		$("#wishlist"+fid).removeClass("text-gray");
																		$("#wishlist"+fid).addClass("text-red");
																	}
																}
															});
														<?php
															}
														?>
													}
												</script>
                                     
                                            </div>
                                            <div class="product-shop">
                                            
                                                <!-- DISPLAY PRODUCT NAME -->
                                                <div class="description">
                                                    <h4 class="product-name"><a href="javascript:void(0);" ><?php echo ucwords($RecentlyAddedProducts[$r]['ProductName']); ?></a></h4>
                                                </div>
                                                <!-- DISPLAY PRODUCT NAME -->
                                                
                                                <!-- DISPLAY PRODUCT PRICE -->
												<div class="price">
													<?php
														if((!empty($RecentlyAddedProducts[$r]['ProductDiscountType'])) && ($RecentlyAddedProducts[$r]['ProductDiscountAmount'] != "00"))
														{
															$ProductDiscountType = $RecentlyAddedProducts[$r]['ProductDiscountType'];
															if($ProductDiscountType == "Rupee")
															{
																$Price1 = $RecentlyAddedProducts[$r]['ProductPrice'] - $RecentlyAddedProducts[$r]['ProductDiscountAmount'];
																if(($Price1) != ($RecentlyAddedProducts[$r]['ProductPrice']))
																{ 
													?>
																	<span class="cutprice"><i class="fa fa-inr"></i><?php echo $RecentlyAddedProducts[$r]['ProductPrice']; ?> /-</span>
													<?php 
																} 
													?>
																	<span class="discount"><i class="fa fa-inr"></i><?php echo  round($Price1); ?> /-</span> 
																	<input type="hidden" name="Price1" id="Price1" value="<?php echo  round($Price1); ?>"/>
													<?php
															}
															if($ProductDiscountType == "Percentage")
															{
																$DiscountPrice = ($RecentlyAddedProducts[$r]['ProductDiscountAmount'] * $RecentlyAddedProducts[$r]['ProductPrice'])/100;
																$Price1 = $RecentlyAddedProducts[$r]['ProductPrice'] - $DiscountPrice;
																if(($Price1) != ($RecentlyAddedProducts[$r]['ProductPrice']))
																{ 
													?>
																	<span class="cutprice"><i class="fa fa-inr"></i><?php echo $RecentlyAddedProducts[$r]['ProductPrice']; ?> /-</span>
													<?php
																}
													?>
																	<span class="discount"><i class="fa fa-inr"></i><?php echo  round($Price1); ?> /-</span>
																	<input type="hidden" name="Price1" id="Price1" value="<?php echo  round($Price1); ?>" />
													<?php
															}
														}
														else
														{
															$Price1 = $RecentlyAddedProducts[$r]['ProductPrice'];
													?>
															<span class="discount"><i class="fa fa-inr"></i><?php echo  round($Price1); ?> /-</span>
															<input type="hidden" name="Price1" id="Price1" value="<?php echo  round($Price1); ?>" />
													<?php
														}
													?>
												</div>
                                                <!-- DISPLAY PRODUCT PRICE -->
                                                
                                                <div class="product-sectiononhover">
                                                    
                                                    <!-- DISPLAY PRODUCT SIZE -->
                                                    <div class="size pdetailsize">
                                                    <ul class="subcategory mt5">
                                                            <?php
                                                                $ProductSize =explode(",",$RecentlyAddedProducts[$r]['ProductSize']);
																$StockFlag = 0;
                                                                for($p=0;$p<count($ProductSize);$p++)
                                                                {
																	$SelectSizeID = $obj->sql_query("SELECT * FROM tbl_size WHERE SizeName = '".$ProductSize[$p]."'");
																	$SelectSizeStock = $obj->sql_query("SELECT * FROM tbl_productsize_stockmanage WHERE ProductID = '".$RecentlyAddedProducts[$r]['ProductID']."' AND SizeID = '".$SelectSizeID[0]['SizeID']."'");
																	if($SelectSizeStock[0]['ProductStock'] > 0)
																	{
																		$StockFlag = 1;
                                                            ?>
																		<li onClick="addc_<?php echo $p; ?>_<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>();" id="S_<?php echo $p; ?>_<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>">
																		<a href="javascript:void(0);" id="Size_<?php echo $ProductSize[$p]; ?>_<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>"><?php if($StockFlag == 0){ echo "Product out of stock"; }else { echo strtoupper($ProductSize[$p]); }?></a></li>
																		<script>
																			function addc_<?php echo $p; ?>_<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>()
																			{
																				$('#S_<?php echo $p; ?>_<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>').addClass("size-active");
																				var a = $('#Size_<?php echo $ProductSize[$p]; ?>_<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>').html();
																				document.getElementById('Size1_<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>').value = a;
																				var s = $("#Size1_<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>").val();
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
                                                            <input type="hidden" id="Size1_<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>" name="Size1_<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>" value="">  
                                                        </ul>    
                                                    
                                                    </div>
                                                    <!-- DISPLAY PRODUCT SIZE -->
                                             
                                                    
                                                    <!-- ADD TO CART BUTTON -->
                                                    <div class="add-to-Cartonhover" >
                                                         <button type="submit" <?php if($StockFlag == 0){?> disabled <?php } ?> class="btn btn-primary button-subscribe btnshadow-nor btn-shopping-item btn-bluehover" id="AddToCartRecentlyAddedItem<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>" onClick="message_show(<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>)" name="AddToCartRecentlyAddedItem<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>">
                                                            <span class="add2cart"> Add to cart </span>
                                                         </button>
                                                    </div>
                                                    <!-- ADD TO CART BUTTON -->
                                                    
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
																		$.notify("Product successfully added to cart", 
																		{
																			position: "bottom left"
																		});
																		
																		item_show(cid);
																		
																		<?php
																			for($rr=0;$rr<count($RecentlyAddedProducts);$rr++)
																			{
																				$ProductSize1 =explode(",",$RecentlyAddedProducts[$rr]['ProductSize']);
																				for($pr=0;$pr<count($ProductSize1);$pr++)
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
														
														function item_show(cid)
														{
															var data = 'cid='+cid;
															
															var parentdata = $('pdetailsize ul li');
															if ($('.pdetailsize ul li').hasClass("size-active")) 
															{											
																var dataString = $("form#Product_"+cid).serialize();
																$.ajax
																({
																	type: "POST",
																	url: "indexcart_itemtest",
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
                                                    
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            	</div> 
						<?php
							}
							}
							//exit;
						?>
                        <!-- RECENTLY ADDED ITEMS -->
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- NEW ARRIVALS -->
	
    <!-- OFFER CONTAINER -->
    <section class="offer-second">
        <div class="overlay-color">
            <div class="container align-verticaltext">
                <div class="row">
                    <div class="col-md-12">
                        <div class="wrapper-offer pull-right">
                            <h2>Summer Collection <br/>40% flat off</h2>
                            <a href = "product" class="btn btn-primary button-add-to-cart btnshadow-nor"> <span class="add2cart">Shop Now</span> </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- OFFER CONTAINER -->
   
    <!-- FEATURED ITEMS -->
    <section class="featured-item">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><span class = "fancy">Featured Items</span></h1>
                </div>
            </div>
            <div class="row product-slider">
                <div class="col-md-12">
                    <div id="owl-demo" class="owl-carousel product-main-page product-main-home-hover">
                    
                    <!-- PRODUCT ADD AS FEATURED -->
                    <?php
						$SelectFeaturedProduct = $obj->sql_query("SELECT * FROM tbl_product WHERE AsFeatured = 'Yes' AND Status = 'Active' ORDER BY ProductID DESC limit 8");
						for($f=0;$f<count($SelectFeaturedProduct);$f++)
						{
								{
					?>
                            <div class="item" id="Featured<?php echo $SelectFeaturedProduct[$f]['ProductID']; ?>">
                            
                            <!-- FEATURED ITEM FORM -->
                            <form id="ProductFeatured_<?php echo $SelectFeaturedProduct[$f]['ProductID']; ?>" name="ProductFeatured_<?php echo $SelectFeaturedProduct[$f]['ProductID']; ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" id="ProductID" name="ProductID" value="<?php echo $SelectFeaturedProduct[$f]['ProductID']; ?>" />
                                <div class="item-main" style="position: relative;">
                                    <div class="item-inner">
                                        <div class="box-images">
                                        	<?php
											$FEPID = Encrypt('myPass123', $SelectFeaturedProduct[$f]['ProductID']);
											$FECID = Encrypt('myPass123', $SelectFeaturedProduct[$f]['CategoryID']);
											?>
                                            <a href="product-detail/<?php  echo $FEPID; ?>/<?php  echo $FECID; ?>/<?php  echo str_replace(" ","-",$RecentlyAddedProducts[$r]['ProductName']); ?>"  class="product-image">
                                                <img data-src="upload_data/productactualimage/large/<?php echo $SelectFeaturedProduct[$f]['ProductActualImage']; ?>" class="img-face lazy-hidden" alt="img" width="300" height="200">
                                                <img data-src="upload_data/producthoverimage/large/<?php echo $SelectFeaturedProduct[$f]['ProductHoverImage']; ?>" alt="img" class="img-face-back lazy-hidden" width="300" height="200">
                                            </a>
                                            
                                            <!-- ADD TO WISHLIST -->
                                            <?php
                                                $SelectWishList = $obj->sql_query("SELECT * FROM tbl_wishlist WHERE ProductID = '".$SelectFeaturedProduct[$f]['ProductID']."' AND RegisterID = '".$_SESSION['RegisterID']."'");
                                             ?>
                                                <div class="wishlist-tooltip">
                                                    <span class="icon-fav wishlist-tooltip"><a class="link-wishlist <?php if($SelectWishList){?>text-red <?php } else { ?> text-gray <?php } ?>" id ="wishlist<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>" onClick="AddToWishlist(<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>)" ><i class="fa fa-heart"></i></a></span>
                                                    <span class="saveToWish">Save as Wishlist</span>
                                                </div>
                                                <div class="qiuck-tooltip">
													<span class="icon-fav quick-tooltip"><a href="javascript:void(0);" data-toggle="modal" data-target="#product-quick-veiw-modal<?php echo $SelectFeaturedProduct[$f]['ProductID']; ?>" class="link-wishlist text-gray" onClick = "QuickView(<?php echo $SelectFeaturedProduct[$f]['ProductID']; ?>);"><i class="fa fa-eye"></i></a></span>
													<span class="qiuckview">Qiuck View</span>
												</div>
                                               
												<script type="text/javascript" language="javascript">
													function AddToWishlist(fid)
													{
														<?php
															if(empty($_SESSION['RegisterID']))
															{
														?>
																$('#login-overlay').modal('show');
														<?php
															}
															else
															{
														?>		
																var dataString = 'fid='+ fid;	
																$.ajax({
																type: "POST",
																url: "addtowishlist",
																data: dataString,
																cache: false,
																success: function(data){
																	if(data == 1)
																	{
																		$.notify.defaults({
																			className: "success"
																		})
																		$.notify("ADDED TO WISHLIST", {
																			position: "bottom left"
																		});
																		$("#wishlist"+fid).removeClass("text-gray");
																		$("#wishlist"+fid).addClass("text-red");
																		
																		
																	}
																	if(data == 2)
																	{
																		$.notify.defaults({
																			className: "error"
																		})
																		$.notify("ALREADY IN WISHLIST", {
																			position: "bottom left"
																		});
																		$("#wishlist"+fid).removeClass("text-gray");
																		$("#wishlist"+fid).addClass("text-red");
																	}
																}
															});
														<?php
															}
														?>
													}
												</script>
                                            <!-- ADD TO WISHLIST -->
                                            
                                        </div>
                                        <div class="product-shop">
                                        
                                        <!-- DISPLAY PRODUCT NAME -->
                                            <div class="description">
                                                <h4 class="product-name"><a href="javascript:void(0);" ><?php echo $SelectFeaturedProduct[$f]['ProductName']; ?></a></h4>
                                            </div>
                                        <!-- DISPLAY PRODUCT NAME -->
                                        
                                            <!-- DISPLAY PRODUCT PRICE -->
											<div class="price">
												<?php
													if((!empty($SelectFeaturedProduct[$f]['ProductDiscountType'])) && ($SelectFeaturedProduct[$f]['ProductDiscountAmount'] != "00"))
													{
														$ProductDiscountType = $SelectFeaturedProduct[$f]['ProductDiscountType'];
														if($ProductDiscountType == "Rupee")
														{
															$Price1 = $SelectFeaturedProduct[$f]['ProductPrice'] - $SelectFeaturedProduct[$f]['ProductDiscountAmount'];
															if(($Price1) != ($SelectFeaturedProduct[$f]['ProductPrice']))
															{ 
												?>

																<span class="cutprice"><i class="fa fa-inr"></i><?php echo $SelectFeaturedProduct[$f]['ProductPrice']; ?> /-</span>
												<?php 
															} 
												?>
																<span class="discount"><i class="fa fa-inr"></i><?php echo  round($Price1); ?> /-</span> 
																<input type="hidden" name="Price1" id="Price1" value="<?php echo  round($Price1); ?>"/>

												<?php
														}
														if($ProductDiscountType == "Percentage")
														{
															$DiscountPrice = ($SelectFeaturedProduct[$f]['ProductDiscountAmount'] * $SelectFeaturedProduct[$f]['ProductPrice'])/100;
															$Price1 = $SelectFeaturedProduct[$f]['ProductPrice'] - $DiscountPrice;
															if(($Price1) != ($SelectFeaturedProduct[$f]['ProductPrice']))
															{ 
												?>
																<span class="cutprice"><i class="fa fa-inr"></i><?php echo $SelectFeaturedProduct[$f]['ProductPrice']; ?> /-</span>
												<?php
															}
												?>
																<span class="discount"><i class="fa fa-inr"></i><?php echo  round($Price1); ?> /-</span>
																<input type="hidden" name="Price1" id="Price1" value="<?php echo  round($Price1); ?>" />
												<?php
														}
													}
													else
													{
														$Price1 = $SelectFeaturedProduct[$f]['ProductPrice'];
												?>
														<span class="discount"><i class="fa fa-inr"></i><?php echo  round($Price1); ?> /-</span>
														<input type="hidden" name="Price1" id="Price1" value="<?php echo  round($Price1); ?>" />
												<?php
													}
												?>
											</div>
                                            <!-- DISPLAY PRODUCT PRICE -->
                                                
                                            <div class="product-sectiononhover">
                                               
                                                <!-- DISPLAY PRODUCT SIZE -->
                                                <div class="size pdetailsize">
                                                        <ul class="subcategory mt5">
                                                            <?php
                                                                $ProductSize1 =explode(",",$SelectFeaturedProduct[$f]['ProductSize']);
																$FStockFlag = 0;
																for($p1=0;$p1<count($ProductSize1);$p1++)
                                                                {
																	$SelectSizeID = $obj->sql_query("SELECT * FROM tbl_size WHERE SizeName = '".$ProductSize1[$p1]."'");
																	$SelectSizeStock = $obj->sql_query("SELECT * FROM tbl_productsize_stockmanage WHERE ProductID = '".$SelectFeaturedProduct[$f]['ProductID']."' AND SizeID = '".$SelectSizeID[0]['SizeID']."'");
																	if($SelectSizeStock[0]['ProductStock'] > 0)
																	{
																		$FStockFlag = 1;
                                                            ?>
																		<li onClick="addf_<?php echo $p1; ?>_<?php echo $SelectFeaturedProduct[$f]['ProductID']; ?>();" id="Ss_<?php echo $p1; ?>_<?php echo $SelectFeaturedProduct[$f]['ProductID']; ?>"><a href="javascript:void(0);" id="SizeRe_<?php echo $ProductSize1[$p1]; ?>_<?php echo $SelectFeaturedProduct[$f]['ProductID']; ?>"><?php echo strtoupper($ProductSize1[$p1]); ?></a></li>
																		<script>
																		   function addf_<?php echo $p1; ?>_<?php echo $SelectFeaturedProduct[$f]['ProductID']; ?>()
																		   {
																			$('#Ss_<?php echo $p1; ?>_<?php echo $SelectFeaturedProduct[$f]['ProductID']; ?>').addClass("size-active");
																			var a = $('#SizeRe_<?php echo $ProductSize1[$p1]; ?>_<?php echo $SelectFeaturedProduct[$f]['ProductID']; ?>').html();
																			
																			document.getElementById('Size2_<?php echo $SelectFeaturedProduct[$f]['ProductID']; ?>').value = a;
																			var s = $("#Size2_<?php echo $SelectFeaturedProduct[$f]['ProductID']; ?>").val();
																			
																			var dataString = 'sid='+ s;	
																				$.ajax
																				({
																					type: "POST",
																					url: "cart_sizetest",
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
																if($FStockFlag == 0)
																{
															?>
																	<span style="color:red;">Product out of stock</span>
																	
															<?php
																}
                                                            ?>
                                                            <input type="hidden" id="Size2_<?php echo $SelectFeaturedProduct[$f]['ProductID']; ?>" name="Size2_<?php echo $SelectFeaturedProduct[$f]['ProductID']; ?>" value="">  
                                                        </ul>
                                                    </div>
                                                <!-- DISPLAY PRODUCT SIZE -->
                                                
                                                <!-- ADD TO CART BUTTON -->
                                                <div class="add-to-Cartonhover">
                                                     <button type="submit" <?php if($FStockFlag == 0){?> disabled <?php } ?> class="btn btn-primary button-subscribe btnshadow-nor btn-shopping-item btn-bluehover" id="AddToCartFeaturedItem<?php echo $SelectFeaturedProduct[$f]['ProductID']; ?>" onClick="addtocart(<?php echo $SelectFeaturedProduct[$f]['ProductID']; ?>)" name="AddToCartFeaturedItem<?php echo $SelectFeaturedProduct[$f]['ProductID']; ?>">
                                                        <span class="add2cart"> Add to cart </span>
                                                     </button>
                                                </div>
                                                <!-- ADD TO CART BUTTON -->
                                                
                                                <!-- SCRIPT FOR ADD TO CART -->
                                                <script type="text/javascript" language="javascript">
                                                function addtocart(cid)
                                                {
													var data = 'cid='+cid;
													$.notify.defaults
													({
													className: "error"
													})
													var parentdata = $('pdetailsize ul li');
													if ($('.pdetailsize ul li').hasClass("size-active")) 
													{
													var dataString = $("form#ProductFeatured_"+cid).serialize();
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
															item_showF(cid);
															<?php
															for($fr=0;$fr<count($SelectFeaturedProduct);$fr++)
															{
															$ProductSizeF =explode(",",$SelectFeaturedProduct[$fr]['ProductSize']);
															for($pfr=0;$pfr<count($ProductSizeF);$pfr++)
															{
															?>
																if($("#Ss_<?php echo $pfr; ?>_"+cid).hasClass("size-active"))
																{
																	$("#Ss_<?php echo $pfr; ?>_"+cid).removeClass("size-active");
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
															url: "indexcart_itemtest",
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
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- FEATURED ITEM FORM -->
                            
                            </div>
                    <?php
						}
						}
					?>
                    <!-- PRODUCT ADD AS FEATURED -->
                    
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--  FEATURED ITEMS -->
  
    <section class="why-choose-us">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>About Us</h1>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-md-2 col-sm-2 col-xs-12 choose-us">
                    <img src="img/logoa.png">
                </div>
                <div class="col-md-10 col-sm-10 col-xs-12 about-logo">
                    <p>Hashtag is an online apparel and accessories store dedicated to the positive stereotypes and constantly evolving trends. Extant ideas and cultural preferences are the most important part of our ideology and on the far way honesty and transparency are our strength.</p>
                    <p>You can choose us not because we’re the best but because of our optimistic attitude and down to earth ethics which ends up in sensible products. We will never forget from where we had started. #EnoughSaid</p>
                </div>
            </div>
        </div>
    </section>
    <!-- WHY WE CHOOSE US -->

	<!-- ARTIST -->
    <section class="artists">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><span class = "fancy">Artists</span></h1>
                </div>
            </div>
            <div id="owl-demo-artst" class="owl-carousel owl-theme">
           		
                <!-- ARTIST DETAIL -->
                <?php
                
				$SelectArtist = $obj->sql_query("SELECT r.RegisterID, r.FirstName, r.UserImage, a.* FROM tbl_register as r INNER JOIN tbl_artist as a WHERE r.RegisterID = a.RegisterID AND a.Status = 'Active' GROUP BY r.FirstName");
					for($ar=0;$ar<count($SelectArtist);$ar++)
					{
				?>
                        <div class="item">
                            <div class="artist-hover">
                            <?php
							$a = Encrypt('myPass123', $SelectArtist[$ar]['RegisterID']);
							?>
                                <a href="artist-detail?Rnd1l=<?php echo $a; ?>">
                                    <img src="upload_data/UserImage/large/<?php echo $SelectArtist[$ar]['UserImage']; ?>" class="" style="width:100%;">
                                    <p><?php echo ucwords($SelectArtist[$ar]['FirstName']); ?></p>
                                </a>
                            </div>
                        </div>
                <?php
					}
				?>
                <!-- ARTIST DETAIL -->
                
           </div>
        </div>
    </section>
    <!-- ARTIST -->
    
    <!-- QUICK CHECK -->
    <section class="quick-check">
        <div class="container-fluid">
            <div class="row text-center">
                <div class="col-md-4 quick-bar col-sm-4 col-xs-12">
                    <a href="javascript:void(0);">
                        <span class="fa-stack fa-2x">
                        <i class="fa fa-life-ring fa-stack-1x text-blue"></i>
                    	</span>
                        <h5>Customer Support</h5>
                        <p class="text-muted">Do you need help? We are here!</p>
                    </a>
                </div>
                <div class="col-md-4 quick-bar col-sm-4 col-xs-12">
                    <a href="javascript:void(0);">
                        <span class="fa-stack fa-2x">
                        <i class="fa fa-paper-plane-o fa-stack-1x text-blue"></i>
                    	</span>
                        <h5>Submit your Art</h5>
                        <p class="text-muted">Welcome to the world of Creativity.</p>
                    </a>
                </div>
                <div class="col-md-4 quick-bar col-sm-4 col-xs-12">
                    <a href="javascript:void(0);">
                        <span class="fa-stack fa-2x">
                        	<i class="fa fa-gift fa-stack-1x text-blue"></i>
                    	</span>
                        <h5>gift voucher</h5>
                        <p class="text-muted">Because gifting makes us feel good.</p>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- QUICK CHECK -->
    
    <!-- REGISTER/LOGIN WITH FACEBOOK & GOOGLE + -->
    <?php include("includes/loginwithfbgp.php") ?>
    <!-- REGISTER/LOGIN WITH FACEBOOK & GOOGLE + -->
    
    <!-- LOGIN MODEL -->
    <?php include("includes/loginmodel.php"); ?>
    <!-- LOGIN MODEL -->
    
    <!-- FOOTER -->
    <?php include("includes/footer.php"); ?>
    <!-- FOOTER -->
	
	<div id = "openquickview"></div>
	
	<script>
	function QuickView(pid)
	{
		var dataString = 'pid='+pid;
		$("#product-quick-veiw-modal"+pid).modal('close');
		$.ajax({
		type: "POST",
		url: "quickview_index",
		data: dataString,
		cache: false,
		beforeSend:function(){
		
		},
		success: function(data){
			if(data)
			{
				$("#openquickview").html(data);
				$("#product-quick-veiw-modal"+pid).modal('show');
				loaddata();
			}
		}
		});
	}
	
	
	
 function loaddata()
 {
	 $(document).ready(function() {
		
        $("#myCarousel").carousel({
            interval: 8000,
        });
    });
	
    (function(window, $, undefined) {

        var conf = {
            center: true,
            backgroundControl: false
        };

        var cache = {
            $carouselContainer: $('.thumbnails-carousel').parent(),
            $thumbnailsLi: $('.thumbnails-carousel li'),
            $controls: $('.thumbnails-carousel').parent().find('.carousel-control')
        };

        function init() {
            cache.$carouselContainer.find('ol.carousel-indicators').addClass('indicators-fix');
            cache.$thumbnailsLi.first().addClass('active-thumbnail');

            if (!conf.backgroundControl) {
                cache.$carouselContainer.find('.carousel-control').addClass('controls-background-reset');
            } else {
                cache.$controls.height(cache.$carouselContainer.find('.carousel-inner').height());
            }

            if (conf.center) {
                cache.$thumbnailsLi.wrapAll("<div class='center clearfix'></div>");
            }
        }

        function refreshOpacities(domEl) {
            cache.$thumbnailsLi.removeClass('active-thumbnail');
            cache.$thumbnailsLi.eq($(domEl).index()).addClass('active-thumbnail');
        }

        function bindUiActions() {
            cache.$carouselContainer.on('slide.bs.carousel', function(e) {
                refreshOpacities(e.relatedTarget);
            });

            cache.$thumbnailsLi.click(function() {
                cache.$carouselContainer.carousel($(this).index());
            });
        }

        $.fn.thumbnailsCarousel = function(options) {
            conf = $.extend(conf, options);

            init();
            bindUiActions();

            return this;
        }

    })(window, jQuery);

    $('.thumbnails-carousel').thumbnailsCarousel();
 }
    </script>
	
	
</body>
</html>
