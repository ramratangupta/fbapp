<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class socialSharing {

    /**
     * Genrate like button with share button.
     * @param $dataURL defult is fbPage constant defiend in define.php otherwise give any other URL
     * @param $dataLayout standard,box_count, button_count, button, default is standard
     * @param $dataShare include share button to default is false
     * @link https://developers.facebook.com/docs/plugins/like-button/
     * @return string return HTML 5 of like button
     */
    public static function getFBLikeSharePlugin($dataURL = AppConfig::appTabLink, $dataLayout = "button_count", $dataShare = true) {

        $str = <<<EOL
                <div class="fb-like" data-href="$dataURL" data-layout="$dataLayout" data-action="like" data-show-faces="false" data-share="$dataShare"></div>
EOL;
        return $str;
    }

    /**
     * get meta og tag and twitter card for website
     * @param type $title
     * @param type $url
     * @param type $image
     * @param type $description
     * @param type $offcialTwitterHandle
     * @link https://dev.twitter.com/docs/cards/validation/validator add new domain to twitter card validation for twitter card to be live
     */
    public static function getFB_Twitter_Meta_Tag($title, $url, $image, $description, $offcialTwitterHandle) {
        echo <<<EOL
        <meta property="og:type" content="website" />
        <meta name="twitter:card" content="summary_large_image"/>
        <meta name="description" content="$description"/>
        <meta name="twitter:description" content="$description"/>
        <meta property="og:description" content="$description" />
        <meta property="og:title" content="$title" />
        <meta name="twitter:title" content="$title"/>        
        <meta property="og:url" content="$url" />
        <meta property="twitter:url" content="$url" />
        <meta property="og:image" content="$image" />
        <meta name="twitter:site" content="$offcialTwitterHandle"/>       
        
EOL;
    }

}
