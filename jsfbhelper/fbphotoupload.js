
function fbphotoupload(msg, img, page) {
    var status = '';
    var publish_action_status = '';
    FB.login(function(response1) {
        if (response1.authResponse) {
            FB.api('/me/permissions', function(info) {
                for (var i = 0; i < info.data.length; i++) {

                    if ($.trim(info.data[i].permission) === "user_photos") {
                        publish_action_status = info.data[i].status;
                        break;
                    }
                }
                if (publish_action_status === 'granted') {
                    $.ajax({url: './ajax/uploadonfbimage.php', type: "POST", data: {imagecopy: msg, fb_upload_img_path: img}}).done(function(data) {
                        console.log(data);
                        if (data === "done") {
                            showErrorPop("Photo has been uploaded");
                        }
                    });
                } else {
                    status = "Permission Skip";
                    showErrorPop("Please authoriz the app for Photo Upload");
                }
            });
        } else {
            showErrorPop('Please authorize this application to participate!');
        }
    }, {scope: 'user_photos'});
    ga('send', 'event', 'Share', "Facebook Photo Upload", status, page, {'nonInteraction': 1});
}