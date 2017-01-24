<?php
require_once "../config.php";
require_once "../includes/common.php";
require_once "../includes/header.php";
?>
<h2>Edit Contact</h2>
<?php

$clean = filter_input_array(INPUT_GET,$_GET); 		
$contact_id = $clean['contact_id'];

$api_url = $api_base_url . "contacts/" . $contact_id . "/";

// Add Contact
if(isset($clean['edit-organization']))
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
	
	$response = curl_exec($http);
	//echo $response;
	$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
	$info = curl_getinfo($http);
	
	$organization = json_decode($response,true);
	$id = $organization['id'];
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
	//var_dump($contacts);
	$organization_id = $contacts['organization_id'];
	$service_id = $contacts['service_id'];
	$name = $contacts['name'];
	$title = $contacts['title'];
	$department = $contacts['department'];
	$email = $contacts['email'];
	}
?>
<form method="get" action="edit.php" name="SaveContactForm">
  <input type="hidden" class="form-control" id="contact_id" name="contact_id" value="<?php echo $contact_id; ?>">	
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
  <button onclick="document.SaveContactForm.submit();" type="submit" class="btn btn-default" name="edit-organization" value="1">Save Any Changes</button>
</form>

<?php

require_once "../includes/footer.php";
?>
