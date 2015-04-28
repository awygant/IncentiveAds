<?php

global $partner_id;
global $banner;
global $CTA_text;
global $campaign_id;
global $ads_api_url;

// ***** DEV PARTNER CONFIGURATION ***** //

// Fashion Options
/*
 $banner = "img/Banners/fashion.png";
 $CTA_text = "Get 20% Off Your Next Purchase!";
 $partner_id = "6";
 $partner_username = "Aaron2";
 $partner_apikey = "Aaron2";
 $api_base_url = "http://dev.flashfotoapi.com/api/";
 $campaign_id = "";
*/

// Automotive Options
/*
 $banner = "img/Banners/auto.png";
 $CTA_text = "Earn $500 Cash Back With Any New Vehicle Purchase";
 $partner_id = "12";
 $partner_username = "Aaron2";
 $partner_apikey = "Aaron2";
 $api_base_url = "http://dev.flashfotoapi.com/api/";
 $campaign_id = "6020916282398";
*/
// ***** END DEV PARTNER CONFIG ***** //


// ***** PRODUCTION PARTNER CONFIGURATION ***** //

// Fashion Options
/*
 $banner = "img/Banners/fashion.png";
 $CTA_text = "Get 20% Off Your Next Purchase!";
 $partner_id = "33";
 $partner_username = "anna";
 $partner_apikey = "N68NiThCGapPK0YCceYloq5Ua2jUdzQS";
 $campaign_id = "";
*/

// Automotive Options

$banner = "img/Banners/auto.png";
$CTA_text = "Earn $500 Cash Back With Any New Vehicle Purchase";
$partner_id = "32";
$partner_username = "anna";
$partner_apikey = "N68NiThCGapPK0YCceYloq5Ua2jUdzQS";

$campaign_id = "6022795555198";

$api_base_url = "http://www.flashfotoapi.com/api/";
// ***** END PRODUCTION PARTNER CONFIG ***** //

$ads_api_url = "http://www.fotam.com/api/ads/add";







// For use later when we implement partner override with $_GET.
/*if(isset($_SESSION["partner_username"]))
    $partner_username = $_SESSION["partner_username"];
else
    $partner_username = "anna";

if(isset($_SESSION["partner_apikey"]))
    $partner_apikey = $_SESSION["partner_apikey"];
else
    $partner_apikey = "N68NiThCGapPK0YCceYloq5Ua2jUdzQS";
*/

//define('ROOT_DIRECTORY', '/');
define('ROOT_DIRECTORY', '/~Anna/IncentiveAds/');
global $server_name, $auth_callback_url; // used in fotam-test.php and for navigation logout button
$server_name = 'http://'.$_SERVER['HTTP_HOST'].ROOT_DIRECTORY;
$base_url = $server_name; //need to consolidate this
$auth_callback_url = $server_name . 'flashfoto/fotam-auth/fotam-test.php';

/***** FOTAM LOGIN SETTINGS ******/
global $login_base_url;
/*** PRODUCTION ***/
$login_base_url = 'http://www.fotam.com';
/*** DEV ***/
//$login_base_url = 'http://staging.onzra.com/FlashFoto/AuthModule/trunk';
//$login_base_url = 'http://flashfoto-staging-authmodule-1.hollywood.onzra.com';

global $fotam_request_token_url, $fotam_login_url, $fotam_access_token_url, $fotam_info_url, $fotam_logout_url, $fotam_settings_url;
$fotam_request_token_url = $login_base_url.'/users/request_token';
$fotam_login_url = $login_base_url.'/users/login';
$fotam_access_token_url = $login_base_url.'/users/access_token';
$fotam_info_url = $login_base_url.'/users/api_info';
$fotam_logout_url = $login_base_url.'/users/logout?callback_url='.$server_name.'logout.php';
$fotam_settings_url = $login_base_url.'/users/settings';
$fotam_share_reporting_url = $login_base_url . '//shares/report?url=';
//echo 'Config:'.$GLOBALS['fotam_request_token_url'].'<br>'.$GLOBALS['fotam_login_url'].'<br>'.$GLOBALS['fotam_access_token_url'].'<br>'.$GLOBALS['fotam_info_url'].'<br>'.$GLOBALS['auth_callback_url'];

global $admins;
$admins = array(65,89,101); //these are staging.onzra.com ID's
$admins = array(1,4); //these are login.fotam.com ID's

/***** END FOTAM LOGIN SETTINGS ******/


?>
