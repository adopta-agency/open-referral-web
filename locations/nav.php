<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#"><strong><?php echo $location_name; ?>:</strong></a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      	<li<?php if($Section == "Location" && $Subsection == ""){ ?> class="active"<?php } ?>><a href="/locations/edit.php?location_id=<?php echo $location_id; ?>&location_name=<?php echo $location_name; ?>">Details</a></li>
        <li<?php if($Section == "Location" && $Subsection == "Accessibility"){ ?> class="active"<?php } ?>><a href="/locations/accessibility/?location_id=<?php echo $location_id; ?>&location_name=<?php echo $location_name; ?>">Accessibility</a></li>
        <li<?php if($Section == "Location" && $Subsection == "Schedules"){ ?> class="active"<?php } ?>><a href="/locations/schedules/?location_id=<?php echo $location_id; ?>&location_name=<?php echo $location_name; ?>">Schedules</a></li>
        <li<?php if($Section == "Location" && $Subsection == "Languages"){ ?> class="active"<?php } ?>><a href="/locations/languages/?location_id=<?php echo $location_id; ?>&location_name=<?php echo $location_name; ?>">Languages</a></li>
        <li<?php if($Section == "Location" && $Subsection == "Phones"){ ?> class="active"<?php } ?>><a href="/locations/phones/?location_id=<?php echo $location_id; ?>&location_name=<?php echo $location_name; ?>">Phones</a></li>
        <li<?php if($Section == "Location" && $Subsection == "Addresses"){ ?> class="active"<?php } ?>><a href="/locations/addresses/?location_id=<?php echo $location_id; ?>&location_name=<?php echo $location_name; ?>">Addresses</a></li>
        <li<?php if($Section == "Location" && $Subsection == "Services"){ ?> class="active"<?php } ?>><a href="/locations/services/?location_id=<?php echo $location_id; ?>&location_name=<?php echo $location_name; ?>">Services</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Add <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="/locations/accessibility/add.php?location_id=<?php echo $location_id; ?>&location_name=<?php echo $location_name; ?>">Accessibility</a></li>
            <li><a href="/locations/schedules/add-regular-schedule.php?location_id=<?php echo $location_id; ?>&location_name=<?php echo $location_name; ?>">Regular Schedule</a></li>
            <li><a href="/locations/schedules/add-holiday-schedule.php?location_id=<?php echo $location_id; ?>&location_name=<?php echo $location_name; ?>">Holiday Schedule</a></li>
            <li><a href="/locations/languages/add.php?location_id=<?php echo $location_id; ?>&location_name=<?php echo $location_name; ?>">Languages</a></li>
            <li><a href="/locations/phones/add.php?location_id=<?php echo $location_id; ?>&location_name=<?php echo $location_name; ?>">Phones</a></li>
            <li><a href="/locations/addresses/add-physical-address.php?location_id=<?php echo $location_id; ?>&location_name=<?php echo $location_name; ?>">Physical Address</a></li>
            <li><a href="/locations/addresses/add-postal-address.php?location_id=<?php echo $location_id; ?>&location_name=<?php echo $location_name; ?>">Postal Address</a></li>             
            <li><a href="/locations/services/add.php?location_id=<?php echo $location_id; ?>&location_name=<?php echo $location_name; ?>">Service</a></li>
          </ul>
        </li>
      </ul>      
    </div>
  </div>
</nav>