<?php

$Section = "Location";
$Subsection = "Accessibility";

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
$accessibility_id = $clean['accessibility_id'];

require_once "../nav.php";

$api_url = $api_base_url . "locations/" . $location_id . "/accessibility/" . $accessibility_id . "/";
//echo $api_url;
// Update Accessibility
if(isset($clean['edit-accessibility']))
	{
			
	$accessibility = $clean['accessibility'];

	//echo $api_url . "<br />";
	$fields_string = "";
	$fields = array(
					'userkey' => urlencode($_SESSION['user_key']),
					'appkey' => urlencode($_SESSION['app_key']),
					'location_id' => urlencode($location_id),
					'accessibility' => urlencode($accessibility)
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
	$accessibility = json_decode($response,true);
	$accessibility_id = $accessibility['id'];
	$accessibility_accessibility = $accessibility['accessibility'];

	?>
	<p class="bg-success" style="text-align: center; font-weight: bold; padding: 5px;">
		<?php echo $accessibility_accessibility; ?> has been saved!
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
	
	$accessibility = json_decode($response,true);	
	$accessibility_accessibility = $accessibility['accessibility'];
	}
?>
<form method="get" action="edit.php" name="SaveAccessibilityForm">
  <input type="hidden" class="form-control" id="location_id" name="location_id" value="<?php echo $location_id; ?>">
  <input type="hidden" class="form-control" id="accessibility_id" name="accessibility_id" value="<?php echo $accessibility_id; ?>">
  <input type="hidden" class="form-control" id="location_name" name="location_name" value="<?php echo $location_name; ?>">	
	<div class="form-group">
	   <label for="name">accessibility:</label>
	   <input type="text" class="form-control" id="accessibility" name="accessibility" value="<?php echo $accessibility_accessibility; ?>">
	</div>  
  <button onclick="document.SaveAccessibilityForm.submit();" type="submit" class="btn btn-default" name="edit-accessibility" value="1">Save Any Changes</button>
</form>

<?php
require_once "../../includes/footer.php";
?>
