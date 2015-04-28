function replaceInterface(msg){
    mainInterface.hide();
    messageInterface.html(msg).show();
}

function restoreInterface(){
    messageInterface.html("").hide();
    mainInterface.show();
}

function cardify(txt){
    return "<div class = \"card\"><div class = \"text-card vertical-center\">" + txt + "</div></div>";
}

function loadingGraphic(msg){
    return "<div class = \"loading text-center vertical-center\">" +
    "<h5>[ " + msg + " ]</h5>" +
    "<div class = \"gearOne spinner reverseSpinner\"></div>" +
    "<div class = \"gearTwo spinner\"></div>" +
    "<div class = \"gearThree spinner reverseSpinner\"></div>" +
    "</div>";
}
