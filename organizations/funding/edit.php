<?php

$Section = "Organization";
$Subsection = "Funding";

$clean = filter_input_array(INPUT_GET,$_GET); 		
$organization_id = $clean['organization_id'];
$organization_name = $clean['organization_name'];

require_once "../../config.php";
require_once "../../includes/common.php";
require_once "../../includes/header.php";

?>
<h2>Edit <?php echo $Section; ?> - <?php echo $Subsection; ?></h2>
<?php

$clean = filter_input_array(INPUT_GET,$_GET); 	
	
$organization_id = $clean['organization_id'];
$funding_id = $clean['funding_id'];

require_once "../nav.php";

$api_url = $api_base_url . "organizations/" . $organization_id . "/funding/" . $funding_id . "/";

// Update Contact
if(isset($clean['edit-organization']))
	{
			
	$source = $clean['source'];

	//echo $api_url . "<br />";
	$fields_string = "";
	$fields = array(
					'userkey' => urlencode($_SESSION['user_key']),
					'appkey' => urlencode($_SESSION['app_key']),					
					'id' => urlencode($funding_id),
					'organization_id' => urlencode($organization_id),
					'source' => urlencode($source)
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
	
	$response = curl_exec($http);
	$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
	$info = curl_getinfo($http);
	//echo $response;
	$funding = json_decode($response,true);
	$funding_id = $funding['id'];
	$funding_source = $funding['source'];
	?>
	<p class="bg-success" style="text-align: center; font-weight: bold; padding: 5px;">
		<?php echo $funding_source; ?> has been saved!
	</p>
	<?php
	curl_close($http);			
	}		
else 
	{
	$http = curl_init();  
	curl_setopt($http, CURLOPT_URL, $api_url);  
	curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);   
	curl_setopt($http, CURLOPT_SSL_VERIFYPEER, false);
	
	$response = curl_exec($http);
	//echo $response;
	$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
	$info = curl_getinfo($http);
	
	$funding = json_decode($response,true);	
	$funding_id = $funding['id'];	
	$source = $funding['source'];
	}
?>
<form method="get" action="edit.php" name="SaveContactForm">
  <input type="hidden" class="form-control" id="organization_id" name="organization_id" value="<?php echo $organization_id; ?>">
  <input type="hidden" class="form-control" id="funding_id" name="funding_id" value="<?php echo $funding_id; ?>">
  <input type="hidden" class="form-control" id="organization_name" name="organization_name" value="<?php echo $organization_name; ?>">	
	<div class="form-group">
	   <label for="name">source:</label>
	   <input type="text" class="form-control" id="source" name="source" value="<?php echo $source; ?>">
	</div>
    
  <button onclick="document.SaveContactForm.submit();" type="submit" class="btn btn-default" name="edit-organization" value="1">Save Any Changes</button>
</form>

<?php
require_once "../../includes/footer.php";
?>
