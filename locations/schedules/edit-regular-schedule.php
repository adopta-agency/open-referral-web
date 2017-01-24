<?php

$Section = "Location";
$Subsection = "Schedules";

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
$regular_schedule_id = $clean['regular_schedule_id'];

require_once "../nav.php";

$api_url = $api_base_url . "locations/" . $location_id . "/regular_schedule/" . $regular_schedule_id . "/";
//echo $api_url;
// Update RegularSchedule
if(isset($clean['edit-regular_schedule']))
	{
			
	$weekday = $clean['weekday'];
	$opens_at = $clean['opens_at'];
	$closes_at = $clean['closes_at'];

	//echo $api_url . "<br />";
	$fields_string = "";
	$fields = array(
					'userkey' => urlencode($_SESSION['user_key']),
					'appkey' => urlencode($_SESSION['app_key']),
					'location_id' => urlencode($location_id),
					'id' => urlencode($regular_schedule_id),
					'weekday' => urlencode($weekday),
					'opens_at' => urlencode($opens_at),
					'closes_at' => urlencode($closes_at)
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
	$regular_schedule = json_decode($response,true);
	$regular_schedule_id = $regular_schedule['id'];

	?>
	<p class="bg-success" style="text-align: center; font-weight: bold; padding: 5px;">
		The regular schedule has been saved!
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
	
	$regular_schedule = json_decode($response,true);	
	$weekday = $regular_schedule['weekday'];
	$opens_at = $regular_schedule['opens_at'];
	$closes_at = $regular_schedule['closes_at'];
	}
?>
<form method="get" action="edit-regular-schedule.php" name="SaveRegularScheduleForm">
  <input type="hidden" class="form-control" id="location_id" name="location_id" value="<?php echo $location_id; ?>">
  <input type="hidden" class="form-control" id="regular_schedule_id" name="regular_schedule_id" value="<?php echo $regular_schedule_id; ?>">
  <input type="hidden" class="form-control" id="location_name" name="location_name" value="<?php echo $location_name; ?>">	
	<div class="form-group">
	   <label for="name">weekday:</label>
	   <input type="text" class="form-control" id="weekday" name="weekday" value="<?php echo $weekday; ?>">
	</div>
	<div class="form-group">
	   <label for="name">opens_at:</label>
	   <input type="text" class="form-control" id="opens_at" name="opens_at" value="<?php echo $opens_at; ?>">
	</div>
	<div class="form-group">
	   <label for="name">closes_at:</label>
	   <input type="text" class="form-control" id="closes_at" name="closes_at" value="<?php echo $closes_at; ?>">
	</div>
  <button onclick="document.SaveRegularScheduleForm.submit();" type="submit" class="btn btn-default" name="edit-regular_schedule" value="1">Save Any Changes</button>
</form>

<?php
require_once "../../includes/footer.php";
?>
