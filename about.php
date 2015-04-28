<?php

include_once("includes/config.php");
include_once("includes/session.php");
include_once("flashfoto/config.php");

?>

<!DOCTYPE html>
<html>
<head>
    <title>About</title>
    <?php include_once("includes/meta.php");?>
    <?php include_once("includes/resources.php"); ?>
</head>
<body>
<?php include_once("includes/nav.php");?>
<div id = "wrap">
    <?php // include_once ("includes/banner.php") ?>
    <div class = "container text-center" style = "text-align:center !important">
        <?php // include_once("includes/CTA_text.php");?>
        <h2>ABOUT</h2>
        <p>powered by</p>
        <a href = "http://www.flashfotoinc.com" target = "_blank"><img class = "about-logo" src = "img/logos/ff-color.png" alt = "Flashfoto Logo"/></a>
        <p>
            Info/Sales: <a href = "mailto:info@flashfotoinc.com">info@flashfotoinc.com</a><br/>
            Call Us: <a href = "tel:14083542600">+1 (408) 354-2600</a><br/>
            More info at <a href = "http://www.flashfotoinc.com/fotam.php" target = "_blank">www.flashfotoinc.com</a>
        </p>
        <p>
            US Patents:<br/>
            <a href = "https://www.google.com/patents/US8131077" target = "_blank">US8131077</a>
            <a href = "https://www.google.com/patents/US8135216" target = "_blank">US8135216</a>
            <a href = "https://www.google.com/patents/US8300936" target = "_blank">US8300936</a><br/>
            <a href = "https://www.google.com/patents/US8385609" target = "_blank">US8385609</a>
            <a href = "https://www.google.com/patents/US8411986" target = "_blank">US8411986</a>
            <a href = "https://www.google.com/patents/US8638993" target = "_blank">US8638993</a><br/>
            <a href = "https://www.google.com/patents/US8670615" target = "_blank">US8670615</a>
            <a href = "https://www.google.com/patents/US8682029" target = "_blank">US8682029</a>
        </p>
        <p>
            Patents Pending:<br/>
            <a href = "https://www.google.com/patents/US20110305397" target = "_blank">US20110305397</a>
            <a href = "https://www.google.com/patents/US20110274344" target = "_blank">US20110274344</a>
        </p>
        <p>&copy; 2014 Flashfoto, Inc.</p>

    </div>
</div>

<?php include_once "includes/footer.php"; ?>
</body>
</html>