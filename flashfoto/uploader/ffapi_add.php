<?php

session_start();
include_once('../config.php');
include_once('../flashfoto.php');


if(empty($partner_username) || empty($partner_apikey) || empty($api_base_url)) {
    $err = 'Please configure your settings in config.inc.php';
}

$FlashFotoAPI = new FlashFoto($partner_username, $partner_apikey, $api_base_url);
 	if (isset($_FILES["image"])) {

		if(empty($_FILES["image"]["tmp_name"])){
            //print('the filename is empty for some reason and we cannot proceed');
            $message = 'filename is empty...';
            $message .= 'error: '.$_FILES["image"]["error"];
            $message .= '("upload_max_filesize"): '.ini_get("upload_max_filesize");
            echo $message;
            return;
        }
        if($_FILES["image"]["error"] == 0){
            $uploaded_type = exif_imagetype($_FILES["image"]["tmp_name"]);
            // What we have now is a number representing our file type.

            switch($uploaded_type) {
                case "1":
                    $uploaded_type = "gif";
                    break;
                case "2":
                    $uploaded_type = "jpeg";
                    break;
                case "3":
                    $uploaded_type = "png";
                    break;
                case "4":
                    //$uploaded_type = "swf";
                    $uploaded_type = "unsupported";
                    break;
                case "5":
                    //$uploaded_type = "psd";
                    $uploaded_type = "unsupported";
                    break;
                case "6":
                    $uploaded_type = "bmp";
                    break;
                case "7":
                    $uploaded_type = "tiff";
                    break;
                case "8":
                    $uploaded_type = "tiff";
                    break;
                // there are many more types that are not supported so...
                default:
                    $uploaded_type = "unsupported";
            }

            if($uploaded_type != "unsupported"){

                $optional = array(
                    "privacy" => "public",
                    "format" => $uploaded_type
                );

                if(isset($_POST["ffid"])){
                    $optional["version"] = "Watermarked";
                    $optional["image_id"] = $_POST["ffid"];
                }

                try {
                    $addResult = $FlashFotoAPI->add(file_get_contents($_FILES["image"]["tmp_name"]) ? file_get_contents($_FILES["image"]["tmp_name"]) : null, $optional ? $optional : null);
		if(isset($_POST["ffid"])){

					try{
						$image_data = $FlashFotoAPI->crop($addResult['Image']['id'], array('ratioHeight'=>1, 'ratioWidth'=>1));
						$addResult = $FlashFotoAPI->add($image_data, $optional ? $optional : null);
						$imageId = $addResult['Image']['id'];
					}catch(Exception $e) {
						$imageId = $addResult['Image']['id'];
					}
					} else {
						$imageId = $addResult['Image']['id'];
					}

                    //$removeResult = $FlashFotoAPI->remove_uniform_background($addResult['Image']['id'], $optional ? $optional : null);
                    $imageId = $addResult['Image']['id'];
                    echo $imageId;
                } catch(Exception $e){
                    throw new Exception('Some Flashfoto API error occurred', 0, $e);
                }
            } else {
                //return 'File type unsupported';
            }
        }
    }
 	else if(isset($_POST["url"])) {
 		// echo "<pre>";
 		// print_r($_POST["url"]);
 		// echo "</pre>";
 		$optional = array(
 			"location" => base64_encode($_POST["url"]),
 		  	"privacy" => "public"
 			);
 		$addResult = $FlashFotoAPI->add(null, $optional ? $optional : null);
		//$removeResult = $FlashFotoAPI->remove_uniform_background($addResult['Image']['id'], $optional ? $optional : null);
		$imageId = $addResult['Image']['id'];
        echo $imageId;
 	}
    else{
        echo "no data received.";
    }
?>
