<?php

$Section = "Location";
$Subsection = "Services";

require_once "../../config.php";
require_once "../../includes/header.php";

$clean = filter_input_array(INPUT_GET,$_GET); 		
$location_id = $clean['location_id'];
$location_name = $clean['location_name'];

$api_url = $api_base_url . "locations/" . $location_id . "/services/";
//echo $api_url;
$http = curl_init();  
curl_setopt($http, CURLOPT_URL, $api_url);  
curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);   
curl_setopt($http, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($http);
$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
$info = curl_getinfo($http);
$services = json_decode($response,true);
//echo $response;
?>
<h2>Edit <?php echo $Section; ?> - <?php echo $Subsection; ?></h2>
<?php
require_once "../nav.php";
?>
<?php
if(count($services) > 0)
	{
	?>
	<table class="table table-striped">
	<?php 			
	foreach($services as $service)
		{			
		$service_id = $service['id'];	
		$name = $service['name'];
		$alternate_name = $service['alternate_name'];	
		?>
		<tr>
			<td><?php echo $name; ?></td>
			<td><?php echo $alternate_name; ?></td>
			<td><a href="/locations/services/edit.php?location_id=<?php echo $location_id; ?>&service_id=<?php echo $service_id; ?>&location_name=<?php echo $location_name; ?>">Edit</a></td>
		</tr>
		<?php
		}
		?>
	</table>
	<?php			
	}
else
	{
	?>
	<div class="alert alert-warning text-center" role="alert">There Are No Services</div>
	<?php			
	}		
require_once "../../includes/footer.php";
?>
