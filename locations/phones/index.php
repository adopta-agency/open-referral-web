<?php

$Section = "Location";
$Subsection = "Phones";

require_once "../../config.php";
require_once "../../includes/header.php";

$clean = filter_input_array(INPUT_GET,$_GET); 		
$location_id = $clean['location_id'];
$location_name = $clean['location_name'];

$api_url = $api_base_url . "locations/" . $location_id . "/phones/";
//echo $api_url;
$http = curl_init();  
curl_setopt($http, CURLOPT_URL, $api_url);  
curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);   
curl_setopt($http, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($http);
//echo $response;
$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
$info = curl_getinfo($http);
$phones = json_decode($response,true);
//var_dump($phones);
?>
<h2>Edit <?php echo $Section; ?> - <?php echo $Subsection; ?></h2>
<?php
require_once "../nav.php";
?>
<?php
if(count($phones) > 0)
	{
	?>
	<table class="table table-striped">
	<?php 			
	foreach($phones as $phone)
		{			
		$phone_id = $phone['id'];	
		$number = $phone['number'];
		$extension = $phone['extension'];
		$type = $phone['type'];
		$department = $phone['department'];
		?>
		<tr>
			<td><?php echo $number; ?></td>
			<td><?php echo $extension; ?></td>
			<td><?php echo $type; ?></td>
			<td><?php echo $department; ?></td>
			<td width="100" align="center"><a href="/locations/phones/edit.php?location_id=<?php echo $location_id; ?>&phone_id=<?php echo $phone_id; ?>&location_name=<?php echo $location_name; ?>">Edit</a></td>
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
	<div class="alert alert-warning text-center" role="alert">There Are No Phone Numbers</div>
	<?php			
	}		
require_once "../../includes/footer.php";
?>
