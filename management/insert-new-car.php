
<?php
    require_once("../config.php");
    require_once("../functions.php");

    // uses custom status code
    /*
        69 := success
        70 := insert error
        71 := maximum no. of car reached
        72 := invalid credential
    */

    $location = "../uploads/";

    $P_UID    = $_POST["uid"];
    $P_BRAND  = $_POST["brand"];
    $P_MODEL  = $_POST["model"];
    $P_PLATE  = $_POST["plate"];
    $P_RATE   = $_POST["rate"];

    if (
        (isset($P_UID)   && !empty($P_UID))   &&
        (isset($P_BRAND) && !empty($P_BRAND)) &&
        (isset($P_MODEL) && !empty($P_MODEL)) &&
        (isset($P_PLATE) && !empty($P_PLATE)) &&
        (isset($P_RATE)  && !empty($P_RATE))
    ) {
        $res_map = json_decode(company_plan_details($P_UID),true);
        
        if ($res_map["statusCode"] != 69) {
            // error
            die(json_encode(Array(
                "statusCode" => 72 ,
                "message" => "invalid credential!"
            )));
        }


        $cpland_id = $res_map["data"]["cpland_id"];

        $num_of_cars = $res_map["data"]["num_of_cars"];

        $user_car = count(getAllCars($P_UID));

        if (($user_car + 1) > $num_of_cars) {
            // error
            die(json_encode(Array(
                "statusCode" => 71 ,
                "message" => "maximum no. of car reached!"
            )));
        }
        // insert car
        $stmnt1 = "INSERT INTO car(brand,model,plateno,rate_per_day) 
                   VALUES ('$P_BRAND','$P_MODEL','$P_PLATE','$P_RATE');
                  ";

        $res1 = $CONN->query($stmnt1);
        if (!$res1) {
            // error
            echo json_encode(Array(
                "statusCode" => 70 ,
                "message" => "insert error!"
            ));
        }
        else {

            $no_problem_at_all = false;
            $carid = $CONN->insert_id;

            for($idx = 0;$idx < 5;$idx++) {
                $file  = $_FILES["image-$idx"];
                $tmp   = $file["tmp_name"];
                $name  = $file["name"];
                $fpath = $location.$P_UID."/cars/".$carid."/";
                if (!file_exists($fpath))
                    mkdir($fpath,0777,true);
                
                if (
                    move_uploaded_file(
                        $tmp,
                        $fpath.$name
                    )
                )
                {
                    $no_problem_at_all = true;
                    $fullpath = $fpath.$name;
                    $fullpath = substr($fullpath,3,strlen($fullpath)-1);

                    $imgpath = $UPLOAD_ONLINEPATH.$fullpath;
                    $istmnt  = "INSERT INTO car_images(carid,image_link) 
                                VALUES ($carid,'$imgpath');
                               ";
                    $ires = $CONN->query($istmnt);
                    if (!$ires) {
                        $no_problem_at_all = false;
                        break;
                    }
                }
                else {
                    $no_problem_at_all = false;
                    break;
                }
            }

            if (!$no_problem_at_all) {
               // error
                echo json_encode(Array(
                    "statusCode" => 70 ,
                    "message" => "insert error!"
                ));
            }
            else {
                $istmnt = "INSERT INTO company_car_details(cpland_id,carid) 
                           VALUES ($cpland_id,$carid);
                          ";
                $insert = $CONN->query($istmnt);
                if (!$insert) {
                    // error
                    echo json_encode(Array(
                        "statusCode" => 70 ,
                        "message" => "insert error!"
                    ));
                }
                else {
                    echo json_encode(Array(
                        "statusCode" => 69 ,
                        "message" => "success!",
                    ));
                }
            }
        }
    }
    else {
        header("location: ./");
    }


?>