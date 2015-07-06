<?php

include_once("includes/session.php");
include_once("flashfoto/config.php");
include_once("mail.php");

$ffid = 0;
if(isset($_GET["ffid"]))
    $ffid = $_GET["ffid"];
else
    header("Location: imagine.php");
if(!isset($_SESSION["email"])){
    header("Location: login.php");
}

if(isset($_SESSION["email"]) && $ffid > 0 && isset($GLOBALS["CTA_text"])){
    $to = $_SESSION["email"];
    $cta = $GLOBALS["CTA_text"];
    $barcode = "http://barcodes4.me/barcode/c39/FlashFotoCoupon.jpg";
    $userId = $_SESSION["userId"];
    $partnerId = $GLOBALS["partner_id"];
    sendEmail($to, $ffid, $barcode, $cta, $userId, $partnerId);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Rewards</title>
    <?php include_once("includes/meta.php");?>
    <?php include_once("includes/resources.php"); ?>
    <?php //include_once("includes/cookies.php"); ?>

    <script type = "text/javascript" src = "flashfoto/js/jquery-2.1.1.min.js"></script>
    <script type = "text/javascript" src = "js/incentiveAds.js"></script>
    <script type = "text/javascript">
        ffid = <?php echo $ffid; ?>;
        api_base_url = "<?php echo $GLOBALS["api_base_url"]; ?>";

        $(document).ready(function(){
            mainInterface = $("#rewards");
            messageInterface = $("#messages");

            var barcodeType = "c39";
            var barcodeText = "FlashFotoCoupon";

            $("#barcode").html(generateBarcode(barcodeType, barcodeText));



            photoContainer = $("#photo");
            var img = new Image();
            var src = api_base_url + "get/" + ffid;
            img.onload = function(){
                photoContainer.html("<img src = \"" + api_base_url + "get/" + ffid + "\" alt = \"Your creation\"/>");
            };
            img.src = src;

        });

        function generateBarcode(type, value){
            return "<img class = \"vertical-center\" src = \"http://barcodes4.me/barcode/" + type + "/" + value + ".jpg\" alt = \"Your coupon!\"/>";
        }

    </script>
</head>
<body>
<!--
<?php var_dump($_SESSION);?>
-->
<?php include_once("includes/nav.php");?>
<div id = "wrap">
    <?php include_once ("includes/banner.php") ?>
    <div class = "container text-center">
        <?php include_once("includes/CTA_text.php");?>
        <p class = "text-center">Step 3: Claim Your Reward!</p>
        <p class = "text-center">We've sent an email to <?php echo $_SESSION["email"]; ?>. If you don't see it, check your spam folder. We know, we don't like going in there either. We're working on it.</p>
        <div class = "rewards">
            <div class = "card">
                <div class = "text-card vertical-center">
                    <h3>Use this Barcode</h3>
                    <p class = "text-center">Psst... we emailed you a copy!</p>
                    <div class = "dynamic arrow center"></div>
                </div>
            </div>
            <div class = "card" id = "barcode"></div>
            <br/>
            <div class = "card full-size">
                <div class = "text-card full-size">
                    <h3>Your Photo:</h3>
                    <div class = "arrow center"></div>
                    <div id = "photo">
                        <div class = "loading text-center vertical-padded">
                            <h5>[ Loading your photo ]</h5>
                            <div class = "gearOne spinner reverseSpinner"></div>
                            <div class = "gearTwo spinner"></div>
                            <div class = "gearThree spinner reverseSpinner"></div>
                        </div>
                    </div>
                    <?php include "includes/share.php";?>
                </div>
            </div>
        </div>
        <div class = "messages"></div>
    </div>
</div>

<?php include_once "includes/footer.php"; ?>
</body>
</html>