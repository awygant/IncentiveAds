<?php

include_once("includes/session.php");
include_once("flashfoto/config.php");

$ffid = 0;
if(isset($_GET["ffid"]))
    $ffid = $_GET["ffid"];
else
    header("Location: index.php");

$ffurl = $GLOBALS["api_base_url"] . "get/" . $ffid;

?>

<!DOCTYPE html>
<html>
<head>
    <title>View Photo</title>
    <?php include_once("includes/meta.php");?>
    <?php include_once("includes/resources.php"); ?>
    <meta property = "og:image" content = "<?php echo $ffurl; ?>">
</head>
<body>
<?php include_once("includes/nav.php");?>
<div id = "wrap">
    <?php include_once ("includes/banner.php") ?>
    <div class = "container text-center">
        <?php include_once("includes/CTA_text.php");?>
        <div class = "card full-size">
            <div class = "text-card full-size">
                <h3>Photo By: <!-- TODO: Grab user data if possible --></h3>
                <div id = "photo">
                    <div class = "loading text-center vertical-padded">
                        <h5>[ Loading your photo ]</h5>
                        <div class = "gearOne spinner reverseSpinner"></div>
                        <div class = "gearTwo spinner"></div>
                        <div class = "gearThree spinner reverseSpinner"></div>
                    </div>
                </div>
                <?php include "includes/share.php"; ?>
            </div>
        </div>
        <div class = "messages"></div>
    </div>
</div>

<?php include_once "includes/footer.php"; ?>
<script type = "text/javascript">

    var ffurl = "<?php echo $ffurl; ?>";

    photoContainer = document.getElementById("photo");
    var img = new Image();
    img.onload = function(){
        photoContainer.innerHTML = "";
        photoContainer.appendChild(this);
    };
    img.src = ffurl;

</script>
</body>
</html>