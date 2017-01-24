<?php

$Section = "Organization";
$Subsection = "Phones";

$clean = filter_input_array(INPUT_GET,$_GET); 		
$organization_id = $clean['organization_id'];
$organization_name = $clean['organization_name'];

require_once "../../config.php";
require_once "../../includes/common.php";
require_once "../../includes/header.php";

?>
<h2>Add <?php echo $Section; ?> - <?php echo $Subsection; ?></h2>
<?php
require_once "../nav.php";

$api_url = $api_base_url;

// Add Phone
if(isset($_REQUEST['add-phone']))
	{
		
	$number = $clean['number'];
	$extension = $clean['extension'];
	$type = $clean['type'];
	$department = $clean['department'];

	$api_url = $api_base_url . "organizations/" . $organization_id . "/phones/";

	//echo $api_url . "<br />";
	$fields_string = "";
	$fields = array(
					'userkey' => urlencode($_SESSION['user_key']),
					'appkey' => urlencode($_SESSION['app_key']),
					'organization_id' => urlencode($organization_id),
					'number' => urlencode($number),
					'extension' => urlencode($extension),
					'type' => urlencode($type),
					'department' => urlencode($department)
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
	
	$response = curl_exec($http);
	$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
	$info = curl_getinfo($http);
	//echo $response;
	$phone = json_decode($response,true);
	$phone_id = $phone['id'];
	$phone_number = $phone['number'];
	?>
	<p class="bg-success" style="text-align: center; font-weight: bold; padding: 5px;">
		<?php echo $phone_number; ?> has been added!
	</p>
	<center>
		<button onclick="location.href='index.php?organization_id=<?php echo $organization_id; ?>&organization_name=<?php echo $organization_name; ?>';" type="button" class="btn btn-default" style="marging-bottom: 5px;"><< Return To Phone Listing</button>
		<button onclick="location.href='edit.php?organization_id=<?php echo $organization_id; ?>&organization_name=<?php echo $organization_name; ?>';" type="button" class="btn btn-default" style="marging-bottom: 5px;">Edit <?php echo $phone_number; ?> <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></button>
	</center>
	<?php
	curl_close($http);			
	}		
else 
	{
		
	?>
	<form method="get" action="add.php">
	<input type="hidden" id="organization_id" name="organization_id" value="<?php echo $organization_id; ?>">
	<input type="hidden" id="organization_name" name="organization_name" value="<?php echo $organization_name; ?>">
		<div class="form-group">
		   <label for="name">number:</label>
		   <input type="text" class="form-control" id="number" name="number">
		</div>
		<div class="form-group">
		   <label for="name">extension:</label>
		   <input type="text" class="form-control" id="extension" name="extension">
		</div>
		<div class="form-group">
		   <label for="name">type:</label>
		   <input type="text" class="form-control" id="type" name="type">
		</div>
		<div class="form-group">
		   <label for="name">department:</label>
		   <input type="text" class="form-control" id="department" name="department">
		</div>    
	  <button type="submit" class="btn btn-default" name="add-phone" value="1">Add This Phone</button>
	</form>
	
	<?php
	}
require_once "../../includes/footer.php";
?>
