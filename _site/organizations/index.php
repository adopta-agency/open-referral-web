<?php
require_once "../config.php";
require_once "../includes/header.php";

$api_url = $api_base_url . "organizations/";
$http = curl_init();  
curl_setopt($http, CURLOPT_URL, $api_url);  
curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);   
curl_setopt($http, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($http);
$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
$info = curl_getinfo($http);
//var_dump($response);	
$organizations = json_decode($response,true);	
?>
<button onclick="location.href='add.php';" type="button" class="btn btn-default" style="float: right; marging-bottom: 5px;">Add Organization</button>
<h2>Organizations</h2>
<table class="table table-striped">
	<?php 
	foreach($organizations as $org)
		{			
		$organization_id = $org['id'];	
		$organization_name = $org['name'];	
		$organization_alternate_name = $org['alternate_name'];	
		$organization_description = $org['description'];	
		$organization_email = $org['email'];	
		$organization_url = $org['url'];	
		$organization_tax_status = $org['tax_status'];	
		$organization_year_incorporated = $org['year_incorporated'];	
		$organization_legal_status = $org['legal_status'];
		?>
		<tr>
			<td><?php echo $organization_name; ?></td>
			<td><?php echo $organization_email; ?></td>
			<td><?php echo $organization_url; ?></td>
			<td><a href="edit.php?id=<?php echo $organization_id; ?>">Edit</a></td>
		</tr>
		<?php
		}
	?>
</table>
<?php
require_once "../includes/footer.php";
?>
