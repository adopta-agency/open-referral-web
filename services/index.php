<?php
require_once "../config.php";
require_once "../includes/header.php";

$api_url = $api_base_url . "services/";
$http = curl_init();  
curl_setopt($http, CURLOPT_URL, $api_url);  
curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);   
curl_setopt($http, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($http);
$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
$info = curl_getinfo($http);
//var_dump($response);	
$services = json_decode($response,true);	
?>
<button onclick="location.href='add.php';" type="button" class="btn btn-default" style="float: right; marging-bottom: 5px;">Add Service</button>
<h2>Services</h2>
<table class="table table-striped">
	<?php 
	foreach($services as $service)
		{			
		$service_id = $service['id'];	
		$organization_id = $service['organization_id'];	
		$program_id = $service['program_id'];	
		$location_id = $service['location_id'];	
		$name = $service['name'];	
		$alternate_name = $service['alternate_name'];	
		$url = $service['url'];	
		$email = $service['email'];	
		$status = $service['status'];
		$application_process = $service['application_process'];
		$wait_time = $service['wait_time'];
		?>
		<tr>
			<td><?php echo $name; ?></td>
			<td><?php echo $email; ?></td>
			<td><?php echo $url; ?></td>
			<td><?php echo $status; ?></td>
			<td><a href="edit.php?service_id=<?php echo $service_id; ?>">Edit</a></td>
		</tr>
		<?php
		}
	?>
</table>
<?php
require_once "../includes/footer.php";
?>
