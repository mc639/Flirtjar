<?php
	/*----------File Information----------*/
	#Project : HASHTAG
	#File Created By : Mona Bera
	#File Created Date : 13 Jan 2016
	/*----------File Information----------*/
	
	include ("includes/connection.php");
	$obj = new myclass();
	
	session_start();
	
	$RegisterID = $_SESSION['RegisterID'];
	$pid = $_POST['pid'];
	$SelectProducts = $obj->sql_query("SELECT * FROM tbl_product WHERE Status = 'Active' AND ProductID = '".$pid."'");
	$SelectProductImage = $obj->sql_query("SELECT * FROM tbl_productimage WHERE ProductID = '".$pid."' ORDER BY DisplayOrder"); 
	
	$htmldata .= "<form id='ProductQuickView' name='ProductQuickView' method='post' enctype='multipart/form-data'>
    				<input type='hidden' id='ProductID' name='ProductID' value='".$pid."'/>
	<div id='product-quick-veiw-modal".$pid."' class='modal fade popmodalproduct' role='dialog' name = 'product-quick-veiw-modal_".$pid."'>
        <div class='modal-dialog'>
            <!-- Modal content-->
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' id='close' data-dismiss='modal' aria-hidden='true'>×</button>
                </div>
                <div class='modal-body'>
                    <div class='col-lg-5 col-md-5 col-sm-5  col-xs-12'>
                        <!-- bootstrap carousel -->
                        <div id='carousel-example-generic' class='carousel slide' data-ride='carousel' data-interval='false'>
                            <!-- Indicators -->
                            <ol class='carousel-indicators'>";
							for($pi=0;$pi<count($SelectProductImage);$pi++)
							{
								$htmldata .="<li data-target='#carousel-example-generic' data-slide-to='".$pi."' ";
								if($pi == 0)
								{
									$htmldata .= "class='active'";
								}
                                $htmldata .= "></li>";
							}
								
                            $htmldata .="</ol>
                            <!-- Wrapper for slides -->
                            <div class='carousel-inner'>";
							
							for($pi=0;$pi<count($SelectProductImage);$pi++)
							{
							
								$htmldata .="<div ";
								if($pi == 0)
								{
									$htmldata .= "class='item active srle'";
								}
								else
								{
									$htmldata .= "class='item'";
								}
								$htmldata .= ">
                                    <img src='upload_data/productimage/large/".$SelectProductImage[$pi]['ImageName']."' alt='1.jpg' class='img-responsive'>
                                    <div class='carousel-caption'>
                                    </div>
                                </div>";
							}
                           $htmldata .="</div>
                            <!-- Controls -->
                            <a class='left carousel-control' href='#carousel-example-generic' role='button' data-slide='prev'>
                                <span class='left-arraow'><i class='fa fa-angle-left f30'></i></span>
                            </a>
                            <a class='right carousel-control' href='#carousel-example-generic' role='button' data-slide='next'>
                                <span class='right-arrow'><i class='fa fa-angle-right f30'></i></span>
                            </a>
                            <!-- Thumbnails -->
                            <ul class='thumbnails-carousel clearfix'>";
							for($pi=0;$pi<count($SelectProductImage);$pi++)
							{
								$htmldata .="<li><img src='upload_data/productimage/thumb/".$SelectProductImage[$pi]['ImageName']."' alt='_tn.jpg'></li>";
							}	
                            $htmldata .="</ul>
                        </div>
                        <div class='clearfix'>&nbsp;</div>
                    </div>
                    <div class='col-lg-7 col-md-7 col-sm-7 col-xs-12 modal-details no-padding'>
                        <div class='modal-details-inner'>
                            <h1 class='product-title'> ".$SelectProducts[0]['ProductName']."</h1>
                            <div class='product-price'>Price : ";
								if((!empty($SelectProducts[0]['ProductDiscountType'])) && ($SelectProducts[0]['ProductDiscountAmount'] != "00"))
								{
									$ProductDiscountType = $SelectProducts[0]['ProductDiscountType'];
									if($ProductDiscountType == "Rupee")
									{
										$Price1 = $SelectProducts[0]['ProductPrice'] - $SelectProducts[0]['ProductDiscountAmount'];
										if(($Price1) != ($SelectProducts[0]['ProductPrice']))
										{ 
											$htmldata .="<span class='cutprice'><i class='fa fa-inr'></i>".$SelectProducts[0]['ProductPrice']." /-</span>"; 
										}
										$htmldata .="<span class='discount'><i class='fa fa-inr'></i>".round($Price1)." /-</span>
														<input type='hidden' name='Price1' id='Price1' value='".round($Price1)."'/>";
									}
									if($ProductDiscountType == "Percentage")
									{
										$DiscountPrice = ($SelectProducts[0]['ProductDiscountAmount'] * $SelectProducts[0]['ProductPrice'])/100;
										$Price1 = $SelectProducts[0]['ProductPrice'] - $DiscountPrice;
										if(($Price1) != ($SelectProducts[0]['ProductPrice']))
										{ 	
											$htmldata .="<span class='cutprice'><i class='fa fa-inr'></i>".$SelectProducts[0]['ProductPrice']." /-</span>"; 
										}
										$htmldata .="<span class='discount'><i class='fa fa-inr'></i>".round($Price1)." /-</span>
														<input type='hidden' name='Price1' id='Price1' value='".round($Price1)."'/>";
									}
								}
								else
								{
									$Price1 = $SelectProducts[0]['ProductPrice'];
								
								$htmldata .="<span class='discount'><i class='fa fa-inr'></i>".round($Price1)." /-</span>
															<input type='hidden' name='Price1' id='Price1' value='".round($Price1)."'/>";
								}
	
							$htmldata .="</div>
                            <div class='details-description'>
                                <p>".$SelectProducts[0]['ProductDescription']."</p>
                            </div>
                            <div class='row'>
                                <div class='col-md-6'>
                                    <div class='quantity'>
                                        <h3 class='quantity-detail-title'><strong>Quantity</strong></h3>
                                        <div class='ml0'>
                                           <input type='text' id='quantity' name='quantity' value='1' class='qty textbox-qty' />
                                        </div>
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class='size'>
                                        <h3 class='size-detail-title'><strong>Size</strong></h3>
                                        <ul class='subcategory mt5'>";
										 $ProductSize =explode(",",$SelectProducts[0]['ProductSize']);
										 $StockFlag = 0;
										for($p=0;$p<count($ProductSize);$p++)
										{
											$_SESSION['PROID'] = $pid;
											$SelectSizeID = $obj->sql_query("SELECT * FROM tbl_size WHERE SizeName = '".$ProductSize[$p]."'");
											$SelectSizeStock = $obj->sql_query("SELECT * FROM tbl_productsize_stockmanage WHERE ProductID = '".$SelectProducts[0]['ProductID']."' AND SizeID = '".$SelectSizeID[0]['SizeID']."'");
											if($SelectSizeStock[0]['ProductStock'] > 0)
											{
												$StockFlag = 1;
										
                                    $htmldata .="<li onClick='add_class_".$p."();' id='SActive_".$p."' name='SActive_".$p."' class = 'RemoveClass123'>
										<a href='javascript:void(0);' id='SizeForQuick_".$p."'>".strtoupper($ProductSize[$p])."</a>
									</li>
										<script>
                                                function add_class_".$p."()
                                                {
													removeALL();
                                                    $('#SActive_".$p."').addClass('size-active');
                                                    var a = $('#SizeForQuick_".$p."').html();
                                                    //alert(a);
													$('#SizeForQuickView').val(a);
                                                }
												function removeALL()
												{
													$('.RemoveClass123').removeClass('size-active');
												}
										</script>
                                           ";
											}
										}
										if($StockFlag == 0)
										{
											$htmldata .="<span style='color:red;'>Product out of stock</span>";
										}
										
                                        $htmldata .="<input type='hidden' id='SizeForQuickView' name='SizeForQuickView' value=''></ul>
                                    </div>
                                </div>
                            </div>
                            <div class='cart-actions pt50'>
                                <div class='addto'>
									<a class=";
									if($StockFlag == 0)
									{
										$htmldata .= "'btn btn-primary mr10 button-add-to-cart disabled'";
									}
									else
									{
										$htmldata .= "'btn btn-primary mr10 button-add-to-cart'";
									}
										
									$htmldata .= "id='AddToCartProductQuickView' onClick='message_showQuickView(".$pid.");' name='AddToCartProductQuickView'> <span class='add2cart'><i class='glyphicon glyphicon-shopping-cart'> </i> Add to cart </span> </a>
                                    <a class='btn btn-primary button-add-to-cart'  name='addtowishlist' id='addtowishlist' onClick='AddToWishlistQuickView(".$pid.");'> <span class='add2cart'><i class='fa fa-heart'></i> Add to Wishlist </span> </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='modal-footer'>
                </div>
            </div>
        </div>
    </div></form>";
	echo $htmldata;
?>
<script type="text/javascript" language = "javascript">
	function message_showQuickView(ProID)
	{
		var ProID = ProID;
		$.notify.defaults
		({
			className: 'error'
		})
		if ($('.size ul li').hasClass('size-active')) 
		{
			var si = $("#SizeForQuickView").val();
			var dataString = $('form#ProductQuickView').serialize();
			$.ajax
			({
				type: 'POST',
				url: 'cart_test_detail',
				cache: false,
				data: dataString,
				success:function(data)
				{
					document.getElementById('Totalcart').innerHTML = data;
					$.notify.defaults({
						className: 'success'
					})
					$.notify('Product successfully added to cart', {
						position: 'bottom left'
					});
					$('#product-quick-veiw-modal'+ProID).modal('hide');
					item_showPQuickView();
				}
			});
			
			var ac = $('.size ul li.size-active').find('a').text();
			$('.hiddensize').text(ac);
			console.log(ac);
		} 
		else 
		{
			$.notify('Please Select Size', 
			{
				position: 'bottom left'
			});
		}
	}
	function item_showPQuickView()
	{
		if ($('.size ul li').hasClass('size-active')) 
		{
			var dataString = $('form#ProductQuickView').serialize();
			$.ajax
			({
				type: 'POST',
				url: 'cart_itemtest',
				cache: false,
				data: dataString,
				success:function(data)
				{
					document.getElementById('ulcart').innerHTML = data;
					$('#ulcart').show();
					window.setInterval(function() {
					 $("#ulcart").hide();
					},  5000);
				}
			});
			var ac = $('.size ul li.size-active').find('a').text();
			$('.hiddensize').text(ac);
			console.log(ac);
			
		} 
	}
	
	function AddToWishlistQuickView(fid)
	{
		var dataString = 'fid='+ fid;
		
		<?php
			if(empty($_SESSION['RegisterID']))
			{
		?>		
				$("#close").trigger('click');
				//$('#login-overlay').modal('show');
				location.href = "login?from=<?php echo $_SESSION['Rdi']; ?>";
				
		<?php
			}
			else
			{
		?>		
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
						$('#product-quick-veiw-modal'+fid).modal('hide');
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