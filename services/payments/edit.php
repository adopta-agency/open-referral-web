<?php

$Section = "Service";
$Subsection = "Languages";

$clean = filter_input_array(INPUT_GET,$_GET); 		
$service_id = $clean['service_id'];
$service_name = $clean['service_name'];

require_once "../../config.php";
require_once "../../includes/common.php";
require_once "../../includes/header.php";

?>
<h2>Edit <?php echo $Section; ?> - <?php echo $Subsection; ?></h2>
<?php

$clean = filter_input_array(INPUT_GET,$_GET); 		
$service_id = $clean['service_id'];
$payment_id = $clean['payment_id'];

require_once "../nav.php";

$api_url = $api_base_url . "services/" . $service_id . "/payments/" . $payment_id . "/";
//echo $api_url;
// Update Language
if(isset($clean['edit-payment']))
	{
			
	$payment = $clean['payment'];

	//echo $api_url . "<br />";
	$fields_string = "";
	$fields = array(
					'userkey' => urlencode($_SESSION['user_key']),
					'appkey' => urlencode($_SESSION['app_key']),
					'service_id' => urlencode($service_id),
					'id' => urlencode($payment_id),
					'payment' => urlencode($payment)
					);
	
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');
	
	//echo $fields_string;
	
	$http = curl_init();

	curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($http, CURLOPT_VERBOSE, 1);
	curl_setopt($http, CURLOPT_HEADER, 0);

	curl_setopt($http,CURLOPT_URL, $api_url);
	curl_setopt($http, CURLOPT_CUSTOMREQUEST, "PUT");
	curl_setopt($http,CURLOPT_POSTFIELDS, $fields_string);	
	
	$response = curl_exec($http);
	$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
	$info = curl_getinfo($http);
	//echo $response;
	$payment = json_decode($response,true);
	$payment_id = $payment['id'];
	$payment = $payment['payment'];

	?>
	<p class="bg-success" style="text-align: center; font-weight: bold; padding: 5px;">
		Payment has been saved!
	</p>
	<?php
	curl_close($http);			
	}		
else 
	{
	$http = curl_init();  
	curl_setopt($http, CURLOPT_URL, $api_url);  
	curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);   
	curl_setopt($http, CURLOPT_SSL_VERIFYPEER, false);
	
	$response = curl_exec($http);
	//echo $response;
	$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
	$info = curl_getinfo($http);
	
	$payments = json_decode($response,true);	
	$payment = $payments['payment'];
	}
?>
<form method="get" action="edit.php" name="SaveLanguageForm">
  <input type="hidden" class="form-control" id="service_id" name="service_id" value="<?php echo $service_id; ?>">
  <input type="hidden" class="form-control" id="payment_id" name="payment_id" value="<?php echo $payment_id; ?>">
  <input type="hidden" class="form-control" id="service_name" name="service_name" value="<?php echo $service_name; ?>">	
	<div class="form-group">
	   <label for="name">payment:</label>
	   <input type="text" class="form-control" id="payment" name="payment" value="<?php echo $payment; ?>">
	</div>
  <button onclick="document.SaveLanguageForm.submit();" type="submit" class="btn btn-default" name="edit-payment" value="1">Save Any Changes</button>
</form>

<?php
require_once "../../includes/footer.php";
?>
