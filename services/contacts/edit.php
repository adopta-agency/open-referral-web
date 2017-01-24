<?php

$Section = "Service";
$Subsection = "Contacts";

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
$contact_id = $clean['contact_id'];

require_once "../nav.php";

$api_url = $api_base_url . "services/" . $service_id . "/contacts/" . $contact_id . "/";

// Update Contact
if(isset($clean['edit-service']))
	{
			
	$name = $clean['name'];
	$title = $clean['title'];
	$department = $clean['department'];
	$email = $clean['email'];

	//echo $api_url . "<br />";
	$fields_string = "";
	$fields = array(
					'userkey' => urlencode($_SESSION['user_key']),
					'appkey' => urlencode($_SESSION['app_key']),
					'id' => urlencode($contact_id),
					'service_id' => urlencode($service_id),
					'name' => urlencode($name),
					'title' => urlencode($title),
					'department' => urlencode($department),
					'email' => urlencode($email)
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
	//echo $output;
	$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
	$info = curl_getinfo($http);

	?>
	<p class="bg-success" style="text-align: center; font-weight: bold; padding: 5px;">
		<?php echo $name; ?> has been saved!
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
	
	$contacts = json_decode($response,true);	
	$name = $contacts['name'];
	$title = $contacts['title'];
	$department = $contacts['department'];
	$email = $contacts['email'];
	}
?>
<form method="get" action="edit.php" name="SaveContactForm">
  <input type="hidden" class="form-control" id="service_id" name="service_id" value="<?php echo $service_id; ?>">
  <input type="hidden" class="form-control" id="contact_id" name="contact_id" value="<?php echo $contact_id; ?>">
  <input type="hidden" class="form-control" id="service_name" name="service_name" value="<?php echo $service_name; ?>">	
	<div class="form-group">
	   <label for="name">name:</label>
	   <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>">
	</div>
	<div class="form-group">
	   <label for="name">title:</label>
	   <input type="text" class="form-control" id="title" name="title" value="<?php echo $title; ?>">
	</div>
	<div class="form-group">
	   <label for="name">department:</label>
	   <input type="text" class="form-control" id="department" name="department" value="<?php echo $department; ?>">
	</div>
	<div class="form-group">
	   <label for="name">email:</label>
	   <input type="text" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
	</div>      
  <button onclick="document.SaveContactForm.submit();" type="submit" class="btn btn-default" name="edit-service" value="1">Save Any Changes</button>
</form>

<?php
require_once "../../includes/footer.php";
?>
