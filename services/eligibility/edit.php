<?php

$Section = "Organization";
$Subsection = "Eligibility";

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
$eligibility_id = $clean['eligibility_id'];

require_once "../nav.php";

$api_url = $api_base_url . "organizations/" . $organization_id . "/eligibility/" . $eligibility_id . "/";

// Update Contact
if(isset($clean['edit-organization']))
	{
			
	$eligibility = $clean['eligibility'];

	//echo $api_url . "<br />";
	$fields_string = "";
	$fields = array(
					'userkey' => urlencode($_SESSION['user_key']),
					'appkey' => urlencode($_SESSION['app_key']),					
					'id' => urlencode($eligibility_id),
					'organization_id' => urlencode($organization_id),
					'eligibility' => urlencode($eligibility)
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
	$eligibility = json_decode($response,true);
	$eligibility_id = $eligibility['id'];
	$eligibility_eligibility = $eligibility['eligibility'];
	?>
	<p class="bg-success" style="text-align: center; font-weight: bold; padding: 5px;">
		<?php echo $eligibility_eligibility; ?> has been saved!
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
	
	$eligibility = json_decode($response,true);	
	$eligibility_id = $eligibility['id'];	
	$eligibility = $eligibility['eligibility'];
	}
?>
<form method="get" action="edit.php" name="SaveContactForm">
  <input type="hidden" class="form-control" id="organization_id" name="organization_id" value="<?php echo $organization_id; ?>">
  <input type="hidden" class="form-control" id="eligibility_id" name="eligibility_id" value="<?php echo $eligibility_id; ?>">
  <input type="hidden" class="form-control" id="organization_name" name="organization_name" value="<?php echo $organization_name; ?>">	
	<div class="form-group">
	   <label for="name">eligibility:</label>
	   <input type="text" class="form-control" id="eligibility" name="eligibility" value="<?php echo $eligibility; ?>">
	</div>
    
  <button onclick="document.SaveContactForm.submit();" type="submit" class="btn btn-default" name="edit-organization" value="1">Save Any Changes</button>
</form>

<?php
require_once "../../includes/footer.php";
?>
