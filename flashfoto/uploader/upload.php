<?php include_once("flashfoto/config.php");?>
<script type = "text/javascript">
    window.api_base_url = "<?php echo $api_base_url;?>";
</script>
<script type = "text/javascript" src = "flashfoto/js/jquery-2.1.1.min.js"></script>
<script type = "text/javascript" src = "flashfoto/uploader/js/Upload.js"></script>

<div id = "uploadSuccessContainer"></div>
<form id = "uploadPhoto">
    <input type = "file" class = "hiddenButton" onchange = "displayUpload(this);" id = "fileInput" accept = "image/*" />
    <div class = "pseudoButton" id = "takePhoto">Choose Photo</div>
    <div id = "imgPreviewWrapper">
        <div id = "uploadLoading" class = "loading text-center">
            <h5>[ Uploading ]</h5>
            <div class = "gearOne spinner reverseSpinner"></div>
            <div class = "gearTwo spinner"></div>
            <div class = "gearThree spinner reverseSpinner"></div>
        </div>
        <img id = "imgPreview" src = ""/>
    </div>

    <!--input type = "submit" value = "Upload!"/-->
    <button class = "cancelForm">Cancel</button>
</form>