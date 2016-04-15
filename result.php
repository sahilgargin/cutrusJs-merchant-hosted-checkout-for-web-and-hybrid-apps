
    <?php
    //Replace this with your secret key from the citrus panel
	$secret_key = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
	 
	$data = "";
	$flag = "true";
	if(isset($_POST['TxId'])) {
		$txnid = $_POST['TxId'];
		$data .= $txnid;
	}
	 if(isset($_POST['TxStatus'])) {
		$txnstatus = $_POST['TxStatus'];
		$data .= $txnstatus;
	 }
	 if(isset($_POST['amount'])) {
		$amount = $_POST['amount'];
		$data .= $amount;
	 }
	 if(isset($_POST['pgTxnNo'])) {
		$pgtxnno = $_POST['pgTxnNo'];
		$data .= $pgtxnno;
	 }
	 if(isset($_POST['issuerRefNo'])) {
		$issuerrefno = $_POST['issuerRefNo'];
		$data .= $issuerrefno;
	 }
	 if(isset($_POST['authIdCode'])) {
		$authidcode = $_POST['authIdCode'];
		$data .= $authidcode;
	 }
	 if(isset($_POST['firstName'])) {
		$firstName = $_POST['firstName'];
		$data .= $firstName;
	 }
	 if(isset($_POST['lastName'])) {
		$lastName = $_POST['lastName'];
		$data .= $lastName;
	 }
	 if(isset($_POST['pgRespCode'])) {
		$pgrespcode = $_POST['pgRespCode'];
		$data .= $pgrespcode;
	 }
	 if(isset($_POST['addressZip'])) {
		$pincode = $_POST['addressZip'];
		$data .= $pincode;
	 }
	 if(isset($_POST['signature'])) {
		$signature = $_POST['signature'];
	 }
     
    $respSignature = hash_hmac('sha1', $data, $secret_key);
	 if($signature != "" && strcmp($signature, $respSignature) != 0) {
		$flag = "false";
	 }
    ?>
    <html>
    <head>
        <meta HTTP-EQUIV="Content-Type" CONTENT="text/html;CHARSET=iso-8859-1">
    </head>
    <body>
        <?php 
        if ($flag == "true") {	
        ?>
        Your Unique Transaction/Order Id : <?php echo $txnid ?>
        Transaction Status : <?php echo $txnstatus ?>
        <?php } else { ?>
        Citrus Response Signature and Our (Merchant) Signature Mis-Mactch 
        <?php }	?>
    </body>
    </html>