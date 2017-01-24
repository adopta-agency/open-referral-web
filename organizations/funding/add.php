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
<h2>Add <?php echo $Section; ?> - <?php echo $Subsection; ?></h2>
<?php
require_once "../nav.php";

$api_url = $api_base_url;

// Add Contact
if(isset($_REQUEST['add-funding']))
	{
	
	$source = $clean['source'];

	$api_url = $api_base_url . "organizations/" . $organization_id . "/funding/";

	//echo $api_url . "<br />";
	$fields_string = "";
	$fields = array(
					'userkey' => urlencode($_SESSION['user_key']),
					'appkey' => urlencode($_SESSION['app_key']),					
					'organization_id' => urlencode($organization_id),
					'source' => urlencode($source)
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
echo $output;
	$funding = json_decode($output,true);
	$funding_id = $funding['id'];
	$funding_source = $funding['source'];
	?>
	<p class="bg-success" style="text-align: center; font-weight: bold; padding: 5px;">
		<?php echo $funding_source; ?> has been added!
	</p>
	<center>
		<button onclick="location.href='index.php?organization_id=<?php echo $organization_id; ?>&organization_name=<?php echo $organization_name; ?>';" type="button" class="btn btn-default" style="marging-bottom: 5px;"><< Return To Funding Listing</button>
		<button onclick="location.href='edit.php?organization_id=<?php echo $organization_id; ?>&organization_name=<?php echo $organization_name; ?>';" type="button" class="btn btn-default" style="marging-bottom: 5px;">Edit <?php echo $funding_source; ?> <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></button>
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
	   <label for="name">source:</label>
	   <input type="text" class="form-control" id="source" name="source">
	</div>     
	<button type="submit" class="btn btn-default" name="add-funding" value="1">Add This Funding Source</button>
	</form>
	
	<?php
	}
require_once "../../includes/footer.php";
?>
