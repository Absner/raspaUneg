<?php
require __DIR__.'/lib/UserApp/Autoloader.php';
require __DIR__.'/lib/UserAppWidget/Autoloader.php';

UserApp\Autoloader::register();
UserApp\Widget\Autoloader::register();
use \UserApp\Widget\User;

User::setAppId("578c31802b019");
$valid_token = false;

if(!User::authenticated() && isset($_COOKIE["ua_session_token"])){
	$token = $_COOKIE["ua_session_token"];

	try{
		$valid_token = User::loginWithToken($token);
	}catch(\UserApp\Exceptions\ServiceException $exception){
		$valid_token = false;
	}
}

if(!$valid_token){
	// Not authorized
}else{
	// Authorized
}
?>