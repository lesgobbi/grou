<?php

    require('../../../_app/Config.inc.php');
    // Allowed extentions.
    $allowedExts = array("txt", "pdf", "doc");

    // Get filename.
    $temp = explode(".", $_FILES["file"]["name"]);

    // Get extension.
    $extension = end($temp);

    // Validate uploaded files.
    // Do not use $_FILES["file"]["type"] as it can be easily forged.
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES["file"]["tmp_name"]);

    if ((($mime == "text/plain")
    || ($mime == "application/msword")
    || ($mime == "application/x-pdf")
    || ($mime == "application/pdf"))
    && in_array(strtolower($extension), $allowedExts)) {
        // Generate new random name.
        $name = sha1(microtime()) . "." . $extension;

        // Save file in the uploads folder.
//        move_uploaded_file($_FILES["file"]["tmp_name"], getcwd() . "/uploads/" . $name);
        move_uploaded_file($_FILES["file"]["tmp_name"], "../../../uploads/" . $name);

        // Generate response.
        $response = new StdClass;
        $response->link = HOME . "/uploads/" . $name;
        echo stripslashes(json_encode($response));
    }
?>