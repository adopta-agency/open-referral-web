<?php

$Section = "Service";
$Subsection = "Contacts";

require_once "../../config.php";
require_once "../../includes/header.php";

$clean = filter_input_array(INPUT_GET,$_GET); 		
$service_id = $clean['service_id'];
$service_name = $clean['service_name'];

$api_url = $api_base_url . "services/" . $service_id . "/contacts/";
//echo $api_url;
$http = curl_init();  
curl_setopt($http, CURLOPT_URL, $api_url);  
curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);   
curl_setopt($http, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($http);
$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
$info = curl_getinfo($http);
$contacts = json_decode($response,true);
//var_dump($contacts);
?>
<h2>Edit <?php echo $Section; ?> - <?php echo $Subsection; ?></h2>
<?php
require_once "../nav.php";
?>
<?php
if(count($contacts) > 0)
	{
	?>
	<table class="table table-striped">
	<?php 			
	foreach($contacts as $contact)
		{			
		$contact_id = $contact['id'];	
		$name = $contact['name'];
		$title = $contact['title'];
		$department = $contact['department'];
		$email = $contact['email'];
		?>
		<tr>
			<td><?php echo $name; ?></td>
			<td><?php echo $title; ?></td>
			<td><?php echo $email; ?></td>
			<td><a href="/services/contacts/edit.php?service_id=<?php echo $service_id; ?>&contact_id=<?php echo $contact_id; ?>&service_name=<?php echo $service_name; ?>">Edit</a></td>
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
	<div class="alert alert-warning text-center" role="alert">There Are No Contacts</div>
	<?php			
	}		
require_once "../../includes/footer.php";
?>
