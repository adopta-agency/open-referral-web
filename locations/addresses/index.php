<?php

$Section = "Location";
$Subsection = "Addresses";

require_once "../../config.php";
require_once "../../includes/header.php";

$clean = filter_input_array(INPUT_GET,$_GET); 		
$location_id = $clean['location_id'];
$location_name = $clean['location_name'];

?>
<h2>Edit <?php echo $Section; ?> - <?php echo $Subsection; ?></h2>
<?php
require_once "../nav.php";
?>
<h3>Regular Schedule</h3>
<?php
$api_url = $api_base_url . "locations/" . $location_id . "/physical_address/";
//echo $api_url;
$http = curl_init();  
curl_setopt($http, CURLOPT_URL, $api_url);  
curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);   
curl_setopt($http, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($http);
//echo $response;
$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
$info = curl_getinfo($http);
$physical_address = json_decode($response,true);
//var_dump($physical_address);

if(count($physical_address) > 0)
	{
	?>
	<table class="table table-striped">
	<?php 			
	foreach($physical_address as $schedule)
		{			
		$postal_address_id = $schedule['id'];
		$location_id = $schedule['location_id'];
		$attention = $schedule['attention'];
		$address_1 = $schedule['address_1'];
		$address_2 = $schedule['address_2'];
		$address_3 = $schedule['address_3'];
		$address_4 = $schedule['address_4'];
		$city = $schedule['city'];
		$state_province = $schedule['state_province'];
		$postal_code = $schedule['postal_code'];
		$country = $schedule['country'];
		?>
		<tr>
			<td><?php echo $address_1; ?></td>
			<td><?php echo $city; ?></td>
			<td><?php echo $state_province; ?></td>
			<td><?php echo $postal_code; ?></td>
			<td><?php echo $country; ?></td>
			<td width="100" align="center"><a href="/locations/schedules/edit.php?location_id=<?php echo $location_id; ?>&postal_address_id=<?php echo $postal_address_id; ?>&location_name=<?php echo $location_name; ?>">Edit</a></td>
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
	<div class="alert alert-warning text-center" role="alert">There Is No Physical Address</div>
	<?php			
	}	
?>
<h3>Postal Address</h3>
<?php
$api_url = $api_base_url . "locations/" . $location_id . "/postal_address/";
//echo $api_url;
$http = curl_init();  
curl_setopt($http, CURLOPT_URL, $api_url);  
curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);   
curl_setopt($http, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($http);
//echo $response;
$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
$info = curl_getinfo($http);
$postal_address = json_decode($response,true);
//var_dump($postal_address);

if(count($postal_address) > 0)
	{
	?>
	<table class="table table-striped">
	<?php 			
	foreach($postal_address as $schedule)
		{			
		$postal_address_id = $schedule['id'];
		$location_id = $schedule['location_id'];
		$attention = $schedule['attention'];
		$address_1 = $schedule['address_1'];
		$address_2 = $schedule['address_2'];
		$address_3 = $schedule['address_3'];
		$address_4 = $schedule['address_4'];
		$city = $schedule['city'];
		$state_province = $schedule['state_province'];
		$postal_code = $schedule['postal_code'];
		$country = $schedule['country'];
		?>
		<tr>
			<td><?php echo $address_1; ?></td>
			<td><?php echo $city; ?></td>
			<td><?php echo $state_province; ?></td>
			<td><?php echo $postal_code; ?></td>
			<td><?php echo $country; ?></td>
			<td width="100" align="center"><a href="/locations/schedules/edit.php?location_id=<?php echo $location_id; ?>&postal_address_id=<?php echo $postal_address_id; ?>&location_name=<?php echo $location_name; ?>">Edit</a></td>
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
	<div class="alert alert-warning text-center" role="alert">There Is No Postal Address</div>
	<?php			
	}		
require_once "../../includes/footer.php";
?>
