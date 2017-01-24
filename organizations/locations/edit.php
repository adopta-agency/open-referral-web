<?php

$Section = "Organization";
$Subsection = "Locations";

$clean = filter_input_array(INPUT_GET,$_GET); 		
$organization_id = $clean['organization_id'];
$organization_name = $clean['organization_name'];

require_once "../../config.php";
require_once "../../includes/common.php";
require_once "../../includes/header.php";

?>
<h2>Edit <?php echo $Section; ?> - <?php echo $Subsection; ?></h2>
<?php

$clean = filter_input_array(INPUT_GET,$_GET); 		
$organization_id = $clean['organization_id'];
$location_id = $clean['location_id'];

require_once "../nav.php";

$api_url = $api_base_url . "organizations/" . $organization_id . "/locations/" . $location_id . "/";

// Update Location
if(isset($clean['edit-organization']))
	{
			
	$name = $clean['name'];
	$alternate_name = $clean['alternate_name'];
	$transportation = $clean['transportation'];
	$latitude = $clean['latitude'];
	$longitude = $clean['longitude'];

	//echo $api_url . "<br />";
	$fields_string = "";
	$fields = array(
					'userkey' => urlencode($_SESSION['user_key']),
					'appkey' => urlencode($_SESSION['app_key']),
					'organization_id' => urlencode($organization_id),
					'name' => urlencode($name),
					'alternate_name' => urlencode($alternate_name),
					'transportation' => urlencode($transportation),
					'latitude' => urlencode($latitude),
					'longitude' => urlencode($longitude)
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
	$location = json_decode($response,true);
	$location_id = $location['id'];
	$location_name = $location['name'];

	?>
	<p class="bg-success" style="text-align: center; font-weight: bold; padding: 5px;">
		<?php echo $location_name; ?> has been saved!
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
	//echo $response;
	$locations = json_decode($response,true);	
	$name = $locations['name'];
	$alternate_name = $locations['alternate_name'];
	$transportation = $locations['transportation'];
	$latitude = $locations['latitude'];
	$longitude = $locations['longitude'];
	}
?>
<form method="get" action="edit.php" name="SaveLocationForm">
  <input type="hidden" class="form-control" id="organization_id" name="organization_id" value="<?php echo $organization_id; ?>">
  <input type="hidden" class="form-control" id="location_id" name="location_id" value="<?php echo $location_id; ?>">
  <input type="hidden" class="form-control" id="organization_name" name="organization_name" value="<?php echo $organization_name; ?>">	
	<div class="form-group">
	   <label for="name">name:</label>
	   <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>">
	</div>
	<div class="form-group">
	   <label for="name">alternate_name:</label>
	   <input type="text" class="form-control" id="alternate_name" name="alternate_name" value="<?php echo $alternate_name; ?>">
	</div>
	<div class="form-group">
	   <label for="name">transportation:</label>
	   <input type="text" class="form-control" id="transportation" name="transportation" value="<?php echo $transportation; ?>">
	</div>
	<div class="form-group">
	   <label for="name">latitude:</label>
	   <input type="text" class="form-control" id="latitude" name="latitude" value="<?php echo $latitude; ?>">
	</div>
	<div class="form-group">
	   <label for="name">longitude:</label>
	   <input type="text" class="form-control" id="longitude" name="longitude" value="<?php echo $longitude; ?>">
	</div>    
  <button onclick="document.SaveLocationForm.submit();" type="submit" class="btn btn-default" name="edit-organization" value="1">Save Any Changes</button>
</form>

<?php
require_once "../../includes/footer.php";
?>
