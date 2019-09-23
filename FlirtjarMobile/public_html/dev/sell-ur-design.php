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
	$obj = new myclass();
	session_start();
	include("includes/session_check.php");
	
	$SelectRegisterDetail = $obj->sql_query("SELECT * FROM tbl_register WHERE RegisterID='".$_SESSION['RegisterID']."'");
	
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hashtag - Profile</title>
    <?php include("includes/js_css.php"); ?>
    <!-- Resource style -->
</head>

<body>
    <!-- HEADER -->
    <?php include("includes/header.php"); ?>
    <!-- HEADER -->
    
    <div id="stickyalias"></div>
    <!-- SCROLL TO TOP-->
    <a href="#0" class="cd-top"><i class="fa fa-angle-up"></i></a>
    <!-- SCROLL TO TOP-->
   
    <div id="stickyalias"></div>
    
    <section class="login pb40 margin-top120">
        <div class="container">
            <div class="row">
                <div class="col-md-11 col-md-offset-1 col-sm-12 tabletlandascape">
                <br>
                <br>
                	<input class="btn btn-primary profile-update-btn update-profile address-save btn-save-default btnshadow-nor form-control pull-right" type="submit" value="Submit Design" id="submit" name="submit" <?php if(empty($_SESSION['RegisterID'])){ ?>onclick="window.location = 'login.php?from=add_artist.php'"<?php } else{ ?>onclick="window.location = 'add_artist.php'"<?php } ?>/>
            	<br>
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
    
    <!-- INDEX PAGE JS -->
    <?php include("includes/index_js.php"); ?>
    <!-- INDEX PAGE JS -->
    
    <!-- VALIDATION SCRIPT -->
    <script type="text/javascript" src="js/jquery.validate.js"></script>
    <!-- VALIDATION SCRIPT -->
    
   
</body>

</html>
