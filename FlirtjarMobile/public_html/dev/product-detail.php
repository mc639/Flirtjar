 <?php
	/*----------File Information----------*/
	#Project : Hashtag
	#File Created By : Avani Trivedi
	#File Created Date : 18 Jan 2016
	#File Edited By :
	#File Edited Date :
	/*----------File Information----------*/
	
	include ("includes/connection.php");
	include("includes/encrypt.php");
	$obj = new myclass();
	session_start();
	
	$a = str_replace(" ","+",$_GET['ProductID']);
	$ProductID = Decrypt('myPass123', $a);
	
	$b = str_replace(" ","+",$_GET['CategoryID']);
	$CategoryID1 = Decrypt('myPass123', $b);
	
	$SID = session_id();
	$date = date('Y-m-d');
	
	/* FOR RECENTLY VIEWED PRODUCTS */
	
	$DeleteRecent = $obj->sql_query("DELETE FROM tbl_product_recent_view WHERE ProductID = '".$ProductID."' AND SID = '".$SID."'");	
	$RecentlyViewed = $obj->sql_query("INSERT INTO tbl_product_recent_view(RID, ProductID, SID, Date)VALUES('','".$ProductID."', '".$SID."', '".$date."')");
	
	/* FOR RECENTLY VIEWED PRODUCTS */
	
	$SelectProduct = $obj->sql_query("SELECT * FROM tbl_product WHERE ProductID = '".$ProductID."'");
	$CategoryID = $SelectProduct[0]['CategoryID'];
	
	$SPID = Encrypt('myPass123', $SelectProduct[0]['ProductID']);
	$SCID = Encrypt('myPass123', $SelectProduct[0]['CategoryID']);
	
	
?>
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- FOR SHARE THIS -->
    <meta property="og:title" content="Hashtag - <?php echo $SelectProduct[0]['ProductName']; ?>"/>
    <meta property="og:description" content="<?php echo $SelectProduct[0]['ProductDescription']; ?>"/>
    <meta property="og:url" content="http://www.hashtag.shop/dev/product-detail/<?php echo $SPID;  ?>/<?php echo $SCID; ?>/<?php echo str_replace(" ","-",$SelectProduct[0]['ProductName']); ?>"/>
    <meta property="og:image" content="upload_data/productactualimage/200x200/<?php echo $SelectProduct[0]['ProductActualImage']; ?>"/>
	<link rel="image_src" href="upload_data/productactualimage/200x200/<?php echo $SelectProduct[0]['ProductActualImage']; ?>"/>
    <!-- FOR SHARE THIS -->
    
    <title><?php echo ucwords($SelectProduct[0]['PageTitle']); ?></title>
  
	<script type="text/javascript">var switchTo5x=true;</script>
	<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
	<script type="text/javascript">stLight.options({publisher: "954d8694-0e41-4f52-82a3-ef6483986b4c", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script> 
	<?php include("includes/js_css.php"); ?>
</head>  


<body>

    
    <!-- HEADER -->
    <?php include("includes/header.php"); ?>
    <!-- HEADER -->
    
    <div id="stickyalias"></div>
    <a href="#0" class="cd-top"><i class="fa fa-angle-up"></i></a>
    
    <section class="headingdisplay margin-top120">
        <div class="container">
            <div class="row">
                <div class="col-md-6 ">
                    <h1 class="pull-left"></h1>
                </div>
                <div class="col-md-6 ">
                   
                    <ul class="breadcrumb pull-right">
                        <li><a href="index">Home</a></li>
                        <li><a class="active"><i class="fa fa-angle-right pr5 breakdivsion"></i>T-Shirt</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class = "product-detail-section">
        <div class="container">
            <div class = "row">
                    <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                        
                        <!-- bootstrap carousel -->
                        <div id="carousel-example-generic" class="carousel slide carousel-pdetail-1" data-ride="carousel" data-interval="false">
                                <div class="carousel-inner">
                                <?php 
									$SelectProductImage = $obj->sql_query("SELECT * FROM tbl_productimage WHERE ProductID = '".$ProductID."' ORDER BY DisplayOrder");
									for($im=0;$im<count($SelectProductImage);$im++)
									{
								   ?> 
                                    <div class="item <?php if($im == 0){ ?> active srle <?php } ?>">
                                        <img src="upload_data/productimage/large/<?php echo $SelectProductImage[$im]['ImageName']; ?>" alt="<?php echo $SelectProductImage[$im]['ImageName']; ?>" class="img-responsive">
                                        <div class="carousel-caption"></div>
                                    </div>
                                 
                                <?php
									}
								?>
                                </div>
                            <!-- Controls -->
                            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                                <span class="left-arraow"><i class="fa fa-angle-left f30"></i></span>
                            </a>
                            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                                <span class="right-arrow"><i class="fa fa-angle-right f30"></i></span>
                            </a>
                            <!-- Controls -->
                              
                            <!-- Thumbnails -->
                            <ul class="thumbnails-carousel clearfix">
                            <?php
								for($im=0;$im<count($SelectProductImage);$im++)
								{
							?>
                                	<li><img src="upload_data/productimage/thumb/<?php echo $SelectProductImage[$im]['ImageName']; ?>" alt="1_tn.jpg"></li>
                           <?php
								}
						    ?>
                            </ul>
                            <!-- Thumbnails -->
                            
                        </div>
                        <!-- bootstrap carousel -->
                        
                    </div>
                    <div class="col-lg-8 col-md-7 col-sm-6 col-xs-12 modal-details no-padding">
                        <div class="modal-details-inner">
                    <form id="Product" name="Product" action="cart" method="post" enctype="multipart/form-data">
    				<input type="hidden" id="ProductID" name="ProductID" value="<?php echo $SelectProduct[0]['ProductID']; ?>"/>
                        	<!-- PRODUCT NAME -->
                            <h1 class="product-title">
								<?php echo ucwords($SelectProduct[0]['ProductName']); ?> 
                            </h1>
                            <!-- PRODUCT NAME -->
 		
                            <br>
                            <!-- PRICE -->
							<?php
                            if(!empty($OfferDiscountType))
                            {
                                if($OfferDiscountType == "Rupee")
                                    {
                                        $Price = $SelectProduct[0]['ProductPrice'] - $OfferDiscountAmount;
                                    }
                                    if($OfferDiscountType == "Percentage")
                                    {
                                        $DiscountPrice = ($OfferDiscountAmount * $SelectProduct[0]['ProductPrice'])/100;
                                        $Price = $SelectProduct[0]['ProductPrice'] - $DiscountPrice;
                                    }
                            }			
                            else
                            {
                                if(!empty($SelectProduct[0]['ProductDiscountType']))
                                {
                                    
                                    $ProductDiscountType = $SelectProduct[0]['ProductDiscountType'];
                                    if($ProductDiscountType == "Rupee")
                                    {
                                        $Price = $SelectProduct[0]['ProductPrice'] - $SelectProduct[0]['ProductDiscountAmount'];
                                    }
                                    if($ProductDiscountType == "Percentage")
                                    {
                                        $DiscountPrice = ($SelectProduct[0]['ProductDiscountAmount'] * $SelectProduct[0]['ProductPrice'])/100;
                                        $Price = $SelectProduct[0]['ProductPrice'] - $DiscountPrice;
                                    }
                                }
                                else
                                {
                                    $Price = $SelectProduct[0]['ProductPrice'];
                                }
                            }
                            ?>
                            <div class="product-price">Price : 
                                <span class="price-sales"> 
                                    <i class="fa fa-inr"></i><?php echo $Price; ?> 
                                    <input type="hidden" id="Price" name="Price" value="<?php echo $Price; ?>" />
                                </span> 
                                <span class="price-standard">
                                </span> 
                            </div>
                            <!-- PRICE -->
                    
                    		<!-- DESCRIPTION -->
                            <div class="details-description">
                                <p>
                                    <?php echo ucwords($SelectProduct[0]['ProductDescription']); ?> 
                                </p>
                            </div>
                            <!-- DESCRIPTION -->
                    
                   
                    
                  
                    <div class="row">
                    	<!-- QUANTITY -->
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <div class="quantity">
                                <h3 class="quantity-detail-title"><strong>Quantity</strong></h3>
								 <div class="m10">
                                    <input type='text' id="quantity" name='quantity' value='1' class='qty textbox-qty' />
                                </div>
                            </div>
                        </div>
                        <!-- QUANTITY -->
                        
                        <!-- SIZE -->
                        <div class="col-md-5 col-sm-8 col-xs-12">
                            <div class="size">
                                <h3 class="size-detail-title"><strong>Size</strong></h3>
                                <ul class="subcategory mt5">
									   <?php
                                            $ProductSize =explode(",",$SelectProduct[0]['ProductSize']);
                                            $StockFlag = 0;
											for($ps=0;$ps<count($ProductSize);$ps++)
                                            {
												$SelectSizeID = $obj->sql_query("SELECT * FROM tbl_size WHERE SizeName = '".$ProductSize[$ps]."'");
												$SelectSizeStock = $obj->sql_query("SELECT * FROM tbl_productsize_stockmanage WHERE ProductID = '".$SelectProduct[0]['ProductID']."' AND SizeID = '".$SelectSizeID[0]['SizeID']."'");
												if($SelectSizeStock[0]['ProductStock'] > 0)
												{
													$StockFlag = 1;
                                        ?>
                                                <li onClick="add_class_<?php echo $ps; ?>();"><a href="#" id="Size_<?php echo $ps; ?>"><?php echo strtoupper($ProductSize[$ps]); ?></a></li>
                                                <script>
                                                function add_class_<?php echo $ps; ?>()
                                                {
                                                    $('.pdetailsize ul li').addClass("size-active");
                                                    var a = $('#Size_<?php echo $ps; ?>').html();
													$("#Size").val(a);
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
                                         <input type="hidden" id="Size" name="Size" value="">
                                </ul>
                            </div>
                        </div>
                       <!-- SIZE -->
                       
                       <!-- SOCIAL SHARE -->
                        <div class="col-md-4 col-sm-4 col-xs-12 mobile-widthextra">
                            <div class="product-share clearfix pull-left">
                                <h3> <strong>SHARE</strong> </h3>
								<span class='st_facebook_large' displayText='Facebook'></span>
								<span class='st_twitter_large' displayText='Tweet'></span>
								<span class='st_googleplus_large' displayText='Google +'></span> 
                            </div>
                        </div>
                       <!-- SOCIAL SHARE -->
                    </div>
                    <div class="cart-actions pt40">
                        <div class="addto">
                       
                            <button type="submit" <?php if($StockFlag == 0){?> disabled <?php } ?> class="btn btn-primary mr10 button-add-to-cart" id="AddToCartProductDetail" onClick="message_show();" name="AddToCartProductDetail" <?php /*?><?php if(empty($_SESSION['RegisterID'])){ ?>onclick="window.location = 'login.php?from=cart.php'"<?php } else{ ?>onclick="window.location = 'cart.php'"<?php } ?><?php */?>>
                            <span class="add2cart"><i class="glyphicon glyphicon-shopping-cart"> </i> Add to cart </span>
                            </button>
                            
                            <button type="button" class="btn btn-primary mr10 button-add-to-cart" name="addtowishlist" id="addtowishlist" onClick="AddToWishlist(<?php echo $SelectProduct[0]['ProductID']; ?>)">
                            <span class="add2cart"><i class="fa fa-heart"></i> Add to Wishlist </span>
                            </button>
                            
                            <!-- SCRIPT FOR ADD TO WISHLIST -->
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
                            <!-- SCRIPT FOR ADD TO WISHLIST -->
                            
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </section>
    <section class="common pt50">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel with-nav-tabs">
                        <div class="panel-heading">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab1default" data-toggle="tab">Product Description</a></li>
                                <li><a href="#tab2default" data-toggle="tab">Product Detail</a></li>
                                <li><a href="#tab3default" data-toggle="tab">Product Care</a></li>
                            </ul>
                        </div>
                        <div class="panel-body">
                            <div class="tab-content">
                            
                            <!-- PRODUCT DESCRIPTION -->
                                <div class="tab-pane fade in active" id="tab1default">
                                    <div class="std">
                                      	<?php echo $SelectProduct[0]['ProductDescription']; ?>  
                                    </div>
                                </div>
                            <!-- PRODUCT DESCRIPTION -->
                            
                            <!-- PRODUCT DETAIL -->
                                <div class="tab-pane fade" id="tab2default">
                                    <div class="pt10 table-responsive">
                                        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table des-tableth">
                                            
                                            <?php
												if(!empty($Price))
												{
											?>
                                                    <tr>
                                                        <td>Price</td>
                                                        <td><?php echo $Price ;?></td>
                                                    </tr>
                                           	<?php
												}
											?>
                                            
                                            <?php
												if(!empty($SelectProduct[0]['ProductDesign']))
												{
											?>
                                            		<tr>
                                                        <td>Design</td>
                                                        <td><?php echo ucwords($SelectProduct[0]['ProductDesign']);?></td>
                                                    </tr>
                                           	<?php
												}
											?>
                                             
                                            <?php
												if(!empty($SelectProduct[0]['ProductMaterial']))
												{
											?>
                                            		<tr>
                                                        <td>Material</td>
                                                        <td><?php echo ucwords($SelectProduct[0]['ProductMaterial']);?></td>
                                                    </tr>
                                           	<?php
												}
											?>
                                            
                                            <?php
												$SelectColor = $obj->sql_query("SELECT * FROM tbl_color WHERE ColorID = '".$SelectProduct[0]['ProductColor']."'");
												if(!empty($SelectColor[0]['ColorName']))
												{
											?>
                                            		<tr>
                                                <td>Color</td>
                                                <td><?php echo ucwords($SelectColor[0]['ColorName']);?></td>
                                            </tr>
                                           	<?php
												}
											?>
                                            
                                            <?php
												if(!empty($SelectProduct[0]['ProductTFabric']))
												{
											?>
                                            		<tr>
                                                        <td>Fabric</td>
                                                        <td><?php echo ucwords($SelectProduct[0]['ProductTFabric']);?></td>
                                                    </tr>
                                           	<?php
												}
											?>
                                            
                                            <?php
												if(!empty($SelectProduct[0]['ProductTFit']))
												{
											?>
                                            		<tr>
                                                        <td>Fit</td>
                                                        <td><?php echo ucwords($SelectProduct[0]['ProductTFit']);?></td>
                                                    </tr>
                                           	<?php
												}
											?>
                                            
                                            
                                            <?php
												if(!empty($SelectProduct[0]['ProductTNeck']))
												{
											?>
                                            		<tr>
                                                        <td>Neck</td>
                                                        <td><?php echo ucwords($SelectProduct[0]['ProductTNeck']);?></td>
                                                    </tr>
                                           	<?php
												}
											?>
                                            <?php
												if(!empty($SelectProduct[0]['ProductTSleeves']))
												{
											?>
                                            		<tr>
                                                        <td>Sleeves</td>
                                                        <td><?php echo ucwords($SelectProduct[0]['ProductTSleeves']);?></td>
                                                    </tr>
                                           	<?php
												}
											?>
                                            <?php
												if(!empty($SelectProduct[0]['ProductMoDevice']))
												{
											?>
                                            		<tr>
                                                        <td>Device</td>
                                                        <td><?php echo ucwords($SelectProduct[0]['ProductMoDevice']);?></td>
                                                    </tr>
                                           	<?php
												}
											?>
                                            <?php
												if(!empty($SelectProduct[0]['ProductMoTexture']))
												{
											?>
                                            		<tr>
                                                        <td>Texture</td>
                                                        <td><?php echo ucwords($SelectProduct[0]['ProductMoTexture']);?></td>
                                                    </tr>
                                           	<?php
												}
											?>
                                            <?php
												if(!empty($SelectProduct[0]['ProductPuType']))
												{
											?>
                                            		<tr>
                                                        <td>Purse Type</td>
                                                        <td><?php echo ucwords($SelectProduct[0]['ProductPuType']);?></td>
                                                    </tr>
                                           	<?php
												}
											?>
                                            <?php
												if(!empty($SelectProduct[0]['ProductPCOccation']))
												{
											?>
                                            		<tr>
                                                        <td>Occation</td>
                                                        <td><?php echo ucwords($SelectProduct[0]['ProductPCOccation']);?></td>
                                                    </tr>
                                           	<?php
												}
											?>
                                            <?php
												if(!empty($SelectProduct[0]['ProductHeight']))
												{
											?>
                                            		<tr>
                                                        <td>Height</td>
                                                        <td><?php echo ucwords($SelectProduct[0]['ProductHeight']);?></td>
                                                    </tr>
                                           	<?php
												}
											?>
                                            <?php
												if(!empty($SelectProduct[0]['ProductWidth']))
												{
											?>
                                            		<tr>
                                                        <td>Width</td>
                                                        <td><?php echo ucwords($SelectProduct[0]['ProductWidth']);?></td>
                                                    </tr>
                                           	<?php
												}
											?>
                                            <?php
												if(!empty($SelectProduct[0]['ProductDepth']))
												{
											?>
                                            		<tr>
                                                        <td>Depth</td>
                                                        <td><?php echo ucwords($SelectProduct[0]['ProductDepth']);?></td>
                                                    </tr>
                                           	<?php
												}
											?>
                                            <?php
												if(!empty($SelectProduct[0]['ProductNOPockets']))
												{
											?>
                                            		<tr>
                                                        <td>No Of Pockets</td>
                                                        <td><?php echo ucwords($SelectProduct[0]['ProductNOPockets']);?></td>
                                                    </tr>
                                           	<?php
												}
											?>
                                            <?php
												if(!empty($SelectProduct[0]['ProductNOCompartments']))
												{
											?>
                                            		<tr>
                                                        <td>No Of Compartments</td>
                                                        <td><?php echo ucwords($SelectProduct[0]['ProductNOCompartments']);?></td>
                                                    </tr>
                                           	<?php
												}
											?>
                                            <?php
												if(!empty($SelectProduct[0]['ProductClosure']))
												{
											?>
                                            		<tr>
                                                        <td>Closure</td>
                                                        <td><?php echo ucwords($SelectProduct[0]['ProductClosure']);?></td>
                                                    </tr>
                                           	<?php
												}
											?>
                                            <?php
												if(!empty($SelectProduct[0]['ProductCardSlots']))
												{
											?>
                                            		<tr>
                                                        <td>Card Slots</td>
                                                        <td><?php echo ucwords($SelectProduct[0]['ProductCardSlots']);?></td>
                                                    </tr>
                                           	<?php
												}
											?>
                                            <?php
												if(!empty($SelectProduct[0]['ProductWaPattern']))
												{
											?>
                                            		<tr>
                                                        <td>Wallet Pattern</td>
                                                        <td><?php echo ucwords($SelectProduct[0]['ProductWaPattern']);?></td>
                                                    </tr>
                                           	<?php
												}
											?>
                                            <?php
												if(!empty($SelectProduct[0]['ProductBeReversibleBelt']))
												{
											?>
                                            		<tr>
                                                        <td>Reversible Belt</td>
                                                        <td><?php echo ucwords($SelectProduct[0]['ProductBeReversibleBelt']);?></td>
                                                    </tr>
                                           	<?php
												}
											?>
                                            <?php
												if(!empty($SelectProduct[0]['ProductBeSize']))
												{
											?>
                                            		<tr>
                                                        <td>Belt Size</td>
                                                        <td><?php echo ucwords($SelectProduct[0]['ProductBeSize']);?></td>
                                                    </tr>
                                           	<?php
												}
											?>
                                        </table>
                                    </div>
                                </div>
                            <!-- PRODUCT DETAIL -->
                            
                            <!-- PRODUCT CARE -->
                                <div class="tab-pane fade" id="tab3default">
                                    <div class="std">
                                        <?php echo $SelectProduct[0]['ProductCare']; ?>
                                    </div>
                                </div>
                            <!-- PRODUCT CARE -->
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- RECENTLY VIEWED ITEMS -->
    <section class="featured-item">
        <div class="container">
            <?php
				$TodayDate = date('Y-m-d');
				$RecentProduct = $obj->sql_query("SELECT r.*,p.* FROM tbl_product AS p INNER JOIN  tbl_product_recent_view AS r WHERE r.SID = '".$SID."' AND p.Status = 'Active' AND r.Date = '".$TodayDate."' AND r.ProductID = p.ProductID AND p.ProductID != '".$ProductID."'  GROUP BY p.ProductName ORDER BY r.RID DESC");
				if(count($RecentProduct)>0)
				{
			?>
			<div class="row">
                <div class="col-md-12">
                    <h1><span>Recently Viwed Items</span></h1>
                </div>
            </div>
            <div class="row product-slider-detail">
                <div class="col-md-12">
                    <div id="owl-demo" class="owl-carousel product-main-page product-main-home-hover">
                    	<?php
							for($re=0;$re<count($RecentProduct);$re++)
							{
								$ProductStock = $RecentProduct[$re]['ProductStock'];
								{
						?>
                                <div class="item">
                                <form id="Pro_<?php echo $RecentProduct[$re]['ProductID']; ?>" name="Pro_<?php echo $RecentProduct[$re]['ProductID']; ?>" method="post" enctype="multipart/form-data">
                                <input type="hidden" id="ProductID" name="ProductID" value="<?php echo $RecentProduct[$re]['ProductID']; ?>" />
                                    <div class="item-main" style="position: relative;">
                                        <div class="item-inner">
                                            <div class="box-images">
                                            <?php 
												$RePID = Encrypt('myPass123', $RecentProduct[$re]['ProductID']);
												$ReCID = Encrypt('myPass123', $RecentProduct[$re]['CategoryID']);
											?>
                                                <a href="product-detail/<?php  echo $RePID; ?>/<?php  echo $ReCID; ?>/<?php  echo str_replace(" ","-",$RecentProduct[$re]['ProductName']); ?>" class="product-image">
                                                    <img data-src="upload_data/productactualimage/large/<?php echo $RecentProduct[$re]['ProductActualImage']; ?>" class="img-face lazy-hidden" alt="img" width="300" height="200">
                                                    <img data-src="upload_data/producthoverimage/large/<?php echo $RecentProduct[$re]['ProductHoverImage']; ?>" alt="img" class="img-face-back lazy-hidden" width="300" height="200">
                                                </a>
                                                    <?php
                                                $SelectWishList = $obj->sql_query("SELECT * FROM tbl_wishlist WHERE ProductID = '".$RecentProduct[$re]['ProductID']."' AND RegisterID = '".$_SESSION['RegisterID']."'");
                                                ?>
                                                    <div class="wishlist-tooltip">
                                                        <span class="icon-fav wishlist-tooltip"><a class="link-wishlist <?php if($SelectWishList){?>text-red <?php } else { ?> text-gray <?php } ?>" id ="wishlist<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>" onClick="AddToWishlist(<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>)" ><i class="fa fa-heart"></i></a></span>
                                                        <span class="saveToWish">Save as Wishlist</span>
                                                    </div>
													
													<div class="qiuck-tooltip">
													<span class="icon-fav quick-tooltip"><a href="javascript:void(0);" data-toggle="modal" data-target="#product-quick-veiw-modal<?php echo $RecentProduct[$re]['ProductID']; ?>" class="link-wishlist text-gray" onClick = "QuickView(<?php echo $RecentProduct[$re]['ProductID']; ?>);"><i class="fa fa-eye"></i></a></span>
													<span class="qiuckview">Qiuck View</span>
												</div>
                                                
                                                <!-- SCRIPT FOR ADD TO WISHLIST -->
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
                                                <!-- SCRIPT FOR ADD TO WISHLIST -->
                                                
                                            </div>
                                            <div class="product-shop">
                                                <div class="description">
                                                    <h4 class="product-name"><a href="#" ><?php echo ucwords($RecentProduct[$re]['ProductName']); ?></a></h4>
                                                </div>
                                                
                                                <!-- PRODUCT PRICE -->
													<div class="price">
														<?php
															if((!empty($RecentProduct[$re]['ProductDiscountType'])) && ($RecentProduct[$re]['ProductDiscountAmount'] != "00"))
															{
																$ProductDiscountType2 = $RecentProduct[$re]['ProductDiscountType'];
																if($ProductDiscountType2 == "Rupee")
																{
																	$Price2 = $RecentProduct[$re]['ProductPrice'] - $RecentProduct[$re]['ProductDiscountAmount'];
																	if(($Price2) != ($RecentProduct[$re]['ProductPrice']))
																	{ 
														?>
																		<span class="cutprice"><i class="fa fa-inr"></i><?php echo $RecentProduct[$re]['ProductPrice']; ?> /-</span>
														<?php 
																	} 
														?>
																		<span class="discount"><i class="fa fa-inr"></i><?php echo $Price2; ?> /-</span> 
																		<input type="hidden" name="Price" id="Price" value="<?php echo $Price2; ?>"/>
														<?php	
																}
																if($ProductDiscountType2 == "Percentage")
																{
																	$DiscountPrice2 = ($RecentProduct[$re]['ProductDiscountAmount'] * $RecentProduct[$re]['ProductPrice'])/100;
																	$Price2 = $RecentProduct[$re]['ProductPrice'] - $DiscountPrice2;
																	if(($Price2) != ($RecentProduct[$re]['ProductPrice']))
																	{ 
														?>
																		<span class="cutprice"><i class="fa fa-inr"></i><?php echo $RecentProduct[$re]['ProductPrice']; ?> /-</span>
														<?php
																	}
														?>
																		<span class="discount"><i class="fa fa-inr"></i><?php echo $Price2; ?> /-</span>
																		<input type="hidden" name="Price" id="Price" value="<?php echo $Price2; ?>" />
														<?php
																}
															}
															else
															{
																$Price2 = $RecentProduct[$re]['ProductPrice'];
														?>
																<span class="discount"><i class="fa fa-inr"></i><?php echo $Price2; ?> /-</span>
																<input type="hidden" name="Price" id="Price" value="<?php echo $Price2; ?>" />
														<?php
															}
														?>
													</div>
                                                 <!-- PRODUCT PRICE -->
                                                 
                                                 <!-- PRODUCT SIZE -->
                                                <div class="product-sectiononhover">
                                                    
                                                    <div class="size pdetailsize">
                                                        <ul class="subcategory mt5">
                                                            <?php
                                                                $ProductSize1 =explode(",",$RecentProduct[$re]['ProductSize']);
																  $RStockFlag = 0;
                                                                for($p1=0;$p1<count($ProductSize1);$p1++)
                                                                {
																	$SelectSizeID = $obj->sql_query("SELECT * FROM tbl_size WHERE SizeName = '".$ProductSize1[$p1]."'");
																	$SelectSizeStock = $obj->sql_query("SELECT * FROM tbl_productsize_stockmanage WHERE ProductID = '".$RecentProduct[$re]['ProductID']."' AND SizeID = '".$SelectSizeID[0]['SizeID']."'");
																	if($SelectSizeStock[0]['ProductStock'] > 0)
																	{
																		$RStockFlag = 1;
                                                            ?>
                                                                    <li onClick="add_<?php echo $p1; ?>_<?php echo $RecentProduct[$re]['ProductID']; ?>();" id="Ss_<?php echo $p1; ?>_<?php echo $RecentProduct[$re]['ProductID']; ?>"><a href="#" id="Size123_<?php echo $p1; ?>_<?php echo $RecentProduct[$re]['ProductID']; ?>"><?php echo strtoupper($ProductSize1[$p1]); ?></a></li>
                                                                    <script>
																	   function add_<?php echo $p1; ?>_<?php echo $RecentProduct[$re]['ProductID']; ?>()
																	   {
																		$('#Ss_<?php echo $p1; ?>_<?php echo $RecentProduct[$re]['ProductID']; ?>').addClass("size-active");
																		var a = $('#Size123_<?php echo $p1; ?>_<?php echo $RecentProduct[$re]['ProductID']; ?>').html();
																		document.getElementById('Size2_<?php echo $RecentProduct[$re]['ProductID']; ?>').value = a;
																		var s = $("#Size2_<?php echo $RecentProduct[$re]['ProductID']; ?>").val();
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
																if($RStockFlag == 0)
																{
															?>
																	<span style="color:red;">Product out of stock</span>
																	
															<?php
																}
															?>
                                                            <input type="hidden" id="Size2_<?php echo $RecentProduct[$re]['ProductID']; ?>" name="Size2_<?php echo $RecentProduct[$re]['ProductID']; ?>" value="">  
                                                        </ul>
                                                    
                                                    </div>
                                                    
                                                    <!-- ADD TO CART BUTTON -->
                                                    <div class="add-to-Cartonhover">
                                                         <button type="submit" <?php if($RStockFlag == 0){?> disabled <?php } ?>  class="btn btn-primary button-subscribe btnshadow-nor btn-shopping-item btn-bluehover" id="AddToCartProductDetailRecent<?php echo $RecentProduct[$re]['ProductID']; ?>" onClick="carta(<?php echo $RecentProduct[$re]['ProductID']; ?>)" name="AddToCartProductDetailRecent<?php echo $RecentProduct[$re]['ProductID']; ?>">
                                                            <span class="add2cart"> Add to cart </span>
                                                         </button>
                                                    </div>
                                                    <!-- ADD TO CART BUTTON -->
                                                    
                                                    
                                                    <!-- SCRIPT FOR ADD TO CART -->
														<script type="text/javascript" language="javascript">
                                                    function carta(cid)
                                                    {
                                                    var data = 'cid='+cid;
                                                    $.notify.defaults
                                                    ({
                                                    className: "error"
                                                    })
                                                    var parentdata = $('pdetailsize ul li');
                                                    if ($('.pdetailsize ul li').hasClass("size-active")) 
                                                    {
                                                    var dataString = $("form#Pro_"+cid).serialize();
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
															for($rer=0;$rer<count($RecentProduct);$rer++)
															{
															$ProductSizeR =explode(",",$RecentProduct[$rer]['ProductSize']);
															for($pr=0;$pr<count($ProductSizeR);$pr++)
															{
															?>
															
																if($("#Ss_<?php echo $pr; ?>_"+cid).hasClass("size-active"))
																{
																	$("#Ss_<?php echo $pr; ?>_"+cid).removeClass("size-active");
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
															var dataString = $("form#Pro_"+cid).serialize();
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
                                                     
                                                </div>
                                                <!-- PRODUCT SIZE -->
                                                
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                </div>
                        <?php
							}
							}
						?>
                    </div>
                </div>
            </div>
			<?php
				}
			?>
        </div>
    </section>
    <!-- RECENTLY VIEWED ITEMS -->
    
    
    <!-- FEATURED ITEMS -->
    <section class="featured-item">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><span>Featured Items</span></h1>
                </div>
            </div>
            <div class="row product-slider">
                <div class="col-md-12">
                    <div id="owl-carousel-secondary" class="owl-carousel product-main-page product-main-home-hover">
                        
                        <!-- FEATURED ITEMS -->
                        <?php
							$RecentlyAddedProducts = $obj->sql_query("SELECT * FROM tbl_product WHERE AsFeatured = 'Yes' AND Status = 'Active' ORDER BY ProductID DESC limit 8");
							for($r=0;$r<count($RecentlyAddedProducts);$r++)
							{
								$PID = $RecentlyAddedProducts[$r]['ProductID'];
								$ProductStockF = $RecentlyAddedProducts[$r]['ProductStock'];
								{
						?>
                                <div class="item" id="Recent<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>">
                                <form id="Product_<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>" name="Product_<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>" method="post" enctype="multipart/form-data">
                                <input type="hidden" id="ProductID" name="ProductID" value="<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>" />
                                    <div class="item-main" style="position: relative;">
                                        <div class="item-inner">
                                            <div class="box-images">
                                            <?php 
												$ReAddPID = Encrypt('myPass123', $RecentlyAddedProducts[$r]['ProductID']);
												$ReAddCID = Encrypt('myPass123', $RecentlyAddedProducts[$r]['CategoryID']);
											?>
                                                <a href="product-detail/<?php  echo $ReAddPID; ?>/<?php  echo $ReAddCID; ?>/<?php  echo str_replace(" ","-",$RecentlyAddedProducts[$r]['ProductName']); ?>" class="product-image">
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
												
                                                <!-- ADD TO WISH LIST -->
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
                                                <!-- ADD TO WISH LIST -->
                                                
                                               <div class="qiuck-tooltip">
													<span class="icon-fav quick-tooltip"><a href="javascript:void(0);" data-toggle="modal" data-target="#product-quick-veiw-modal<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>" class="link-wishlist text-gray" onClick = "QuickView(<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>);"><i class="fa fa-eye"></i></a></span>
													<span class="qiuckview">Qiuck View</span>
												</div>
                                             
                                            </div>
                                            <div class="product-shop">
                                            
                                                <!-- DISPLAY PRODUCT NAME -->
                                                <div class="description">
                                                    <h4 class="product-name"><a href="#" ><?php echo ucwords($RecentlyAddedProducts[$r]['ProductName']); ?></a></h4>
                                                </div>
                                                <!-- DISPLAY PRODUCT NAME -->
                                                
                                                <!-- DISPLAY PRODUCT PRICE -->
												<div class="price">
													<?php
														if((!empty($RecentlyAddedProducts[$r]['ProductDiscountType'])) && ($RecentlyAddedProducts[$r]['ProductDiscountAmount'] != "00"))
														{
															$ProductDiscountType1 = $RecentlyAddedProducts[$r]['ProductDiscountType'];
															if($ProductDiscountType1 == "Rupee")
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
															if($ProductDiscountType1 == "Percentage")
															{
																$DiscountPrice1 = ($RecentlyAddedProducts[$r]['ProductDiscountAmount'] * $RecentlyAddedProducts[$r]['ProductPrice'])/100;
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
																$FStockFlag = 0;
                                                                for($p=0;$p<count($ProductSize);$p++)
                                                                {
																	$SelectSizeID = $obj->sql_query("SELECT * FROM tbl_size WHERE SizeName = '".$ProductSize[$p]."'");
																	$SelectSizeStock = $obj->sql_query("SELECT * FROM tbl_productsize_stockmanage WHERE ProductID = '".$RecentlyAddedProducts[$r]['ProductID']."' AND SizeID = '".$SelectSizeID[0]['SizeID']."'");
																	if($SelectSizeStock[0]['ProductStock'] > 0)
																	{
																		$FStockFlag = 1;
                                                            ?>
                                                                    <li onClick="addc_<?php echo $p; ?>_<?php echo $RecentlyAddedProducts[$r]['ProductID'] ?>();" id="S_<?php echo $p; ?>_<?php echo $RecentlyAddedProducts[$r]['ProductID'] ?>"><a href="#" id="Size_<?php echo $p; ?>_<?php echo $RecentlyAddedProducts[$r]['ProductID'] ?>"><?php echo strtoupper($ProductSize[$p]); ?></a></li>
                                                                    <script>
																	   function addc_<?php echo $p; ?>_<?php echo $RecentlyAddedProducts[$r]['ProductID'] ?>()
																	   {
																		$('#S_<?php echo $p; ?>_<?php echo $RecentlyAddedProducts[$r]['ProductID'] ?>').addClass("size-active");
																		var a = $('#Size_<?php echo $p; ?>_<?php echo $RecentlyAddedProducts[$r]['ProductID'] ?>').html();
																		document.getElementById('Size1_<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>').value = a;
																		var s = $("#Size1_<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>").val();
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
                                                            <input type="hidden" id="Size1_<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>" name="Size1_<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>" value="">  
                                                        </ul>
                                                    
                                                    </div>
                                                    <!-- DISPLAY PRODUCT SIZE -->
                                             
                                                    
                                                    <!-- ADD TO CART BUTTON -->
                                                    <div class="add-to-Cartonhover">
                                                         <button type="submit" <?php if($FStockFlag == 0){?> disabled <?php } ?> class="btn btn-primary button-subscribe btnshadow-nor btn-shopping-item btn-bluehover" id="AddToCartProductDetailRecentlyAdded<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>" onClick="cart_data(<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>)" name="AddToCartProductDetailRecentlyAdded<?php echo $RecentlyAddedProducts[$r]['ProductID']; ?>">
                                                            <span class="add2cart"> Add to cart </span>
                                                         </button>
                                                    </div>
                                                    <!-- ADD TO CART BUTTON -->
                                                    
                                                     <!-- SCRIPT FOR ADD TO CART -->
														<script type="text/javascript" language="javascript">
                                                        function cart_data(cid)
                                                        {
															var data = 'cid='+ cid;	
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
																		item_showRA(cid)
																	}
																});
																
																<?php
																for($ra=0;$ra<count($RecentlyAddedProducts);$ra++)
																{
																$ProductSizeRA =explode(",",$RecentlyAddedProducts[$ra]['ProductSize']);
																for($pra=0;$pra<count($ProductSizeRA);$pra++)
																{
																?>
																
																	if($("#S_<?php echo $pra; ?>_"+cid).hasClass("size-active"))
																	{
																		$("#S_<?php echo $pra; ?>_"+cid).removeClass("size-active");
																	}
																<?php
																}
																}
																?>
																
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
														function item_showRA(cid)
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
                                                    
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            	</div>
						<?php
							}
							}
						?>
                        <!-- FEATURED ITEMS -->
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- FEATURED ITEMS -->
	
	<div id = "openquickview"></div>
	
    
     <!-- REGISTER/LOGIN WITH FACEBOOK & GOOGLE + -->
    <?php include("includes/loginwithfbgp.php") ?>
    <!-- REGISTER/LOGIN WITH FACEBOOK & GOOGLE + -->
    
    <!-- LOGIN MODEL -->
    <?php include("includes/loginmodel.php"); ?>
    <!-- LOGIN MODEL -->
    
    <!-- FOOTER -->
    <?php include("includes/footer.php"); ?>
    <!-- FOOTER -->
   
    <script>
	function message_show()
	{
		$.notify.defaults
		({
			className: "error"
		})
		var parentdata = $('pdetailsize ul li');
		if ($('.pdetailsize ul li').hasClass("size-active")) 
		{
			var dataString = $("form#Product").serialize();
			$.ajax
			({
				type: "POST",
				url: "cart_test_detail",
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
						item_showP();
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
	
	function item_showP()
	{
		var parentdata = $('pdetailsize ul li');
		if ($('.pdetailsize ul li').hasClass("size-active")) 
		{											
			var dataString = $("form#Product").serialize();
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
    $(document).ready(function() {
		
        $("#myCarousel").carousel({
            interval: 8000,
        });
    });
    ;
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
    </script>
    
    
	<script>
	function QuickView(pid)
	{
		var dataString = 'pid='+pid;
		$("#product-quick-veiw-modal"+pid).modal('close');
		$.ajax({
		type: "POST",
		url: "quickview",
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
