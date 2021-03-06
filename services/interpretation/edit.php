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
$interpretation_service_id = $clean['interpretation_services_id'];

require_once "../nav.php";

$api_url = $api_base_url . "services/" . $service_id . "/interpretation-services/" . $interpretation_service_id . "/";
//echo $api_url;
// Update Language
if(isset($clean['edit-interpretation_services']))
	{
			
	$interpretation_services = $clean['interpretation_services'];

	//echo $api_url . "<br />";
	$fields_string = "";
	$fields = array(
					'userkey' => urlencode($_SESSION['user_key']),
					'appkey' => urlencode($_SESSION['app_key']),
					'service_id' => urlencode($service_id),
					'id' => urlencode($interpretation_service_id),
					'interpretation_services' => urlencode($interpretation_services)
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
	$interpretation_services = json_decode($response,true);
	$interpretation_service_id = $interpretation_services['id'];
	$interpretation_services = $interpretation_services['interpretation_services'];

	?>
	<p class="bg-success" style="text-align: center; font-weight: bold; padding: 5px;">
		Interpretation service has been saved!
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
	
	$interpretation_services = json_decode($response,true);	
	$interpretation_services = $interpretation_services['interpretation_services'];
	}
?>
<form method="get" action="edit.php" name="SaveLanguageForm">
  <input type="hidden" class="form-control" id="service_id" name="service_id" value="<?php echo $service_id; ?>">
  <input type="hidden" class="form-control" id="interpretation_services_id" name="interpretation_services_id" value="<?php echo $interpretation_service_id; ?>">
  <input type="hidden" class="form-control" id="service_name" name="service_name" value="<?php echo $service_name; ?>">	
	<div class="form-group">
	   <label for="name">interpretation_services:</label>
	   <input type="text" class="form-control" id="interpretation_services" name="interpretation_services" value="<?php echo $interpretation_services; ?>">
	</div>
  <button onclick="document.SaveLanguageForm.submit();" type="submit" class="btn btn-default" name="edit-interpretation_services" value="1">Save Any Changes</button>
</form>

<?php
require_once "../../includes/footer.php";
?>
