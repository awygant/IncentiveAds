<?php

include_once('../config.php');
include_once('../flashfoto.php');

if(empty($partner_username) || empty($partner_apikey) || empty($api_base_url)) {
	$err = 'Please configure your settings in config.inc.php';
}
$FlashFotoAPI = new FlashFoto($partner_username, $partner_apikey, $api_base_url);
if(!isset($_POST["ffid"])){
    exit;
}
else{
    $ffid = $_POST["ffid"];

    try{
        $status = $FlashFotoAPI->segment_status($ffid);
    }
    catch(Exception $e) {
        try{
            $iniResult = $FlashFotoAPI->segment($ffid);
        } catch(Exception $e) {

        }
    }



    $status = null;
    while(1){
        sleep(1);
        $status = $FlashFotoAPI->segment_status($ffid);
        if($status["segmentation_status"] == "failed" || $status["segmentation_status"] == "finished"){
            break;
        }
    }
    if($status["segmentation_status"] == "finished"){
        $segment_data = json_encode($status);
        echo json_encode($status, JSON_PRETTY_PRINT);
    }
    else{
        if($status["segmentation_status"] == "failed")
            echo "Segmentation Failed.";
    }
}

?>