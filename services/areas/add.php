<?php

$Section = "Service";
$Subsection = "Service Areas";

$clean = filter_input_array(INPUT_GET,$_GET); 		
$service_id = $clean['service_id'];
$service_name = $clean['service_name'];

require_once "../../config.php";
require_once "../../includes/common.php";
require_once "../../includes/header.php";

?>
<h2>Add <?php echo $Section; ?> - <?php echo $Subsection; ?></h2>
<?php
require_once "../nav.php";

$api_url = $api_base_url;

// Add Language
if(isset($_REQUEST['add-service_area']))
	{
		
	$service_area = $clean['service_area'];

	$api_url = $api_base_url . "services/" . $service_id . "/service-area/";

	//echo $api_url . "<br />";
	$fields_string = "";
	$fields = array(
					'userkey' => urlencode($_SESSION['user_key']),
					'appkey' => urlencode($_SESSION['app_key']),
					'service_id' => urlencode($service_id),
					'service_area' => urlencode($service_area)
					);
	
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');
	
	//echo $fields_string;
	
	$http = curl_init();
	
	curl_setopt($http,CURLOPT_URL, $api_url);
	curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);  
	curl_setopt($http,CURLOPT_POST, count($fields));
	curl_setopt($http,CURLOPT_POSTFIELDS, $fields_string);	
	curl_setopt($http, CURLOPT_SSL_VERIFYPEER, false);
	
	$response = curl_exec($http);
	$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
	$info = curl_getinfo($http);
	//echo $response;
	$service_area = json_decode($response,true);
	$service_area_id = $service_area['id'];
	$service_area_service_area = $service_area['service_area'];
	?>
	<p class="bg-success" style="text-align: center; font-weight: bold; padding: 5px;">
		The service area has been added!
	</p>
	<center>
		<button onclick="location.href='index.php?service_id=<?php echo $service_id; ?>&service_name=<?php echo $service_name; ?>';" type="button" class="btn btn-default" style="marging-bottom: 5px;"><< Return To Language Listing</button>
		<button onclick="location.href='edit.php?service_id=<?php echo $service_id; ?>&service_name=<?php echo $service_name; ?>';" type="button" class="btn btn-default" style="marging-bottom: 5px;">Edit Service Area <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></button>
	</center>
	<?php
	curl_close($http);			
	}		
else 
	{
		
	?>
	<form method="get" action="add.php">
	<input type="hidden" id="service_id" name="service_id" value="<?php echo $service_id; ?>">
	<input type="hidden" id="service_name" name="service_name" value="<?php echo $service_name; ?>">
		<div class="form-group">
		   <label for="name">service_area:</label>
		   <input type="text" class="form-control" id="service_area" name="service_area">
		</div>  
	  <button type="submit" class="btn btn-default" name="add-service_area" value="1">Add This Service Area</button>
	</form>
	
	<?php
	}
require_once "../../includes/footer.php";
?>
