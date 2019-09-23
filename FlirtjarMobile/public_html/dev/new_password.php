<?php
	/*----------File Information----------*/
	#Project : HashTag
	#File Created By : Avani Trivedi 
	#File Created Date : 12 Nov 2016
	#File Edited By :
	#File Edited Date :
	/*----------File Information----------*/

	include ("includes/connection.php");
	include("includes/encrypt.php");
	$obj = new myclass();
	session_start();
	$Token = $_GET['Token'];
	$SelectMember = $obj->sql_query("SELECT * FROM tbl_register WHERE Token = '".$Token."'");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hashtag - Reset Password</title>
    <?php include("includes/js_css.php"); ?>
    <!-- Resource style -->
    <script src="js/jquery.1.11.2.js" type="text/javascript"></script> 
    <script type="text/javascript" src="js/jquery.validate.js"></script>
    <script type="text/javascript">
    $('#NewPassword').ready(function(){
		$("#NewPassword").validate({
			errorElement: "p", 	
			messages:
			{
				
				NewPassword1:
				{ 
					required:"Please enter new password.",
					minlength:"Please enter minimum 6 character." 
				},
				ConfirmPassword1:
				{
					required:"Please enter confirm password.",
					equalTo:"Password does not match, try again.",
					minlength:"Please enter minimum 6 character."
				},
			},
			rules : 
			{
				NewPassword1:
				{
					minlength:6
				},
				ConfirmPassword1:
				{
					minlength:6,
					equalTo : "#NewPassword1"
				}
			},
			beforeSend: function()
			{
				$("#PasswordSuccessMessage1").slideDown(3500);
				$("#PasswordSuccessMessage1").html("Wait...");
			},
			submitHandler: function() {
				var dataString = $("form#NewPassword").serialize();
				$.ajax
				({
					type: "POST",
					url: "changepwd.php",
					cache: false,
					data: dataString,
					success:function(data)
					{
						if(data==1)
						{	 
							$.notify.defaults({
								className: "success"
							})
							$.notify("Password Changed successfully...", {
								position: "bottom left"
							});
						}
						else
						{
							$.notify.defaults({
								className: "error"
							})
							$.notify("Password could not change .. Please Try Again...", {
								position: "bottom left"
							});
						}
						$("#NewPassword1").val('');
						$("#ConfirmPassword1").val('');
					}
				}); 
				return false;
			}
		});
    });
    </script>
</head>

<body>
    <!-- HEADER -->
    <?php include("includes/header.php"); ?>
    <!-- HEADER -->
    
    <div id="stickyalias"></div>
    <a href="#0" class="cd-top"><i class="fa fa-angle-up"></i></a>
    <div id="stickyalias"></div>
   
    <section class="login pb40 margin-top120">
            <div class="container">
				<?php
					if(count($SelectMember) == 0)
					{
				?>
						<div class="row">
							<div class="row">&nbsp;</div>
							<div class="row">&nbsp;</div>
							<div class="row">&nbsp;</div>
							<div class="row">&nbsp;</div>
							<div class="col-md-8 col-md-offset-2 col-sm-12 tabletlandascape">
								<center>Your token has been expired. You cannot reset your password. Please try again.</center>
							</div>
							<div class="row">&nbsp;</div>
							<div class="row">&nbsp;</div>
							<div class="row">&nbsp;</div>
							<div class="row">&nbsp;</div>
						</div>
				<?php
					}
					else
					{
				?>
				
						<div class="row">
							<div class="col-md-8 col-md-offset-2 col-sm-12 tabletlandascape">
								<form id="NewPassword" name="NewPassword" method="post" class="login-form update-profile-form pt40">
									<input type="hidden" name="RegisterID" value="<?php echo $_SESSION['RegisterID']; ?>">
									<input type="hidden" id="Token" name="Token" value="<?php echo $Token; ?>">
								   
									<div class="form-group pb10">
										<label for="inputEmail3" class="col-sm-3 col-md-3 control-label label-profile">NEW PASSWORD</label>
										<div class="col-sm-9 col-md-8">
											<input name="NewPassword1" id="NewPassword1" placeholder="New Password" type="password" class="required form-control mb10" />
										</div>
									</div>
									<div class="form-group pb10">
										<label for="inputEmail3" class="col-sm-3 col-md-3 control-label label-profile">CONFIRM PASSWORD</label>
										<div class="col-sm-9 col-md-8">
											<input name="ConfirmPassword1" id="ConfirmPassword1" placeholder="Confirm Password" type="password" class="required form-control mb20" />
										</div>
									</div>
									<div class="form-group pb10">
										<label for="inputEmail3" class="col-sm-3 col-md-3 control-label label-profile"><span style="display:none;">gender</span></label>
										<div class="col-sm-9 col-md-8 ">
											
											 
											 <button type="submit" id="NewSubmit" name="NewSubmit" class="btn btn-primary profile-update-btn update-profile address-save btn-save-default btnshadow-nor form-control pull-right">
											 <i class="fa fa-pencil pr10"></i>Update
											 </button>
										</div>
									</div>
								</form>
							</div>
						</div>
				<?php
					}
				?>
				
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
    <!--INDEX PAGE JS -->

</body>

</html>
