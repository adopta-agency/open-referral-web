<?php

$Section = "Organization";
$Subsection = "Services";

require_once "../../config.php";
require_once "../../includes/header.php";

$clean = filter_input_array(INPUT_GET,$_GET); 		
$organization_id = $clean['organization_id'];
$organization_name = $clean['organization_name'];

$api_url = $api_base_url . "organizations/" . $organization_id . "/services/";
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
			<td><a href="/organizations/services/edit.php?organization_id=<?php echo $organization_id; ?>&service_id=<?php echo $service_id; ?>&organization_name=<?php echo $organization_name; ?>">Edit</a></td>
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
