<?php
require_once "../config.php";
require_once "../includes/common.php";
require_once "../includes/header.php";
?>
<h2>User</h2>
<?php


?>
<form method="get" action="edit.php" name="SaveOrganizationForm">
  <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $id; ?>">	
  <div class="form-group">
    <label for="name">ID:</label>
    <input type="text" class="form-control" id="user_id" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
  </div>
  <div class="form-group">
    <label for="alternate_name">Name:</label>
    <input type="text" class="form-control" id="name" name="name" value="<?php echo $_SESSION['name']; ?>">
  </div>
  <div class="form-group">
    <label for="email">Email:</label>
    <input type="email" class="form-control" id="email" name="email" value="<?php echo $_SESSION['email']; ?>">
  </div>
  <div class="form-group">
    <label for="url">Github ID:</label>
    <input type="text" class="form-control" id="github_id" name="github_id" value="<?php echo $_SESSION['github_id']; ?>">
  </div>  
  <div class="form-group">
    <label for="tax_status">Github Login:</label>
    <input type="text" class="form-control" id="github_login" name="github_login" value="<?php echo $_SESSION['github_login']; ?>">
  </div> 
  <div class="form-group">
    <label for="year_incorporated">User Key:</label>
    <input type="text" class="form-control" id="user_key" name="user_key" value="<?php echo $_SESSION['user_key']; ?>">
  </div>   
  <div class="form-group">
    <label for="legal_status">App Key:</label>
    <input type="text" class="form-control" id="app_key" value="<?php echo $_SESSION['app_key']; ?>">
  </div>        
  <button onclick="document.SaveOrganizationForm.submit();" type="submit" class="btn btn-default" name="edit-user" value="1">Save Any Changes</button>
</form>

<?php

require_once "../includes/footer.php";
?>
