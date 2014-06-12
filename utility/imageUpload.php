<?php

class imageUpload {

    /**
     * Upload file and store in AppConfig::UPLOAD_DIR/AppConfig::ORIGINAL_FILE_PATH where AppConfig::ORIGINAL_FILE_PATH  and  AppConfig::UPLOAD_DIR is defiend in define.php
     * @param string $fileName HTML element name
     * @param int $maxfilesize in MB default is 4MB
     * @param array $allowedExts array of allowedExts without . like array("jpg", "png", "jpeg", "gif")
     * @param array $allowedType array allowed mime type like array("image/jpeg", "image/x-png", "image/png", "image/x-pjpeg", "image/pjpeg", "image/jpg", "image/gif")
     * @link http://reference.sitepoint.com/html/mime-types-full
     * @link http://www.php.net/manual/en/features.file-upload.errors.php description
     * @return array check with array index status if it is blank then access filename index. <br>
     * filename format  /<YYYY>/<MMM>/social_user_id_timestame.extension <br>
     * where YYYY is year in 4 digit, MMM is JAN, FEB .. for example /2014/JAN/1111_2132131232.jpg
     * @author Ramratan Gupta <ramratan.gupta@gmail.com>
     */
    public static function fileUpload($fileName, $maxfilesize = 4, $allowedExts = array("jpg", "png", "jpeg", "gif"), $allowedType = array("image/jpeg", "image/x-png", "image/png", "image/x-pjpeg", "image/pjpeg", "image/jpg", "image/gif")) {

        $extension = substr(strrchr($_FILES[$fileName]["name"], '.'), 1);
        $temp_file_name = (isset($_SESSION['User']['social_user_id']) ? $_SESSION['User']['social_user_id'] : "ns") . "_" . time() . "." . $extension;
        $successMsg = "";
        $retArray = array();
        //Check for server error 
        if ($_FILES[$fileName]["error"] > 0) {
            /*
             * if error code is 1, The uploaded file exceeds the upload_max_filesize directive in php.ini.
             * Error code http://www.php.net/manual/en/features.file-upload.errors.php
             */
            $successMsg .= "Server Error";
        } else if (in_array($_FILES[$fileName]["type"], $allowedType) && in_array(strtolower($extension), $allowedExts)) {
            if (($_FILES[$fileName]["size"]) > ($maxfilesize * 1048576)) {
                $successMsg .= "File size exeeds {$maxfilesize} MB";
            } else {

                $uploaddir = AppConfig::UPLOAD_DIR . "/" . AppConfig::ORIGINAL_FILE_PATH;
                if (file_exists($uploaddir . "/" . $temp_file_name)) {
                    $temp_file_name = rand() . $temp_file_name;
                }
                move_uploaded_file($_FILES[$fileName]["tmp_name"], $uploaddir . "/" . $temp_file_name);
                $retArray['filename'] = $temp_file_name;
            }
        } else {
            $successMsg .= 'Not a valid file';
        }
        $retArray['status'] = $successMsg;
        return $retArray;
    }

    /**
     * Create a thumb Image with proper aspect ratio with background color provided, <br>
     * under the folder AppConfig::UPLOAD_DIR/$targetfolderName where $targetfolderName is fifth argument. <br>
     * AppConfig::UPLOAD_DIR is defiend in define.php. default value is thumb
     * @param string $targetThumbFileName file name for target <br>
     *  in our case pass /<YYYY>/<MMM>/social_user_id_timestame.extension which is store in DB
     * @param string $sourceImageURL it can be local relative file system file or <br>
     * full URL with HTTP like image URL from returnd facebook 
     * @param int $width Thumb file width
     * @param int $height Thumb file height
     * @param string $targetfolderName a thumb folder name under folder AppConfig::UPLOAD_DIR
     * @param int $r Red component in RGB color scheme default is 255
     * @param int $g Green component in RGB color scheme default is 255
     * @param int $b Blue component in RGB color scheme default is 255.<br>
     * Overall background color is Black, RGB color code is needed for background fill color 
     * @return string created
     */
    public static function createImageByURL($targetThumbFileName, $sourceImageURL, $width, $height, $targetfolderName = "thumb", $r = 255, $g = 255, $b = 255) {

        $orgwidth = $width;
        $orgheight = $height;
        list($widthPic, $heightPic) = getimagesize($sourceImageURL);
        
        $source_aspect_ratio = $widthPic / $heightPic;
        $thumbnail_aspect_ratio = $width / $height;

        if ($widthPic <= $width && $heightPic <= $height) {
            $width = $widthPic;
            $height = $heightPic;
        } elseif ($thumbnail_aspect_ratio > $source_aspect_ratio) {
            $width = (int) ($height * $source_aspect_ratio);
        } else {
            $height = (int) ($width / $source_aspect_ratio);
        }

        $im1 = @imagecreatefromjpeg($sourceImageURL);

        $func = 'jpg';
        if ($im1 == false) {
            $im1 = @imagecreatefromgif($sourceImageURL);
            $func = 'gif';
        }
        if ($im1 == false) {
            $im1 = @imagecreatefrompng($sourceImageURL);
            $func = 'png';
        }
        var_dump($im1);
        $backLayerforImage = imagecreatetruecolor($width, $height);

        $backgroundColor = imagecolorallocate($backLayerforImage, $r, $g, $b);
        imagefill($backLayerforImage, 0, 0, $backgroundColor);
        //imagecolortransparent($backLayerforImage, $backgroundColor);

        imagecopyresampled($backLayerforImage, $im1, 0, 0, 0, 0, $width, $height, $widthPic, $heightPic);
        $image_backlayer = imagecreatetruecolor($orgwidth, $orgheight);
        $backgroundColor = imagecolorallocate($image_backlayer, $r, $g, $b);
        //imagecolortransparent($image_backlayer, $backgroundColor);
        imagefill($image_backlayer, 0, 0, $backgroundColor);
        if ($width < $orgwidth || $height < $orgheight) {

            imagecopy($image_backlayer, $backLayerforImage, (($orgwidth - $width) / 2), (($orgheight - $height) / 2), 0, 0, $width, $height);
        } else {
            imagecopy($image_backlayer, $backLayerforImage, 0, 0, 0, 0, $widthPic, $height);
        }

        $thumbFileNameFinal = AppConfig::UPLOAD_DIR . "/" . $targetfolderName . "/" . $targetThumbFileName;
        switch ($func) {
            case 'jpg':
                imagejpeg($image_backlayer, $thumbFileNameFinal);
                break;
            case 'gif':
                imagegif($image_backlayer, $thumbFileNameFinal);
                break;
            case 'png':
                imagepng($image_backlayer, $thumbFileNameFinal);
                break;
        }

        imagedestroy($image_backlayer);
        imagedestroy($backLayerforImage);
        imagedestroy($im1);
        return 'created';
    }

}
