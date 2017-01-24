<?php

$Section = "Service";
$Subsection = "Documents";

$clean = filter_input_array(INPUT_GET,$_GET); 		
$service_id = $clean['service_id'];
$service_name = $clean['service_name'];

require_once "../../config.php";
require_once "../../includes/common.php";
require_once "../../includes/header.php";

?>
<h2>Edit <?php echo $Section; ?> - <?php echo $Subsection; ?></h2>
<?php

$clean = filter_input_array(INPUT_GET,$_GET); 		
$service_id = $clean['service_id'];
$required_document_id = $clean['required_document_id'];

require_once "../nav.php";

$api_url = $api_base_url . "services/" . $service_id . "/required-document/" . $required_document_id . "/";
//echo $api_url;
// Update Language
if(isset($clean['edit-required_document']))
	{
			
	$required_document = $clean['required_document'];

	//echo $api_url . "<br />";
	$fields_string = "";
	$fields = array(
					'userkey' => urlencode($_SESSION['user_key']),
					'appkey' => urlencode($_SESSION['app_key']),
					'service_id' => urlencode($service_id),
					'id' => urlencode($required_document_id),
					'required_document' => urlencode($required_document)
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
	$required_document = json_decode($response,true);
	$required_document_id = $required_document['id'];
	$required_document = $required_document['required_document'];

	?>
	<p class="bg-success" style="text-align: center; font-weight: bold; padding: 5px;">
		<?php echo $required_document; ?> has been saved!
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
	
	$required_documents = json_decode($response,true);	
	$required_document = $required_documents['required_document'];
	}
?>
<form method="get" action="edit.php" name="SaveLanguageForm">
  <input type="hidden" class="form-control" id="service_id" name="service_id" value="<?php echo $service_id; ?>">
  <input type="hidden" class="form-control" id="required_document_id" name="required_document_id" value="<?php echo $required_document_id; ?>">
  <input type="hidden" class="form-control" id="service_name" name="service_name" value="<?php echo $service_name; ?>">	
	<div class="form-group">
	   <label for="name">required document:</label>
	   <input type="text" class="form-control" id="required_document" name="required_document" value="<?php echo $required_document; ?>">
	</div>
  <button onclick="document.SaveLanguageForm.submit();" type="submit" class="btn btn-default" name="edit-required_document" value="1">Save Any Changes</button>
</form>

<?php
require_once "../../includes/footer.php";
?>
