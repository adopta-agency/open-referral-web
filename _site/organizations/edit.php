<?php
require_once "../config.php";
require_once "../includes/common.php";
require_once "../includes/header.php";
?>
<h2>Edit Organization</h2>
<?php

$clean = filter_input_array(INPUT_GET,$_GET); 		
$id = $clean['id'];

$api_url = $api_base_url . "organizations/" . $id . "/";

// Add Organization
if(isset($clean['edit-organization']))
	{
			
	$name = $clean['name'];
	$alternate_name = $clean['alternate_name'];
	$description = $clean['description'];
	$email = $clean['email'];
	$url = $clean['url'];
	$tax_status = $clean['tax_status'];
	$tax_id = $clean['tax_id'];
	$year_incorporated = $clean['year_incorporated'];
	$legal_status = $clean['legal_status'];

	//echo $api_url . "<br />";
	$fields = array(
					'userkey' => urlencode($_SESSION['user_key']),
					'appkey' => urlencode($_SESSION['app_key']),
					'name' => urlencode($name),
					'alternate_name' => urlencode($alternate_name),
					'description' => urlencode($description),
					'email' => urlencode($email),
					'url' => urlencode($url),
					'tax_status' => urlencode($tax_status),
					'tax_id' => urlencode($tax_id),
					'year_incorporated' => urlencode($year_incorporated),					
					'legal_status' => urlencode($legal_status)
					);
	
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');
	
	//echo $fields_string;
	
	$http = curl_init();

	curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($http, CURLOPT_VERBOSE, 1);
	curl_setopt($http, CURLOPT_HEADER, 0);

	curl_setopt($http,CURLOPT_URL, $api_url);
	curl_setopt($http, CURLOPT_CUSTOMREQUEST, "PUT");
	curl_setopt($http,CURLOPT_POSTFIELDS, $fields_string);	
	
	$output = curl_exec($http);
	$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
	$info = curl_getinfo($http);

	?>
	<p class="bg-success" style="text-align: center; font-weight: bold; padding: 5px;">
		<?php echo $name; ?> has been saved!
	</p>
	<?php
	curl_close($ch);			
	}		
else 
	{
	
	$http = curl_init();  
	curl_setopt($http, CURLOPT_URL, $api_url);  
	curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);   
	curl_setopt($http, CURLOPT_SSL_VERIFYPEER, false);
	
	$response = curl_exec($http);
	$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
	$info = curl_getinfo($http);
	
	$organizations = json_decode($response,true);	
	
	$name = $organizations['name'];
	$alternate_name = $organizations['alternate_name'];
	$description = $organizations['description'];
	$email = $organizations['email'];
	$url = $organizations['url'];
	$tax_status = $organizations['tax_status'];
	$tax_id = $organizations['tax_id'];
	$year_incorporated = $organizations['year_incorporated'];
	$legal_status = $organizations['legal_status'];
	}
?>
<form method="get" action="edit.php" name="SaveOrganizationForm">
  <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $id; ?>">	
  <div class="form-group">
    <label for="name">Name:</label>
    <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>">
  </div>
  <div class="form-group">
    <label for="alternate_name">Alternate Name:</label>
    <input type="text" class="form-control" id="alternate_name" name="alternate_name" value="<?php echo $alternate_name; ?>">
  </div>
  <div class="form-group">
    <label for="description">Description:</label>
    <textarea class="form-control" id="description" name="description" rows="3"><?php echo $description; ?></textarea>
  </div> 
  <div class="form-group">
    <label for="email">Email:</label>
    <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
  </div>
  <div class="form-group">
    <label for="url">URL:</label>
    <input type="text" class="form-control" id="url" name="url" value="<?php echo $url; ?>">
  </div>  
  <div class="form-group">
    <label for="tax_status">Tax Status:</label>
    <input type="text" class="form-control" id="tax_status" name="tax_status" value="<?php echo $tax_status; ?>">
  </div> 
  <div class="form-group">
    <label for="year_incorporated">Year Incorporated:</label>
    <input type="text" class="form-control" id="year_incorporated" name="year_incorporated" value="<?php echo $year_incorporated; ?>">
  </div>   
  <div class="form-group">
    <label for="legal_status">Legal Status:</label>
    <input type="text" class="form-control" id="legal_status" name="legal_status" value="<?php echo $legal_status; ?>">
  </div>        
  <button onclick="document.SaveOrganizationForm.submit();" type="submit" class="btn btn-default" name="edit-organization" value="1">Save Any Changes</button>
</form>

<?php

require_once "../includes/footer.php";
?>
