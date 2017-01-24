<?php
require_once "config.php";
require_once "includes/header.php";
?>

	<div class="jumbotron">
	  <div class="container">
	    <h3>Open Referral Website</h3>
	    <p>This is a demonstration Open Referral website built on top of an API that uses human services data specification (HSDS). This website is both a prototype and in development phases, and is fast changing, you can interact with the project via its Github repository.</p>
	  </div>
	</div>	

  <!-- Example row of columns -->
  <div class="row">
    <div class="col-md-4">
      <h4>Organizations</h4>
		<?php
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
					<td><a href="edit.php?organization_id=<?php echo $organization_id; ?>">Edit</a></td>
				</tr>
				<?php
				}
			?>
		</table>		
    </div>
    <div class="col-md-4">
      <h4>Services</h4>
		
		<?php
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
					<td><a href="edit.php?service_id=<?php echo $service_id; ?>">Edit</a></td>
				</tr>
				<?php
				}
			?>
		</table>

   </div>
    <div class="col-md-4">
      <h4>Locations</h4>
		<?php
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
					<td><a href="edit.php?location_id=<?php echo $location_id; ?>&location_name=<?php echo $name; ?>">Edit</a></td>
				</tr>
				<?php
				}
			?>
		</table>		
    </div>
    
  </div>

<?php
require_once "includes/footer.php";
?>
