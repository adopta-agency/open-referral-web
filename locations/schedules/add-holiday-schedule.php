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
<h2>Add <?php echo $Section; ?> - <?php echo $Subsection; ?></h2>
<?php
require_once "../nav.php";

$api_url = $api_base_url;

// Add Language
if(isset($_REQUEST['add-holiday_schedule']))
	{
		
	$closed = $clean['closed'];
	$opens_at = $clean['opens_at'];
	$closes_at = $clean['closes_at'];
	$start_date = $clean['start_date'];
	$end_date = $clean['end_date'];

	$api_url = $api_base_url . "locations/" . $location_id . "/holiday_schedule/";

	//echo $api_url . "<br />";
	$fields_string = "";
	$fields = array(
					'userkey' => urlencode($_SESSION['user_key']),
					'appkey' => urlencode($_SESSION['app_key']),
					'location_id' => urlencode($location_id),
					'closed' => urlencode($closed),
					'opens_at' => urlencode($opens_at),
					'closes_at' => urlencode($closes_at),
					'start_date' => urlencode($start_date),
					'end_date' => urlencode($end_date)
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
	$holiday_schedule = json_decode($response,true);
	$holiday_schedule_id = $holiday_schedule['id'];
	$holiday_schedule_closed = $holiday_schedule['closed'];
	?>
	<p class="bg-success" style="text-align: center; font-weight: bold; padding: 5px;">
		The holiday schedule has been added!
	</p>
	<center>
		<button onclick="location.href='index.php?location_id=<?php echo $location_id; ?>&location_name=<?php echo $location_name; ?>';" type="button" class="btn btn-default" style="marging-bottom: 5px;"><< Return To Language Listing</button>
		<button onclick="location.href='edit.php?location_id=<?php echo $location_id; ?>&location_name=<?php echo $location_name; ?>';" type="button" class="btn btn-default" style="marging-bottom: 5px;">Edit <?php echo $holiday_schedule_closed; ?> <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></button>
	</center>
	<?php
	curl_close($http);			
	}		
else 
	{
		
	?>
	<form method="get" action="add-holiday-schedule.php">
	<input type="hidden" id="location_id" name="location_id" value="<?php echo $location_id; ?>">
	<input type="hidden" id="location_name" name="location_name" value="<?php echo $location_name; ?>">
	<div class="form-group">
	   <label for="name">closed:</label>
	   <input type="text" class="form-control" id="closed" name="closed">
	</div>
	<div class="form-group">
	   <label for="name">opens_at:</label>
	   <input type="text" class="form-control" id="opens_at" name="opens_at">
	</div>
	<div class="form-group">
	   <label for="name">closes_at:</label>
	   <input type="text" class="form-control" id="closes_at" name="closes_at">
	</div>
	<div class="form-group">
	   <label for="name">start_date:</label>
	   <input type="text" class="form-control" id="start_date" name="start_date">
	</div>
	<div class="form-group">
	   <label for="name">end_date:</label>
	   <input type="text" class="form-control" id="end_date" name="end_date">
	</div>
	  <button type="submit" class="btn btn-default" name="add-holiday_schedule" value="1">Add This Holiday Schedule</button>
	</form>
	
	<?php
	}
require_once "../../includes/footer.php";
?>
