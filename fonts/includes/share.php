<button onclick = "share()">Share</button>
<div class = "shareOptions">
    <button class = "facebookShare" onclick = "shareToFacebook()">Facebook</button>
    <button class = "twitterShare" onclick = "shareToTwitter()">Twitter</button>
</div>
<!--p class = "text-center">Shared 123 times</p><!-- TODO: Grab reporting data -->

<script type = "text/javascript">
 var login_base_url = "<?php echo $GLOBALS['login_base_url'];?>";
 var base_url = "<?php echo $base_url;?>";
 var ffid = "<?php echo $ffid; ?>";
 function share(){
     var shareBoxes = document.getElementsByClassName("shareOptions");
     for(var i = 0; i < shareBoxes.length; i++){
         shareBoxes[i].style.display = "inline-block";
     }
 }
 function shareToFacebook(){
     window.location.href = login_base_url + "/shares/share?network=Facebook&url=" + base_url + "/view.php?ffid=" + ffid;
 }
 function shareToTwitter(){
     window.location.href = login_base_url + "/shares/share?network=Twitter&url=" + base_url + "/view.php?ffid=" + ffid;
 }
</script>