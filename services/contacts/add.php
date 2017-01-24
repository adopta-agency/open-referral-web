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
<h2>Add <?php echo $Section; ?> - <?php echo $Subsection; ?></h2>
<?php
require_once "../nav.php";

$api_url = $api_base_url;

// Add Contact
if(isset($_REQUEST['add-service']))
	{
		
	$name = $clean['name'];
	$title = $clean['title'];
	$department = $clean['department'];
	$email = $clean['email'];

	$api_url = $api_base_url . "services/" . $service_id . "/contacts/";

	//echo $api_url . "<br />";
	$fields_string = "";
	$fields = array(
					'userkey' => urlencode($_SESSION['user_key']),
					'appkey' => urlencode($_SESSION['app_key']),
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
	
	curl_setopt($http,CURLOPT_URL, $api_url);
	curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);  
	curl_setopt($http,CURLOPT_POST, count($fields));
	curl_setopt($http,CURLOPT_POSTFIELDS, $fields_string);	
	curl_setopt($http, CURLOPT_SSL_VERIFYPEER, false);
	
	$output = curl_exec($http);
	$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
	$info = curl_getinfo($http);
	
	//echo $output;
	
	$service = json_decode($output,true);
	//var_dump($service);
	$id = $service['id'];
	$name = $service['name'];
	?>
	<p class="bg-success" style="text-align: center; font-weight: bold; padding: 5px;">
		<?php echo $name; ?> has been added!
	</p>
	<center>
		<button onclick="location.href='index.php?service_id=<?php echo $service_id; ?>&service_name=<?php echo $service_name; ?>';" type="button" class="btn btn-default" style="marging-bottom: 5px;"><< Return To Contact Listing</button>
		<button onclick="location.href='edit.php?service_id=<?php echo $service_id; ?>&service_name=<?php echo $service_name; ?>';" type="button" class="btn btn-default" style="marging-bottom: 5px;">Edit <?php echo $name; ?> <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></button>
	</center>
	<?php
	curl_close($http);			
	}		
else 
	{
		
	?>
	<form method="get" action="add.php">
	<input type="hidden" id="service_id" name="service_id" value="<?php echo $service_id; ?>">
	<input type="hidden" id="service_name" name="service_name" value="<?php echo $service_name; ?>">
		<div class="form-group">
		   <label for="name">name:</label>
		   <input type="text" class="form-control" id="name" name="name">
		</div>
		<div class="form-group">
		   <label for="name">title:</label>
		   <input type="text" class="form-control" id="title" name="title">
		</div>
		<div class="form-group">
		   <label for="name">department:</label>
		   <input type="text" class="form-control" id="department" name="department">
		</div>
		<div class="form-group">
		   <label for="name">email:</label>
		   <input type="text" class="form-control" id="email" name="email">
		</div>       
	  <button type="submit" class="btn btn-default" name="add-service" value="1">Add This Contact</button>
	</form>
	
	<?php
	}
require_once "../../includes/footer.php";
?>
