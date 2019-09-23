<?php
	/*----------File Information----------*/
	#Project : HashTag
	#File Created By : Avani Trivedi 
	#File Created Date : 11 Nov 2016
	#File Edited By :
	#File Edited Date :
	/*----------File Information----------*/

	include("includes/connection.php");
	require_once('includes/class.phpmailer.php');
	include("includes/includebase.php");
	$obj = new myclass();
	session_start();
	$Year = date('Y');
	$from = $_POST['from'];

	
	  if($_POST['Action']=="Update")
	  {
		$RegisterID = $_POST['RegisterID'];
		$FirstName = addslashes($_POST["FirstName"]);
		$LastName = addslashes($_POST["LastName"]);
		$ContactNo = $_POST["ContactNo"];
		$Gender = $_POST['Gender'];
		$Email = $_POST["Email"];
		$_SESSION["FullName"] = $FirstName;
		$update = $obj->sql_query("UPDATE tbl_register SET FirstName = '".$FirstName."', LastName = '".$LastName."', Email = '".$Email."', ContactNo = '".$ContactNo."', Gender = '".$Gender."' WHERE RegisterID = '".$RegisterID."'");
		  
		echo $FirstName ;
		exit;
	  }
	  else
	  {
		$FirstName = addslashes($_POST["FirstName"]);
		$LastName = addslashes($_POST["LastName"]);
		$ContactNo = $_POST["ContactNo"];
		$Email = $_POST["Email"];
		$UserImage = $_FILES['UserImage']['name'];
		$Password = $_POST["Password1"];
		$DisplayOrder = $_POST['DisplayOrder'];
		$Status = $_POST['Status'];
		
		$SelectEmail = $obj->sql_query("SELECT Email FROM tbl_register WHERE Email = '".$Email."'");
		if(count($SelectEmail) == 0)
		{
			$insert = $obj->sql_query("INSERT INTO tbl_register (RegisterID, FirstName, LastName, ContactNo, Email, UserImage, Password, RegisterDate, Status)
			VALUES ('', '".$FirstName."', '".$LastName."', '".$ContactNo."', '".$Email."', '', '".$Password."', CURRENT_TIMESTAMP, 'Active')");
		
			$_SESSION['RegisterID'] = mysql_insert_id();
			$_SESSION["FullName"] = $FirstName;
			
			$_SESSION['on_off1_member'] = 1;
		
			$subject = "Welcome to Hashtagshop.in";

			$toemail = "$Email";
			
			$mailbody = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<title>Untitled Document</title>
</head>

<body>
<table width='600px' align='center' style='border:#ddd 1px solid;'>
	<tr>
		<td><div style='width:600px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; margin:0px; padding:0px; border:#ddd 1px solid;'> 
  <!--header-->
  <div style='background:#FFDE00; padding:25px 0px;'></div>
  <div style='position:relative; background:#000; padding:0px 0px 0px 0px; text-align:center;'>
    <div style='position:absolute; top:-32px; left:35%;'><a href='#'><img src='images/logoa.png'/></a></div>
  </div>
  <!--emial data-->
  <div style='width:100%;'>
    <div style='padding:0px 20px 20px 20px;'>
      <h1>Hello, ".$FirstName."</h1>
      <h3>Welcome to Hashtagshop.in!</h3>
      <p>We are very happy to have you on our website. As a registered user, you will be able to access the website features.</p>
      <p>Thank you for registering with us!</p>
      <p>Happy Shopping!</p>
    </div>
  </div>
  <!--footer-->
  <div style='background:#359ADE; padding:20px; font-size:24px; color:#FFFFFF; text-align:center;'> Start Shopping <a href='".$BASE."' style='color:#fff;'>Click Here.</a> </div>
  <div style='background:#fff; text-align:center;'>
    <h3 style='color:#000;'>Connect With Us</h3>
    <div style='padding-bottom:20px;'><a href='#'><img src='images/1451521558_facebook_circle_color.png'/></a><a href='#'><img src='images/1451521580_twitter_circle_color.png'/></a><a href='#'><img src='images/1451521606_instagram_circle_color.png'/></a><a href='#'><img src='images/1451521612_google_circle_color.png'/></a><a href='#'><img src='images/1451521962_pinterest.png'/></a></div>
    <div style='background:#ffde00;padding:1px 0px'><p>Hashtag Web Shop,6/A Virnagar Society, Opp. Kiranpark & IDBI Bank,Bhimjipura Cross Roads, New Vadaj,Ahmedabad - 380013</p><p>Tel.: +91 9913456456 Email: hello@hashtagshop.in</p></div>
	<div style='background:#000; padding:5px 0px; color:#999;'>&copy; ".$Year." Hashtag All Rights Reserved. </div>
  </div>
</div></td>
	</tr>
</table>
</body>
</html>";

			// PHP MAIL FUNCTION
				$mail = new PHPMailer(); // defaults to using php "mail()"
				$mail->SetFrom("sendmail@hashtagshop.in", "Hashtag");
				$mail->AddReplyTo("$Email","$FirstName");
				$address = "$Email";
				$mail->AddAddress($address, "");
				$mail->Subject    = "$subject";
				$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; //optional, comment out and test
				$mail->MsgHTML($mailbody);
				$mail->IsSMTP();
				$mail->CharSet = "ISO-8859-1";
				$mail->SMTPAuth = true;
				$mail->Host = "mail.hashtagshop.in";
				$mail->Port = "587";
				$mail->Username = 'sendmail@hashtagshop.in';
				$mail->Password = 'hshop!@#';
				$mail->Send();
			// PHP MAIL FUNCTION
			
			
			
			
			$SelectAdminEmail = $obj->sql_query("SELECT * FROM tbl_admin");
			$Adminemail = $SelectAdminEmail[0]['AdminEmail'];
			$AdminName = $SelectAdminEmail[0]['AdminUserName'];
			
			$subject = "Hashtag - New User Register";
			$toemail = "$Adminemail";
			
			$mailbody = "<table width='800' border='1'>
						  <tr>
							<td colspan='2'><font face='Verdana, Geneva, sans-serif'>New User Registered,<br />
							 Below Are User's Detail
							</font></td>
						  </tr>
						  <tr>
							<td width='25%'><font face='Verdana, Geneva, sans-serif'>Login Link : </font></td>
							<td width='75%'><font face='Verdana, Geneva, sans-serif'>".$BASE."login</font></td>
						  </tr>
						  <tr>
							<td><font face='Verdana, Geneva, sans-serif'>Username : </font></td>
							<td><font face='Verdana, Geneva, sans-serif'>$FirstName</font></td>
						  </tr>
						  <tr>
							<td><font face='Verdana, Geneva, sans-serif'>Email : </font></td>
							<td><font face='Verdana, Geneva, sans-serif'>$Email</font></td>
						  </tr>
						  <tr>
							<td><font face='Verdana, Geneva, sans-serif'>Password : </font></td>
							<td><font face='Verdana, Geneva, sans-serif'>$Password</font></td>
						  </tr>
						  <tr>
							<td colspan='2'><font face='Verdana, Geneva, sans-serif'>Thanks<br />
						Hashatg Team</font></td>
						  </tr>
						</table>";
	
			// PHP MAIL FUNCTION
				$mail = new PHPMailer(); // defaults to using php "mail()"
	
				$mail->SetFrom("sendmail@hashtagshop.in", "Hashtag");
				$mail->AddReplyTo("$Adminemail","$AdminName");
				$address = "$Adminemail";
				$mail->AddAddress($address, "");
				$mail->Subject    = "$subject";
				$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; //optional, comment out and test
				$mail->MsgHTML($mailbody);
				$mail->IsSMTP();
				$mail->CharSet = "ISO-8859-1";
				$mail->SMTPAuth = true;
				$mail->Host = "mail.hashtagshop.in";
				$mail->Port = "587";
				$mail->Username = 'sendmail@hashtagshop.in';
				$mail->Password = 'hshop!@#';
				
				$mail->Send();
	
			if(!$insert)
			{
				echo '2';
				exit;
			}
			else
			{
				echo '1';
			}
			exit;
		}
	 }
	?>