<?php
	/*----------File Information----------*/
	#Project : HashTag
	#File Created By : Avani Trivedi 
	#File Created Date : 20 Jan 2016
	#File Edited By :
	#File Edited Date :
	/*----------File Information----------*/
	
	include ("includes/connection.php");
	$obj = new myclass();
	session_start();
	include("includes/encrypt.php");
	if(!empty($_POST['Search']))
	{
		$a1 = $_POST['Search'];
	}
	if(!empty($_GET['Search']))
	{
		$b = $_GET['Search'];
		
		$a1 = str_replace("-"," ",$b);
		
	}
	
	/* FOR PRICE LEFT MENU */
	$data = $_GET['data'];
	$PricerangeCount = substr_count($data,",");
	$PricerangeCount = $PricerangeCount+1;
	$temp1   = explode(',',$data);
	foreach($temp1 as $key => $value)
	{
		if($key % 2 == 0)
		{
			$MinOdd[] = $value;
		}	
		else
		{
			$MaxEven[] = $value;
			$a = $MaxEven[$key][$value];
			
		}
	}
	$OptionInTest =array_slice($temp1,0,2);
	$new_str = implode(',', $OptionInTest);
	/* FOR PRICE LEFT MENU */
	
	/* FOR SIZE LEFT MENU */
	$Psi = ($_GET['size']);
	$temp2   = explode(',',$Psi);
	$SizeCount = substr_count($Psi,",");
	$SizeCount = $SizeCount+1;
	/* FOR SIZE LEFT MENU */
	
	/* FOR CATEGORY LEFT MENU */
	$CategoryID = ($_GET['CategoryID']);
	//echo $CategoryID; exit;
	$temp3   = explode(',',$CategoryID);
	$CategoryCount = substr_count($CategoryID,",");
	$CategoryCount = $CategoryCount+1;
	/* FOR CATEGORY LEFT MENU */
	
	/* FOR HIGH PRICE */
	$HighPrice = $_GET['highprice'];
	/* FOR HIGH PRICE */
	
	/* FOR LOW PRICE */
	$LowPrice = $_GET['lowprice'];
	/* FOR LOW PRICE */
	
	/* FOR POPULARITY */
	$Popularity = $_GET['popularity'];
	/* FOR POPULARITY */
	
	/* FOR ALL PRODUCT */
	$AllProduct = "SELECT p.ProductID,p.ProductDiscountAmount, p.ProductDiscountType, p.Status, p.ProductSize, p.CategoryID, p.ProductName, p.ProductActualImage, p.ProductHoverImage, p.ProductPrice, c.*,pi.ProductID, pi.ImageName FROM tbl_category AS c INNER JOIN tbl_product AS p ON c.CategoryID = p.CategoryID OR c.ParentCategoryID = p.CategoryID INNER JOIN tbl_productimage AS pi ON p.ProductID = pi.ProductID WHERE (c.CategoryName LIKE '%".$a1."%' OR p.ProductName LIKE '%".$a1."%') AND p.Status = 'Active' ";
	/* FOR ALL PRODUCT */
	
	/* FOR PRICE LEFT MENU */
	if(!empty($data))
	{
		if((!empty($_GET['data'])) && (!empty($_GET['highprice'])) && (!empty($_GET['size'])))
		{
			if((!empty($_GET['data'])) && (!empty($_GET['highprice'])) && (!empty($_GET['size'])) && (!empty($_GET['CategoryID'])))
			{
				$AllProduct.=" AND (";
				for($cs=0;$cs<$SizeCount;$cs++)
				{
					$AllProduct .="(p.ProductSize REGEXP  ',$temp2[$cs]$' OR  p.ProductSize REGEXP  ',$temp2[$cs],' OR  p.ProductSize REGEXP  '$$temp2[$cs],' OR p.ProductSize REGEXP  '^$temp2[$cs]$' OR p.ProductSize REGEXP  '$temp2[$cs],') ";	
					if($cs<$SizeCount-1)
					{
						$AllProduct .="OR ";
					}
				}
					$AllProduct .=" ) AND (";
					$mypricecount = $PricerangeCount/2;
					for($pc=0;$pc<$mypricecount;$pc++)
					{
						$AllProduct .=" (p.ProductPrice >= '".$MinOdd[$pc]."' AND p.ProductPrice <= '".$MaxEven[$pc]."')";
						if($pc<$mypricecount-1)
						{
							$AllProduct .=" OR ";
						}
						
					}
					$AllProduct.=" ) AND (";
					for($cc=0;$cc<$CategoryCount;$cc++)
					{
						$AllProduct .="((c.CategoryID = p.CategoryID OR p.CategoryID =  '".$temp3[$cc]."') AND (c.ParentCategoryID =  '".$temp3[$cc]."' OR c.CategoryID =  '".$temp3[$cc]."'))";	
						if($cc<$CategoryCount-1)
						{
							$AllProduct .=" OR ";
						}
						
					}
					$AllProduct .=" )GROUP BY p.ProductName ORDER BY p.ProductPrice DESC"; 
			}
			else
			{
				$AllProduct.=" AND (";
				for($cs=0;$cs<$SizeCount;$cs++)
				{
					$AllProduct .="(p.ProductSize REGEXP  ',$temp2[$cs]$' OR  p.ProductSize REGEXP  ',$temp2[$cs],' OR  p.ProductSize REGEXP  '$$temp2[$cs],' OR p.ProductSize REGEXP  '^$temp2[$cs]$' OR p.ProductSize REGEXP  '$temp2[$cs],') ";	
					if($cs<$SizeCount-1)
					{
						$AllProduct .="OR ";
					}
				}
					$AllProduct .=" ) AND (";
					$mypricecount = $PricerangeCount/2;
					for($pc=0;$pc<$mypricecount;$pc++)
					{
						$AllProduct .=" (p.ProductPrice >= '".$MinOdd[$pc]."' AND p.ProductPrice <= '".$MaxEven[$pc]."')";
						if($pc<$mypricecount-1)
						{
							$AllProduct .=" OR ";
						}
						
					}
					$AllProduct .=")  GROUP BY p.ProductName ORDER BY p.ProductPrice DESC"; 
			}
		}
		elseif((!empty($_GET['data'])) && (!empty($_GET['lowprice'])) && (!empty($_GET['size'])))
		{
			if((!empty($_GET['data'])) && (!empty($_GET['lowprice'])) && (!empty($_GET['size'])) && (!empty($_GET['CategoryID'])))
			{
				$AllProduct.=" AND (";
				for($cs=0;$cs<$SizeCount;$cs++)
				{
					$AllProduct .="(p.ProductSize REGEXP  ',$temp2[$cs]$' OR  p.ProductSize REGEXP  ',$temp2[$cs],' OR  p.ProductSize REGEXP  '$$temp2[$cs],' OR p.ProductSize REGEXP  '^$temp2[$cs]$' OR p.ProductSize REGEXP  '$temp2[$cs],') ";	
					if($cs<$SizeCount-1)
					{
						$AllProduct .="OR ";
					}
				}
					$AllProduct .=" ) AND (";
					$mypricecount = $PricerangeCount/2;
					for($pc=0;$pc<$mypricecount;$pc++)
					{
						$AllProduct .=" (p.ProductPrice >= '".$MinOdd[$pc]."' AND p.ProductPrice <= '".$MaxEven[$pc]."')";
						if($pc<$mypricecount-1)
						{
							$AllProduct .=" OR ";
						}
						
					}
					$AllProduct.=" ) AND (";
					for($cc=0;$cc<$CategoryCount;$cc++)
					{
						$AllProduct .="((c.CategoryID = p.CategoryID OR p.CategoryID =  '".$temp3[$cc]."') AND (c.ParentCategoryID =  '".$temp3[$cc]."' OR c.CategoryID =  '".$temp3[$cc]."'))";	
						if($cc<$CategoryCount-1)
						{
							$AllProduct .=" OR ";
						}
						
					}
					$AllProduct .=" ) GROUP BY p.ProductName ORDER BY p.ProductPrice ASC"; 
			}
			else
			{
				$AllProduct.=" AND (";
				for($cs=0;$cs<$SizeCount;$cs++)
				{
					$AllProduct .="(p.ProductSize REGEXP  ',$temp2[$cs]$' OR  p.ProductSize REGEXP  ',$temp2[$cs],' OR  p.ProductSize REGEXP  '$$temp2[$cs],' OR p.ProductSize REGEXP  '^$temp2[$cs]$' OR p.ProductSize REGEXP  '$temp2[$cs],') ";	
					if($cs<$SizeCount-1)
					{
						$AllProduct .="OR ";
					}
				}
					$AllProduct .=" ) AND (";
					$mypricecount = $PricerangeCount/2;
					for($pc=0;$pc<$mypricecount;$pc++)
					{
						$AllProduct .=" (p.ProductPrice >= '".$MinOdd[$pc]."' AND p.ProductPrice <= '".$MaxEven[$pc]."')";
						if($pc<$mypricecount-1)
						{
							$AllProduct .=" OR ";
						}
						
					}
					$AllProduct .=" )GROUP BY p.ProductName ORDER BY p.ProductPrice ASC"; 
			}
			
		}
		
		/* SIZE - POPULARITY - DATA */
		elseif((!empty($_GET['data'])) && (!empty($_GET['popularity'])) && (!empty($_GET['size'])))
		{
			if((!empty($_GET['data'])) && (!empty($_GET['popularity'])) && (!empty($_GET['size'])) && (!empty($_GET['CategoryID'])))
			{
				$AllProduct.=" AND (";
				for($cs=0;$cs<$SizeCount;$cs++)
				{
					$AllProduct .="(p.ProductSize REGEXP  ',$temp2[$cs]$' OR  p.ProductSize REGEXP  ',$temp2[$cs],' OR  p.ProductSize REGEXP  '$$temp2[$cs],' OR p.ProductSize REGEXP  '^$temp2[$cs]$' OR p.ProductSize REGEXP  '$temp2[$cs],') ";	
					if($cs<$SizeCount-1)
					{
						$AllProduct .="OR ";
					}
				}
					$AllProduct .=" ) AND (";
					$mypricecount = $PricerangeCount/2;
					for($pc=0;$pc<$mypricecount;$pc++)
					{
						$AllProduct .=" (p.ProductPrice >= '".$MinOdd[$pc]."' AND p.ProductPrice <= '".$MaxEven[$pc]."')";
						if($pc<$mypricecount-1)
						{
							$AllProduct .=" OR ";
						}
						
					}
					$AllProduct.=" ) AND ( ";
					for($cc=0;$cc<$CategoryCount;$cc++)
					{
						$AllProduct .="((c.CategoryID = p.CategoryID OR p.CategoryID =  '".$temp3[$cc]."') AND (c.ParentCategoryID =  '".$temp3[$cc]."' OR c.CategoryID =  '".$temp3[$cc]."'))";	
						if($cc<$CategoryCount-1)
						{
							$AllProduct .=" OR ";
						}
						
					}
					$AllProduct .=" ) GROUP BY p.ProductName ORDER BY p.ProductSoldCount DESC"; 
			}
			else
			{
				$AllProduct.=" AND (";
				for($cs=0;$cs<$SizeCount;$cs++)
				{
					$AllProduct .="(p.ProductSize REGEXP  ',$temp2[$cs]$' OR  p.ProductSize REGEXP  ',$temp2[$cs],' OR  p.ProductSize REGEXP  '$$temp2[$cs],' OR p.ProductSize REGEXP  '^$temp2[$cs]$' OR p.ProductSize REGEXP  '$temp2[$cs],') ";	
					if($cs<$SizeCount-1)
					{
						$AllProduct .="OR ";
					}
				}
					$AllProduct .=" ) AND (";
					$mypricecount = $PricerangeCount/2;
					for($pc=0;$pc<$mypricecount;$pc++)
					{
						$AllProduct .=" (p.ProductPrice >= '".$MinOdd[$pc]."' AND p.ProductPrice <= '".$MaxEven[$pc]."')";
						if($pc<$mypricecount-1)
						{
							$AllProduct .=" OR ";
						}
						
					}
					$AllProduct .=" )GROUP BY p.ProductName ORDER BY p.ProductSoldCount DESC"; 
			}
		}
		/* SIZE - POPULARITY - DATA */
		
		elseif((!empty($_GET['size'])) && (!empty($_GET['data'])))
		{
			if((!empty($_GET['size'])) && (!empty($_GET['data']) && (!empty($_GET['CategoryID']))))
			{
				$AllProduct.=" AND (";
				for($cs=0;$cs<$SizeCount;$cs++)
				{
					$AllProduct .="(p.ProductSize REGEXP  ',$temp2[$cs]$' OR  p.ProductSize REGEXP  ',$temp2[$cs],' OR  p.ProductSize REGEXP  '$$temp2[$cs],' OR p.ProductSize REGEXP  '^$temp2[$cs]$' OR p.ProductSize REGEXP  '$temp2[$cs],') ";	
					if($cs<$SizeCount-1)
					{
						$AllProduct .="OR ";
					}
				}
					$AllProduct .=" ) AND (";
					$mypricecount = $PricerangeCount/2;
					for($pc=0;$pc<$mypricecount;$pc++)
					{
						$AllProduct .=" (p.ProductPrice >= '".$MinOdd[$pc]."' AND p.ProductPrice <= '".$MaxEven[$pc]."')";
						if($pc<$mypricecount-1)
						{
							$AllProduct .=" OR ";
						}
						
					}
					$AllProduct.=" ) AND (";
					for($cc=0;$cc<$CategoryCount;$cc++)
					{
						$AllProduct .="((c.CategoryID = p.CategoryID OR p.CategoryID =  '".$temp3[$cc]."') AND (c.ParentCategoryID =  '".$temp3[$cc]."' OR c.CategoryID =  '".$temp3[$cc]."'))";	
						if($cc<$CategoryCount-1)
						{
							$AllProduct .=" OR ";
						}
						
					}
					$AllProduct .=" ) GROUP BY p.ProductName ORDER BY p.ProductPrice"; 
			}
			else
			{
				$AllProduct.=" AND (";
				for($cs=0;$cs<$SizeCount;$cs++)
				{
					$AllProduct .="(p.ProductSize REGEXP  ',$temp2[$cs]$' OR  p.ProductSize REGEXP  ',$temp2[$cs],' OR  p.ProductSize REGEXP  '$$temp2[$cs],' OR p.ProductSize REGEXP  '^$temp2[$cs]$' OR p.ProductSize REGEXP  '$temp2[$cs],') ";	
					if($cs<$SizeCount-1)
					{
						$AllProduct .="OR ";
					}
				}
					$AllProduct .=" ) AND ( ";
					$mypricecount = $PricerangeCount/2;
					for($pc=0;$pc<$mypricecount;$pc++)
					{
						$AllProduct .=" (p.ProductPrice >= '".$MinOdd[$pc]."' AND p.ProductPrice <= '".$MaxEven[$pc]."')";
						if($pc<$mypricecount-1)
						{
							$AllProduct .=" OR ";
						}
						
					}
					$AllProduct .=" ) GROUP BY p.ProductName ORDER BY p.ProductPrice"; 
			}				
		}
		elseif((!empty($_GET['data'])) && (!empty($_GET['lowprice'])))
		{
			if((!empty($_GET['data'])) && (!empty($_GET['lowprice']))  && (!empty($_GET['CategoryID'])))
			{
				$AllProduct .=" AND (";
				$mypricecount = $PricerangeCount/2;
				for($pc=0;$pc<$mypricecount;$pc++)
				{
					$AllProduct .=" (p.ProductPrice >= '".$MinOdd[$pc]."' AND p.ProductPrice <= '".$MaxEven[$pc]."')";
					if($pc<$mypricecount-1)
					{
						$AllProduct .=" OR ";
					}
					
				}
				$AllProduct.=" ) AND (";
				for($cc=0;$cc<$CategoryCount;$cc++)
				{
					$AllProduct .="((c.CategoryID = p.CategoryID OR p.CategoryID =  '".$temp3[$cc]."') AND (c.ParentCategoryID =  '".$temp3[$cc]."' OR c.CategoryID =  '".$temp3[$cc]."'))";	
					if($cc<$CategoryCount-1)
					{
						$AllProduct .=" OR ";
					}
					
				}
				$AllProduct .=" ) GROUP BY p.ProductName ORDER BY p.ProductPrice ASC"; 

			}
			else
			{
				$AllProduct .=" AND ";
				$mypricecount = $PricerangeCount/2;
				$AllProduct.=" (";
				for($pc=0;$pc<$mypricecount;$pc++)
				{
					$AllProduct .=" (p.ProductPrice >= '".$MinOdd[$pc]."' AND p.ProductPrice <= '".$MaxEven[$pc]."')";
					if($pc<$mypricecount-1)
					{
						$AllProduct .=" OR ";
					}
					
				}
				$AllProduct .=" ) GROUP BY p.ProductName ORDER BY p.ProductPrice ASC"; 
			}
		}
		elseif((!empty($_GET['data'])) && (!empty($_GET['highprice'])))
		{
			if((!empty($_GET['data'])) && (!empty($_GET['highprice']))  && (!empty($_GET['CategoryID'])))
			{
				$AllProduct .=" AND ( ";
				$mypricecount = $PricerangeCount/2;
				for($pc=0;$pc<$mypricecount;$pc++)
				{
					$AllProduct .=" (p.ProductPrice >= '".$MinOdd[$pc]."' AND p.ProductPrice <= '".$MaxEven[$pc]."')";
					if($pc<$mypricecount-1)
					{
						$AllProduct .=" OR ";
					}
					
				}
				$AllProduct.=" ) AND ( ";
				for($cc=0;$cc<$CategoryCount;$cc++)
				{
					$AllProduct .="((c.CategoryID = p.CategoryID OR p.CategoryID =  '".$temp3[$cc]."') AND (c.ParentCategoryID =  '".$temp3[$cc]."' OR c.CategoryID =  '".$temp3[$cc]."'))";	
					if($cc<$CategoryCount-1)
					{
						$AllProduct .=" OR ";
					}
					
				}
				$AllProduct .=" ) GROUP BY p.ProductName ORDER BY p.ProductPrice DESC"; 
			}
			else
			{
				$AllProduct .=" AND ( ";
				$mypricecount = $PricerangeCount/2;
				for($pc=0;$pc<$mypricecount;$pc++)
				{
					$AllProduct .=" (p.ProductPrice >= '".$MinOdd[$pc]."' AND p.ProductPrice <= '".$MaxEven[$pc]."')";
					if($pc<$mypricecount-1)
					{
						$AllProduct .=" OR ";
					}
					
				}
				$AllProduct .=" ) GROUP BY p.ProductName ORDER BY p.ProductPrice DESC"; 
			}
		}
		
		/* DATA - POPULARITY */
		elseif((!empty($_GET['data'])) && (!empty($_GET['popularity'])))
		{
			if((!empty($_GET['data'])) && (!empty($_GET['popularity'])) && (!empty($_GET['CategoryID'])))
			{
				$AllProduct .=" AND ( ";
				$mypricecount = $PricerangeCount/2;
				for($pc=0;$pc<$mypricecount;$pc++)
				{
					$AllProduct .=" (p.ProductPrice >= '".$MinOdd[$pc]."' AND p.ProductPrice <= '".$MaxEven[$pc]."')";
					if($pc<$mypricecount-1)
					{
						$AllProduct .=" OR ";
					}
					
				}
				$AllProduct.=" ) AND (";
				for($cc=0;$cc<$CategoryCount;$cc++)
				{
					$AllProduct .="((c.CategoryID = p.CategoryID OR p.CategoryID =  '".$temp3[$cc]."') AND (c.ParentCategoryID =  '".$temp3[$cc]."' OR c.CategoryID =  '".$temp3[$cc]."'))";	
					if($cc<$CategoryCount-1)
					{
						$AllProduct .=" OR ";
					}
					
				}
				$AllProduct .=" ) GROUP BY p.ProductName ORDER BY p.ProductSoldCount DESC"; 
			}
			else
			{
				$AllProduct .=" AND (";
				$mypricecount = $PricerangeCount/2;
				for($pc=0;$pc<$mypricecount;$pc++)
				{
					$AllProduct .=" (p.ProductPrice >= '".$MinOdd[$pc]."' AND p.ProductPrice <= '".$MaxEven[$pc]."')";
					if($pc<$mypricecount-1)
					{
						$AllProduct .=" OR ";
					}
					
				}
				$AllProduct .=" ) GROUP BY p.ProductName ORDER BY p.ProductSoldCount DESC"; 
			}
		}
		/* DATA - POPULARITY */
		
		else
		{
			$AllProduct .=" AND ";
			$mypricecount = $PricerangeCount/2;
			for($pc=0;$pc<$mypricecount;$pc++)
			{
				$AllProduct .=" (p.ProductPrice >= '".$MinOdd[$pc]."' AND p.ProductPrice <= '".$MaxEven[$pc]."') ";
				if($pc<$mypricecount-1)
				{
					$AllProduct .=" OR ";
				}
				
			}
			$AllProduct .=" GROUP BY p.ProductName ORDER BY p.ProductPrice"; 
		}
		
	}
	/* FOR PRICE LEFT MENU */
	
	/* FOR SIZE LEFT MENU (SIZE->HIGHPRICE) */
	elseif(!empty($Psi))
	{
		if((!empty($_GET['size'])) && (!empty($_GET['data'])) && (!empty($_GET['highprice'])))
		{
			if((!empty($_GET['size'])) && (!empty($_GET['data'])) && (!empty($_GET['highprice'])) && (!empty($_GET['CategoryID'])))
			{
				$AllProduct.=" AND (";
				for($cs=0;$cs<$SizeCount;$cs++)
				{
					$AllProduct .="(p.ProductSize REGEXP  ',$temp2[$cs]$' OR  p.ProductSize REGEXP  ',$temp2[$cs],' OR  p.ProductSize REGEXP  '$$temp2[$cs],' OR p.ProductSize REGEXP  '^$temp2[$cs]$' OR p.ProductSize REGEXP  '$temp2[$cs],') ";	
					if($cs<$SizeCount-1)
					{
						$AllProduct .="OR ";
					}
				}
				$AllProduct.=" ) AND (";
				for($cc=0;$cc<$CategoryCount;$cc++)
				{
					$AllProduct .="((c.CategoryID = p.CategoryID OR p.CategoryID =  '".$temp3[$cc]."') AND (c.ParentCategoryID =  '".$temp3[$cc]."' OR c.CategoryID =  '".$temp3[$cc]."'))";	
					if($cc<$CategoryCount-1)
					{
						$AllProduct .=" OR ";
					}
					
				}
				$AllProduct .=" ) GROUP BY p.ProductName ORDER BY p.ProductPrice DESC";	
			}
			else
			{
				$AllProduct.=" AND (";
				for($cs=0;$cs<$SizeCount;$cs++)
				{
					$AllProduct .="(p.ProductSize REGEXP  ',$temp2[$cs]$' OR  p.ProductSize REGEXP  ',$temp2[$cs],' OR  p.ProductSize REGEXP  '$$temp2[$cs],' OR p.ProductSize REGEXP  '^$temp2[$cs]$' OR p.ProductSize REGEXP  '$temp2[$cs],') ";	
					if($cs<$SizeCount-1)
					{
						$AllProduct .="OR ";
					}
				}
					$AllProduct .=" ) GROUP BY p.ProductName ORDER BY p.ProductPrice DESC";	
			}
		}
		
		elseif((!empty($_GET['size'])) && (!empty($_GET['data'])) && (!empty($_GET['lowprice'])))
		{
			if((!empty($_GET['size'])) && (!empty($_GET['data'])) && (!empty($_GET['lowprice'])) && (!empty($_GET['CategoryID'])))
			{
				$AllProduct.=" AND (";
				for($cs=0;$cs<$SizeCount;$cs++)
				{
					$AllProduct .="(p.ProductSize REGEXP  ',$temp2[$cs]$' OR  p.ProductSize REGEXP  ',$temp2[$cs],' OR  p.ProductSize REGEXP  '$$temp2[$cs],' OR p.ProductSize REGEXP  '^$temp2[$cs]$' OR p.ProductSize REGEXP  '$temp2[$cs],') ";	
					if($cs<$SizeCount-1)
					{
						$AllProduct .="OR ";
					}
				}
					$AllProduct.=" ) AND ( ";
				for($cc=0;$cc<$CategoryCount;$cc++)
				{
					$AllProduct .="((c.CategoryID = p.CategoryID OR p.CategoryID =  '".$temp3[$cc]."') AND (c.ParentCategoryID =  '".$temp3[$cc]."' OR c.CategoryID =  '".$temp3[$cc]."'))";	
					if($cc<$CategoryCount-1)
					{
						$AllProduct .=" OR ";
					}
					
				}
					$AllProduct .=" ) GROUP BY p.ProductName ORDER BY p.ProductPrice ASC";	

			}
			else
			{
				$AllProduct.=" AND (";
				for($cs=0;$cs<$SizeCount;$cs++)
				{
					$AllProduct .="(p.ProductSize REGEXP  ',$temp2[$cs]$' OR  p.ProductSize REGEXP  ',$temp2[$cs],' OR  p.ProductSize REGEXP  '$$temp2[$cs],' OR p.ProductSize REGEXP  '^$temp2[$cs]$' OR p.ProductSize REGEXP  '$temp2[$cs],') ";	
					if($cs<$SizeCount-1)
					{
						$AllProduct .="OR ";
					}
				}
					$AllProduct .=" ) GROUP BY p.ProductName ORDER BY p.ProductPrice ASC";	
			}
		}
		
		/* SIZE - POPULARITY - DATA */		
		elseif((!empty($_GET['size'])) && (!empty($_GET['data'])) && (!empty($_GET['popularity'])))
		{
			if((!empty($_GET['size'])) && (!empty($_GET['data'])) && (!empty($_GET['popularity'])) && (!empty($_GET['CategoryID'])))
			{
				$AllProduct.=" AND (";
				for($cs=0;$cs<$SizeCount;$cs++)
				{
					$AllProduct .="(p.ProductSize REGEXP  ',$temp2[$cs]$' OR  p.ProductSize REGEXP  ',$temp2[$cs],' OR  p.ProductSize REGEXP  '$$temp2[$cs],' OR p.ProductSize REGEXP  '^$temp2[$cs]$' OR p.ProductSize REGEXP  '$temp2[$cs],') ";	
					if($cs<$SizeCount-1)
					{
						$AllProduct .="OR ";
					}
				}
				$AllProduct.=" ) AND (";
				for($cc=0;$cc<$CategoryCount;$cc++)
				{
					$AllProduct .="((c.CategoryID = p.CategoryID OR p.CategoryID =  '".$temp3[$cc]."') AND (c.ParentCategoryID =  '".$temp3[$cc]."' OR c.CategoryID =  '".$temp3[$cc]."'))";	
					if($cc<$CategoryCount-1)
					{
						$AllProduct .=" OR ";
					}
					
				}
				$AllProduct .=" ) GROUP BY p.ProductName ORDER BY p.ProductSoldCount DESC";	
			}
			else
			{
				$AllProduct.=" AND (";
				for($cs=0;$cs<$SizeCount;$cs++)
				{
					$AllProduct .="(p.ProductSize REGEXP  ',$temp2[$cs]$' OR  p.ProductSize REGEXP  ',$temp2[$cs],' OR  p.ProductSize REGEXP  '$$temp2[$cs],' OR p.ProductSize REGEXP  '^$temp2[$cs]$' OR p.ProductSize REGEXP  '$temp2[$cs],') ";	
					if($cs<$SizeCount-1)
					{
						$AllProduct .="OR ";
					}
				}
					$AllProduct .=" ) GROUP BY p.ProductName ORDER BY p.ProductSoldCount DESC";	
			}
			
		}
		/* SIZE - POPULARITY - DATA */
		
		/* SIZE - POPULARITY */
		elseif((!empty($_GET['size'])) && (!empty($_GET['popularity'])))
		{
			if((!empty($_GET['size'])) && (!empty($_GET['popularity'])) && (!empty($_GET['CategoryID'])))
			{
				$AllProduct.=" AND (";
				for($cs=0;$cs<$SizeCount;$cs++)
				{
					$AllProduct .="(p.ProductSize REGEXP  ',$temp2[$cs]$' OR  p.ProductSize REGEXP  ',$temp2[$cs],' OR  p.ProductSize REGEXP  '$$temp2[$cs],' OR p.ProductSize REGEXP  '^$temp2[$cs]$' OR p.ProductSize REGEXP  '$temp2[$cs],') ";	
					if($cs<$SizeCount-1)
					{
						$AllProduct .="OR ";
					}
				}
				$AllProduct.=" ) AND (";
				for($cc=0;$cc<$CategoryCount;$cc++)
				{
					$AllProduct .="((c.CategoryID = p.CategoryID OR p.CategoryID =  '".$temp3[$cc]."') AND (c.ParentCategoryID =  '".$temp3[$cc]."' OR c.CategoryID =  '".$temp3[$cc]."'))";	
					if($cc<$CategoryCount-1)
					{
						$AllProduct .=" OR ";
					}
					
				}
				$AllProduct .=" ) GROUP BY p.ProductName ORDER BY p.ProductSoldCount DESC";	

			}
			else
			{
				$AllProduct.=" AND (";
				for($cs=0;$cs<$SizeCount;$cs++)
				{
					$AllProduct .="(p.ProductSize REGEXP  ',$temp2[$cs]$' OR  p.ProductSize REGEXP  ',$temp2[$cs],' OR  p.ProductSize REGEXP  '$$temp2[$cs],' OR p.ProductSize REGEXP  '^$temp2[$cs]$' OR p.ProductSize REGEXP  '$temp2[$cs],') ";	
					if($cs<$SizeCount-1)
					{
						$AllProduct .="OR ";
					}
				}
					$AllProduct .=" ) GROUP BY p.ProductName ORDER BY p.ProductSoldCount DESC";	
			}
		}
		/* SIZE - POPULARITY */
		
		/* SIZE - HIGHPRICE */
		elseif((!empty($_GET['size'])) && (!empty($_GET['highprice'])))
		{
			if((!empty($_GET['size'])) && (!empty($_GET['highprice'])) && (!empty($_GET['CategoryID'])))
			{
				$AllProduct.=" AND (";
				for($cs=0;$cs<$SizeCount;$cs++)
				{
					$AllProduct .="(p.ProductSize REGEXP  ',$temp2[$cs]$' OR  p.ProductSize REGEXP  ',$temp2[$cs],' OR  p.ProductSize REGEXP  '$$temp2[$cs],' OR p.ProductSize REGEXP  '^$temp2[$cs]$' OR p.ProductSize REGEXP  '$temp2[$cs],') ";	
					if($cs<$SizeCount-1)
					{
						$AllProduct .="OR ";
					}
				}
				$AllProduct.=" ) AND (";
				for($cc=0;$cc<$CategoryCount;$cc++)
				{
					$AllProduct .="((c.CategoryID = p.CategoryID OR p.CategoryID =  '".$temp3[$cc]."') AND (c.ParentCategoryID =  '".$temp3[$cc]."' OR c.CategoryID =  '".$temp3[$cc]."'))";	
					if($cc<$CategoryCount-1)
					{
						$AllProduct .=" OR ";
					}
					
				}
				$AllProduct .=" ) GROUP BY p.ProductName ORDER BY p.ProductPrice DESC";
			}
			else
			{
				$AllProduct.=" AND (";
				for($cs=0;$cs<$SizeCount;$cs++)
				{
					$AllProduct .="(p.ProductSize REGEXP  ',$temp2[$cs]$' OR  p.ProductSize REGEXP  ',$temp2[$cs],' OR  p.ProductSize REGEXP  '$$temp2[$cs],' OR p.ProductSize REGEXP  '^$temp2[$cs]$' OR p.ProductSize REGEXP  '$temp2[$cs],') ";	
					if($cs<$SizeCount-1)
					{
						$AllProduct .="OR ";
					}
				}
					$AllProduct .=" ) GROUP BY p.ProductName ORDER BY p.ProductPrice DESC";
			}
		}
		/* SIZE - HIGHPRICE */
		
		/* SIZE - LOWPRICE */
		elseif((!empty($_GET['size'])) && (!empty($_GET['lowprice'])))
		{
			if((!empty($_GET['size'])) && (!empty($_GET['lowprice']))&& (!empty($_GET['CategoryID'])))
			{
				$AllProduct.=" AND (";
				for($cs=0;$cs<$SizeCount;$cs++)
				{
					$AllProduct .="(p.ProductSize REGEXP  ',$temp2[$cs]$' OR  p.ProductSize REGEXP  ',$temp2[$cs],' OR  p.ProductSize REGEXP  '$$temp2[$cs],' OR p.ProductSize REGEXP  '^$temp2[$cs]$' OR p.ProductSize REGEXP  '$temp2[$cs],') ";	
					if($cs<$SizeCount-1)
					{
						$AllProduct .="OR ";
					}
				}
				$AllProduct.=" ) AND (";
				for($cc=0;$cc<$CategoryCount;$cc++)
				{
					$AllProduct .="((c.CategoryID = p.CategoryID OR p.CategoryID =  '".$temp3[$cc]."') AND (c.ParentCategoryID =  '".$temp3[$cc]."' OR c.CategoryID =  '".$temp3[$cc]."'))";	
					if($cc<$CategoryCount-1)
					{
						$AllProduct .=" OR ";
					}
					
				}
				$AllProduct .=" ) GROUP BY p.ProductName ORDER BY p.ProductPrice ASC";	
				
			}
			else
			{
				$AllProduct.=" AND (";
				for($cs=0;$cs<$SizeCount;$cs++)
				{
					$AllProduct .="(p.ProductSize REGEXP  ',$temp2[$cs]$' OR  p.ProductSize REGEXP  ',$temp2[$cs],' OR  p.ProductSize REGEXP  '$$temp2[$cs],' OR p.ProductSize REGEXP  '^$temp2[$cs]$' OR p.ProductSize REGEXP  '$temp2[$cs],') ";	
					if($cs<$SizeCount-1)
					{
						$AllProduct .="OR ";
					}
				}
					$AllProduct .=" ) GROUP BY p.ProductName ORDER BY p.ProductPrice ASC";	
			}
		}
		/* SIZE - LOWPRICE */
		
		/* SIZE - LEFT MENU PRICE */
		elseif((!empty($_GET['size'])) && (!empty($_GET['data'])))
		{
			if((!empty($_GET['size'])) && (!empty($_GET['data'])) && (!empty($_GET['CategoryID'])))
			{
				$AllProduct.=" AND (";
				for($cs=0;$cs<$SizeCount;$cs++)
				{
					$AllProduct .="(p.ProductSize REGEXP  ',$temp2[$cs]$' OR  p.ProductSize REGEXP  ',$temp2[$cs],' OR  p.ProductSize REGEXP  '$$temp2[$cs],' OR p.ProductSize REGEXP  '^$temp2[$cs]$' OR p.ProductSize REGEXP  '$temp2[$cs],') ";	
					if($cs<$SizeCount-1)
					{
						$AllProduct .="OR ";
					}
				}
				$AllProduct.=" ) AND ( ";
				for($cc=0;$cc<$CategoryCount;$cc++)
				{
					$AllProduct .="((c.CategoryID = p.CategoryID OR p.CategoryID =  '".$temp3[$cc]."') AND (c.ParentCategoryID =  '".$temp3[$cc]."' OR c.CategoryID =  '".$temp3[$cc]."'))";	
					if($cc<$CategoryCount-1)
					{
						$AllProduct .=" OR ";
					}
					
				}
				$AllProduct .=" ) GROUP BY p.ProductName ORDER BY p.ProductPrice ASC";	

			}
			else
			{
				$AllProduct.=" AND (";
				for($cs=0;$cs<$SizeCount;$cs++)
				{
					$AllProduct .="(p.ProductSize REGEXP  ',$temp2[$cs]$' OR  p.ProductSize REGEXP  ',$temp2[$cs],' OR  p.ProductSize REGEXP  '$$temp2[$cs],' OR p.ProductSize REGEXP  '^$temp2[$cs]$' OR p.ProductSize REGEXP  '$temp2[$cs],') ";	
					if($cs<$SizeCount-1)
					{
						$AllProduct .="OR ";
					}
				}
					$AllProduct .=" ) GROUP BY p.ProductName ORDER BY p.ProductPrice ASC";	
			}
		}
		/* SIZE - LEFT MENU PRICE */
		
		/* SIZE */
		else
		{
			$AllProduct.=" AND (";
			for($cs=0;$cs<$SizeCount;$cs++)
			{
				$AllProduct .="(p.ProductSize REGEXP  ',$temp2[$cs]$' OR  p.ProductSize REGEXP  ',$temp2[$cs],' OR  p.ProductSize REGEXP  '$$temp2[$cs],' OR p.ProductSize REGEXP  '^$temp2[$cs]$' OR p.ProductSize REGEXP  '$temp2[$cs],') ";	
				if($cs<$SizeCount-1)
				{
					$AllProduct .="OR ";
				}
				
			}
			$AllProduct .=" ) GROUP BY p.ProductName ORDER BY p.ProductPrice DESC";
		}
		/* SIZE */
	}
	/* FOR SIZE LEFT MENU (SIZE->HIGHPRICE) */
	/* FOR CATEGORY LEFT MENU*/
	/* CATEGORY */
	elseif(!empty($CategoryID))
	{
		/* CATEGORY - SIZE - HIGHPRICE - DATA */
		if((!empty($CategoryID)) && (!empty($_GET['data'])) && (!empty($_GET['highprice'])) && (!empty($_GET['size'])))
		{
			$AllProduct.=" AND (";
			for($cs=0;$cs<$SizeCount;$cs++)
			{
				$AllProduct .="(p.ProductSize REGEXP  ',$temp2[$cs]$' OR  p.ProductSize REGEXP  ',$temp2[$cs],' OR  p.ProductSize REGEXP  '$$temp2[$cs],' OR p.ProductSize REGEXP  '^$temp2[$cs]$' OR p.ProductSize REGEXP  '$temp2[$cs],') ";	
				if($cs<$SizeCount-1)
				{
					$AllProduct .="OR ";
				}
			}
				$AllProduct .=" ) AND (";
				$mypricecount = $PricerangeCount/2;
				for($pc=0;$pc<$mypricecount;$pc++)
				{
					$AllProduct .=" (p.ProductPrice >= '".$MinOdd[$pc]."' AND p.ProductPrice <= '".$MaxEven[$pc]."')";
					if($pc<$mypricecount-1)
					{
						$AllProduct .=" OR ";
					}
					
				}
				$AllProduct.=" ) AND (";
				for($cc=0;$cc<$CategoryCount;$cc++)
				{
					$AllProduct .="((c.CategoryID = p.CategoryID OR p.CategoryID =  '".$temp3[$cc]."') AND (c.ParentCategoryID =  '".$temp3[$cc]."' OR c.CategoryID =  '".$temp3[$cc]."'))";	
					if($cc<$CategoryCount-1)
					{
						$AllProduct .=" OR ";
					}
					
				}
				$AllProduct .=" ) GROUP BY p.ProductID ORDER BY p.ProductPrice DESC"; 
		}
		/* CATEGORY - SIZE - HIGHPRICE - DATA */
		
		/* CATEGORY - SIZE - LOWPRICE - DATA */
		elseif((!empty($CategoryID)) && (!empty($_GET['data'])) && (!empty($_GET['lowprice'])) && (!empty($_GET['size'])))
		{
			$AllProduct.=" AND (";
			for($cs=0;$cs<$SizeCount;$cs++)
			{
				$AllProduct .="(p.ProductSize REGEXP  ',$temp2[$cs]$' OR  p.ProductSize REGEXP  ',$temp2[$cs],' OR  p.ProductSize REGEXP  '$$temp2[$cs],' OR p.ProductSize REGEXP  '^$temp2[$cs]$' OR p.ProductSize REGEXP  '$temp2[$cs],') ";	
				if($cs<$SizeCount-1)
				{
					$AllProduct .="OR ";
				}
			}
				$AllProduct .=" ) AND (";
				$mypricecount = $PricerangeCount/2;
				for($pc=0;$pc<$mypricecount;$pc++)
				{
					$AllProduct .=" (p.ProductPrice >= '".$MinOdd[$pc]."' AND p.ProductPrice <= '".$MaxEven[$pc]."')";
					if($pc<$mypricecount-1)
					{
						$AllProduct .=" OR ";
					}
					
				}
				$AllProduct.=" ) AND (";
				for($cc=0;$cc<$CategoryCount;$cc++)
				{
					$AllProduct .="((c.CategoryID = p.CategoryID OR p.CategoryID =  '".$temp3[$cc]."') AND (c.ParentCategoryID =  '".$temp3[$cc]."' OR c.CategoryID =  '".$temp3[$cc]."'))";	
					if($cc<$CategoryCount-1)
					{
						$AllProduct .=" OR ";
					}
					
				}
				$AllProduct .=" ) GROUP BY p.ProductID ORDER BY p.ProductPrice ASC"; 
		}
		/* CATEGORY - SIZE - LOWPRICE - DATA */
		
				
		/* CATEGORY - DATA - SIZE */
		elseif((!empty($CategoryID)) && (!empty($_GET['size'])) && (!empty($_GET['data'])))
		{
			$AllProduct.=" AND (";
			for($cs=0;$cs<$SizeCount;$cs++)
			{
				$AllProduct .="(p.ProductSize REGEXP  ',$temp2[$cs]$' OR  p.ProductSize REGEXP  ',$temp2[$cs],' OR  p.ProductSize REGEXP  '$$temp2[$cs],' OR p.ProductSize REGEXP  '^$temp2[$cs]$' OR p.ProductSize REGEXP  '$temp2[$cs],') ";	
				if($cs<$SizeCount-1)
				{
					$AllProduct .="OR ";
				}
			}
				$AllProduct .=" ) AND (";
				$mypricecount = $PricerangeCount/2;
				for($pc=0;$pc<$mypricecount;$pc++)
				{
					$AllProduct .=" (p.ProductPrice >= '".$MinOdd[$pc]."' AND p.ProductPrice <= '".$MaxEven[$pc]."')";
					if($pc<$mypricecount-1)
					{
						$AllProduct .=" OR ";
					}
					
				}
				$AllProduct.=" ) AND (";
				for($cc=0;$cc<$CategoryCount;$cc++)
				{
					$AllProduct .="((c.CategoryID = p.CategoryID OR p.CategoryID =  '".$temp3[$cc]."') AND (c.ParentCategoryID =  '".$temp3[$cc]."' OR c.CategoryID =  '".$temp3[$cc]."'))";	
					if($cc<$CategoryCount-1)
					{
						$AllProduct .=" OR ";
					}
					
				}
				$AllProduct .=" ) GROUP BY p.ProductID ORDER BY p.ProductPrice"; 	
		}
		/* CATEGORY - DATA - SIZE */
		
		/* CATEGORY - DATA - LOWPRICE */
		elseif((!empty($CategoryID)) && (!empty($_GET['data'])) && (!empty($_GET['lowprice'])))
		{
			$AllProduct .=" AND (";
			$mypricecount = $PricerangeCount/2;
			for($pc=0;$pc<$mypricecount;$pc++)
			{
				$AllProduct .=" (p.ProductPrice >= '".$MinOdd[$pc]."' AND p.ProductPrice <= '".$MaxEven[$pc]."')";
				if($pc<$mypricecount-1)
				{
					$AllProduct .=" OR ";
				}
				
			}
			$AllProduct.=") AND (";
			for($cc=0;$cc<$CategoryCount;$cc++)
			{
				$AllProduct .="((c.CategoryID = p.CategoryID OR p.CategoryID =  '".$temp3[$cc]."') AND (c.ParentCategoryID =  '".$temp3[$cc]."' OR c.CategoryID =  '".$temp3[$cc]."'))";	
				if($cc<$CategoryCount-1)
				{
					$AllProduct .=" OR ";
				}
				
			}
			$AllProduct .=" )GROUP BY p.ProductID ORDER BY p.ProductPrice ASC";	
		}
		/* CATEGORY - DATA - LOWPRICE */
		
		/* CATEGORY - DATA - HIGHPRICE */
		elseif((!empty($CategoryID)) && (!empty($_GET['data'])) && (!empty($_GET['highprice'])))
		{
			$AllProduct .=" AND (";
			$mypricecount = $PricerangeCount/2;
			for($pc=0;$pc<$mypricecount;$pc++)
			{
				$AllProduct .=" (p.ProductPrice >= '".$MinOdd[$pc]."' AND p.ProductPrice <= '".$MaxEven[$pc]."')";
				if($pc<$mypricecount-1)
				{
					$AllProduct .=" OR ";
				}
				
			}
			$AllProduct.=" ) AND (";
			for($cc=0;$cc<$CategoryCount;$cc++)
			{
				$AllProduct .="((c.CategoryID = p.CategoryID OR p.CategoryID =  '".$temp3[$cc]."') AND (c.ParentCategoryID =  '".$temp3[$cc]."' OR c.CategoryID =  '".$temp3[$cc]."'))";	
				if($cc<$CategoryCount-1)
				{
					$AllProduct .=" OR ";
				}
				
			}
			$AllProduct .=" )GROUP BY p.ProductID ORDER BY p.ProductPrice DESC";
		}
		/* CATEGORY - DATA - HIGHPRICE */
		
		/* CATEGORY - DATA - POPULARITY */
		elseif((!empty($CategoryID)) && (!empty($_GET['data'])) && (!empty($_GET['popularity'])))
		{
			$AllProduct .=" AND ( ";
			$mypricecount = $PricerangeCount/2;
			for($pc=0;$pc<$mypricecount;$pc++)
			{
				$AllProduct .=" (p.ProductPrice >= '".$MinOdd[$pc]."' AND p.ProductPrice <= '".$MaxEven[$pc]."')";
				if($pc<$mypricecount-1)
				{
					$AllProduct .=" OR ";
				}
				
			}
			$AllProduct.=" ) AND (";
			for($cc=0;$cc<$CategoryCount;$cc++)
			{
				$AllProduct .="((c.CategoryID = p.CategoryID OR p.CategoryID =  '".$temp3[$cc]."') AND (c.ParentCategoryID =  '".$temp3[$cc]."' OR c.CategoryID =  '".$temp3[$cc]."'))";	
				if($cc<$CategoryCount-1)
				{
					$AllProduct .=" OR ";
				}
				
			}
			$AllProduct .=" ) GROUP BY p.ProductID ORDER BY p.ProductSoldCount DESC";	
		}
		/* CATEGORY - DATA - POPULARITY */
		
		/* CATEGORY - SIZE */
		elseif((!empty($_GET['CategoryID'])) && (!empty($Psi)))
		{
			$AllProduct.=" AND (";
			for($cs=0;$cs<$SizeCount;$cs++)
			{
				$AllProduct .="(p.ProductSize REGEXP  ',$temp2[$cs]$' OR  p.ProductSize REGEXP  ',$temp2[$cs],' OR  p.ProductSize REGEXP  '$$temp2[$cs],' OR p.ProductSize REGEXP  '^$temp2[$cs]$' OR p.ProductSize REGEXP  '$temp2[$cs],') ";	
				if($cs<$SizeCount-1)
				{
					$AllProduct .="OR ";
				}
			}
			$AllProduct.=" ) AND ( ";
			for($cc=0;$cc<$CategoryCount;$cc++)
			{
				$AllProduct .="((c.CategoryID = p.CategoryID OR p.CategoryID =  '".$temp3[$cc]."') AND (c.ParentCategoryID =  '".$temp3[$cc]."' OR c.CategoryID =  '".$temp3[$cc]."'))";	
				if($cc<$CategoryCount-1)
				{
					$AllProduct .=" OR ";
				}
				
			}
			$AllProduct .=" )GROUP BY p.ProductID ";
		}
		/* CATEGORY - SIZE */
		
		/* CATEGORY - DATA */
		elseif((!empty($_GET['CategoryID'])) && (!empty($_GET['data'])))
		{
			$AllProduct .=" AND (";
			$mypricecount = $PricerangeCount/2;
			for($pc=0;$pc<$mypricecount;$pc++)
			{
				$AllProduct .=" (p.ProductPrice >= '".$MinOdd[$pc]."' AND p.ProductPrice <= '".$MaxEven[$pc]."')";
				if($pc<$mypricecount-1)
				{
					$AllProduct .=" OR ";
				}
			}
			$AllProduct .=" ) AND (";
			for($cc=0;$cc<$CategoryCount;$cc++)
			{
				$AllProduct .="((c.CategoryID = p.CategoryID OR p.CategoryID =  '".$temp3[$cc]."') AND (c.ParentCategoryID =  '".$temp3[$cc]."' OR c.CategoryID =  '".$temp3[$cc]."'))";	
				if($cc<$CategoryCount-1)
				{
					$AllProduct .=" OR ";
				}
			}
			$AllProduct .=" ) GROUP BY p.ProductID ";
		}
		/* CATEGORY - DATA */
		
		/* CATEGORY - HIGHPRICE */
		elseif((!empty($CategoryID)) && ($HighPrice == "highprice"))
		{
			$AllProduct.=" AND ";
			for($cc=0;$cc<$CategoryCount;$cc++)
			{
				$AllProduct .="((c.CategoryID = p.CategoryID OR p.CategoryID =  '".$temp3[$cc]."') AND (c.ParentCategoryID =  '".$temp3[$cc]."' OR c.CategoryID =  '".$temp3[$cc]."'))";	
				if($cc<$CategoryCount-1)
				{
					$AllProduct .=" OR ";
				}
				
			}
			$AllProduct .=" GROUP BY p.ProductName ORDER BY p.ProductPrice DESC";
		}
		/* CATEGORY - HIGHPRICE */
		
		/* CATEGORY - LOWPRICE */
		elseif((!empty($_GET['CategoryID'])) && (!empty($_GET['lowprice'])))
		{
			
			$AllProduct.=" AND ";
			for($cc=0;$cc<$CategoryCount;$cc++)
			{
				$AllProduct .="((c.CategoryID = p.CategoryID OR p.CategoryID =  '".$temp3[$cc]."') AND (c.ParentCategoryID =  '".$temp3[$cc]."' OR c.CategoryID =  '".$temp3[$cc]."'))";	
				if($cc<$CategoryCount-1)
				{
					$AllProduct .=" OR ";
				}
				
			}
			$AllProduct .=" GROUP BY p.ProductName ORDER BY p.ProductPrice ASC";	
		}
		/* CATEGORY - LOWPRICE */
		
		/* CATEGORY - POPULARITY */
		elseif((!empty($_GET['CategoryID'])) && (!empty($_GET['popularity'])))
		{
			$AllProduct.=" AND ";
			for($cc=0;$cc<$CategoryCount;$cc++)
			{
				$AllProduct .="((c.CategoryID = p.CategoryID OR p.CategoryID =  '".$temp3[$cc]."') AND (c.ParentCategoryID =  '".$temp3[$cc]."' OR c.CategoryID =  '".$temp3[$cc]."'))";	
				if($cc<$CategoryCount-1)
				{
					$AllProduct .=" OR ";
				}
				
			}
			$AllProduct .=" GROUP BY p.ProductID ORDER BY p.ProductSoldCount DESC";	
		}
		/* CATEGORY - POPULARITY */
		
		
		
		/* CATEGORY */
		else
		{
			$AllProduct.=" AND (";
			for($cc=0;$cc<$CategoryCount;$cc++)
			{
				$AllProduct .="((c.CategoryID = p.CategoryID OR p.CategoryID =  '".$temp3[$cc]."') AND (c.ParentCategoryID =  '".$temp3[$cc]."' OR c.CategoryID =  '".$temp3[$cc]."'))";	
				if($cc<$CategoryCount-1)
				{
					$AllProduct .=" OR ";
				}
				
			}
			$AllProduct .=" )GROUP BY p.ProductName ";
		}
		/* CATEGORY */
		
	}
	/* CATEGORY */
	/* FOR CATEGORY LEFT MENU */
	
	
	/* FOR HIGH PRICE */
	elseif($HighPrice == "highprice")
	{
		$AllProduct .=" GROUP BY p.ProductName ORDER BY p.ProductPrice DESC";	
	}
	/* FOR HIGH PRICE */
	
	/* FOR LOW PRICE */
	elseif($LowPrice == "lowprice")
	{
		$AllProduct .=" GROUP BY p.ProductName ORDER BY p.ProductPrice ASC";	
	}
	/* FOR LOW PRICE */
	else
	{
		$AllProduct .= " GROUP BY p.ProductName ORDER BY p.ProductID ASC";
	}
	
	$Product = $obj->sql_query($AllProduct);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hashtag - Search</title>
      
    <?php include("includes/js_css.php"); ?>
   
    <style>
    </style>
    <!-- Resource style -->
    
</head>

<body>
	<!-- HEADER -->
    <?php include("includes/header.php"); ?>
    <!-- HEADER -->
    
    <div id="stickyalias"></div>
    <a href="#0" class="cd-top"><i class="fa fa-angle-up"></i></a>
    <!-- BREADCRUM -->
    <section class="headingdisplay margin-top120">
        <div class="container">
            <div class="row">
                <div class="col-md-6 ">
                    <h1 class="pull-left">Search</h1>
                </div>
                <div class="col-md-6 ">
                    <ul class="breadcrumb pull-right">
                        <li><a href="index">Home</a></li>
                        <li><a href="#" class="active"><i class="fa fa-angle-right pr5 breakdivsion"></i>Search</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- BREADCRUM -->
    
    <!-- CONTENT -->
    <section class="product-detail" id="pdetail">
        <div class="container">
            <div class="row">
            	<!-- SIDE BAR -->
                <div class="col-lg-3 col-md-2 col-sm-12">
                    <!-- LEFT MENU PRODUCT -->
                    <?php include("includes/search_leftmenu.php"); ?>
                    <!-- LEFT MENU PRODUCT -->
                </div>
                <!-- SIDE BAR -->
                
                <!-- CONTENT -->
                <div class="col-md-9 col-sm-9 mobile-filter">
                    <!-- SORT BY ALPHABET - POPULARITY - SIZE -->
                    <div class="row sort-by">
                        <div class="col-md-12 pull-right pr0 sortdataby">
                            <ul>
                            <?php echo $a; ?>
                                <li><a href="search?highprice=highprice<?php if(!empty($a1)) { ?>&Search=<?php echo str_replace(" ","-",$a1); } ?><?php if(!empty($_GET['CategoryID'])) { ?>&CategoryID=<?php echo $_GET['CategoryID']; } ?><?php if(!empty($_GET['size'])) { ?>&size=<?php echo $_GET['size']; } ?><?php if(!empty($_GET['data'])) { ?>&data=<?php echo $_GET['data']; } ?><?php if(!empty($CampaignID)) {?>&CampaignID=<?php echo $CampaignID; }?>" <?php if(($HighPrice == "highprice")){?> class="active" <?php } ?>>Price : High To Low</a></li>
                                <li><a href="search?lowprice=lowprice<?php if(!empty($a1)) { ?>&Search=<?php echo str_replace(" ","-",$a1); } ?><?php if(!empty($_GET['CategoryID'])) { ?>&CategoryID=<?php echo $_GET['CategoryID']; } ?><?php if(!empty($_GET['size'])) { ?>&size=<?php echo $_GET['size']; } ?><?php if(!empty($_GET['data'])) { ?>&data=<?php echo $_GET['data']; } ?><?php if(!empty($CampaignID)) {?>&CampaignID=<?php echo $CampaignID; }?>" <?php if(($LowPrice == "lowprice")) {?> class="active" <?php } ?>>Price : Low To High</a></li>
                                <li><a href="search?popularity=popularity<?php if(!empty($a1)) { ?>&Search=<?php echo str_replace(" ","-",$a1); } ?><?php if(!empty($_GET['CategoryID'])) { ?>&CategoryID=<?php echo $_GET['CategoryID']; } ?><?php if(!empty($_GET['size'])) { ?>&size=<?php echo $_GET['size']; } ?><?php if(!empty($_GET['data'])) { ?>&data=<?php echo $_GET['data']; } ?><?php if(!empty($CampaignID)) {?>&CampaignID=<?php echo $CampaignID; }?>" <?php if(($Popularity == "popularity")) {?> class="active" <?php } ?>>By Popularity</a></li>
                                <li><a href="search<?php if(!empty($a1)) { ?>?Search=<?php echo str_replace(" ","-",$a1); } ?>" <?php if((empty($_GET['highprice'])) && (empty($_GET['lowprice'])) && (empty($_GET['size'])) && (empty($_GET['data']))  && (empty($_GET['CategoryID']))){?> class="active" <?php } ?> >New</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- SORT BY ALPHABET - POPULARITY - SIZE -->
                    
                    <!-- DISPLAY PRODUCT -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row ptb10 product-main-page mobile50 product-main-page product-main-home-hover height-productpage">
                                <!-- ROW -->
                                    <?php
                                    if(count($Product) == '0')
                                    {
                                    ?>
                                        <div>
                                            <center><h3>No Product Available !!! </h3></center>
                                        </div>
                                    <?php	
                                    }
                                    else
                                    {
                                        for($i=0;$i<count($Product);$i++)
                                        {
                                            $PID = $Product[$i]['ProductID'];
											{
											
                                    ?>
                                            <!-- PRODUCT -->
                                            <div class="col-md-4 col-sm-3 col-xs-12 product-height">
                                                <div class="item" id="Recent<?php echo $Product[$i]['ProductID']; ?>">
                                                <form id="Product_<?php echo $Product[$i]['ProductID']; ?>" name="Product_<?php echo $Product[$i]['ProductID']; ?>" method="post" enctype="multipart/form-data">
                                                <input type="hidden" id="ProductID" name="ProductID" value="<?php echo $Product[$i]['ProductID']; ?>" />
                                                    <div class="item-main" style="position: relative;">
                                                        <div class="item-inner">
                                                        
                                                            <div class="box-images">
                                                            
                                                                <!-- PRODUCT IMAGE -->
                                                                <?php
																$SPID = Encrypt('myPass123', $Product[$i]['ProductID']);
																$SCID = Encrypt('myPass123', $Product[$i]['CategoryID']);
																?>
                                                                <a href="product-detail/<?php  echo $SPID; ?>/<?php  echo $SCID; ?>/<?php  echo str_replace(" ","-",$Product[$i]['ProductName']); ?>" class="product-image">
                                                               		 <img data-src="upload_data/productactualimage/large/<?php echo $Product[$i]['ProductActualImage']; ?>" class="img-face lazy-hidden" width="300" height="200">
																	 <img data-src="upload_data/producthoverimage/large/<?php echo $Product[$i]['ProductHoverImage']; ?>" class="img-face-back lazy-hidden" width="300" height="200">
                                                                </a>
                                                               
                                                                <!-- PRODUCT IMAGE -->
                                                                
                                                                <!-- WISH LIST LINK -->
																<?php
																$SelectWishList = $obj->sql_query("SELECT * FROM tbl_wishlist WHERE ProductID = '".$Product[$i]['ProductID']."' AND RegisterID = '".$_SESSION['RegisterID']."'");
																?>
                                                                <div class="wishlist-tooltip">
																<span class="icon-fav wishlist-tooltip"><a class="link-wishlist <?php if($SelectWishList){?>text-red <?php } else { ?> text-gray <?php } ?>" id ="wishlist<?php echo $Product[$i]['ProductID']; ?>" onClick="AddToWishlist(<?php echo $Product[$i]['ProductID']; ?>)" ><i class="fa fa-heart"></i></a></span>
																<span class="saveToWish">Save as Wishlist</span>
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
                                                                <!-- WISH LIST LINK -->
                                                                
                                                                <!-- QUICK VIEW LINK -->
                                                                <div class="qiuck-tooltip">
																	<span class="icon-fav quick-tooltip"><a href="javascript:void(0);" data-toggle="modal" data-target="#product-quick-veiw-modal<?php echo $Product[$i]['ProductID']; ?>" class="link-wishlist text-gray" onClick = "QuickView(<?php echo $Product[$i]['ProductID']; ?>);"><i class="fa fa-eye"></i></a></span>
																	<span class="qiuckview">Qiuck View</span>
																</div>
                                                                <!-- QUICK VIEW LINK -->
                                                            </div>
                                                            
                                                            <div class="product-shop">
                                                            
                                                                <!-- TITLE -->
                                                                <div class="description">
                                                                    <h4 class="product-name"><a href="product-detail/<?php  echo $Product[$i]['ProductID']; ?>/<?php  echo $Product[$i]['CategoryID']; ?>/<?php  echo str_replace(" ","-",$Product[$i]['ProductName']); ?>" ><?php echo ucfirst($Product[$i]['ProductName']); ?></a></h4>
                                                                </div>
                                                                <!-- TITLE -->
                                                                
                                                                <!-- PRICE -->
																<div class="price">
																	<?php
																		if((!empty($Product[$i]['ProductDiscountType'])) && ($Product[$i]['ProductDiscountAmount'] != "00"))
																		{
																			$ProductDiscountType = $Product[$i]['ProductDiscountType'];
																			if($ProductDiscountType == "Rupee")
																			{
																				$Price1 = $Product[$i]['ProductPrice'] - $Product[$i]['ProductDiscountAmount'];
																				if(($Price1) != ($Product[$i]['ProductPrice']))
																				{ 
																	?>
																				<span class="cutprice"><i class="fa fa-inr"></i><?php echo $Product[$i]['ProductPrice']; ?> /-</span>
																	<?php 
																				} 
																	?>
																				<span class="discount"><i class="fa fa-inr"></i><?php echo  round($Price1); ?> /-</span> 
																				<input type="hidden" name="Price1" id="Price1" value="<?php echo  round($Price1); ?>"/>
																	<?php
																			}
																			if($ProductDiscountType == "Percentage")
																			{
																				$DiscountPrice = ($Product[$i]['ProductDiscountAmount'] * $Product[$i]['ProductPrice'])/100;
																				$Price1 = $Product[$i]['ProductPrice'] - $DiscountPrice;
																				if(($Price1) != ($Product[$i]['ProductPrice']))
																				{ 
																	?>
																					<span class="cutprice"><i class="fa fa-inr"></i><?php echo $Product[$i]['ProductPrice']; ?> /-</span>
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
																			$Price1 = $Product[$i]['ProductPrice'];
																	?>
																			<span class="discount"><i class="fa fa-inr"></i><?php echo  round($Price1); ?> /-</span>
																			<input type="hidden" name="Price1" id="Price1" value="<?php echo  round($Price1); ?>" />
																	<?php
																		}
																	?>
																</div>
                                                                <!-- PRICE -->
                                                                
                                                                <div class="product-sectiononhover">
                                                                    
                                                                    <!-- DISPLAY PRODUCT SIZE -->
                                                                    <div class="size pdetailsize">
                                                                    	<ul class="subcategory mt5">
                                                                            <?php
                                                                                $ProductSize =explode(",",$Product[$i]['ProductSize']);
																				$StockFlag = 0;
                                                                                for($p=0;$p<count($ProductSize);$p++)
                                                                                {
																					$SelectSizeID = $obj->sql_query("SELECT * FROM tbl_size WHERE SizeName = '".$ProductSize[$p]."'");
																					$SelectSizeStock = $obj->sql_query("SELECT * FROM tbl_productsize_stockmanage WHERE ProductID = '".$Product[$i]['ProductID']."' AND SizeID = '".$SelectSizeID[0]['SizeID']."'");
																					if($SelectSizeStock[0]['ProductStock'] > 0)
																					{
																						$StockFlag = 1;
                                                                            ?>
                                                                                    <li onClick="addc_<?php echo $p; ?>_<?php echo $Product[$i]['ProductID']; ?>();" id="S_<?php echo $p; ?>_<?php echo $Product[$i]['ProductID']; ?>"><a href="#" id="Size_<?php echo $ProductSize[$p]; ?>_<?php echo $Product[$i]['ProductID']; ?>"><?php echo strtoupper($ProductSize[$p]); ?></a></li>
                                                                                    <script>
                                                                                       function addc_<?php echo $p; ?>_<?php echo $Product[$i]['ProductID']; ?>()
                                                                                       {
                                                                                        $('#S_<?php echo $p; ?>_<?php echo $Product[$i]['ProductID']; ?>').addClass("size-active");
                                                                                        var a = $('#Size_<?php echo $ProductSize[$p]; ?>_<?php echo $Product[$i]['ProductID']; ?>').html();
                                                                                        
                                                                                        document.getElementById('Size1_<?php echo $Product[$i]['ProductID']; ?>').value = a;
                                                                                        var s = $("#Size1_<?php echo $Product[$i]['ProductID']; ?>").val();
                                                                                        
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
                                                                            <input type="hidden" id="Size1_<?php echo $Product[$i]['ProductID']; ?>" name="Size1_<?php echo $Product[$i]['ProductID']; ?>" value="">  
                                                                        </ul>    
                                                                    </div>
                                                                    <!-- DISPLAY PRODUCT SIZE -->
                                                                    
                                                                    <!-- ADD TO CART BUTTON -->
                                                                    <div class="add-to-Cartonhover">
                                                                         <button type="submit" <?php if($StockFlag == 0){?> disabled <?php } ?> class="btn btn-primary button-subscribe btnshadow-nor btn-shopping-item btn-bluehover" id="AddToCartSearchProduct<?php echo $Product[$i]['ProductID']; ?>" onClick="message_show(<?php echo $Product[$i]['ProductID']; ?>)" name="AddToCartSearchProduct<?php echo $Product[$i]['ProductID']; ?>">
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
																						$.notify("Product successfully added to cart", {
																						position: "bottom left"
																						});
																						item_showF(cid)
																						<?php
																						for($rer=0;$rer<count($Product);$rer++)
																						{
																						$ProductSizeR =explode(",",$Product[$rer]['ProductSize']);
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
                                                                    <!-- SCRIPT FOR ADD TO CART -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                </div>
                                            </div>
                                            <!-- PRODUCT -->
                                    <?php
                                        }
									}
                                    }
                                    ?>
                                <!-- ROW -->
                            </div>
                        </div>
                    </div>
                    <!-- DISPLAY PRODUCT -->
                </div>
                <!-- CONTENT -->
            </div>
        </div>
        <div class = "seperator"></div>
    </section>
    <!-- CONTENT -->
    
	<!-- REGISTER/LOGIN WITH FACEBOOK & GOOGLE + -->
    <?php include("includes/loginwithfbgp.php") ?>
    <!-- REGISTER/LOGIN WITH FACEBOOK & GOOGLE + -->
    
    <!-- LOGIN MODEL -->
    <?php include("includes/loginmodel.php"); ?>
    <!-- LOGIN MODEL -->
    
    <!-- FOOTER -->
    <?php include("includes/footer.php"); ?>
    <!-- FOOTER -->
   
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
    
    <!-- INDEX PAGE JS -->
    <?php include("includes/index_js.php"); ?>
    <!-- INDEX PAGE JS -->
    
     <!-- VALIDATION SCRIPT -->
    <script type="text/javascript" src="js/jquery.validate.js"></script>
    <!-- VALIDATION SCRIPT -->
    
    
</body>

</html>
