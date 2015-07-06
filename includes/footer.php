

<div id="footer">
    <p class = "text-center">
        <?php if(isset($_SESSION["email"])){
            echo '<button class = "small inverted" onclick = "window.location.href = \'index.php\'">START OVER</button>
                    <button class = "small inverted" onclick = "window.location.href = \'' . $GLOBALS["fotam_logout_url"] . '\'">LOGOUT</button>';
        }
        ?>

    </p>
    <div class="container">
        <div class = "row">
            <div class = "col-md-3 col-sm-6 col-xs-6">
                <h5>Flashfoto, Inc.</h5>
                <a href = "http://www.flashfotoinc.com/tech.php" target = "_blank">Tech & Patents</a><br/>
                <a href = "http://www.flashfotoinc.com/contact.php" target = "_blank">Contact Us</a><br/>
                <a href = "http://www.flashfotoinc.com/careers.php" target = "_blank">Careers</a>
            </div>
            <div class = "col-md-3 col-sm-6 col-xs-6">
                <h5>Products</h5>
                <a href = "http://www.flashfotoinc.com/fotam.php" target = "_blank">Fotam</a><br/>
                <a href = "http://www.flashfotoinc.com/fotamads.php" target = "_blank">Fotam Ads</a><br/>
                <a href = "http://www.flashfotoinc.com/backgroundremoval.php" target = "_blank">Background Removal</a><br/>
                <a href = "http://www.yourpicturewith.com" target = "_blank">YourPictureWith.com</a>
            </div>
            <div class="clearfix visible-xs visible-sm"></div>
            <div class = "col-md-3 col-sm-6 col-xs-6">
                <h5>Our Sites</h5>
                <a href = "http://www.backgroundremoval.com/" target = "_blank">Background Removal</a><br/>
                <a href = "http://www.freebackgroundremoval.com/" target = "_blank">Free Background Removal</a><br/>
                <a href = "http://www.yourpicturewith.com/" target = "_blank">Your Picture With</a><br/>
                <a href = "http://www.fotam.com/" target = "_blank">Fotam</a>
                <p></p>
                <a href = "http://www.facebook.com/FlashFotoInc" target = "_blank">Facebook</a><br/>
                <a href = "http://www.twitter.com/FlashFotoInc" target = "_blank">Twitter</a>
            </div>
            <div class = "col-md-3 col-sm-6 col-xs-6">
                <h5>Solutions</h5>
                <a href = "http://www.flashfotoinc.com/automotive.php" target = "_blank">Automotive</a><br/>
                <a href = "http://www.flashfotoinc.com/entertainment.php" target = "_blank">Entertainment</a>
            </div>
        </div>
        <p class = "text-muted text-center">&copy; Flashfoto, Inc. 2015 | <a href = "http://www.flashfotoinc.com/legal.php" target="_blank">Legal</a></p>
    </div>
</div>