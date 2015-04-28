<script type = "text/javascript">
<?php

if(isset($_SESSION["ensightenCookie"])){
    $ensightenCookie = $_SESSION["ensightenCookie"];
}
else if(isset($_SESSION["finishedAds"])){
    $ensightenCookie = array();
    $ads = $_SESSION["finishedAds"];
    foreach($ads as $ad){
        $ffurl = $api_base_url . "get/" . $ad["ImageVersion"]["image_id"];
        array_push($ensightenCookie, $ffurl);
    }
    $_SESSION["ensightenCookie"] = $ensightenCookie;
}
else{
    $ensightenCookie = array("https://flashfotoapi.com/api/get/3378019", "https://flashfotoapi.com/api/get/3378014", "https://flashfotoapi.com/api/get/3378015", "https://flashfotoapi.com/api/get/3378016", "https://flashfotoapi.com/api/get/3378017", "https://flashfotoapi.com/api/get/3378018", "https://flashfotoapi.com/api/get/3378020", "https://flashfotoapi.com/api/get/3378021");
}

echo ("console.log('" . json_encode($ensightenCookie) . "');");

?>

</script>