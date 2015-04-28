<?php

session_start();
include_once('../config.php');
include_once('../flashfoto.php');
require("fotamAds.php");

if(!isset($_POST["scenePayload"]) || !isset($_SESSION["facebookId"])){
    exit;
}
$scenePayload = json_decode($_POST["scenePayload"]);
foreach($scenePayload as $scene){
    facebookAd($scene, $api_base_url);
}

// facebookAd($scenePayload[0], $api_base_url);

function facebookAd($scenePayload, $api_base_url){
    $metaData = $scenePayload->Meta;
    $imageId = $scenePayload->ImageVersion->image_id;
    $fbId = $_SESSION["facebookId"];
    $gender = $_SESSION["gender"];
    $imgUrl = $api_base_url . "get/" . $imageId;
    $applicationType = "Facebook";
    $title = $metaData->title;
    $bodyText = $metaData->body;
    $url = $metaData->url;
    $ads = new fotamAds();
    echo $ads->createAd($GLOBALS["ads_api_url"], $GLOBALS["campaign_id"], $imgUrl, $fbId, $applicationType, $title, $bodyText, $url, $gender);
}



?>