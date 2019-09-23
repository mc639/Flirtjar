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
	$from = $_GET['from'];
	$_SESSION['RedirectTo'] = $from;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HashTag - Terms & Conditions</title>
    
    <?php include("includes/js_css.php"); ?>
</head>

<body>
	<!-- HEADER -->
    <?php include("includes/header.php"); ?>
    <!-- HEADER -->
    
    <div id="stickyalias"></div>
    
    <!-- ICON FOR GO BOTTOM TO TOP -->
    <a href="#0" class="cd-top"><i class="fa fa-angle-up"></i></a>
    <!-- ICON FOR GO BOTTOM TO TOP -->
    
    <!-- BREADCRUM DIV -->
    <section class="headingdisplay margin-top120">
        <div class="container">
            <div class="row">
                <div class="col-md-6 ">
                    <h1 class="pull-left">Terms Of Use</h1>
                </div>
                <div class="col-md-6 ">
                    <ul class="breadcrumb pull-right">
                        <li><a href="index">Home</a></li>
                        <li><a href="terms-of-use" class="active"><i class="fa fa-angle-right pr5 breakdivsion"></i>Terms Of Use</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- BREADCRUM DIV -->
    
    <!-- CONTENT DIV -->
    <section class="about-us">
        <div class="container">
            <div class="row">
            
                <div class="col-md-12">
                    <p>Access to and use of Hashtagshop.in and the products and service available through the website are subject to the following terms, conditions and notices (herein after called “Terms of Use”). By browsing through these Terms of Use and using the services provided by our website (hashtagshop.in), you agree to all Terms of Usealong with the Privacy Policy on our website, which may be updated by us from time to time. Please check this page regularly to take notice of any changes we may have made to the Terms of Use. </p>
                    <p>We reserve the right to withdraw or amend the services without notice. We will not be liable if for any reason this Website is unavailable at any time or for any period. From time to time, we may restrict access to some parts or this entire Website.</p>
                	<p>The user may carefully read all the information on products and services as provided in relevant sections.</p>
                </div>
                
                <div class="col-md-12">
                    <ul class="general-vertical">
                        <li><span><i class="fa fa-circle-o-notch fa-1 pr10"></i>This website www.hashtagshop.in is operated by Hashtag Webshop (herein after called “Company”), an India based company incorporated under the Indian Partnership Act of 1932. With our registered office at</span></li>
                        <li><span><i class="fa fa-circle-o-notch fa-1 pr10"></i>Our Privacy Policy incorporated by reference in these Terms of Use, sets out how we will use personal information you provide to us. By using this Website, you agree to be bound by the Privacy Policy, and warrant that all data provided by you is accurate and up to date. For details please visit our Privacy Policy section.</span></li>
                        <li><span><i class="fa fa-circle-o-notch fa-1 pr10"></i>The liability of Company under this Terms of Use is limited to the value of the product purchased from Company plus shipping charges that may have been charged. Under no circumstances shall Company be liable for any direct or indirect costs incurred by you for any reason related to the purchase or intended purchase of products and services on the website owned by Company.</span></li>
                       
                        <li><span><i class="fa fa-circle-o-notch fa-1 pr10"></i>Company will not be responsible for any liability arising out of the conduct of its employees, associates, contractors and suppliers that may cause any financial or other loss to you.</span></li>
                        <li><span><i class="fa fa-circle-o-notch fa-1 pr10"></i>Company owns the Website and shall retain all intellectual property rights, and ownership and proprietary rights and shall have the sole right, title and interest in and over the Website. No part of the website, the designs or the terms and references within shall be copied or transmitted for commercial purposes. Nothing contained in this Terms of Use shall give or be deemed to grant, whether directly or by implication, you any right, title or interest in or to the ownership or use of the Trade Marks and Intellectual property. Purchases of products on this site do not transfer any of the intellectual property related to the products, their design or concepts to you.</span></li>
                        <li><span><i class="fa fa-circle-o-notch fa-1 pr10"></i>Any fraud, neglect, deliberate omission, wrongful act or default conducted by you will be subject to legal action and Company will not be responsible for your actions.</span></li>
                        <li><span><i class="fa fa-circle-o-notch fa-1 pr10"></i>Company shall not be liable for any loss or damage arising from its failure to perform any of its obligations under this Terms of Use if such failure is the result of circumstances outside its control including but not limited to the outbreak of war, any governmental act, act of war, explosion, accident, civil commotion, riot, industrial dispute, strike, lockout, stoppages or restraint of labor from whatever cause, whether partial or general, weather conditions, traffic congestion, mechanical breakdown, obstruction of any public or private road or highway or outbreak of any communicable disease or any other force majeure, fire, flood or any other act of God.</span></li>
                        <li><span><i class="fa fa-circle-o-notch fa-1 pr10"></i>Company may at any time make changes or modify the website, its contents, the policies and terms and conditions including the privacy policy, shipping policy, return policy without any prior notice and it may do so with no prior permissions from users of the site or service.</span></li>
                        <li><span><i class="fa fa-circle-o-notch fa-1 pr10"></i>We ensure that all details of prices appearing on the website are accurate, however errors may occur. If we discover an error in the price of any goods, which you have ordered, we will inform you of this as soon as possible. If we are unable to contact you we will treat the order as cancelled. If you cancel and you have already paid for the goods, you will receive a full refund. Additionally, prices for items may change from time to time without notice. However, these changes will not affect orders that have already been dispatched. The price of an item includes VAT (or similar sales tax) at the prevailing rate for which we are responsible as a seller. Please note that the prices listed on the website are only applicable for items purchased on the website and not through any other source.</span></li>
                        <li><span><i class="fa fa-circle-o-notch fa-1 pr10"></i>The images of the items on the website are for illustrative purposes only. Although we have made every effort to display the colors accurately, we cannot guarantee that your computer's display of the colors accurately reflect the color of the items. Your items may vary slightly from those images. All sizes and measurements of items are approximate; however we do make every effort to ensure they are accurate as possible. We take all reasonable care to ensure that all details, descriptions and prices of items are as accurate as possible.</span></li>
                        <li><span><i class="fa fa-circle-o-notch fa-1 pr10"></i>The buyer or user of the product needs to make their own judgment of the safety and risks associated with various products that may be sold, and are solely responsible for the consequences of use of these products. Company is not responsible for any consequences that arise from the use of the product.</span></li>
                        <li><span><i class="fa fa-circle-o-notch fa-1 pr10"></i>You will be given various options for delivery of items during the order process. The options available to you will vary depending on where you are ordering. An estimated delivery time is displayed on the order summary page. On placing your order, you will receive an email containing a summary of the order and also the estimated delivery time to your location. Sometimes, delivery may take longer due to unforeseen circumstances. In such cases, we will proactively reach out to you by e-mail and SMS. However, we will not be able to compensate for any mental agony caused due to delay in delivery. If a non-delivery or late delivery occurs due to a negligence of the User (i.e. wrong or incomplete name or address or recipient not available) any extra cost spent by Company for re-delivery shall be claimed from the User placing the order.</span></li>
                        <li><span><i class="fa fa-circle-o-notch fa-1 pr10"></i>Request for cancellations of orders once placed on Website shall not be entertained.You can only return damaged products or products that are not as per your order. Returns must comply with the Return Policy as given in Return Policy section. Also Company shall not entertain any complains after 15 days, once the order is delivered.</span></li>
                        <li><span><i class="fa fa-circle-o-notch fa-1 pr10"></i>The User certifies that he/she is at least 18 (eighteen) years of age or has the consent of a parent or legal guardian to use the website www.hashtagshop.in</span></li>
                        <li><span><i class="fa fa-circle-o-notch fa-1 pr10"></i>These terms shall be governed by and constructed in accordance with the laws of India without reference to conflict of laws principles and disputes arising in relation hereto shall be subject to the exclusive jurisdiction of the courts at Ahmedabad (Gujarat).</span></li>
                        <li><span><i class="fa fa-circle-o-notch fa-1 pr10"></i>The User agrees to give accurate, authentic and true information. Company reserves the right to confirm and validate the information and other details provided by the User at any point of time. If any such User details are found not to be true wholly or partly, Company has the right in its sole discretion to reject the registration and debar the User from using the services of Hashtagshop.in and / or other affiliated websites without prior intimation whatsoever.</span></li>
                        <li><span><i class="fa fa-circle-o-notch fa-1 pr10"></i>You agree that the Company may, in its sole discretion and without prior notice, terminate your access to the website and block your future access if we determine that you have violated these Terms of Service or any other policies. If you or the Company terminates your use of any service, you shall still be liable to pay for any service that you have already ordered till the time of such termination.</span></li>
                        <li><span><i class="fa fa-circle-o-notch fa-1 pr10"></i>Company has the right to assign or transfer all or part of its rights or obligations under this Agreement without prior notification.</span></li>
                        <li><span><i class="fa fa-circle-o-notch fa-1 pr10"></i>If you do not agree with Terms of Use of Website or dissatisfied with website or material available on it, please do not use this website.</span></li>
                        <li><span><i class="fa fa-circle-o-notch fa-1 pr10"></i>In the event of any disputes, differences or controversies between the Parties hereto, out of or in connection with the provisions of this Agreement, or any action taken hereunder, the Parties hereto shall thoroughly explore all possibilities for an amicable settlement. In case an amicable settlement cannot be reached, a sole arbitrator in accordance with the provisions of the Arbitration and Conciliation Act, 1996 including any amendment or re-enactment thereof, shall refer such disputes, differences or controversies to arbitration. The proceedings of such arbitration shall be conducted in English language and the venue of such arbitration shall be Ahmedabad (Gujarat). The award of such arbitration shall be final and binding upon the Parties hereto.</span></li>
                        <li><span><i class="fa fa-circle-o-notch fa-1 pr10"></i>If you have any questions, comments or requests regarding our Terms of Use or the website please contact us at feedback@hashtagshop.in.All notices, demands or other communications required or permitted to be given or made under or in connection with this Terms of Use shall be in writing and shall be sufficiently given or made (a) if delivered by hand or (b) sent by pre-paid registered post addressed to Company’s registered office.</span></li>
                    </ul>
                </div>
                
                
            </div>
       </div>
    </section>
    <!-- CONTENT DIV -->
    
    <div class="seperator"></div>
    
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
    
</body>

</html>
