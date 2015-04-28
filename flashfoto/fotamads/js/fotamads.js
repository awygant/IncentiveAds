adsStatus = "Starting...";
unitsCompleted = 0;
unitsTotal = 3;

function segmentation(ffid){

    var dfd = $.Deferred();

    var formdata = new FormData();
    formdata.append("ffid", ffid);

    $.ajax({
        url: "flashfoto/fotamads/segmentation.php",
        type: "POST",
        data: formdata,
        processData: false,
        contentType: false,
        tryCount: 0,
        retryLimit: 3,
        success: function (res){
            dfd.resolve(res);
        },
        error: function(request, textStatus, errorThrown){
            console.log('ERROR on request', request.responseText);
            console.log('text', textStatus);
            console.log('error', errorThrown);
            if (errorThrown == 'Internal Server Error') {
                this.tryCount++;
                if (this.tryCount <= this.retryLimit) {
                    $.ajax(this);
                }
                adsStatus = "Sorry, we seem to be having problems at the moment. Please try again later!";
            }
            if (errorThrown == 'timeout') {
                adsStatus = "Sorry, the application timed out. You need a better connection!";
            }
            if(errorThrown == "Segmentation Failed."){
                console.log("Segmentation Failed.");
            }
            else{
                adsStatus = "Sorry, an error occurred. Please refresh and try again!";
            }
            dfd.reject();
        },
        timeout: 300000
    });

    return dfd.promise();
}


function buildAds(ffid, partner){
    var dfd = $.Deferred();

    if(!ffid || ffid <= 0 || ffid.length <=0){
        return "FFID " + ffid + " not accepted.";
    }

    adsStatus = "Extracting face and hair...";
    unitsCompleted++;
    $.when(segmentation(ffid)).done(function(segmentationData){
        if(segmentationData.length > 0 && segmentationData!=-1){
            unitsCompleted++;
            adsStatus = "Building cool photos with your selfie...";
            var formdata = new FormData();
            formdata.append("ffid", ffid);
            formdata.append("headData", segmentationData);
            formdata.append("partner", partner);
            formdata.append("gender", "both"); // TODO: Get user's FB info and change this.

            $.ajax({
               url: "flashfoto/fotamads/merge.php",
                type: "POST",
                data: formdata,
                processData: false,
                contentType: false,
                tryCount:0,
                retryLimit: 3,
                success:function(res){
                    unitsCompleted++;
                    adsStatus = "Finished!";
                    dfd.resolve(res);
                },
                error: function(request, textStatus, errorThrown){
                    console.log('ERROR on request', request.responseText);
                    console.log('text', textStatus);
                    console.log('error', errorThrown);
                    if (errorThrown == 'Internal Server Error') {
                        this.tryCount++;
                        if (this.tryCount <= this.retryLimit) {
                            $.ajax(this);
                        }
                        adsStatus = "Sorry, we seem to be having problems at the moment. Please try again later!";
                    }
                    if (errorThrown == 'timeout') {
                        adsStatus = "Sorry, the application timed out. You need a better connection!";
                    }
                    else{
                        adsStatus = "Sorry, an error occurred. Please refresh and try again!";
                    }
                    dfd.reject();
                },
                timeout: 900000
            });

        }
    });

    return dfd.promise();
}



 function createFacebookAds(scenePayload){
 console.log("creating ads");
 var formdata = new FormData();
 formdata.append("scenePayload", scenePayload);
     $.ajax({
         url: "flashfoto/fotamads/createFacebookAds.php",
         type: "POST",
         data: formdata,
         processData: false,
         contentType: false,
         success:function(res){
             console.log("YAY: ", res);
         },
         error: function(request, textStatus, errorThrown){
             console.log('ERROR on request', request.responseText);
             console.log('text', textStatus);
             console.log('error', errorThrown);
             if (errorThrown == 'Internal Server Error') {
                 this.tryCount++;
                 if (this.tryCount <= this.retryLimit) {
                     $.ajax(this);
                 }
             }
             if (errorThrown == 'timeout') {
             }
             else{
             }
         },
         timeout: 1
     });
 }

function getAdsStatus(){
    return adsStatus;
}

function getPercentDone(){
    if(unitsCompleted > unitsTotal)
        return 100;
    if(unitsCompleted > 0 && unitsTotal > 0)
        return unitsCompleted/unitsTotal * 100;
    else
        return 0;
}