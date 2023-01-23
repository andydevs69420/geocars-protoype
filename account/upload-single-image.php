<?php
    require_once("../config.php");

    // uses custom status code
    /*
        69 := success
        70 := upload failed
        71 := update failed
    */

    $location = "../uploads/";

    $uid = $_POST["uid"];
    $col = $_POST["col"];
    $cpic_id = $_POST["cpic_id"];
    $fileimg = $_FILES["image"];


    if (
        (isset($uid) && !empty($uid)) &&
        (isset($col) && !empty($col)) &&
        (isset($cpic_id) && !empty($cpic_id)) &&
        (isset($fileimg) && !empty($fileimg))
    ) {
        $folderpath = $location.$uid."/company_pic/";
        $fullpath   = $folderpath.$fileimg["name"];


        if (!file_exists($folderpath))
            mkdir($folderpath,0777,true);

        if (
            ! move_uploaded_file(
                $fileimg["tmp_name"] ,
                $fullpath
            )
        ) {
            echo json_encode(Array(
                "statusCode" => 70 ,
                "message" => "upload failed!"
            ));
        }
        else {
            $fullpath = substr($fullpath,3,strlen($fullpath)-1);
            $imgpath  = $UPLOAD_ONLINEPATH.$fullpath;
            $stmnt    = "UPDATE company_pic SET $col = '$imgpath' WHERE cpic_id = $cpic_id;";
            $update   = $CONN->query($stmnt);
            if ($CONN->error) {
                echo json_encode(Array(
                    "statusCode" => 71 ,
                    "message" => "update error!"
                ));
            } 
            else {
                echo json_encode(Array(
                    "statusCode" => 69 ,
                    "message" => "success!" ,
                    "data" => $imgpath
                ));
            }
        }
    }
    else {
        header("location: ./");
    }

?>



