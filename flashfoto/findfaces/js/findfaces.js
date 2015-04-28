function findFaces(ffid, callback){
    $.ajax({
        url: "flashfoto/findfaces/findfaces.php?ffid=" + ffid,
        tryCount: 0,
        retryLimit: 3,
        success: function (confidence) {
            callback(ffid, confidence);
        },
        error: function (request, textStatus, errorThrown) {
            console.log('ERROR on request', request.responseText);
            console.log('text', textStatus);
            console.log('error', errorThrown);
            if (errorThrown == 'Internal Server Error') {
                this.tryCount++;
                if (this.tryCount <= this.retryLimit) {
                    $.ajax(this);
                }
                else{
                    callback(ffid, 0, "Sorry, we seem to be having problems at the moment. Please try again later!");
                }
            }
            if (errorThrown == 'timeout') {
                callback(ffid, 0, "Sorry, the application timed out. You need a better connection!")
            }
        },
        timeout: 10000
    });
}
