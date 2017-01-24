<?php

$Section = "Service";
$Subsection = "Service Areas";

require_once "../../config.php";
require_once "../../includes/header.php";

$clean = filter_input_array(INPUT_GET,$_GET); 		
$service_id = $clean['service_id'];
$service_name = $clean['service_name'];

$api_url = $api_base_url . "services/" . $service_id . "/service-area/";
//echo $api_url;
$http = curl_init();  
curl_setopt($http, CURLOPT_URL, $api_url);  
curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);   
curl_setopt($http, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($http);
//echo $response;
$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
$info = curl_getinfo($http);
$service_area = json_decode($response,true);
//var_dump($service_area);
?>
<h2>Edit <?php echo $Section; ?> - <?php echo $Subsection; ?></h2>
<?php
require_once "../nav.php";
?>
<?php
if(count($service_area) > 0)
	{
	?>
	<table class="table table-striped">
	<?php 			
	foreach($service_area as $service_area)
		{			
		$service_area_id = $service_area['id'];	
		$service_area = $service_area['service_area'];
		?>
		<tr>
			<td><?php echo $service_area; ?></td>
			<td width="100" align="center"><a href="/services/areas/edit.php?service_id=<?php echo $service_id; ?>&service_area_id=<?php echo $service_area_id; ?>&service_name=<?php echo $service_name; ?>">Edit</a></td>
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
	<div class="alert alert-warning text-center" role="alert">There Are No Service Areas</div>
	<?php			
	}		
require_once "../../includes/footer.php";
?>
