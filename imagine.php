<?php

include_once("includes/session.php");
include_once("flashfoto/config.php");

$ffid = 0;
if(isset($_GET["ffid"]))
    $ffid = $_GET["ffid"];
else
    header("Location: upload.php");

if(!isset($_SESSION["email"])){
    header("Location: login.php");
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Imagine</title>
        <?php include_once("includes/meta.php");?>
        <?php include_once("includes/resources.php"); ?>
        <?php include_once("includes/cookies.php"); ?>

        <script type = "text/javascript" src = "flashfoto/js/jquery-2.1.1.min.js"></script>
        <script type = "text/javascript" src = "flashfoto/fotamads/js/fotamads.js"></script>
        <script type = "text/javascript" src = "js/incentiveAds.js"></script>
        <script type = "text/javascript">
            <?php
            echo "var api_base_url = \"" . $GLOBALS["api_base_url"] . "\";";
            echo "var headFfid = " . $ffid . ";";
            echo "var partner_id = " . $GLOBALS["partner_id"] . ";";
             ?>
            $(document).ready(function(){
                mainInterface = $("#scenes");
                messageInterface = $("#messages");
                replaceInterface(cardify(loadingGraphic("Building a Personalized Experience")));



                $.when(buildAds(headFfid, partner_id)).done(function(res){
                    console.log(res);
                    /* buildAds returns a list of JSON objects structured like so:
                     * {
                     *  "ImageVersion":{
                     *      "id":"40794",
                     *      "image_id":"23437",
                     *      "version":"",
                     *      "format":"jpeg",
                     *      "width":"323",
                     *      "height":"238",
                     *      "sources":"[]",
                     *      "created":"2015-01-19 16:13:56",
                     *      "modified":"2015-01-19 16:13:56"
                     *  },
                     *  "Image":{
                     *      "id":"23437",
                     *      "partner_id":"8",
                     *      "group":"Image",
                     *      "privacy":"public",
                     *      "metadata":null,
                     *      "created":"2015-01-19 16:13:56",
                     *      "modified":"2015-01-19 16:13:56"
                     *  },
                     *  "Meta":{
                     *      "title":"It's Your Turn",
                     *      "body":"See what you look like in a new Lexus!",
                     *      "url":"http:\/\/dev.flashfotoapi.com\/api\/get\/23322?version=Layer2"
                     *  }
                     * }
                     */
                    //createFacebookAds(res);
                    window.clearInterval(segmentStatus);
                    cardContainer = $("#scenes");
                    res = JSON.parse(res);
                    res.forEach(function(scene, index, arr){

                        var ffid = scene["ImageVersion"]["image_id"];
                        var ffurl = api_base_url + "get/" + ffid;
                        var imgCard = $(buildCard("", ffid));

                        var img = new Image();
                        img.onload = function(){
                            imgCard.append(this);
                            cardContainer.append(imgCard);
                            if(index == arr.length-1){
                                restoreInterface();
                                updateStatusBar($("#statusBar"));
                            }
                        };
                        img.src = ffurl + "?height=238&resize=fit";

                    });

                });

                statusBarContainer = $("#statusBar");
                var segmentStatus = setInterval(function(){
                    updateStatusBar(statusBarContainer);
                }, 500);

            });

            function updateStatusBar(statusBar){
                var completed = statusBar.children(".completed");
                var percentDone = getPercentDone();
                completed.css("width", percentDone + "%");

                var statusMsg = getAdsStatus();
                var statusContainer = statusBar.next(".statusMsg");
                statusContainer.html(statusMsg);

                if(percentDone >= 100){
                    setTimeout(function(){
                        statusBar.hide();
                    }, 1000);
                }
            }

            function choose(elem, ffid){
                $(elem).addClass("approved");
                var thankYou = "<p class = \"success\">Cool! Taking you to your reward...</p>";
                var loading = cardify(loadingGraphic("Redirecting"));
                replaceInterface(thankYou + loading);
                setTimeout(function(){
                    window.location.href = "reward.php?ffid=" + ffid;
                }, 1500);
            }

            function buildCard(content, ffid){
                return "<div onclick = \"choose(this," + ffid + ");\" class = \"card\">" + content + "</div>";
            }


        </script>

    </head>
        <body>
        <?php include_once("includes/nav.php");?>
        <div id = "wrap">
            <?php include_once ("includes/banner.php") ?>
            <div class = "container text-center">
                <?php include_once("includes/CTA_text.php");?>
                <p class = "text-center">Step 2: Pick your Favorite!</p>
                <div id = "scenes" class = "container-fluid">
                    <div class = "card">
                        <div class = "text-card vertical-center">
                            <h3>Tap your favorite scene to finish!</h3>
                        </div>
                    </div>
                </div>
                <div id = "messages"></div>
                <div id = "statusBar">
                    <div class = "completed"></div>
                </div>
                <p class = "statusMsg"></p>
            </div>
        </div>

        <?php include_once "includes/footer.php"; ?>
        </body>
</html>
