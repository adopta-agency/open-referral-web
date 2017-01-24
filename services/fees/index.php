<?php

$Section = "Service";
$Subsection = "Funding";

require_once "../../config.php";
require_once "../../includes/header.php";

$clean = filter_input_array(INPUT_GET,$_GET); 		
$service_id = $clean['service_id'];
$service_name = $clean['service_name'];

$api_url = $api_base_url . "services/" . $service_id . "/fees/";
//echo $api_url;
$http = curl_init();  
curl_setopt($http, CURLOPT_URL, $api_url);  
curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);   
curl_setopt($http, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($http);
$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
$info = curl_getinfo($http);

//echo $response;

$fees = json_decode($response,true);
//var_dump($fees);
?>
<h2>Edit <?php echo $Section; ?> - <?php echo $Subsection; ?></h2>
<?php
require_once "../nav.php";
?>
<?php
if(count($fees) > 0)
	{
	?>
	<table class="table table-striped">
	<?php 			
	foreach($fees as $fees)
		{			
		$fee_id = $fees['id'];	
		$fee = $fees['fee'];
		?>
		<tr>
			<td><?php echo $fee; ?></td>
			<td width="50"><a href="/services/fees/edit.php?service_id=<?php echo $service_id; ?>&fee_id=<?php echo $fee_id; ?>&service_name=<?php echo $service_name; ?>">Edit</a></td>
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
	<div class="alert alert-warning text-center" role="alert">There Is No Funding</div>
	<?php			
	}		
require_once "../../includes/footer.php";
?>
