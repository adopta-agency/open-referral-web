<?php

$Section = "Organization";
$Subsection = "Locations";

require_once "../../config.php";
require_once "../../includes/header.php";

$clean = filter_input_array(INPUT_GET,$_GET); 		
$organization_id = $clean['organization_id'];
$organization_name = $clean['organization_name'];

$api_url = $api_base_url . "organizations/" . $organization_id . "/locations/";
//echo $api_url;
$http = curl_init();  
curl_setopt($http, CURLOPT_URL, $api_url);  
curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);   
curl_setopt($http, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($http);
$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
$info = curl_getinfo($http);
$locations = json_decode($response,true);
//var_dump($locations);
?>
<h2>Edit <?php echo $Section; ?> - <?php echo $Subsection; ?></h2>
<?php
require_once "../nav.php";
?>
<?php
if(count($locations) > 0)
	{
	?>
	<table class="table table-striped">
	<?php 			
	foreach($locations as $location)
		{				
		$location_id = $location['id'];
		$name = $location['name'];
		$alternate_name = $location['alternate_name'];
		$transportation = $location['transportation'];
		$latitude = $location['latitude'];
		$longitude = $location['longitude'];
		?>
		<tr>
			<td><?php echo $name; ?></td>
			<td><?php echo $transportation; ?></td>
			<td><?php echo $longitude; ?>/<?php echo $latitude; ?></td>
			<td width="100" align='center'><a href="/organizations/locations/edit.php?organization_id=<?php echo $organization_id; ?>&location_id=<?php echo $location_id; ?>&organization_name=<?php echo $organization_name; ?>">Edit</a></td>
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
	<div class="alert alert-warning text-center" role="alert">There Are No Locations</div>
	<?php			
	}		
require_once "../../includes/footer.php";
?>
