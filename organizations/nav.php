<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#"><strong><?php echo $organization_name; ?>:</strong></a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      	<li<?php if($Section == "Organization" && $Subsection == ""){ ?> class="active"<?php } ?>><a href="/organizations/edit.php?organization_id=<?php echo $organization_id; ?>&organization_name=<?php echo $organization_name; ?>">Details</a></li>
        <li<?php if($Section == "Organization" && $Subsection == "Contacts"){ ?> class="active"<?php } ?>><a href="/organizations/contacts/?organization_id=<?php echo $organization_id; ?>&organization_name=<?php echo $organization_name; ?>">Contacts</a></li>
        <li<?php if($Section == "Organization" && $Subsection == "Funding"){ ?> class="active"<?php } ?>><a href="/organizations/funding/?organization_id=<?php echo $organization_id; ?>&organization_name=<?php echo $organization_name; ?>">Funding</a></li>
        <li<?php if($Section == "Organization" && $Subsection == "Locations"){ ?> class="active"<?php } ?>><a href="/organizations/locations/?organization_id=<?php echo $organization_id; ?>&organization_name=<?php echo $organization_name; ?>">Locations</a></li>
        <li<?php if($Section == "Organization" && $Subsection == "Phones"){ ?> class="active"<?php } ?>><a href="/organizations/phones/?organization_id=<?php echo $organization_id; ?>&organization_name=<?php echo $organization_name; ?>">Phones</a></li>
        <li<?php if($Section == "Organization" && $Subsection == "Programs"){ ?> class="active"<?php } ?>><a href="/organizations/programs/?organization_id=<?php echo $organization_id; ?>&organization_name=<?php echo $organization_name; ?>">Programs</a></li>
        <li<?php if($Section == "Organization" && $Subsection == "Services"){ ?> class="active"<?php } ?>><a href="/organizations/services/?organization_id=<?php echo $organization_id; ?>&organization_name=<?php echo $organization_name; ?>">Services</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Add <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="/organizations/contacts/add.php?organization_id=<?php echo $organization_id; ?>&organization_name=<?php echo $organization_name; ?>">Contact</a></li>
            <li><a href="/organizations/funding/add.php?organization_id=<?php echo $organization_id; ?>&organization_name=<?php echo $organization_name; ?>">Funding</a></li>
            <li><a href="/organizations/locations/add.php?organization_id=<?php echo $organization_id; ?>&organization_name=<?php echo $organization_name; ?>">Location</a></li>
            <li><a href="/organizations/phones/add.php?organization_id=<?php echo $organization_id; ?>&organization_name=<?php echo $organization_name; ?>">Phone</a></li>
            <li><a href="/organizations/programs/add.php?organization_id=<?php echo $organization_id; ?>&organization_name=<?php echo $organization_name; ?>">Program</a></li>
            <li><a href="/organizations/services/add.php?organization_id=<?php echo $organization_id; ?>&organization_name=<?php echo $organization_name; ?>">Service</a></li>
          </ul>
        </li>
      </ul>      
    </div>
  </div>
</nav>