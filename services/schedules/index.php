<?php

$Section = "Service";
$Subsection = "Schedules";

require_once "../../config.php";
require_once "../../includes/header.php";

$clean = filter_input_array(INPUT_GET,$_GET); 		
$service_id = $clean['service_id'];
$service_name = $clean['service_name'];

?>
<h2>Edit <?php echo $Section; ?> - <?php echo $Subsection; ?></h2>
<?php
require_once "../nav.php";
?>
<h3>Regular Schedule</h3>
<?php
$api_url = $api_base_url . "services/" . $service_id . "/regular_schedule/";
//echo $api_url;
$http = curl_init();  
curl_setopt($http, CURLOPT_URL, $api_url);  
curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);   
curl_setopt($http, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($http);
//echo $response;
$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
$info = curl_getinfo($http);
$regular_schedule = json_decode($response,true);
//var_dump($regular_schedule);

if(count($regular_schedule) > 0)
	{
	?>
	<table class="table table-striped">
	<?php 			
	foreach($regular_schedule as $schedule)
		{			
		$regular_schedule_id = $schedule['id'];
		$weekday = $schedule['weekday'];
		$opens_at = $schedule['opens_at'];
		$closes_at = $schedule['closes_at'];
		?>
		<tr>
			<td><?php echo $weekday; ?></td>
			<td><?php echo $opens_at; ?></td>
			<td><?php echo $closes_at; ?></td>
			<td width="100" align="center"><a href="/services/schedules/edit-regular-schedule.php?service_id=<?php echo $service_id; ?>&regular_schedule_id=<?php echo $regular_schedule_id; ?>&service_name=<?php echo $service_name; ?>">Edit</a></td>
		</tr>
		<?php
		}
		?>
	</table>
	<?php			
	}
else
	{
	?>
	<div class="alert alert-warning text-center" role="alert">There Is No Regular Schedule Yet</div>
	<?php			
	}	
?>
<h3>Holiday Schedule</h3>
<?php
$api_url = $api_base_url . "services/" . $service_id . "/holiday_schedule/";
//echo $api_url;
$http = curl_init();  
curl_setopt($http, CURLOPT_URL, $api_url);  
curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);   
curl_setopt($http, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($http);
//echo $response;
$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
$info = curl_getinfo($http);
$holiday_schedule = json_decode($response,true);
//var_dump($holiday_schedule);

if(count($holiday_schedule) > 0)
	{
	?>
	<table class="table table-striped">
	<?php 			
	foreach($holiday_schedule as $schedule)
		{			
		$holiday_schedule_id = $schedule['id'];
		$closed = $schedule['closed'];
		$opens_at = $schedule['opens_at'];
		$closes_at = $schedule['closes_at'];
		$start_date = $schedule['start_date'];
		$end_date = $schedule['end_date'];
		?>
		<tr>
			<td><?php echo $closed; ?></td>
			<td><?php echo $opens_at; ?></td>
			<td><?php echo $closes_at; ?></td>
			<td><?php echo $start_date; ?></td>
			<td><?php echo $end_date; ?></td>
			<td width="100" align="center"><a href="/services/schedules/edit.php?service_id=<?php echo $service_id; ?>&holiday_schedule_id=<?php echo $holiday_schedule_id; ?>&service_name=<?php echo $service_name; ?>">Edit</a></td>
		</tr>
		<?php
		}
		?>
	</table>
	<?php			
	}
else
	{
	?>
	<div class="alert alert-warning text-center" role="alert">There Is No Holiday Schedule</div>
	<?php			
	}		
require_once "../../includes/footer.php";
?>
