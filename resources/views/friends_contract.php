
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">

    <title>Sale form Expats' School</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="business godesto saleform">
    <meta name="keywords" content="business,godesto,saleform">
    <meta name="author" content="">


    <!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<![endif]-->

    <!-- CSS Files
    ================================================== -->
    <link rel="stylesheet" media="all"  href="https://www.expatsschools.com/sale_form/css/main.css" type="text/css" id="main-css">
    <link rel="stylesheet"  media="all"  href="https://www.expatsschools.com/sale_form/css/switcher.css" type="text/css">
    <link rel="stylesheet" href="#" id="colors">
    <link rel="stylesheet" href="#" id="boxed">

    <!-- Javascript Files
    ================================================== -->
    <script src="https://www.expatsschools.com/sale_form/js/jquery.min.js"></script>
    <script src="https://www.expatsschools.com/sale_form/js/bootstrap.min.js"></script>
    <script src="https://www.expatsschools.com/sale_form/js/jquery.isotope.min.js"></script>
    <script src="https://www.expatsschools.com/sale_form/js/jquery.prettyPhoto.js"></script>
    <script src="https://www.expatsschools.com/sale_form/js/easing.js"></script>
    <script src="https://www.expatsschools.com/sale_form/js/jquery.ui.totop.js"></script>
    <script src="https://www.expatsschools.com/sale_form/js/selectnav.js"></script>
    <script src="https://www.expatsschools.com/sale_form/js/ender.js"></script>
    <script src="https://www.expatsschools.com/sale_form/js/jquery.lazyload.js"></script>
    <script src="https://www.expatsschools.com/sale_form/js/jquery.flexslider-min.js"></script>
    <script src="https://www.expatsschools.com/sale_form/js/custom.js"></script>


<style>
body{color:#000;}
#subheader {background: #FFF !important;       -webkit-print-color-adjust: exact !important;}
#subheader h1{border-bottom:1px solid #000; color:#000 !important;  -webkit-print-color-adjust: exact !important; padding-bottom:10px; width:100%; border-right:0px !important;}
#subheader span{padding-top:0; color:#000 !important;  -webkit-print-color-adjust: exact !important; }

textarea{padding:10px;}
footer {color: #222;}
footer a{color:#222;}
.form-control{background-color: #ccc !important;  -webkit-print-color-adjust: exact !important;  background-image: none;    -webkit-box-shadow:none;  box-shadow: none;  -webkit-transition: none;transition: none;border: 0;border-radius: 0;margin-bottom: 20px;}
footer h3 {font-size: 20px;color: #428bca;}
.bgbtn{ background-color:#222;   -webkit-print-color-adjust: exact; color:#FFF !important;}

label { text-shadow:none;font-size: 1.5em; font-weight:normal;}
.dotted_fields{    background: none;
    /* border-bottom: 1px dashed; */
    outline: none;
    border: none;
    box-shadow: none;
    border-bottom: 1px dashed;}
	
	#content .container {
    margin-bottom: 50px;
    width: 800px;
    background: #FFF;
    padding-top: 20px;
}
#content{text-shadow:none;}
.btn{color:#000;}

@media (max-width: 800px) 
{
	#content .container { width:100%;}
	#subheader h1{border-right:0;}
	#subheader span{display:block;}
}
:root {
  /* larger checkbox */
}
:root label.checkbox-bootstrap input[type=checkbox] {
  /* hide original check box */
  opacity: 0;
  position: absolute;
  /* find the nearest span with checkbox-placeholder class and draw custom checkbox */
  /* draw checkmark before the span placeholder when original hidden input is checked */
  /* disabled checkbox style */
  /* disabled and checked checkbox style */
  /* when the checkbox is focused with tab key show dots arround */
}
:root label.checkbox-bootstrap input[type=checkbox] + span.checkbox-placeholder {
  width: 14px;
  height: 14px;
  border: 1px solid;
  border-radius: 3px;
  /*checkbox border color*/
  border-color: #737373;
  display: inline-block;
  cursor: pointer;
  margin: 0 7px 0 -20px;
  vertical-align: middle;
  text-align: center;
}
:root label.checkbox-bootstrap input[type=checkbox]:checked + span.checkbox-placeholder {
  background: #428bca;
}
:root label.checkbox-bootstrap input[type=checkbox]:checked + span.checkbox-placeholder:before {
  display: inline-block;
  position: relative;
  vertical-align: text-top;
  width: 5px;
  height: 9px;
  /*checkmark arrow color*/
  border: solid white;
  border-width: 0 2px 2px 0;
  /*can be done with post css autoprefixer*/
  -webkit-transform: rotate(45deg);
  -moz-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  -o-transform: rotate(45deg);
  transform: rotate(45deg);
  content: "";
}
:root label.checkbox-bootstrap input[type=checkbox]:disabled + span.checkbox-placeholder {
  background: #ececec;
  border-color: #c3c2c2;
}
:root label.checkbox-bootstrap input[type=checkbox]:checked:disabled + span.checkbox-placeholder {
  background: #d6d6d6;
  border-color: #bdbdbd;
}
:root label.checkbox-bootstrap input[type=checkbox]:focus:not(:hover) + span.checkbox-placeholder {
  outline: 1px dotted black;
}
:root label.checkbox-bootstrap.checkbox-lg input[type=checkbox] + span.checkbox-placeholder {
  width: 26px;
  height: 26px;
  border: 2px solid;
  border-radius: 5px;
  /*checkbox border color*/
  border-color: #737373;
}
:root label.checkbox-bootstrap.checkbox-lg input[type=checkbox]:checked + span.checkbox-placeholder:before {
  width: 9px;
  height: 15px;
  /*checkmark arrow color*/
  border: solid white;
  border-width: 0 3px 3px 0;
}
label{font-size:1em;}

</style>
</head>

<body>
<?php

		/*
		param = { id:id };		
		param.friend_name = friend_name;
		param.contract_s_date = ;
		param.contract_e_date = ;
		param.venu = ;
		param.deal_desc = ;
		param.redemption = ;
		param.terms = ;
		param.addational_offers = ;
		param.reservation_place = ;
		
		*/
		
		if ( empty( $contracts )  )
		{
			$friend_name 				 = 'JA The Resort Golf Course';
			$contract_s_date			 = '27/11/2018';
			$contract_e_date 			 = '31/05/2019';
			$reservation_place 			 = '- Golf Reception Desk<br>- +971 4 8145023';
			$addational_offers 			 = '- None';
			$redemption 				 = '-  a valid ETC Membership Card-upon redemption';
			$deal_desc 					 = '- JA The Resort Golf Course will offer special rates of AED195 per person for 9 holes and AED295 for 18 holes midweek which include AED50 off F&B in the sports café.<br>- For weekends the special offer will be AED235 for 9 holes and AED385 for 18 holes (Fridays/Saturdays and Public holidays) which include AED50 off F&B in the sports café.';
			$venu 						 = 'JA The Resort Golf Course';
			$terms 						 = '- The above offer for midweek golf (Sunday – Thursday) does not include Public holidays ';
		
			
			$c_name 						 = 'Jon Dove';
			$c_title 						 = 'Cluster General Manager';
			$c_date 						 = '27/11/2018';
			
			$ex_name 						 = 'Rob Patterson';
			$ex_title 						 = 'Founder Member';
			$ex_date 						 = '27/11/2018';
			
		
		
		
		
		
		}
		else
		{
			$friend_name 				= $contracts[0] -> friend_name;
			$contract_s_date			 = $contracts[0] -> contract_s_date;
			$contract_e_date 			 = $contracts[0] -> contract_e_date;
			$reservation_place 			 = $contracts[0] -> reservation_place;
			$addational_offers 			 = $contracts[0] -> addational_offers;
			$redemption 				 = $contracts[0] -> redemption;
			$deal_desc 					 = $contracts[0] -> deal_desc;
			$venu 						 = $contracts[0] -> venu;
			$terms 						 = $contracts[0] -> terms;
			
			$c_name 						 = $contracts[0] -> c_name;
			$c_title 						 = $contracts[0] -> c_title;
			$c_date 						 = $contracts[0] -> c_date;
			
			$ex_name 						 = $contracts[0] -> ex_name;
			$ex_title 						 = $contracts[0] -> ex_title;
			$ex_date 						 = $contracts[0] -> ex_date;
			
			
			
		}


?>
<input type="hidden" id="id" name="id"  value="<?php echo $id;?>">
<?php

?>
    <div id="wrapper">

       

        <!-- subheader begin -->
        <div id="subheader">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div style="width:50%; float:left;"><h1>ETC Friendship Agreement</h1>
                        <span>(expatsschools.com) (A Pegasus Project Consultants DWC-LLC Company)</span>
                        </div>
                        <div class="pull-right"><img src="https://www.expatsschools.com/css/img/logoa.png"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- subheader close -->

        <!-- content begin -->
        <div id="content">
            <div class="container">
             <p>This agreement is made on <span contenteditable>27/11/2018</span></p>
             <p>Between: <span contenteditable id="friend_name"><?php echo $friend_name;?></span> (Hereinafter called ‘Friend’)
             <p>And: Expats Schools, Expat Teachers Club (Hereinafter called ‘ETC’)
             <br> 1) The Friend shall provide the ETC with a discount(s) for each individual ETC member with effect from <span contenteditable id="contract_s_date"><?php echo $contract_s_date;?></span>, which shall be regarded as the commencement date of the agreement, and shall continue until <span contenteditable    id="contract_e_date"><?php echo $contract_e_date;?></span>.
             <br>2) The following discount will be given to the ETC members: (see details below):
             </p>
            
            
            
            
            
            
            
            
            <div class="table-responsive">

                <table class="table table-bordered ">
               
                <tr>
                    <td style="width:35%;">Venu</td>
                    <td><div contenteditable="true" id="venu"><strong><?php echo $venu;?></strong></div></td>
                </tr>
                
                <tr>
                    <td  style="width:35%;">Deal description:</td>
                    <td><div contenteditable="true" id="deal_desc"><strong><?php echo $deal_desc;?></strong></div></td>
                </tr>
                
                
                <tr>
                    <td style="width:35%;">Exclusions/Terms & Conditions: </td>
                    <td><div contenteditable="true" id="terms"><strong><?php echo $terms;?></strong></div></td>
                </tr>
                
                
                
                <tr>
                    <td style="width:35%;">Redemption of deal</td>
                    <td><div contenteditable="true"  id="redemption"><strong><?php echo $redemption;?></strong></div></td>
                </tr>
                
                
                
                <tr>
                    <td style="width:35%;">Additional offers:</td>
                    <td><div contenteditable="true" id="addational_offers"><strong><?php echo $addational_offers;?></strong></div></td>
                </tr>
                
                
                <tr>
                    <td style="width:35%;">Reservation/Contact details for Members:</td>
                    <td>
                    <div contenteditable="true"  id="reservation_place"><strong><?php echo $reservation_place;?></strong></div>
					</td>
                </tr>
                
                 
                
                
                </table>
		</div>
        
        <div>
        <p>For the ETC office, the primary contact for the Friend is:</p>
        </div>
        
        
         <div class="table-responsive">

                <table class="table table-bordered ">
                        <tr>
                            <td style="width:35%;">Contact Person:</td>
                            <td><div contenteditable="true"><strong>Rob Patterson</strong></div></td>
                        </tr>
                        
                        <tr>
                            <td style="width:35%;">Contact E-mail:</td>
                            <td><div contenteditable="true"><strong>rob@expatsschools.com</strong></div></td>
                        </tr>
                        
                        <tr>
                            <td style="width:35%;">Contact Phone:</td>
                            <td><div contenteditable="true"><strong>+971 50 211 0661</strong></div></td>
                        </tr>
                        
                        
                        <tr>
                            <td style="width:35%;">Head Office Address:</td>
                            <td><div contenteditable="true"><strong>PO Box 712626</strong></div></td>
                        </tr>
       			 </table>
        
        </div>
        
        
        <div>
        
        <p>3) Discounts shall be granted on production of the ETC mobile application (card examples and screenshots of the mobile application will be provided by the ETC).</p>

        <p>4) The ETC will create the Friend’s profile on the ETC website with the information mentioned in (2) within one (1) week of receiving this signed agreement and will maintain it as required until the expiry or termination of the agreement. The Friend will receive an email with login details to the ETC website’s back end within one (1) week of sending the signed agreement.</p>
        
        <p>5) The Partner will upload all the necessary information (address, contact numbers, locations, detailed description of the venue(s) etc.) to the ETC website’s back end within one (1) week of commencement on this agreement and is responsible for keeping deal details up-to-date until the expiry or termination of the agreement. The Friend is also responsible for uploading special offers and promotions. All information uploaded to the website will be approved by the ETC office within two (2) business days. 
	        In the event the Friend fails to upload information to the ETC website’s back end for more than one (1) month from the commencement of this agreement, the ETC has the right to immediately disable the Partner’s login to the ETC website and terminate this contract.</p>
        
       <p>6) The Partner agrees to use the appropriate Redeem Code to track spend and savings by ETC members. Friends operating online agree to manually input sales to ETC members. This information shall remain confidential between both parties.</p>
        
        <p>7) In case of termination or breach of contract:
        <ul>
        	<li>In case of termination or changes to the Terms & Conditions of the offer one (1) months’ notice must be given by either party.</li>
       	    <li>In the event the Friend fails to oblige to the terms laid down in this agreement, the ETC has the right to immediately disable the Friend’s advertisement(s) on the ETC website and mobile application until the matter is resolved.</li>
       	</ul>
         </p>
        
        <p>8) Each ETC member shall be personally responsible for payment of:<p>
      	<ul>
        	<li>All accounts in respect of goods, products and services provided to him/her by the Friend.</li>
      		 <li>Compensation to the Friend and/or its staff in case of any damage caused to the outlet property, goods or products or any injury inflicted on its personnel.</li>
        </ul>
        <p>All such payments shall be settled by each ETC member either prior to or at the time of use. ETC accepts no responsibility for any costs and expenses incurred by or owed to the specified outlet as referred to the above; however, the ETC will use its best endeavors to recover the amount owned.</p>
        
        <p>9) The ETC reserves the right to terminate a contract if usage figures indicate low usage by ETC members within the notice period specified.</p>
        
        <p>10) The ETC reserves the right to cancel the friendship agreement if a higher discount is being offered to another educational industry discount program. The friend will be offered the opportunity to match or better the discount offered to the ETC.</p> 
        
        <p>11) Any change or amendment of this agreement has to be put in writing and signed by both parties to become valid.</p>
        
        <p>12) Should any clause of this agreement be invalid, this shall not affect the validity of the remaining clauses. The invalid clause is to be replaced with a corresponding text, which is valid and equivalent.</p>
        
        
        
        </div>
        
        <div>
        
        
        
        
<div>
<p><strong>On behalf of the Friend:</strong></p>			
<div style="width:50%; float:left;">
<p><span style="width:10%; display:inline-block;">Date</span> 	<span contenteditable="true" id="c_date" style="margin-left:20px;"><strong><?php echo $c_date;?></strong></span></p>	
<p><span style="width:10%; display:inline-block;">Name</span>		<span contenteditable="true" id="c_name"  style="margin-left:20px;"><strong><?php echo $c_name;?></strong></span></p>
</div>
<div style="width:50%; float:left;">
<p><span style="width:14%; display:inline-block;">Title</span>	<span contenteditable="true" id="c_title"  style="margin-left:20px;"><strong><?php echo $c_title;?> </strong></span></p>  
<p><span style="width:14%; display:inline-block;">Signature</span>	<span contenteditable="true"  style="margin-left:20px;"><strong>________________________</strong></span></p>
</div>

</div>

<div style="margin-top:20px; float:left; width:100%;">
<p><strong>On behalf of the Expats’ Schools:</strong></p>			
<div style="width:50%; float:left;">
<p><span style="width:10%; display:inline-block;">Date</span> 	<span contenteditable="true" id="ex_date" style="margin-left:20px;"><strong><?php echo $ex_date;?></strong></span></p>	
<p><span style="width:10%; display:inline-block;">Name</span>		<span contenteditable="true" id="ex_name"  style="margin-left:20px;"><strong><?php echo $ex_name;?></strong></span></p>
</div>
<div style="width:50%; float:left;">
<p><span style="width:14%; display:inline-block;">Title</span>	<span contenteditable="true" id="ex_title"  style="margin-left:20px;"><strong><?php echo $ex_title;?></strong></span></p>  
<p><span style="width:14%; display:inline-block;">Signature</span>	<span contenteditable="true"  style="margin-left:20px;"><strong>________________________</strong></span></p>
</div>

</div>











        </div>
                
                
                

            </div>
        </div>
        <!-- content close -->

        <!-- footer begin -->
        <footer style="background:#ddd !important; text-align:center; -webkit-print-color-adjust: exact !important;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                    <p><strong>hello@expattschools.com<strong></p>
                    <p><strong>expattschools.com<strong></p>
                    <p><strong>PO Box 71262</strong></p>                    
                    </div>
                </div>
            </div>
        </footer>
        <!-- footer close -->

    </div>

    <!-- style switcher
    ================================================== -->
    <script src="https://www.expatsschools.com/sale_form/js/switcher.js"></script>


    <script>
	$(document).ready(function(e)
	{
        setInterval( save_contract, 5000);
    });
	
	function save_contract()
	{
		id = $('#id').val();
		friend_name 		 = $('#friend_name').html();
		contract_s_date		 = $('#contract_s_date').html();
		contract_e_date		 = $('#contract_e_date').html();
		venu		 		 = $('#venu strong').html();
		deal_desc			 = $('#deal_desc strong').html();
		redemption 			 = $('#redemption strong').html();
		terms				 = $('#terms strong').html();
		addational_offers	 = $('#addational_offers strong').html();
		reservation_place    = $('#reservation_place strong').html();
		
		ex_title  			  = $('#ex_title strong').html();
		ex_date   			 = $('#ex_date strong').html();
		ex_name   			 = $('#ex_name strong').html();
		
		c_name    	 = $('#c_name strong').html();
		c_title   	 = $('#c_title strong').html();
		c_date    	 = $('#c_date strong').html();
		
		
		param = { id:id };		
		param.friend_name = friend_name;
		param.contract_s_date = contract_s_date;
		param.contract_e_date = contract_e_date;
		param.venu = venu;
		param.deal_desc = deal_desc;
		param.redemption = redemption;
		param.terms = terms;
		param.addational_offers = addational_offers;
		param.reservation_place = reservation_place;
		param.t=1;
		
	
		
		param.c_name = c_name;
		param.c_title = c_title;
		param.c_date = c_date;
		
		param.ex_name = ex_name;
		param.ex_title = ex_title;
		param.ex_date = ex_date;
		param._token = token;
		
		
		console.log(param);
		//return;
		$.ajax({
			type: 'POST',
			url: $('body').attr('fullpath') + '/friends_contract',
			data: param,
			success: function(response) 
			{
			}
		}); 		
		
	}
	
	</script>

</body>
</html>
