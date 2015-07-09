<?php

include_once("flashfoto/config.php");
include_once("includes/session.php");
include_once("includes/partner_config.php");

if(!isset($_SESSION["email"])){
    header("Location: login.php");
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Fotam</title>
    <?php include_once("includes/meta.php");?>
    <?php include_once("includes/resources.php"); ?>
    <?php //include_once("includes/cookies.php"); ?>

</head>
<body>
<?php include_once("includes/nav.php");?>
<div id = "wrap">
    <div class = "container text-center">
        <h2 class = "text-center">Choose a Partner:</h2>
        <?php
        $partners = new PartnerConfig();
        $partners->get_partner_info("all");
        $partners->print_partner_blocks();

        // TODO: When a user selects a partner, give this session variable a $chosen_partner property.
        $_SESSION["partners"] = $partners;
        ?>
    </div>
</div>

<?php include_once "includes/footer.php"; ?>
</body>
</html>