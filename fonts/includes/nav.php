<nav class="navbar navbar-flash" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle navbar-toggle-flash" data-toggle="collapse"
                data-target="#example-navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar icon-bar-flash"></span>
            <span class="icon-bar icon-bar-flash"></span>
            <span class="icon-bar icon-bar-flash"></span>
        </button>
        <a class="navbar-brand text-uppercase" href="index.php">FOTAM</a>
    </div>
    <div class="collapse navbar-collapse navbar-right" id="example-navbar-collapse">
        <ul class="nav navbar-nav">
            <li><a href = "index.php">Home</a></li>
            <?php if(isset($_SESSION["email"])){
                echo '<li><a href = "' . $GLOBALS["fotam_logout_url"] . '">Logout</a></li>';
                //echo '<li><a href = "logout.php">Logout</a></li>';
            }
            ?>
            <li><a href = "about.php">About</a></li>
        </ul>
    </div>
</nav>