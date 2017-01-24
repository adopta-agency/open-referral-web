<?php
session_start();

date_default_timezone_set('America/Los_Angeles');
error_reporting(E_ALL);
ini_set('display_errors', '1');

?>
<!DOCTYPE html>
<html lang="en-us">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  
  <link rel="icon" href="/favicon.ico">

  <title>Developers</title>

  <script src="/js/jquery-latest.min.js" type="text/javascript" charset="utf-8"></script>
  <script src="/js/github.js" type="text/javascript" charset="utf-8"></script>
  <script src="/js/utility.js" type="text/javascript" charset="utf-8"></script>

<link href="/css/bootstrap.css" rel="stylesheet">

</head>

<body>
  	
	<nav class="navbar navbar-inverse navbar-fixed-top">
	  <div class="container">
	    <div class="navbar-header">
	      <a class="navbar-brand" href="/">Human Services Website</a>
	    </div>
	    <div id="navbar" class="collapse navbar-collapse">
	    	
	      <ul class="nav navbar-nav">
	        <li class="active"><a href="/">Home</a></li>
	        <li class="active"><a href="/organizations/">Organizations</a></li>
	        <li class="active"><a href="/services/">Services</a></li>
	        <li class="active"><a href="/locations/">Locations</a></li>	        
	        <li><a href="/contacts/">Contacts</a></li>
          <!--<li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Secondary <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="/contacts/">Contacts</a></li>
              <li><a href="/programs/">Programs</a></li>
            </ul>
          </li>	-->       	        
          <li class="active"><a href="/about/">About</a></li>
	      </ul>	    
	      <?php if(isset($_SESSION['name'])) { ?>
		   	<a type="button" class="btn btn-default pull-right" style="margin-top: 8px;">Account</a>
		   <?php } else { ?>
		   	<a type="button" class="btn btn-default pull-right" style="margin-top: 8px;">Login</a>
		   <?php } ?> 
	    </div>   
	  </div>
	</nav>
	<div class="container">
	  <div style="padding: 50px;">
	  	<div class="page">
