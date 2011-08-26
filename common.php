<?php 

/*
 * Shared settings for all the consumer OpenID stuff. 
 * Also bootstraps the include path and the includes themselves.
 * ashish@tru.ly
 */

error_reporting( 0 );

// this is the test endpoint.
define('TRULY_URL', "http://r3.tru.ly/");

// set up the include paths
$path_extra = dirname(dirname(dirname(__FILE__)));
$path = ini_get('include_path');
$path = $path_extra . PATH_SEPARATOR . $path . PATH_SEPARATOR . dirname(__FILE__) . "/openid/";
ini_set('include_path', $path);

require_once "Auth/OpenID/Consumer.php";
require_once "Auth/OpenID/SQLStore.php";
require_once "Auth/OpenID/MySQLStore.php";
require_once "Auth/OpenID/MemcachedStore.php";
require_once "Auth/OpenID/SReg.php";
require_once "Auth/OpenID/PAPE.php";
require_once "Auth/OpenID/AX.php";
require_once "DB.php";

function getReturnTo() {
    return sprintf("%s://%s:%s%s/finish_auth.php",
                   getScheme(), $_SERVER['SERVER_NAME'],
                   $_SERVER['SERVER_PORT'],
                   dirname($_SERVER['PHP_SELF']));
}

function getTrustRoot() {
    return sprintf("%s://%s:%s%s/",
                   getScheme(), $_SERVER['SERVER_NAME'],
                   $_SERVER['SERVER_PORT'],
                   dirname($_SERVER['PHP_SELF']));
}

function getScheme() {
    $parts = parse_url( TRULY_URL );
    return $parts["scheme"];
}

function getConsumer( ){
    $memcache = new Memcache();
    $memcache->connect('localhost', 11211);
    $store = new Auth_OpenID_MemcachedStore( $memcache );
	  return new Auth_OpenID_Consumer($store);
}

