<?php
require_once "../config.php";
require_once "../includes/header.php";

?>
<h2>Login</h2>
<p>Currently login is only available via Github authenticaiton. You will need an active Github account with name and email address available. Once you authenticate by clicking on the icon below, you will be logged in, and able write, as well as read information into the system.</p>
<p align="center"><a href="github/?action=login"><img src="https://s3.amazonaws.com/kinlane-productions/api-evangelist/github/github-logo-transparent.png" align="center" width="150"></a></p>
<p>We will add regular user and password login, with additional social accounts like Twitter, LinkedIn, and Facebook soon. For right now, we'll just depend on Github authentication for web and API access.</p>

<?php
require_once "../includes/footer.php";
?>
