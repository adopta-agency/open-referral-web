<?php
require_once "../config.php";
require_once "../includes/header.php";

$api_url = $api_base_url . "contacts/";
$http = curl_init();  
curl_setopt($http, CURLOPT_URL, $api_url);  
curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);   
curl_setopt($http, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($http);
$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
$info = curl_getinfo($http);
//var_dump($response);	
$contacts = json_decode($response,true);	
?>
<button onclick="location.href='add.php';" type="button" class="btn btn-default" style="float: right; marging-bottom: 5px;">Add Contact</button>
<h2>Contacts</h2>
<table class="table table-striped">
	<?php 
	foreach($contacts as $contact)
		{			
		$contact_id = $contact['id'];	
		$contactanization_id = $contact['organization_id'];
		$service_id = $contact['service_id'];
		$name = $contact['name'];
		$title = $contact['title'];
		$department = $contact['department'];
		$email = $contact['email'];
		?>
		<tr>
			<td><?php echo $name; ?></td>
			<td><?php echo $title; ?></td>
			<td><?php echo $email; ?></td>
			<td><a href="edit.php?contact_id=<?php echo $contact_id; ?>">Edit</a></td>
		</tr>
		<?php
		}
	?>
</table>
<?php
require_once "../includes/footer.php";
?>
