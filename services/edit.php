<?php
$Section = "Service";
$Subsection = "";

require_once "../config.php";
require_once "../includes/common.php";
require_once "../includes/header.php";
?>
<h2>Edit <?php echo $Section; ?></h2>
<?php

$clean = filter_input_array(INPUT_GET,$_GET); 		
$service_id = $clean['service_id'];

$api_url = $api_base_url . "services/" . $service_id . "/";

// Add Service
if(isset($clean['edit-service']))
	{

	$service_name = $clean['service_name'];
	$alternate_name = $clean['alternate_name'];
	$url = $clean['url'];
	$email = $clean['email'];
	$status = $clean['status'];
	$application_process = $clean['application_process'];
	$wait_time = $clean['wait_time'];

	//echo $api_url . "<br />";
	$fields_string = "";
	$fields = array(
					'userkey' => urlencode($_SESSION['user_key']),
					'appkey' => urlencode($_SESSION['app_key']),
					'id' => urlencode($service_id),
					'name' => urlencode($service_name),
					'alternate_name' => urlencode($alternate_name),
					'url' => urlencode($url),
					'email' => urlencode($email),
					'status' => urlencode($status),
					'application_process' => urlencode($application_process),
					'wait_time' => urlencode($wait_time)
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
	$service = json_decode($response,true);
	$service_id = $service['id'];
	?>
	<p class="bg-success" style="text-align: center; font-weight: bold; padding: 5px;">
		Service has been added!
	</p>
	<?php
	curl_close($http);			
	}		
else 
	{
	//echo $api_url;
	$http = curl_init();  
	curl_setopt($http, CURLOPT_URL, $api_url);  
	curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);   
	curl_setopt($http, CURLOPT_SSL_VERIFYPEER, false);
	
	$response = curl_exec($http);
	$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
	$info = curl_getinfo($http);
	//echo $response . "<br />";
	$services = json_decode($response,true);	
		
	$service_name = $services['name'];	
	$alternate_name = $services['alternate_name'];	
	$url = $services['url'];	
	$email = $services['email'];	
	$status = $services['status'];
	$application_process = $services['application_process'];
	$wait_time = $services['wait_time'];
	}
	
require_once "nav.php";	
?>
<form method="get" action="edit.php" name="SaveServiceForm">
  <input type="hidden" class="form-control" id="service_id" name="service_id" value="<?php echo $service_id; ?>">	
	<div class="form-group">
	   <label for="name">name:</label>
	   <input type="text" class="form-control" id="service_name" name="service_name" value="<?php echo $service_name; ?>">
	</div>
	<div class="form-group">
	   <label for="name">alternate_name:</label>
	   <input type="text" class="form-control" id="alternate_name" name="alternate_name" value="<?php echo $alternate_name; ?>">
	</div>
	<div class="form-group">
	   <label for="name">url:</label>
	   <input type="text" class="form-control" id="url" name="url" value="<?php echo $url; ?>">
	</div>
	<div class="form-group">
	   <label for="name">email:</label>
	   <input type="text" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
	</div>
	<div class="form-group">
	   <label for="name">status:</label>
	   <input type="text" class="form-control" id="status" name="status" value="<?php echo $status; ?>">
	</div>
	<div class="form-group">
	   <label for="name">application_process:</label>
	   <input type="text" class="form-control" id="application_process" name="application_process" value="<?php echo $application_process; ?>">
	</div>
	<div class="form-group">
	   <label for="name">wait_time:</label>
	   <input type="text" class="form-control" id="wait_time" name="wait_time" value="<?php echo $wait_time; ?>">
	</div>       
  <button onclick="document.SaveServiceForm.submit();" type="submit" class="btn btn-default" name="edit-service" value="1">Save Any Changes</button>
</form>

<?php

require_once "../includes/footer.php";
?>
