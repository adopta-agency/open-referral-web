<?php
require_once "../config.php";
require_once "../includes/header.php";

$api_url = $api_base_url . "locations/";
$http = curl_init();  
curl_setopt($http, CURLOPT_URL, $api_url);  
curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);   
curl_setopt($http, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($http);
$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
$info = curl_getinfo($http);
//echo $response;
$locations = json_decode($response,true);
//var_dump($locations);	
?>
<button onclick="location.href='add.php';" type="button" class="btn btn-default" style="float: right; marging-bottom: 5px;">Add Location</button>
<h2>Locations</h2>
<table class="table table-striped">
	<?php 
	foreach($locations as $location)
		{
		$location_id = $location['id'];				
		$organization_id = $location['organization_id'];
		$name = $location['name'];
		$alternate_name = $location['alternate_name'];
		$transportation = $location['transportation'];
		$latitude = $location['latitude'];
		$longitude = $location['longitude'];
		?>
		<tr>
			<td><?php echo $name; ?></td>
			<td><?php echo $alternate_name; ?></td>
			<td><?php echo $transportation; ?></td>
			<td><?php echo $longitude; ?>/<?php echo $latitude; ?></td>
			<td><a href="edit.php?location_id=<?php echo $location_id; ?>&location_name=<?php echo $name; ?>">Edit</a></td>
		</tr>
		<?php
		}
	?>
</table>
<?php
require_once "../includes/footer.php";
?>
