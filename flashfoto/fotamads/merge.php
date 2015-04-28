<?php

session_start();
include_once('../config.php');
include_once('../flashfoto.php');



if(empty($partner_username) || empty($partner_apikey) || empty($api_base_url)) {
    $err = 'Please configure your settings in config.inc.php';
}

$ffid=0;
if(isset($_POST["ffid"])){
    $ffid = $_POST["ffid"];
}
else{
    echo "No ffid provided.";
    exit;
}
if(isset($_POST["headData"])){
    $head_data = json_decode($_POST["headData"]);
}
else{
    echo "No head data provided.";
    exit;
}
if(isset($_POST["partner"])){
    $partnerId = $_POST["partner"];
}
else{
    echo "No partner provided.";
    exit;
}

$gender = "both";
if(isset($_SESSION["gender"])){
    $gender = $_SESSION["gender"];
}



// ***** PART ONE: GET SCENE DATA USING THE GIVEN PARAMETERS ***** //
// ****** DATABASE CONFIG ****** //
$db_port = 3306;

// ****** DEV DATABASE CONFIG ****** //
/*
$db_host = "dev.yourpicturewith.com";
$db_user = "dev_user";
$db_password = "hollywood";
$api_base_url = "http://dev.flashfotoapi.com/api/";
*/

// ****** PROD DATABASE CONFIG ****** //

$db_host = "10.210.97.147";
//$db_user = "flashfoto";
//$db_password = "ff-fb-vjFi9q2Kz9h";
$db_user = "ads_demo";
$db_password = "@rch!3";
$api_base_url = "http://www.flashfotoapi.com/api/";

$db_database = "FlashFoto_facebook";
$dbSettings = array('db_host' => $db_host, 'db_user' => $db_user, 'db_password' => $db_password, 'db_database' => $db_database, 'db_port' => $db_port);
require("fotamAds.php");

if(isset($partnerId)&&isset($gender)){
    $ads = new fotamAds();
    $ads->initialize($dbSettings,$api_base_url); //create db connection
    $ads->sceneSelection($partnerId, $gender); //get scenes by partner and gender
    //$ads->displayTargetedScenes(); // Debugging
    $ads->sceneData(); //get mount data for ads layouts and placed in payload variable
    $ads->cleanup(); //close db connections
    $scenes = $ads->payload;
} else {
    echo 'You need to provide gender and partnerId as query string parameters!<br>';
    echo 'Example: http://localhost/~aaronm/fotam/flashTITS/examples/sceneData.php?partnerId=10&gender=male';
}



if(!isset($scenes)){
    echo "Failed to retrieve scene data.";
    exit;
}



// ***** PART TWO: BUILD THINGS ***** //



$finishedAds = [];
$scenes = json_decode($scenes);

// Limits the array size to 5 scenes
if(count($scenes) > 5){
    $scenes = array_slice($scenes, 0, 5);
}

foreach($scenes as $scene){
    $finishedAds[] = buildScene($scene, $head_data, $ffid, $partner_username, $partner_apikey, $api_base_url, $ads);
}



function buildScene($scene, $head_data, $ffid, $partner_username, $partner_apikey, $api_base_url, $ads){

    $mergeData = [];
    $layers = $scene[0];
    //$layers = array_reverse($layers); // For testing purposes
    $head = $scene[1];
    foreach($layers as $layer){
        if($layer != "null" && $layer != null)
        {
            $startIndex = strrpos($layer, "/") + 1;
            $finishIndex = strpos($layer, "?");
            $img_id = substr($layer, $startIndex, $finishIndex - $startIndex);
            $versionIndex = strpos($layer, "=")+1;
            $version = substr($layer, $versionIndex);
            $img_id = intval($img_id);
            $layerInfo = array(
                "image_id" => $img_id,
                "version" => $version
            );
            $mergeData[] = $layerInfo;
        }
        else{

            // Mount data from the scene

            $mountData = $head[0]->Face[0];
            $angle = $mountData->angle;
            $height = $mountData->height;
            $width = $mountData->width;
            $xPos = $mountData->x; // Gives the left edge of the mount box
            $yPos = $mountData->y; // Gives the bottom of the mount box

            // Data from the incoming head
            $headHeight = $head_data->head_height;
            $faceBottom = $head_data->head_position_y;
            $faceAndHairWidth = $head_data->crop_width;
            $faceAndHairHeight = $head_data->crop_height;
            $chinX = $head_data->chin_point_x;
            $chinY = $head_data->chin_point_y;

            // Resizing and position calculations
            $resizeRatio = $height/$headHeight;
            $scale = $resizeRatio * 100;
            $adjustedFaceAndHairWidth = floor($faceAndHairWidth * $resizeRatio);
            $adjustedFaceAndHairHeight = floor($faceAndHairHeight * $resizeRatio);
            $adjustedChinX = floor($chinX * $resizeRatio);
            $adjustedChinY = floor($chinY * $resizeRatio);
            $adjustedFaceBottom = floor($faceBottom * $resizeRatio);
            $deltaChinY = $adjustedChinY - $adjustedFaceBottom;

            // Gives us the location of the chin based off incoming chin data and scene face location data
            $targetChinX = $xPos + $width/2;
            $targetChinY = $yPos + $deltaChinY;

            // Gives us a bottom left starting point based off the target chin location
            $targetX = $targetChinX - $adjustedChinX;
            $targetY = $targetChinY - $adjustedChinY + $adjustedFaceAndHairHeight;

            $ffid = intval($ffid);
            $targetX = intval($targetX);
            $targetY = intval($targetY);
            $scale = intval($scale);
            $angle = intval($angle);

            $headInfo = array(
                "image_id" => $ffid,
                "version" => "HardMasked",
                "x" => $targetX,
                "y" => $targetY,
                "scale" => $scale,
                "angle" => $angle
            );
            $mergeData[] = $headInfo;

        }

    }
    $metaData = $scene[2];
    $mergedScene = mergeScene($metaData, $mergeData, $partner_username, $partner_apikey, $api_base_url, $ads);
    $mergedScene["Meta"] = $metaData;
    return $mergedScene;
    // return mergeScene($scene[2], $mergeData, $partner_username, $partner_apikey, $api_base_url, $ads);
}

function mergeScene($metaData, $mergeData, $partner_username, $partner_apikey, $api_base_url, $ads){

    $FlashFotoAPI = new FlashFoto($partner_username, $partner_apikey, $api_base_url);
    $optional = array(
        "privacy" => "public"
    );

    try {
        $imageId = $FlashFotoAPI->merge($mergeData, $optional ? $optional : null);
    } catch(Exception $e){
        throw new Exception('Some Flashfoto API error occurred', 0, $e);
    }

    // If an ad was created and the user is logged in via Facebook
    /*if(isset($_SESSION["facebookId"]) && $imageId > 0){
         facebookAd($metaData, $imageId, $ads, $api_base_url);
    }*/

    return $imageId;

}
// Add the finished ads to a Session variable for use in the ensighten cookie block (includes/cookies.php);
$_SESSION["finishedAds"] = $finishedAds;
echo json_encode($finishedAds);

?>
