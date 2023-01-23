
<?php
    require_once("../config.php");
    // uses custom status code
    /*
        69 := success
        70 := upload fail
        71 := update fail
    */ 

    $location = "../uploads/";

    $P_UID   = $_POST["uid"];
    $P_CARID = $_POST["carid"];
    $P_BRAND = $_POST["brand"];
    $P_MODEL = $_POST["model"];
    $P_PLATE = $_POST["plate"];
    $P_RATE  = $_POST["rate"];
    $P_IMAGECHANGED = $_POST["hasImageChanged"];
    $P_IMAGESID = $_POST["imagesid"];

    if (
        (isset($P_UID)   && !empty($P_UID))   &&
        (isset($P_CARID) && !empty($P_CARID)) &&
        (isset($P_BRAND) && !empty($P_MODEL)) &&
        (isset($P_MODEL) && !empty($P_MODEL)) &&
        (isset($P_PLATE) && !empty($P_PLATE)) &&
        (isset($P_RATE)  && !empty($P_RATE))  &&
        (isset($P_IMAGECHANGED) && !empty($P_IMAGECHANGED)) &&
        (isset($P_IMAGESID) && !empty($P_IMAGESID))
    ) {



        $stmnt = "UPDATE car SET 
                  brand = '$P_BRAND' , 
                  model = '$P_MODEL' , 
                  plateno = '$P_PLATE' , 
                  rate_per_day = '$P_RATE' 
                  WHERE carid = $P_CARID;
                 ";

        $updateres = $CONN->query($stmnt);

        if (!$updateres) 
            die(json_encode(Array(
                "statusCode" => 71,
                "message" => "update fail!"
            )));

        if ($P_IMAGECHANGED == "true") {
            
            $imagesid = explode(",",$P_IMAGESID);

            foreach($imagesid as $carid) {

                $file  = $_FILES["image-$carid"];
                $fname = $file["name"];
                $tmppath = $file["tmp_name"];

                $fullpath = $location.$P_UID."/cars/".$carid."/";
                if (!file_exists($fullpath))
                    mkdir($fullpath,0777,true);
                
                if (
                    !move_uploaded_file(
                        $tmppath,
                        $fullpath.$fname
                    )
                ){
                    die(json_encode(Array(
                        "statusCode" => 70,
                        "message" => "upload fail!"
                    )));
                }
                else {
                    $fullpath  = substr($fullpath,3,strlen($fullpath)-1);
                    $FOOL_path = $UPLOAD_ONLINEPATH.$fullpath.$fname; // hahahaha
                    $updateimg = "UPDATE car_images SET image_link = '$FOOL_path' WHERE carimg_id = $carid;";
                    
                    $updateimgres = $CONN->query($updateimg);

                    if (!$updateimgres)
                        die(json_encode(Array(
                            "statusCode" => 71,
                            "message" => "update fail!"
                        ))); 
                }
            }
        }
        echo json_encode(Array(
            "statusCode" => 69,
            "message" => "success!"
        ));
    }
    else {
        header("location: ./");
    }

?>