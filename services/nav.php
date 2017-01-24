<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#"><strong><?php echo $service_name; ?>:</strong></a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      	<li<?php if($Section == "Service" && $Subsection == ""){ ?> class="active"<?php } ?>><a href="/services/edit.php?service_id=<?php echo $service_id; ?>&service_name=<?php echo $service_name; ?>">Details</a></li>
        <li<?php if($Section == "Service" && $Subsection == "Contacts"){ ?> class="active"<?php } ?>><a href="/services/contacts/?service_id=<?php echo $service_id; ?>&service_name=<?php echo $service_name; ?>">Contacts</a></li>
        <li<?php if($Section == "Service" && $Subsection == "Funding"){ ?> class="active"<?php } ?>><a href="/services/funding/?service_id=<?php echo $service_id; ?>&service_name=<?php echo $service_name; ?>">Funding</a></li>
        <li<?php if($Section == "Service" && $Subsection == "Phones"){ ?> class="active"<?php } ?>><a href="/services/phones/?service_id=<?php echo $service_id; ?>&service_name=<?php echo $service_name; ?>">Phones</a></li>
        <li<?php if($Section == "Service" && $Subsection == "Areas"){ ?> class="active"<?php } ?>><a href="/services/areas/?service_id=<?php echo $service_id; ?>&service_name=<?php echo $service_name; ?>">Areas</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Add <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="/services/contacts/add.php?service_id=<?php echo $service_id; ?>&service_name=<?php echo $service_name; ?>">Contact</a></li>
            <li><a href="/services/funding/add.php?service_id=<?php echo $service_id; ?>&service_name=<?php echo $service_name; ?>">Funding</a></li>
            <li><a href="/services/phones/add.php?service_id=<?php echo $service_id; ?>&service_name=<?php echo $service_name; ?>">Phone</a></li>
            <li><a href="/services/areas/add.php?service_id=<?php echo $service_id; ?>&service_name=<?php echo $service_name; ?>">Area</a></li>
          </ul>
        </li>
      </ul>      
    </div>
  </div>
</nav>