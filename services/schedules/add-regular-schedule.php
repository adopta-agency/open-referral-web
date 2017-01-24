<?php
$Section = "Service";
$Subsection = "Schedules";

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
if(isset($_REQUEST['add-regular_schedule']))
	{
		
	$weekday = $clean['weekday'];
	$opens_at = $clean['opens_at'];
	$closes_at = $clean['closes_at'];

	$api_url = $api_base_url . "services/" . $service_id . "/regular_schedule/";

	//echo $api_url . "<br />";
	$fields_string = "";
	$fields = array(
					'userkey' => urlencode($_SESSION['user_key']),
					'appkey' => urlencode($_SESSION['app_key']),
					'service_id' => urlencode($service_id),
					'weekday' => urlencode($weekday),
					'opens_at' => urlencode($opens_at),
					'closes_at' => urlencode($closes_at)
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
	$regular_schedule = json_decode($response,true);
	$regular_schedule_id = $regular_schedule['id'];
	$regular_schedule_weekday = $regular_schedule['weekday'];
	?>
	<p class="bg-success" style="text-align: center; font-weight: bold; padding: 5px;">
		The regular schedule has been added!
	</p>
	<center>
		<button onclick="service.href='index.php?service_id=<?php echo $service_id; ?>&service_name=<?php echo $service_name; ?>';" type="button" class="btn btn-default" style="marging-bottom: 5px;"><< Return To Language Listing</button>
		<button onclick="service.href='edit.php?service_id=<?php echo $service_id; ?>&service_name=<?php echo $service_name; ?>';" type="button" class="btn btn-default" style="marging-bottom: 5px;">Edit <?php echo $regular_schedule_weekday; ?> <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></button>
	</center>
	<?php
	curl_close($http);			
	}		
else 
	{
		
	?>
	<form method="get" action="add-regular-schedule.php">
	<input type="hidden" id="service_id" name="service_id" value="<?php echo $service_id; ?>">
	<input type="hidden" id="service_name" name="service_name" value="<?php echo $service_name; ?>">
	<div class="form-group">
	   <label for="name">weekday:</label>
	   <input type="text" class="form-control" id="weekday" name="weekday">
	</div>
	<div class="form-group">
	   <label for="name">opens_at:</label>
	   <input type="text" class="form-control" id="opens_at" name="opens_at">
	</div>
	<div class="form-group">
	   <label for="name">closes_at:</label>
	   <input type="text" class="form-control" id="closes_at" name="closes_at">
	</div>
	  <button type="submit" class="btn btn-default" name="add-regular_schedule" value="1">Add This Regular Schedule</button>
	</form>
	
	<?php
	}
require_once "../../includes/footer.php";
?>
