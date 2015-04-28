<?php

include_once("includes/config.php");
include_once("includes/session.php");
include_once("flashfoto/config.php");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <?php include_once("includes/meta.php");?>
    <?php include_once("includes/resources.php"); ?>
</head>
<body>
<?php include_once("includes/nav.php");?>
<div id = "wrap">
    <?php include_once ("includes/banner.php") ?>
    <div class = "container text-center">
        <?php include_once("includes/CTA_text.php");?>
        <p class = "text-center">Login to access rewards!</p>
        <div class = "card">
            <div class = "text-card vertical-center">
                <h3>Login to Fotam Below:</h3>
                <button onclick = "window.location.href = 'flashfoto/fotam-auth/fotam-test.php'">Login</button>
            </div>
        </div>
        <p class = "text-center">Q: Why do I need to do this?</p>
        <p class = "text-center">A: When you login with your Fotam account, you'll have access a full suite of personalized photo experiences. By logging in, you're ensuring you get to see the most relevant content.</p>
    </div>
</div>

<?php include_once "includes/footer.php"; ?>
</body>
</html>