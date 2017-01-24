<?php
require_once "../config.php";
require_once "../includes/common.php";
require_once "../includes/header.php";
?>
<h2>Add Location</h2>
<?php

$api_url = $api_base_url;

// Add Location
$fields_string = "";
if(isset($_REQUEST['add-organization']))
	{
		
	$clean = filter_input_array(INPUT_GET,$_GET);
	 		
	$name = $clean['name'];
	$alternate_name = $clean['alternate_name'];
	$transportation = $clean['transportation'];
	$latitude = $clean['latitude'];
	$longitude = $clean['longitude'];

	$api_url = $api_base_url . "locations/";

	//echo $api_url . "<br />";
	$fields = array(
					'userkey' => urlencode($_SESSION['user_key']),
					'appkey' => urlencode($_SESSION['app_key']),
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
	
	curl_setopt($http,CURLOPT_URL, $api_url);
	curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);  
	curl_setopt($http,CURLOPT_POST, count($fields));
	curl_setopt($http,CURLOPT_POSTFIELDS, $fields_string);	
	curl_setopt($http, CURLOPT_SSL_VERIFYPEER, false);
	
	$response = curl_exec($http);
	$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
	$info = curl_getinfo($http);
	//echo $response;
	$location = json_decode($response,true);
	$location_id = $location['id'];
	$location_name = $location['name'];
	?>
	<p class="bg-success" style="text-align: center; font-weight: bold; padding: 5px;">
		<?php echo $location_name; ?> has been added!
	</p>
	<center>
		<button onclick="location.href='index.php';" type="button" class="btn btn-default" style="marging-bottom: 5px;"><< Return To Location Listing</button>
		<button onclick="location.href='edit.php?location_id=<?php echo $location_id; ?>&location_name=<?php echo $location_name; ?>';" type="button" class="btn btn-default" style="marging-bottom: 5px;">Edit <?php echo $location_name; ?> <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></button>
	</center>
	<?php
	curl_close($http);			
	}		
else 
	{
		
	?>
	<form method="get" action="add.php">
	<div class="form-group">
	   <label for="name">name:</label>
	   <input type="text" class="form-control" id="name" name="name">
	</div>
	<div class="form-group">
	   <label for="name">alternate_name:</label>
	   <input type="text" class="form-control" id="alternate_name" name="alternate_name">
	</div>
	<div class="form-group">
	   <label for="name">transportation:</label>
	   <input type="text" class="form-control" id="transportation" name="transportation">
	</div>
	<div class="form-group">
	   <label for="name">latitude:</label>
	   <input type="text" class="form-control" id="latitude" name="latitude">
	</div>
	<div class="form-group">
	   <label for="name">longitude:</label>
	   <input type="text" class="form-control" id="longitude" name="longitude">
	</div>       
	  <button type="submit" class="btn btn-default" name="add-organization" value="1">Add This Location</button>
	</form>
	
	<?php
	}
require_once "../includes/footer.php";
?>
