<?php

$Section = "Organization";
$Subsection = "Eligibility";

require_once "../../config.php";
require_once "../../includes/header.php";

$clean = filter_input_array(INPUT_GET,$_GET); 		
$organization_id = $clean['organization_id'];
$organization_name = $clean['organization_name'];

$api_url = $api_base_url . "organizations/" . $organization_id . "/eligibility/";
//echo $api_url;
$http = curl_init();  
curl_setopt($http, CURLOPT_URL, $api_url);  
curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);   
curl_setopt($http, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($http);
$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
$info = curl_getinfo($http);

//echo $response;

$eligibility = json_decode($response,true);
//var_dump($eligibility);
?>
<h2>Edit <?php echo $Section; ?> - <?php echo $Subsection; ?></h2>
<?php
require_once "../nav.php";
?>
<?php
if(count($eligibility) > 0)
	{
	?>
	<table class="table table-striped">
	<?php 			
	foreach($eligibility as $eligibility)
		{			
		$eligibility_id = $eligibility['id'];	
		$eligibility = $eligibility['eligibility'];
		?>
		<tr>
			<td><?php echo $eligibility; ?></td>
			<td width="50"><a href="/organizations/eligibility/edit.php?organization_id=<?php echo $organization_id; ?>&eligibility_id=<?php echo $eligibility_id; ?>&organization_name=<?php echo $organization_name; ?>">Edit</a></td>
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
	<div class="alert alert-warning text-center" role="alert">There Is No Eligibility</div>
	<?php			
	}		
require_once "../../includes/footer.php";
?>
