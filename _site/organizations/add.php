<?php
require_once "../config.php";
require_once "../includes/common.php";
require_once "../includes/header.php";
?>
<h2>Add Organization</h2>
<?php

$api_url = $api_base_url;

// Add Organization
if(isset($_REQUEST['add-organization']))
	{
		
	$clean = filter_input_array(INPUT_GET,$_GET); 		
	$organization_name = $clean['name'];
	$organization_alternate_name = $clean['alternate_name'];
	$organization_description = $clean['description'];
	$organization_email = $clean['email'];
	$organization_url = $clean['url'];
	$organization_tax_status = $clean['tax_status'];
	$organization_year_incorporated = $clean['year_incorporated'];
	$organization_legal_status = $clean['legal_status'];

	$api_url = $api_base_url . "organizations/";

	//echo $api_url . "<br />";
	$fields = array(
					'userkey' => urlencode($_SESSION['user_key']),
					'appkey' => urlencode($_SESSION['app_key']),
					'name' => urlencode($organization_name),
					'alternate_name' => urlencode($organization_alternate_name),
					'description' => urlencode($organization_description),
					'email' => urlencode($organization_email),
					'url' => urlencode($organization_url),
					'tax_status' => urlencode($organization_tax_status),
					'year_incorporated' => urlencode($organization_year_incorporated),					
					'legal_status' => urlencode($organization_legal_status)
					);
	
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');
	
	//echo $fields_string;
	
	$http = curl_init();
	
	curl_setopt($http,CURLOPT_URL, $api_url);
	curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);  
	curl_setopt($http,CURLOPT_POST, count($fields));
	curl_setopt($http,CURLOPT_POSTFIELDS, $fields_string);	
	curl_setopt($http, CURLOPT_SSL_VERIFYPEER, false);
	
	$output = curl_exec($http);
	$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
	$info = curl_getinfo($http);
	
	//var_dump($output);
	
	$organization = json_decode($output,true);
	//var_dump($organization);
	$id = $organization['id'];
	$name = $organization['name'];
	?>
	<p class="bg-success" style="text-align: center; font-weight: bold; padding: 5px;">
		<?php echo $name; ?> has been added!
	</p>
	<center>
		<button onclick="location.href='index.php';" type="button" class="btn btn-default" style="marging-bottom: 5px;"><< Return To Organization Listing</button>
		<button onclick="location.href='edit.php?id=<?php echo $id; ?>';" type="button" class="btn btn-default" style="marging-bottom: 5px;">Edit <?php echo $name; ?> <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></button>
	</center>
	<?php
	curl_close($ch);			
	}		
else 
	{
		
	?>
	<form method="get" action="add.php">
	  <div class="form-group">
	    <label for="name">Name:</label>
	    <input type="text" class="form-control" id="name" name="name" placeholder="Name">
	  </div>
	  <div class="form-group">
	    <label for="alternate_name">Alternate Name:</label>
	    <input type="text" class="form-control" id="alternate_name" name="alternate_name" placeholder="Alt Name">
	  </div>
	  <div class="form-group">
	    <label for="description">Description:</label>
	    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
	  </div> 
	  <div class="form-group">
	    <label for="email">Email:</label>
	    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
	  </div>
	  <div class="form-group">
	    <label for="url">URL:</label>
	    <input type="text" class="form-control" id="url" name="url" placeholder="URL">
	  </div>  
	  <div class="form-group">
	    <label for="tax_status">Tax Status:</label>
	    <input type="text" class="form-control" id="tax_status" name="tax_status" placeholder="Tax Status">
	  </div> 
	  <div class="form-group">
	    <label for="year_incorporated">Year Incorporated:</label>
	    <input type="text" class="form-control" id="year_incorporated" name="year_incorporated" placeholder="Year Incorporated">
	  </div>   
	  <div class="form-group">
	    <label for="legal_status">Legal Status:</label>
	    <input type="text" class="form-control" id="legal_status" placeholder="Legal Status">
	  </div>        
	  <button type="submit" class="btn btn-default" name="add-organization" value="1">Add This Organization</button>
	</form>
	
	<?php
	}
require_once "../includes/footer.php";
?>
