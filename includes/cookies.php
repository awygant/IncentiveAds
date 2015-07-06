<script type = "text/javascript">
<?php



if(isset($_SESSION["gender"]) && strlen($_SESSION["gender"]) > 0){
    if($_SESSION["gender"] == 'male'){
        $defaultScenes = $GLOBALS["default_male_scenes"];
    }
    else{
        $defaultScenes = $GLOBALS["default_female_scenes"];
    }
}
else{
    $defaultScenes = array_merge($GLOBALS["default_male_scenes"], $GLOBALS["default_female_scenes"]);
}

if(isset($_SESSION["finishedAds"])){
    $ensightenCookie = array();
    $ads = $_SESSION["finishedAds"];
    foreach($ads as $ad){

        $ffImgId = $ad["ImageVersion"]["image_id"];
        $meta = $ad["Meta"];
        $title = $meta->title;

        $adsData = array(
            "title"=>$title,
            "image_id"=>$ffImgId
        );
        array_push($ensightenCookie, $adsData);
    }
    $_SESSION["ensightenCookie"] = $ensightenCookie;
    $default_and_personalized = array(
        "Default"=>$defaultScenes,
        "Personalized"=>$ensightenCookie
    );
    echo ("console.log(JSON.stringify(" . json_encode($default_and_personalized) . "));");
}

else{
    echo ("console.log(JSON.stringify(" . json_encode($defaultScenes) . "));");
}

?>

</script>

