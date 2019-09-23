<?php
	

	include("includes/connection.php");
	
	require_once('includes/class.phpmailer.php');
	
	$obj = new myclass();
	session_start();
	
	$date = date('Y');
	date_default_timezone_set('asia/calcutta');
	$todaydate = date('Y-m-d');
	$todaytime = date('h:i:s A');
	include("includes/includebase.php");
	
	
		$Email = $_POST["SubscriberEmail"];
		
		$sql= $obj->sql_query("select Email from tbl_signupdata where Email = '".$Email."'");
		if(count($sql)==0)
		{
			$obj->sql_query("INSERT INTO tbl_signupdata (SignUpDataID, Name, Email, SignUpDate, SignUpTime)
			VALUES (NULL, '', '".$Email."','".$todaydate."','".$todaytime."')");
			
			
			$subject = "Hashtag - Newsletters Subscription";
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
      <h1>Hello, ".$Email."</h1>
      <h3>Welcome to Hashtagshop.in!</h3>
      <p>Thank you for subscribing with <a href='".$BASE."'>hashtagshop.in</a>. Stay connected and keep shopping.</p>
      <p>Happy Shopping!</p>
    </div>
  </div>
  <!--footer-->
  <div style='background:#359ADE; padding:20px; font-size:24px; color:#FFFFFF; text-align:center;'> Start Shopping <a href='".$BASE."' style='color:#fff;'>Click Here.</a> </div>
  <div style='background:#fff; text-align:center;'>
    <h3 style='color:#000;'>Connect With Us</h3>
    <div style='padding-bottom:20px;'><a href='#'><img src='images/1451521558_facebook_circle_color.png'/></a><a href='#'><img src='images/1451521580_twitter_circle_color.png'/></a><a href='#'><img src='images/1451521606_instagram_circle_color.png'/></a><a href='#'><img src='images/1451521612_google_circle_color.png'/></a><a href='#'><img src='images/1451521962_pinterest.png'/></a></div>
    <div style='background:#ffde00;padding:1px 0px'><p>Hashtag Web Shop,6/A Virnagar Society, Opp. Kiranpark & IDBI Bank,Bhimjipura Cross Roads, New Vadaj,Ahmedabad - 380013</p><p>Tel.: +91 9913456456 Email: hello@hashtagshop.in</p></div>
	<div style='background:#000; padding:5px 0px; color:#999;'>&copy; ".$date." Hashtag All Rights Reserved. </div>
  </div>
</div></td>
	</tr>
</table>
</body>
</html>";
			
			$mail = new PHPMailer(); // defaults to using php "mail()"
			$mail->SetFrom("sendmail@hashtagshop.in", "Hashtag");
			$mail->AddReplyTo("$Email","$Name");
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
			echo '1';
		}
		else
		{
			echo '2';
		}
	
?>