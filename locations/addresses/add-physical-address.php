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
<h2>Add <?php echo $Section; ?> - <?php echo $Subsection; ?></h2>
<?php
require_once "../nav.php";

$api_url = $api_base_url;

// Add Language
if(isset($_REQUEST['add-physical_address']))
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

	$api_url = $api_base_url . "locations/" . $location_id . "/physical_address/";

	//echo $api_url . "<br />";
	$fields_string = "";
	$fields = array(
					'userkey' => urlencode($_SESSION['user_key']),
					'appkey' => urlencode($_SESSION['app_key']),
					'location_id' => urlencode($location_id),
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
	
	curl_setopt($http,CURLOPT_URL, $api_url);
	curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);  
	curl_setopt($http,CURLOPT_POST, count($fields));
	curl_setopt($http,CURLOPT_POSTFIELDS, $fields_string);	
	curl_setopt($http, CURLOPT_SSL_VERIFYPEER, false);
	
	$response = curl_exec($http);
	$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
	$info = curl_getinfo($http);
	echo $response;
	$physical_address = json_decode($response,true);
	$physical_address_id = $physical_address['id'];
	?>
	<p class="bg-success" style="text-align: center; font-weight: bold; padding: 5px;">
		The physical address has been added!
	</p>
	<center>
		<button onclick="location.href='index.php?location_id=<?php echo $location_id; ?>&location_name=<?php echo $location_name; ?>';" type="button" class="btn btn-default" style="marging-bottom: 5px;"><< Return To Language Listing</button>
		<button onclick="location.href='edit.php?location_id=<?php echo $location_id; ?>&location_name=<?php echo $location_name; ?>';" type="button" class="btn btn-default" style="marging-bottom: 5px;">Edit Physical Address <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></button>
	</center>
	<?php
	curl_close($http);			
	}		
else 
	{
		
	?>
	<form method="get" action="add-physical-address.php">
	<input type="hidden" id="location_id" name="location_id" value="<?php echo $location_id; ?>">
	<input type="hidden" id="location_name" name="location_name" value="<?php echo $location_name; ?>">
	<div class="form-group">
	   <label for="name">attention:</label>
	   <input type="text" class="form-control" id="attention" name="attention">
	</div>
	<div class="form-group">
	   <label for="name">address_1:</label>
	   <input type="text" class="form-control" id="address_1" name="address_1">
	</div>
	<div class="form-group">
	   <label for="name">address_2:</label>
	   <input type="text" class="form-control" id="address_2" name="address_2">
	</div>
	<div class="form-group">
	   <label for="name">address_3:</label>
	   <input type="text" class="form-control" id="address_3" name="address_3">
	</div>
	<div class="form-group">
	   <label for="name">address_4:</label>
	   <input type="text" class="form-control" id="address_4" name="address_4">
	</div>
	<div class="form-group">
	   <label for="name">city:</label>
	   <input type="text" class="form-control" id="city" name="city">
	</div>
	<div class="form-group">
	   <label for="name">state_province:</label>
	   <input type="text" class="form-control" id="state_province" name="state_province">
	</div>
	<div class="form-group">
	   <label for="name">postal_code:</label>
	   <input type="text" class="form-control" id="postal_code" name="postal_code">
	</div>
	<div class="form-group">
	   <label for="name">country:</label>
	   <input type="text" class="form-control" id="country" name="country">
	</div>
	  <button type="submit" class="btn btn-default" name="add-physical_address" value="1">Add This Physical Address</button>
	</form>
	
	<?php
	}
require_once "../../includes/footer.php";
?>
