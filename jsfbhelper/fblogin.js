
/**
 * user_login_type asign F (facebook) or M [Microsite]<br>
 * @param redirectPages provide start page without php extenstion
 * @param user_login_type (in case of M this code will assign M or W (Wapsite by detecting mobile site)
 * @param extraparam ,seprated extra permission value other tehn <br>
 *  email,user_likes
 */
function fbLogin(redirectPages, user_login_type, extraparam) {
    var extrparam = '';
    if (extraparam !== undefined)
        extrparam = "," + extraparam;
    var access_token = '';
    var expiresIn = '';
    FB.getLoginStatus(function(response) {
        if (response.status === 'connected') {
            access_token = response.authResponse.accessToken;
            expiresIn = response.authResponse.expiresIn;
            myData(redirectPages, user_login_type, extraparam, access_token, expiresIn);
        } else {
            // the user isn't logged in to Facebook.
            FB.login(function(response) {
                if (response.authResponse) {
                    access_token = response.authResponse.accessToken;
                    expiresIn = response.authResponse.expiresIn;
                    myData(redirectPages, user_login_type, extraparam, access_token, expiresIn)
                } else {

                    ga('send', 'event', 'Facebook Login', 'Cancel', 'User Cancel The Login Box', '', {'nonInteraction': 1});
                    showErrorPop('Please authorize this application to participate!');
                }
            }, {scope: 'email' + extrparam});
        }
    });
}
function myData(redirectPages, user_login_type, extraparam, access_token, expiresIn) {
    FB.api('/me', {fields: 'name,email,location,gender,birthday'}, function(info) {
        if (typeof (info.error) !== 'undefined') {
            showErrorPop('Something wrong with facebook, please try again!');
            ga('send', 'event', 'Facebook Login', 'Error', 'Something wrong with facebook', '', {'nonInteraction': 1});
            fbLogin(redirectPages, user_login_type, extraparam);
        } else {
            showErrorPop('Please wait...');
            $('#errorclose').css("display", "none");
            ga('send', 'event', 'Facebook Login', 'Success', 'Click to Start', '', {'nonInteraction': 1});
            var user_type = user_login_type;
            if (user_login_type === "M") {
                if (navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/BlackBerry/i) || navigator.userAgent.match(/Windows Phone/i))
                {
                    user_type = 'W';//Wap site
                }
            }
            $.ajax({url: "./ajax/fbusersave.php?access_token=" + access_token + "&user_type=" + user_type + "&expiresIn=" + expiresIn, type: "POST", data: info}).done(function(data) {
                if (data === "done") {
                    hideErrorPop();
                    location.href = redirectPages + '.php';
                }
            });
        }
    });
}