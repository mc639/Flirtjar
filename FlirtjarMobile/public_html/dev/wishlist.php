<?php
	/*----------File Information----------*/
	#Project : HASHTAG
	#File Created By : Mona Bera
	#File Created Date : 13 Jan 2016
	#File Edited By :
	#File Edited Date :
	/*----------File Information----------*/
	
	include("includes/connection.php");
	include("includes/encrypt.php");
	$obj = new myclass();
	session_start();
	
	$SelectWishListData = $obj->sql_query("SELECT w.* , p.* FROM tbl_product AS p INNER JOIN tbl_wishlist AS w WHERE w.RegisterID = '".$_SESSION['RegisterID']."' AND w.ProductID = p.ProductID");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My WishList</title>

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

<!-- WISHLIST SUBHEADER -->
<section class="headingdisplay margin-top120">
  <div class="container">
    <div class="row">
      <div class="col-md-6 ">
        <h1 class="pull-left">Wish-List</h1>
      </div>
      <div class="col-md-6 ">
        <ul class="breadcrumb pull-right">
          <li><a href="index">Home</a></li>
          <li><a href="wishlist" class="active"><i class="fa fa-angle-right pr5 breakdivsion"></i>Wish-List</a></li>
        </ul>
      </div>
    </div>
  </div>
</section>
<!-- WISHLIST SUBHEADER --> 

<!-- DISPLAY WISHLIST PRODUCTS -->
<section class="product-detail" id="pdetail">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-sm-12 mobile-filter">
        <div class="row">
          <div class="col-md-12">
            <div class="row ptb10 product-main-page"> 
              
              <!-- WISH LIST IS EMPTY -->
              <?php
			  	if((count($SelectWishListData)) == 0)
				{
			  ?>
              		<div class="emptyWish">Your Wishlist is Empty</div>
              <?php
				}
				?>
              <!-- WISH LIST IS EMPTY --> 
              
              <!-- WISHLIST IS NOT EMPTY -->
              <?php
			  	if((count($SelectWishListData)) > 0)
				{
			  ?>
                  <!--<div class = "product-height" style = "top:0px;">-->
					<?php
						for($w=0;$w<count($SelectWishListData);$w++)
						{
							
							{
                    ?>
                    		<div class="col-md-3 col-sm-3 col-xs-12 product-height" id="Hidediv<?php echo $SelectWishListData[$w]['ProductID']; ?>">
                      <div class="item-main" style="position: relative;">
                      
                      <!-- REMOVE FROM WISHLIST -->
                        <div class = "main-close-wrap">
                            
                            <a href="javascript:void(0);" onClick="DeleteWishlistItem(<?php echo $SelectWishListData[$w]['ProductID']; ?>)" class="fa fa-times text-white"><!--<i class="fa fa-times text-white"></i>--></a>
                            
                        </div>
                        
                        <!-- SCRIPT FOR DELETE WISHLIST ITEM -->
						<script type="text/javascript" language="javascript">
							function DeleteWishlistItem(wid)
							{
								 var dataString = 'wid='+ wid;
								 $.ajax({
											type: "POST",
											url: "wishlistdelete",
											data: dataString,
											cache: false,
									  success: function(result){
											if(result)
											{
												 if(result= 1)
												 {
													 $("#Hidediv"+wid).hide();
													  $.notify.defaults({
														className: "success"
													})
													$.notify("Removed From Wishlist", {
														position: "bottom left"
													});
												  
												 }
												 else
												 {
												  alert("DATA IS NOT DELETE");
												 }
											}
										   }
										});	
							}
						</script>
                        <!-- SCRIPT FOR DELETE WISHLIST ITEM -->
                        
                      <!-- REMOVE FROM WISHLIST -->
                      
                        <div class="item" id="Recent<?php echo $SelectWishListData[$w]['ProductID']; ?>">
                            <form id="Product_<?php echo $SelectWishListData[$w]['ProductID']; ?>" name="Product_<?php echo $SelectWishListData[$w]['ProductID']; ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" id="ProductID" name="ProductID" value="<?php echo $SelectWishListData[$w]['ProductID']; ?>" />
                            <div class="item-main" style="position: relative;">
                                <div class="item-inner">
                                    <div class="box-images"> 
                                     <?php
										$WPID = Encrypt('myPass123', $SelectWishListData[$w]['ProductID']);
										$WCID = Encrypt('myPass123', $SelectWishListData[$w]['CategoryID']);
									  ?>
                                        <a href="product-detail/<?php echo $WPID; ?>/<?php echo $WCID; ?>/<?php echo $SelectWishListData[$w]['ProductName'] ?>"  class="product-image"> 
                                            <img data-src="upload_data/productactualimage/large/<?php echo $SelectWishListData[$w]['ProductActualImage']; ?>" class="img-face lazy-hidden" alt="img"> 
											<img data-src="upload_data/producthoverimage/large/<?php echo $SelectWishListData[$w]['ProductHoverImage']; ?>" alt="img" class="img-face-back lazy-hidden"> 
                                        </a> 
                                     
										<div class="qiuck-tooltip">
											<span class="icon-fav quick-tooltip"><a href="javascript:void(0);" data-toggle="modal" data-target="#product-quick-veiw-modal<?php echo $SelectWishListData[$w]['ProductID']; ?>" class="link-wishlist text-gray" onClick = "QuickView(<?php echo $SelectWishListData[$w]['ProductID']; ?>);"><i class="fa fa-eye"></i></a></span>
											<span class="qiuckview">Qiuck View</span>
										</div>
                                    </div>
                                    
                                    <div class="product-shop">
                                    <div class="description">
                                    <h4 class="product-name"><a href="product-detail" ><?php echo $SelectWishListData[$w]['ProductName']; ?></a></h4>
                                    </div>
                                    
                                    <!-- WISHLIST PRODUCT PRICE -->
                                    <div class="price">
                                    <?php
										if((!empty($SelectWishListData[$w]['ProductDiscountType'])) && ($SelectWishListData[$w]['ProductDiscountAmount'] != "00"))
										{
										$ProductDiscountType = $SelectWishListData[$w]['ProductDiscountType'];
										if($ProductDiscountType == "Rupee")
										{
											$Price = $SelectWishListData[$w]['ProductPrice'] - $SelectWishListData[$w]['ProductDiscountAmount'];
											if(($Price) != ($SelectWishListData[$w]['ProductPrice']))
											{ 
                                    ?>
                                                <span class="cutprice"><i class="fa fa-inr"></i><?php echo $SelectWishListData[$w]['ProductPrice']; ?> /-</span>
                                                <input type="hidden" name="Price1" id="Price1" value="<?php echo  round($Price); ?>" />
                                    <?php 
                                        	} 
                                    ?>
                                            <span class="discount"><i class="fa fa-inr"></i><?php echo  round($Price); ?> /-</span>
                                            <input type="hidden" name="Price1" id="Price1" value="<?php echo  round($Price); ?>" />
                                    <?php
                                    	}
										if($ProductDiscountType == "Percentage")
										{
											$DiscountPrice = ($SelectWishListData[$w]['ProductDiscountAmount'] * $SelectWishListData[$w]['ProductPrice'])/100;
											$Price = $SelectWishListData[$w]['ProductPrice'] - $DiscountPrice;
											if(($Price) != ($SelectWishListData[$w]['ProductPrice']))
											{ 
                                    ?>
                                                <span class="cutprice"><i class="fa fa-inr"></i><?php echo $SelectWishListData[$w]['ProductPrice']; ?> /-</span>
                                                <input type="hidden" name="Price1" id="Price1" value="<?php echo  round($Price); ?>" />
                                    <?php
                                        	}
                                    ?>
                                            <span class="discount"><i class="fa fa-inr"></i><?php echo  round($Price); ?> /-</span>
                                            <input type="hidden" name="Price1" id="Price1" value="<?php echo  round($Price); ?>" />
                                    <?php
                                    	}
                                    	}
										else
										{
										$Price = $SelectWishListData[$r]['ProductPrice'];
                                    ?>
                                        <span class="discount"><i class="fa fa-inr"></i><?php echo  round($Price); ?> /-</span>
                                        <input type="hidden" name="Price1" id="Price1" value="<?php echo  round($Price); ?>" />
                                    <?php
                                    	}
                                    ?>
                                    
                                    </div>
                                    <!-- WISHLIST PRODUCT PRICE -->
                                    
                                    <div class="product-sectiononhover">
                                    
                                    <!-- WISHLIST PRODUCT SIZE -->
                                        <div class="size pdetailsize">
                                           
                                            
                                            <ul class="subcategory mt5">
												<?php
                                                    $ProductSize =explode(",",$SelectWishListData[$w]['ProductSize']);
                                                    $StockFlag = 0;
													for($p=0;$p<count($ProductSize);$p++)
                                                    {
														$SelectSizeID = $obj->sql_query("SELECT * FROM tbl_size WHERE SizeName = '".$ProductSize[$p]."'");
														$SelectSizeStock = $obj->sql_query("SELECT * FROM tbl_productsize_stockmanage WHERE ProductID = '".$SelectWishListData[$w]['ProductID']."' AND SizeID = '".$SelectSizeID[0]['SizeID']."'");
														if($SelectSizeStock[0]['ProductStock'] > 0)
														{
															$StockFlag = 1;
                                                ?>
                                                        <li onClick="addc_<?php echo $p; ?>_<?php echo $SelectWishListData[$w]['ProductID']; ?>();" id="S_<?php echo $p; ?>_<?php echo $SelectWishListData[$w]['ProductID']; ?>"><a href="#" id="Size_<?php echo $ProductSize[$p]; ?>_<?php echo $SelectWishListData[$w]['ProductID']; ?>"><?php echo strtoupper($ProductSize[$p]); ?></a></li>
                                                        <script>
                                                           function addc_<?php echo $p; ?>_<?php echo $SelectWishListData[$w]['ProductID']; ?>()
                                                           {
                                                            $('#S_<?php echo $p; ?>_<?php echo $SelectWishListData[$w]['ProductID']; ?>').addClass("size-active");
                                                            var a = $('#Size_<?php echo $ProductSize[$p]; ?>_<?php echo $SelectWishListData[$w]['ProductID']; ?>').html();
                                                            
                                                            document.getElementById('Size1_<?php echo $SelectWishListData[$w]['ProductID']; ?>').value = a;
                                                            var s = $("#Size1_<?php echo $SelectWishListData[$w]['ProductID']; ?>").val();
                                                            
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
                                                <input type="hidden" id="Size1_<?php echo $SelectWishListData[$w]['ProductID']; ?>" name="Size1_<?php echo $SelectWishListData[$w]['ProductID']; ?>" value="">  
                                            </ul>
                                        </div>
                                    <!-- WISHLIST PRODUCT SIZE -->
                                    
                                    <!-- ADD TO CART BUTTON -->
                                   
									<div class="add-to-Cartonhover">
										 <button type="submit" <?php if($StockFlag == 0){?> disabled <?php } ?> class="btn btn-primary button-subscribe btnshadow-nor btn-shopping-item btn-bluehover" id="AddToCartWishList<?php echo $SelectWishListData[$w]['ProductID']; ?>" onClick="message_show(<?php echo $SelectWishListData[$w]['ProductID']; ?>)" name="AddToCartSearchProduct<?php echo $SelectWishListData[$w]['ProductID']; ?>">
											<span class="add2cart"> Add to cart </span>
										 </button>
									</div>
                                    <!-- ADD TO CART BUTTON -->
                                    
                                    <!-- SCRIPT TO CART -->
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
													item_showF(cid);
																
													<?php
														for($rer=0;$rer<count($SelectWishListData);$rer++)
														{
														$ProductSizeR =explode(",",$SelectWishListData[$rer]['ProductSize']);
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
														}, 5000);
												}
											});
											var ac = $('.pdetailsize ul li.size-active').find('a').text();
											$('.hiddensize').text(ac);
											console.log(ac);
										} 
									}
                                    </script>
                                    <!-- SCRIPT TO CART -->
                                    </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                      </div>
                    </div>
					<?php
                    	}
                    ?>
                 <!-- </div>-->
              <?php
				}
				}
				?>
              <!-- WISHLIST IS NOT EMPTY --> 
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <div class = "seperator"></div>
</section>
<!-- DISPLAY WISHLIST PRODUCTS --> 

	<!-- REGISTER/LOGIN WITH FACEBOOK & GOOGLE + -->
    <?php include("includes/loginwithfbgp.php") ?>
    <!-- REGISTER/LOGIN WITH FACEBOOK & GOOGLE + -->
    
    <!-- LOGIN MODEL -->
    <?php include("includes/loginmodel.php"); ?>
    <!-- LOGIN MODEL -->
    
    <!-- INCLUDE FOOTER -->
    <?php include("includes/footer.php"); ?>
    <!-- INCLUDE FOOTER -->

<!-- QUICK VIEW -->
<div id = "openquickview"></div>
	
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
<!-- QUICK VIEW -->

   
    <!-- VALIDATION SCRIPT -->
    <script type="text/javascript" src="js/jquery.validate.js"></script>
    <!-- VALIDATION SCRIPT -->

</body>
</html>
