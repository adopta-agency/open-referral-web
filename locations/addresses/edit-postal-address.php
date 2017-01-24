<?php

$Section = "Location";
$Subsection = "Addresses";

$clean = filter_input_array(INPUT_GET,$_GET); 		
$location_id = $clean['location_id'];
$location_name = $clean['location_name'];

require_once "../../config.php";
require_once "../../includes/common.php";
require_once "../../includes/header.php";

?>
<h2>Edit <?php echo $Section; ?> - <?php echo $Subsection; ?></h2>
<?php

$clean = filter_input_array(INPUT_GET,$_GET); 		
$location_id = $clean['location_id'];
$postal_address_id = $clean['postal_address_id'];

require_once "../nav.php";

$api_url = $api_base_url . "locations/" . $location_id . "/postal_address/" . $postal_address_id . "/";
//echo $api_url;
// Update HolidaySchedule
if(isset($clean['edit-postal_address']))
	{
			
	$attention = $clean['attention'];
	$address_1 = $clean['address_1'];
	$address_2 = $clean['address_2'];
	$address_3 = $clean['address_3'];
	$address_4 = $clean['address_4'];
	$city = $clean['city'];
	$state_province = $clean['state_province'];
	$postal_code = $clean['postal_code'];
	$country = $clean['country'];

	//echo $api_url . "<br />";
	$fields_string = "";
	$fields = array(
					'userkey' => urlencode($_SESSION['user_key']),
					'appkey' => urlencode($_SESSION['app_key']),
					'location_id' => urlencode($location_id),
					'id' => urlencode($id),
					'attention' => urlencode($attention),
					'address_1' => urlencode($address_1),
					'address_2' => urlencode($address_2),
					'address_3' => urlencode($address_3),
					'address_4' => urlencode($address_4),
					'city' => urlencode($city),
					'state_province' => urlencode($state_province),
					'postal_code' => urlencode($postal_code),
					'country' => urlencode($country)
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
	$postal_address = json_decode($response,true);
	$postal_address_id = $postal_address['id'];

	?>
	<p class="bg-success" style="text-align: center; font-weight: bold; padding: 5px;">
		The postal address has been saved!
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
	
	$postal_address = json_decode($response,true);	
	$attention = $postal_address['attention'];
	$address_1 = $postal_address['address_1'];
	$address_2 = $postal_address['address_2'];
	$address_3 = $postal_address['address_3'];
	$address_4 = $postal_address['address_4'];
	$city = $postal_address['city'];
	$state_province = $postal_address['state_province'];
	$postal_code = $postal_address['postal_code'];
	$country = $postal_address['country'];
	}
?>
<form method="get" action="edit-postal-address.php" name="SaveHolidayScheduleForm">
  <input type="hidden" class="form-control" id="location_id" name="location_id" value="<?php echo $location_id; ?>">
  <input type="hidden" class="form-control" id="postal_address_id" name="postal_address_id" value="<?php echo $postal_address_id; ?>">
  <input type="hidden" class="form-control" id="location_name" name="location_name" value="<?php echo $location_name; ?>">	
	<div class="form-group">
	   <label for="name">attention:</label>
	   <input type="text" class="form-control" id="attention" name="attention" value="<?php echo $attention; ?>">
	</div>
	<div class="form-group">
	   <label for="name">address_1:</label>
	   <input type="text" class="form-control" id="address_1" name="address_1" value="<?php echo $address_1; ?>">
	</div>
	<div class="form-group">
	   <label for="name">address_2:</label>
	   <input type="text" class="form-control" id="address_2" name="address_2" value="<?php echo $address_2; ?>">
	</div>
	<div class="form-group">
	   <label for="name">address_3:</label>
	   <input type="text" class="form-control" id="address_3" name="address_3" value="<?php echo $address_3; ?>">
	</div>
	<div class="form-group">
	   <label for="name">address_4:</label>
	   <input type="text" class="form-control" id="address_4" name="address_4" value="<?php echo $address_4; ?>">
	</div>
	<div class="form-group">
	   <label for="name">city:</label>
	   <input type="text" class="form-control" id="city" name="city" value="<?php echo $city; ?>">
	</div>
	<div class="form-group">
	   <label for="name">state_province:</label>
	   <input type="text" class="form-control" id="state_province" name="state_province" value="<?php echo $state_province; ?>">
	</div>
	<div class="form-group">
	   <label for="name">postal_code:</label>
	   <input type="text" class="form-control" id="postal_code" name="postal_code" value="<?php echo $postal_code; ?>">
	</div>
	<div class="form-group">
	   <label for="name">country:</label>
	   <input type="text" class="form-control" id="country" name="country" value="<?php echo $country; ?>">
	</div>
  <button onclick="document.SaveHolidayScheduleForm.submit();" type="submit" class="btn btn-default" name="edit-postal_address" value="1">Save Any Changes</button>
</form>

<?php
require_once "../../includes/footer.php";
?>
