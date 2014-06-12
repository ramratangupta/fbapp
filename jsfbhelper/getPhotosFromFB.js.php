<script>
    function getPhotosFromFB(page) {
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
                        $.fancybox({'transitionIn': 'elastic', 'transitionOut': 'elastic', type: 'iframe', height: 483.0, 'href': './ajax/getPhotosFromFB.php'});
                    } else {
                        status = "Permission Skip";
                        showErrorPop("Please authoriz the app to upload photos from Facebook");
                    }
                });
            } else {
                showErrorPop('Please authorize this application to participate!');
            }
        }, {scope: 'user_photos'});
        ga('send', 'event', 'Upload', "Upload\Get photos from Facebook", status, page, {'nonInteraction': 1});
    }
    function selectPicture(id) {
        $.fancybox.close();

        showErrorPop('Please wait...');
        $.ajax({url: './ajax/getPhotoFromFBpicid.php', type: 'POST', data: {fbpicid: id}}).done(function(data) {
            $("#fbuploadedimg").html('<img src="<?php echo AppConfig::UPLOAD_DIR ?>/thumb/' + data + '"/>');
            hideErrorPop();
        });

    }
</script>