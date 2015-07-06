<?php

include_once("flashfoto/config.php");
include_once("includes/session.php");
include_once("includes/partner_config.php");


/*if(!isset($_SESSION["partner_username"]))
    overridePartnerDetails("3"); // Default to lexussc
if(isset($_GET["partner"])){
    overridePartnerDetails($_GET["partner"]);
}*/
if(!isset($_SESSION["email"])){
    header("Location: login.php");
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Upload</title>
        <?php include_once("includes/meta.php");?>
        <?php include_once("includes/resources.php"); ?>
        <?php //include_once("includes/cookies.php"); ?>

        <script type = "text/javascript">

            // Callback function for findFaces
            function judgeScore(ffid, score, msg){


                var faceFinder = $("#faceFinder");
                msg = msg || "";


                /*
                 * If score > threshold, move on to next page
                 * Else, reset the form with the appropriate error message.
                 */

                var confidenceThreshold = 85;
                if(score >= confidenceThreshold){
                    faceFinder.html("<p class = \"success\">Nice selfie! Taking you to Step 2...</p>");
                    // We must reset the form here, otherwise the back button landing here will just submit the form again.
                    resetForm();
                    setTimeout(function(){
                        window.location.href = "imagine.php?ffid=" + ffid;
                    }, 1500);
                }
                else {
                    faceFinder.hide();
                    $("#uploader").show();
                    if(msg.length > 0)
                        resetForm(msg);
                    else{
                        resetForm("Sorry, no faces were found in this photo. Try taking your photo in a well-lit area against a smooth background!");
                    }
                }

            }
        </script>

    </head>
    <body>
    <?php include_once("includes/nav.php");?>
    <div id = "wrap">
        <!--pre><?php var_dump($_SESSION);?></pre-->
        <?php include_once ("includes/banner.php") ?>
        <div class = "container text-center">
            <?php include_once("includes/CTA_text.php");?>
            <p class = "text-center">Step 1: Take a selfie!</p>

            <script type = "text/javascript" src = "flashfoto/findfaces/js/findfaces.js"></script>

            <div id = "faceFinder">
                <div id = "faceFinderLoadWrapper">
                    <div id = "faceFinderLoading" class = "loading text-center">
                        <h5>[ Finding Faces ]</h5>
                        <div class = "gearOne spinner reverseSpinner"></div>
                        <div class = "gearTwo spinner"></div>
                        <div class = "gearThree spinner reverseSpinner"></div>
                    </div>
                </div>
            </div>

            <div id = "uploader">
                <?php include_once("flashfoto/uploader/upload.php"); ?>
                <script type = "text/javascript">
                    setUploadCallback(function(ffid){
                        $("#uploader").hide();
                        $("#faceFinder").show();
                        findFaces(ffid, judgeScore);
                    });
                </script>
            </div>
        </div>
    </div>

        <?php include_once "includes/footer.php"; ?>
    </body>
</html>