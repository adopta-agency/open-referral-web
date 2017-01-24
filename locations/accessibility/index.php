<?php

$Section = "Location";
$Subsection = "Accessibility";

require_once "../../config.php";
require_once "../../includes/header.php";

$clean = filter_input_array(INPUT_GET,$_GET); 		
$location_id = $clean['location_id'];
$location_name = $clean['location_name'];

$api_url = $api_base_url . "locations/" . $location_id . "/accessibility/";
//echo $api_url;
$http = curl_init();  
curl_setopt($http, CURLOPT_URL, $api_url);  
curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);   
curl_setopt($http, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($http);
//echo $response;
$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
$info = curl_getinfo($http);
$accessibility = json_decode($response,true);
?>
<h2>Edit <?php echo $Section; ?> - <?php echo $Subsection; ?></h2>
<?php
require_once "../nav.php";
?>
<?php
if(count($accessibility) > 0)
	{
	?>
	<table class="table table-striped">
	<?php 			
	foreach($accessibility as $accessibility)
		{			
		$accessibility_id = $accessibility['id'];
		$accessibility_item = $accessibility['accessibility'];
		?>
		<tr>
			<td><?php echo $accessibility_item; ?></td>
			<td width="100" align="center"><a href="/locations/accessibility/edit.php?location_id=<?php echo $location_id; ?>&accessibility_id=<?php echo $accessibility_id; ?>&location_name=<?php echo $location_name; ?>">Edit</a></td>
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
	<div class="alert alert-warning text-center" role="alert">There Is No Accessibility Info</div>
	<?php			
	}		
require_once "../../includes/footer.php";
?>
