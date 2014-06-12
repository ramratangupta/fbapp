<script type="text/javascript">

    function fbshare(msg, page, url, img)
    {
        FB.ui({
            method: 'feed',
            name: '‪<?php AppConfig::appName ?>',
            link: url,
            picture: img,
            description: msg
        },
        function(response) {
            var status = '';
            if (response && response.post_id) {
                status = "Yes";
            } else {
                status = "No";
            }
            ga('send', 'event', 'Share', "Facebook ", status, page, {'nonInteraction': 1});
        });
    }
    function twittershare(msg, page, url)
    {
        var urls = "http://twitter.com/intent/tweet?text=" + encodeURIComponent(msg) + "&url=" + url;
        window.open(urls, 'mywindow', 'width=500,height=300');
        ga('send', 'event', 'Share', "Twitter", 'Yes', page, {'nonInteraction': 1});
    }
    function fbinvite(page) {
        FB.ui({method: 'apprequests',
            message: 'I invited you to use this app',
            filters: ['app_non_users'],
            title: '<?php AppConfig::appName ?>'
        }, function(response) {
            var status = '';
            if (response && response.hasOwnProperty('to')) {
                status = "Yes";//save the data
                $.ajax({url: "ajax/invite.php", type: "post", data: {tofriends: response.to}}).done(function(d) {
                    //console.log(d);
                });
            } else {
                status = "No";
            }
            ga('send', 'event', 'Invite', "Facebook", status, page, {'nonInteraction': 1});

        });
        return;
    }
    function autopost(msg, page, url, img) {
        var publish_action_status = '';
        var status = '';
        FB.login(function(response1) {
            if (response1.authResponse) {
                FB.api('/me/permissions', function(info) {
                    for (var i = 0; i < info.data.length; i++) {

                        if ($.trim(info.data[i].permission) === "publish_actions") {
                            publish_action_status = info.data[i].status;
                            break;
                        }
                    }
                    if (publish_action_status === 'granted') {

                        var body = '';
                        FB.api('/me/feed', 'post', {
                            body: body,name: '‪<?php AppConfig::appName ?>',
                            message: msg,
                            link: url,
                            picture: img}, function(response) {
                            if (!response || response.error) {
                                status = 'No';
                            } else {
                                status = 'Yes';
                            }
                        });

                    } else {
                        status = "Permission Skip";
                        showErrorPop("Please authoriz the app for auto post");
                    }
                });
            } else {
                showErrorPop('Please authorize this application to participate!');
            }
        }, {scope: 'publish_actions'});
        ga('send', 'event', 'Share', "Facebook Auto Post", status, page, {'nonInteraction': 1});
    }
</script>