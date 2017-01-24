<?php

$Section = "Organization";
$Subsection = "Services";

$clean = filter_input_array(INPUT_GET,$_GET); 		
$organization_id = $clean['organization_id'];
$organization_name = $clean['organization_name'];

require_once "../../config.php";
require_once "../../includes/common.php";
require_once "../../includes/header.php";

?>
<h2>Add <?php echo $Section; ?> - <?php echo $Subsection; ?></h2>
<?php
require_once "../nav.php";

$api_url = $api_base_url;

// Add Service
if(isset($clean['add-service']))
	{		

	$name = $clean['name'];
	$alternate_name = $clean['alternate_name'];	

	$api_url = $api_base_url . "organizations/" . $organization_id . "/services/";

	//echo $api_url . "<br />";
	$fields_string = "";
	$fields = array(
					'userkey' => urlencode($_SESSION['user_key']),
					'appkey' => urlencode($_SESSION['app_key']),
					'organization_id' => urlencode($organization_id),
					'name' => urlencode($name),
					'alternate_name' => urlencode($alternate_name)
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
	$service = json_decode($response,true);
	$service_id = $service['id'];
	$service_name = $service['name'];
	?>
	<p class="bg-success" style="text-align: center; font-weight: bold; padding: 5px;">
		<?php echo $service_name; ?> has been added!
	</p>
	<center>
		<button onclick="location.href='index.php?organization_id=<?php echo $organization_id; ?>&organization_name=<?php echo $organization_name; ?>';" type="button" class="btn btn-default" style="marging-bottom: 5px;"><< Return To Service Listing</button>
		<button onclick="location.href='edit.php?organization_id=<?php echo $organization_id; ?>&organization_name=<?php echo $organization_name; ?>';" type="button" class="btn btn-default" style="marging-bottom: 5px;">Edit <?php echo $service_name; ?> <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></button>
	</center>
	<?php
	curl_close($http);			
	}		
else 
	{
		
	?>
	<form method="get" action="add.php">
	<input type="hidden" id="organization_id" name="organization_id" value="<?php echo $organization_id; ?>">
	<input type="hidden" id="organization_name" name="organization_name" value="<?php echo $organization_name; ?>">
	<div class="form-group">
	   <label for="name">name:</label>
	   <input type="text" class="form-control" id="name" name="name">
	</div>
	<div class="form-group">
	   <label for="name">alternate_name:</label>
	   <input type="text" class="form-control" id="alternate_name" name="alternate_name">
	</div>    
	  <button type="submit" class="btn btn-default" name="add-service" value="1">Add This Service</button>
	</form>
	
	<?php
	}
require_once "../../includes/footer.php";
?>
