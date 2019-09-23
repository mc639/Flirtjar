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
    
    <!-- DISPLAY MENU -->
    <?php include("includes/profilemenu.php"); ?>
    <!-- DISPLAY MENU -->
    
    <div id="stickyalias"></div>
   
    <section class="login pb40">
        <div class="container">
            <div class="row">
                <div class="col-md-11 col-md-offset-1 col-sm-12 tabletlandascape">
                	<p class="forget-info text-red" id="ProfileMessage"></p>
                    <p class="forget-info" id="ProfileSuccessMessage"></p>
                    <form method="post" name="ProfileForm" id="ProfileForm" class="login-form update-profile-form pt40">
                    	<input type="hidden" name="Action" id="Action" value="Update">
                        <input type="hidden" name="RegisterID" value="<?php echo $SelectRegisterDetail[0]['RegisterID']; ?>">
                        <div class="form-group pb10">
                            <label for="inputEmail3" class="col-sm-3 col-md-3 control-label label-profile pr0">first name</label>
                            <div class="col-sm-9 col-md-8">
                                <input id="FirstName" name="FirstName" value="<?php echo $SelectRegisterDetail[0]['FirstName']; ?>" placeholder="First Name" type="text" class="form-control mb10" />
                            </div>
                        </div>
                        <div class="form-group pb10">
                            <label for="inputEmail3" class="col-sm-3 col-md-3 control-label label-profile">last name</label>
                            <div class="col-sm-9 col-md-8">
                                <input id="LastName" name="LastName" value="<?php echo $SelectRegisterDetail[0]['LastName']; ?>" placeholder="Last Name" type="text" class="form-control mb10" />
                            </div>
                        </div>
                        <div class="form-group pb10">
                            <label for="inputEmail3" class="col-sm-3 col-md-3 control-label label-profile">phone</label>
                            <div class="col-sm-9 col-md-8">
                                <input name="ContactNo" id="ContactNo" value="<?php echo $SelectRegisterDetail[0]['ContactNo']; ?>" maxlength="10" minlength="10" placeholder="Phone" type="text" class="number form-control mb20" />
                            </div>
                        </div>
                        <div class="form-group pb10">
                            <label for="inputEmail3" class="col-sm-3 col-md-3 control-label label-profile">e-mail address</label>
                            <div class="col-sm-9 col-md-8">
                                <input name="Email" id="Email" value="<?php echo $SelectRegisterDetail[0]['Email']; ?>" placeholder="E-mail Address" type="text" class="form-control mb10" readonly/>
                            </div>
                        </div>
                        <div class="form-group pb10">
                            <label for="inputEmail3" class="col-sm-3 col-md-3 control-label label-profile">gender</label>
                            <div class="col-sm-9 col-md-8">
                                <div class="input-group" style="width:100%;">
                                    <div class="remember-me pull-left">
                                        <label>
                                            <input type="radio" id="Gender1" name="Gender" value="Male" <?php if($SelectRegisterDetail[0]['Gender'] == "Male") { echo 'checked'; } ?>/>
                                            <label for="Gender1" class="radiobox">Male</label>
                                        </label>
                                    </div>
                                    <div class="remember-me pull-left">
                                        <label>
                                            <input type="radio" id="Gender2" name="Gender" value="Female" <?php if($SelectRegisterDetail[0]['Gender'] == "Female") { echo 'checked'; } ?>/>
                                            <label for="Gender2" class="radiobox">Female</label>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group pb10">
                            <div class="col-sm-12 col-md-11 co-lg-11 ">
                                <button type="submit" class="btn btn-primary profile-update-btn update-profile address-save btn-save-default btnshadow-nor form-control pull-right"> 
                                	<i class="fa fa-pencil pr10"></i>Update
                                </button>
                            </div>
                        </div>
                	</form>
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
