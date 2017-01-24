<?php

$Section = "Location";
$Subsection = "Phones";

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
$phone_id = $clean['phone_id'];

require_once "../nav.php";

$api_url = $api_base_url . "locations/" . $location_id . "/phones/" . $phone_id . "/";
echo $api_url;
// Update Phone
if(isset($clean['edit-phone']))
	{
			
	$number = $clean['number'];
	$extension = $clean['extension'];
	$type = $clean['type'];
	$department = $clean['department'];

	//echo $api_url . "<br />";
	$fields_string = "";
	$fields = array(
					'userkey' => urlencode($_SESSION['user_key']),
					'appkey' => urlencode($_SESSION['app_key']),
					'location_id' => urlencode($location_id),
					'id' => urlencode($phone_id),
					'number' => urlencode($number),
					'extension' => urlencode($extension),
					'type' => urlencode($type),
					'department' => urlencode($department)
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
	$phone = json_decode($response,true);
	$phone_id = $phone['id'];
	$phone_number = $phone['number'];

	?>
	<p class="bg-success" style="text-align: center; font-weight: bold; padding: 5px;">
		<?php echo $phone_number; ?> has been saved!
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
	
	$phones = json_decode($response,true);	
	$number = $phones['number'];
	$extension = $phones['extension'];
	$type = $phones['type'];
	$department = $phones['department'];
	}
?>
<form method="get" action="edit.php" name="SavePhoneForm">
  <input type="hidden" class="form-control" id="location_id" name="location_id" value="<?php echo $location_id; ?>">
  <input type="hidden" class="form-control" id="phone_id" name="phone_id" value="<?php echo $phone_id; ?>">
  <input type="hidden" class="form-control" id="location_name" name="location_name" value="<?php echo $location_name; ?>">	
	<div class="form-group">
	   <label for="name">number:</label>
	   <input type="text" class="form-control" id="number" name="number" value="<?php echo $number; ?>">
	</div>
	<div class="form-group">
	   <label for="name">extension:</label>
	   <input type="text" class="form-control" id="extension" name="extension" value="<?php echo $extension; ?>">
	</div>
	<div class="form-group">
	   <label for="name">type:</label>
	   <input type="text" class="form-control" id="type" name="type" value="<?php echo $type; ?>">
	</div>
	<div class="form-group">
	   <label for="name">department:</label>
	   <input type="text" class="form-control" id="department" name="department" value="<?php echo $department; ?>">
	</div>    
  <button onclick="document.SavePhoneForm.submit();" type="submit" class="btn btn-default" name="edit-phone" value="1">Save Any Changes</button>
</form>

<?php
require_once "../../includes/footer.php";
?>
