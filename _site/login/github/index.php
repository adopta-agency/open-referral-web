<?php
date_default_timezone_set('America/Los_Angeles');
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once "../../config.php";
require_once "../../includes/common.php";

define('OAUTH2_CLIENT_ID', $github_oauth_client_id);
define('OAUTH2_CLIENT_SECRET', $github_oauth_client_secret);

$authorizeURL = 'https://github.com/login/oauth/authorize';
$tokenURL = 'https://github.com/login/oauth/access_token';
$apiURLBase = 'https://api.github.com/';

session_start();

if(get('action') == 'login') 
	{
  	$_SESSION['state'] = hash('sha256', microtime(TRUE).rand().$_SERVER['REMOTE_ADDR']);
  	unset($_SESSION['access_token']);

	$params = array(
		'client_id' => OAUTH2_CLIENT_ID,
		'redirect_uri' => 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'],
		'scope' => 'user',
		'state' => $_SESSION['state']
		);
  	header('Location: ' . $authorizeURL . '?' . http_build_query($params));
  	die();
	}

if(get('code')) 
	{
  	if(!get('state') || $_SESSION['state'] != get('state')) 
  		{
    	header('Location: ' . $_SERVER['PHP_SELF']);
    	die();
  	}

	$token = apiRequest($tokenURL, array(
		'client_id' => OAUTH2_CLIENT_ID,
		'client_secret' => OAUTH2_CLIENT_SECRET,
		'redirect_uri' => 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'],
		'state' => $_SESSION['state'],
		'code' => get('code')
		));
	$_SESSION['access_token'] = $token->access_token;

  	header('Location: ' . $_SERVER['PHP_SELF']);
	}

if(session('access_token')) 
	{
	echo "HERE:" . session('access_token') . "<br />";
  	$user = apiRequest($apiURLBase . 'user');
	
	$github_id = $user->id;
	$github_login = $user->login;
	$github_name = $user->name;
	$github_email = $user->email;
	
	$api_url = $api_base_url . "users/";

	//echo $api_url . "<br />";
	$fields_string = "";
	$fields = array(
					'github_id' => urlencode($github_id),
					'github_login' => urlencode($github_login),
					'name' => urlencode($github_name),
					'email' => urlencode($github_email)
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

	$user = json_decode($output,true);	
	
	$_SESSION['user_id'] = $user['id'];
	$_SESSION['name'] = $user['name'];
	$_SESSION['email'] = $user['email'];
	$_SESSION['github_id'] = $user['github_id'];
	$_SESSION['github_login'] = $user['github_login'];
	$_SESSION['user_key'] = $user['user_key'];
	$_SESSION['app_key'] = $user['app_key'];	
	//var_dump($_SESSION);
	header('Location: ' . $base_url);

	} 
else 
	{
  	//echo '<h3>Not logged in</h3>';
  	//echo '<p><a href="?action=login">Log In</a></p>';
	}

function apiRequest($url, $post=FALSE, $headers=array()) 
	{
  	$ch = curl_init($url);
  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

  	if($post)
		{
    	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
		}
		
  	$headers[] = 'Accept: application/json';

  	if(session('access_token'))
		{
    	$headers[] = 'Authorization: Bearer ' . session('access_token');
		}
		
  	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  	curl_setopt($ch, CURLOPT_USERAGENT ,$_SERVER['HTTP_USER_AGENT']);

  	$response = curl_exec($ch);
  	return json_decode($response);
	}

function get($key, $default=NULL) 
	{
  	return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
	}

function session($key, $default=NULL) 
	{
  	return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
	}
?>