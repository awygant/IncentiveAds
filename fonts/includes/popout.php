<div id = "popoutWrapper"><div id = "popoutLightbox" class = "text-center"><div id = "popoutInnerWrapper"></div></div></div>

<script type = "text/javascript">
    $(document).ready(function(){
        popoutLightboxWrapper = $("#popoutWrapper");
        popoutLightbox = $("#popoutLightbox");
        popoutInnerWrapper = $("#popoutInnerWrapper");
        popoutLightboxWrapper.click(function(){
            closeLightbox();
        });
        $(".popout").click(function(){
            if(popoutLightbox.is(":visible")){
                closeLightbox();
            }
            else{
                openLightbox($(this).clone());
            }
        });
        function closeLightbox(){
            popoutInnerWrapper.html("");
            popoutLightboxWrapper.fadeOut();
        }
        function openLightbox(content){
            var caption = "";
            if($(content).data("caption")){
                caption = "<p>" + $(content).data("caption") + "</p><p class = 'small'>Tap anywhere to close.</p>";
            }
            popoutInnerWrapper.html(content);
            popoutInnerWrapper.append(caption);
            popoutLightboxWrapper.fadeIn();
        }
    });
</script>