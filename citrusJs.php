<?php
   //Need to change with your Secret Key
    $secret_key = "xXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX"; 
    
    //Need to change with your Access Key
    $access_key = "XXXXXXXXXXXXXXXXXXXXXX"; 
    //Should be unique for every transaction
    $txnID = uniqid();
    //Need to change with your Order Amount
    $amount = "1.00"; 
    //Need to change with your Return URL
    $returnURL = "http://localhost/citrus/php/merchantCheckout/result.php";
    //Need to change with your Notify URL
    $notifyUrl = "www.YourDomain.com/notifyResponsePage";

    $data = "merchantAccessKey=" . $access_key
                . "&transactionId="  . $txnID 
                . "&amount="         . $amount;
    $signature = hash_hmac('sha1', $data, $secret_key);

?>
<html>
	<head>
		<script src="http://code.jquery.com/jquery-1.11.1.min.js"> </script>
		<script src="https://icp.citruspay.com/js/citrus.js"> </script>
		<script src="https://icp.citruspay.com/js/jquery.payment.min.js"> </script>
		 
		 <script type="text/javascript">
		 jQuery(document).ready(function() {	
			jQuery.support.cors = true; 
			
			// setup card inputs;	 	
			jQuery('#citrusExpiry').payment('formatCardExpiry');
			jQuery('#citrusCvv').payment('formatCardCVC');
			jQuery('#citrusNumber').keyup(function() {
				var cardNum = jQuery('#citrusNumber').val().replace(/\s+/g, '');		
					var type = jQuery.payment.cardType(cardNum);
					console.log(type);
					jQuery("#citrusNumber").css("background-image", "url(images/" + type + ".png)");						
					if(type!='amex')
					jQuery("#citrusCvv").attr("maxlength","3");
					else
					jQuery("#citrusCvv").attr("maxlength","4");						
					jQuery('#citrusNumber').payment('formatCardNumber');											
					jQuery("#citrusScheme").val(type);		
			});				 
		});
			CitrusPay.Merchant.Config = {
				// Merchant details
				Merchant: {
					accessKey: 'XXXXXXXXXXXXXXXXXXXXX', //Replace with your access key
					vanityUrl: 'YYYYYYYYYYYYYY'  //Replace with your vanity URL
				}
			};
		</script>
		<script type="text/javascript">
    
			fetchPaymentOptions();
			
			function handleCitrusPaymentOptions(citrusPaymentOptions) {
				if (citrusPaymentOptions.netBanking != null)
					for (i = 0; i < citrusPaymentOptions.netBanking.length; i++) {
						var obj = document.getElementById("citrusAvailableOptions");
						var option = document.createElement("option");
						option.text = citrusPaymentOptions.netBanking[i].bankName;
						option.value = citrusPaymentOptions.netBanking[i].issuerCode;
						obj = option;
					}
			}
		</script>
		<script type="text/javascript">
			function citrusServerErrorMsg(errorResponse) {
				alert(errorResponse);
				console.log(errorResponse);
			}
			function citrusClientErrMsg(errorResponse) {
				alert(errorResponse);
				console.log(errorResponse);
			}
		</script>
		
		
	</head>
	<body>
		<form>
			<label for="citrusFirstName">First Name</label>
			<input type="hidden" id="citrusFirstName" value="Sahil" /> <br/>
			<label for="citrusLastName">Last Name</label>
			<input type="hidden" id="citrusLastName" value="Garg" /><br/>
			
			<label for="citrusEmail">Email</label>
			<input type="text" id="citrusEmail" value="" /><br/><br/>
			
			<label for="citrusStreet1">Address 1</label>
			<input type="hidden" id="citrusStreet1" value="" /><br/><br/>
			<label for="citrusStreet2">Address 2</label>
			<input type="hidden" id="citrusStreet2" value="" /><br/><br/>
			<label for="citrusCity">City</label>
			<input type="hidden" id="citrusCity" value="" /><br/><br/>
			<label for="citrusState">State</label>
			<input type="hidden" id="citrusState" value="" /><br/><br/>
			<label for="citrusCountry">Country</label>
			<input type="hidden" id="citrusCountry" value="" /><br/><br/>
			<label for="citrusZip">Zip</label>
			<input type="hidden" id="citrusZip" value="" /><br/><br/>
			<label for="citrusMobile">Mobile</label>
			<input type="text" id="citrusMobile" value="" /><br/><br/>
			
			<label for="citrusAmount">Amount</label>
			<input type="text" readonly id="citrusAmount" value="<?php echo $amount;?>" /><br/><br/>
			<label for="citrusMerchantTxnId">Transaction Id</label>
			<input type="text" readonly id="citrusMerchantTxnId" value="<?php echo $txnID;?>" /><br/><br/>
			
			<input type="hidden" readonly id="citrusSignature" value="<?php echo $signature;?>" /><br/><br/>
			
			<input type="hidden" readonly id="citrusReturnUrl" value="<?php echo $returnURL;?>" /><br/><br/>
			
			<input type="hidden" readonly id="citrusNotifyUrl" value="<?php echo $notifyUrl;?>" /><br/><br/>
			
			<label for="citrusCardType">Select Card Type</label>
			 <select id="citrusCardType">
				<option selected="selected" value="credit">Credit</option>
				<option value="debit">Debit</option>
			</select><br/><br/>
			<label for="citrusScheme">Select Card Affiliation</label>
			<select id="citrusScheme">
				<option selected="selected" value="VISA">VISA</option>
				<option value="mastercard">MASTER</option>
			</select><br/><br/>
			
			<label for="citrusNumber">Enter Card Number</label>
			<input type="text" id="citrusNumber" value=""/><br/><br/>
			
			<label for="citrusCardHolder">Name on Card</label>
			<input type="text" id="citrusCardHolder" value=""/><br/><br/>
			
			<label for="citrusExpiry">Expiry Date</label>
			<input type="text" id="citrusExpiry" value=""/><br/><br/>
			
			<label for="citrusCvv">Enter CVV</label>
			<input placeholder="CVV" type="password" id="citrusCvv" name="cvv" class="FailureMsgHide" autocomplete="off" value=""><br/><br/>
			
			<input type="button" value="Pay Now" id="citrusCardPayButton"/>
          
		</form>
		
		<script type="text/javascript">
		
			//Net Banking
			$('#citrusNetbankingButton').on("click", function () { makePayment("netbanking") });
			//Card Payment
			$("#citrusCardPayButton").on("click", function () { makePayment("card") });
		</script>
		
	</body>
</html>