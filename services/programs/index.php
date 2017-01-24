<?php

$Section = "Service";
$Subsection = "Programs";

require_once "../../config.php";
require_once "../../includes/header.php";

$clean = filter_input_array(INPUT_GET,$_GET); 		
$service_id = $clean['service_id'];
$service_name = $clean['service_name'];

$api_url = $api_base_url . "services/" . $service_id . "/programs/";
//echo $api_url;
$http = curl_init();  
curl_setopt($http, CURLOPT_URL, $api_url);  
curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);   
curl_setopt($http, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($http);
$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
$info = curl_getinfo($http);
$programs = json_decode($response,true);
echo $response;
?>
<h2>Edit <?php echo $Section; ?> - <?php echo $Subsection; ?></h2>
<?php
require_once "../nav.php";
?>
<?php
if(count($programs) > 0)
	{
	?>
	<table class="table table-striped">
	<?php 			
	foreach($programs as $program)
		{			
		$program_id = $program['id'];	
		$name = $program['name'];
		$alternate_name = $program['alternate_name'];	
		?>
		<tr>
			<td><?php echo $name; ?></td>
			<td><?php echo $alternate_name; ?></td>
			<td><a href="/services/programs/edit.php?service_id=<?php echo $service_id; ?>&program_id=<?php echo $program_id; ?>&service_name=<?php echo $service_name; ?>">Edit</a></td>
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
	<div class="alert alert-warning text-center" role="alert">There Are No Programs</div>
	<?php			
	}		
require_once "../../includes/footer.php";
?>
