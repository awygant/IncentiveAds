<?php
/**
 * Created by PhpStorm.
 * User: aaronm
 * Date: 10/15/14
 * Time: 5:31 PM
 */

// ****** DATABASE CONFIG ****** //
$db_port = 3306;

// ****** DEV DATABASE CONFIG ****** //
$db_host = "dev.yourpicturewith.com";
$db_user = "dev_user";
$db_password = "hollywood";
$api_base_url = "http://dev.flashfotoapi.com/api/";

// ****** PROD DATABASE CONFIG ****** //
$db_host = "10.181.133.85";
$db_user = "flashfoto";
$db_password = "ff-fb-vjFi9q2Kz9h";
$api_base_url = "http://www.flashfotoapi.com/api/";



$db_database = "FlashFoto_facebook";

/*
// Pulling this out for the new advertisements table in the admin tool
$db_tracking_database = "nextlevelshit";
*/

$dbSettings = array('db_host' => $db_host, 'db_user' => $db_user, 'db_password' => $db_password, 'db_database' => $db_database, 'db_port' => $db_port);



session_start();
require('../fotamAds.php');

if(isset($_GET['partnerId'])){
    $partnerId = $_GET['partnerId'];
}
else if (isset($_POST['partnerId']))
    $partnerId = $_POST['partnerId'];

if(isset($_GET['gender'])){
    $gender = $_GET['gender'];
}
else if(isset($_POST['gender']))
    $gender = $_POST['gender'];

if(isset($partnerId)&&isset($gender)){
    $ads = new fotamAds();
    $ads->initialize($dbSettings,$api_base_url); //create db connection
    $ads->sceneSelection($partnerId,$gender); //get scenes by partner and gender
    //$ads->displayTargetedScenes();
    $ads->sceneData(); //get mount data for ads layouts and placed in payload variable
    $ads->cleanup(); //close db connections
    echo $ads->payload;
} else {
    echo 'You need to provide gender and partnerId as query string parameters!<br>';
    echo 'Example: http://localhost/~aaronm/fotam/flashTITS/examples/sceneData.php?partnerId=10&gender=male';
}
