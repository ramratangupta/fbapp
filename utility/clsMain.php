<?php

class clsMain {

    static function GetCurrentDate() {
        date_default_timezone_set("UTC");
        return gmdate("Y-m-d", time() + 19800);  //india time format(GMT +5.5)
    }

    static function GetCurrentDateTime() {
        date_default_timezone_set("UTC");
        return gmdate("Y-m-d H:i:s", time() + 19800);  //india time format(GMT +5.5)
    }

    /**
     * echo the date in format Tue, 06-Nov-2012
     */
    static function formatedateIndian($date) {//YYYY-MM-DD
        return date('D, d-M-Y', strtotime($date)); //Tue, 06-Nov-2012 
    }

    /**
     * echo the date in format 12:30:59 AM - Tue, 06-Nov-2012
     */
    static function formatedDate_TimeIndian($date) {//YYYY-MM-DD hh:mm:ss
        return date('h:i:s A - D, d-M-Y', strtotime($date)); // 12:30 AM - Tue, 06-Nov-2012
    }

    /**
     * Call this function to echo FB init
     */
    public static function getFBRoot($canvasAutoGrow = true) {

        echo '<div id="fb-root"></div><script>
      window.fbAsyncInit = function() {
        FB.init({
          appId      : "' . AppConfig::appid . '",
          xfbml      : true,
          status : true, // check login status
          cookie : true, // enable cookies to allow the server to access the session
          version    : "v2.0"
        });';
        if ($canvasAutoGrow) {
            echo 'FB.Canvas.setAutoGrow(100);';
        }
        echo '};
      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/en_US/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, \'script\', \'facebook-jssdk\'));</script>';
    }

    /**
     * Call this function to echo GA
     */
    public static function getGACode() {
        echo "<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '" . AppConfig::GA_CODE . "', '" . AppConfig::domain . "');
  ga('send', 'pageview');
</script>";
    }

    /**
     * Call this function to echo GA code and FB init
     */
    public static function getGA_FBROOT() {

        clsMain::getFBRoot();
        clsMain::getGACode();
    }

    /**
     * Short long url to bitly short URL <br>
     * You need to first intialize inside the funtion $api_user and $api_key from URL<br>
     * get your keys api_user and api_key : 
     * @link https://bitly.com/a/your_api_key
     */
    public static function bitly_short_url($longurl) {

        //https://bitly.com/a/your_api_key get your keys api_user and api_key
        $url = strip_tags($longurl);
        //send it to the bitly shorten webservice
        $ch = curl_init("http://api.bitly.com/v3/shorten?login=" . AppConfig::BITLY_API_USER . "&apiKey=" . AppConfig::BITLY_API_KEY . "&longUrl=$url&format=json");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //the response is a JSON object, send it to your webpage
        $json = curl_exec($ch);
        $url = json_decode($json, true);
        var_dump($url);
        return $url['data']['url'];
    }

    /**
     * include the Google Hosted Libraries for Jquery
     * @param string $version 2.0.3, 2.0.2, 2.0.1, 2.0.0, 1.10.2, 1.10.1, 1.10.0, 1.9.1, <br>
     * 1.9.0, 1.8.3, 1.8.2, 1.8.1, 1.8.0, 1.7.2, 1.7.1, 1.7.0
     * @return string script tag
     * @link https://developers.google.com/speed/libraries/devguide#jquery
     */
    public static function include_online_jquery($version = '1.8.2') {
        echo '<script src="//ajax.googleapis.com/ajax/libs/jquery/' . $version . '/jquery.min.js"></script>';
    }

    public static function include_fancybox() {
        echo '<script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" />';
    }

}
