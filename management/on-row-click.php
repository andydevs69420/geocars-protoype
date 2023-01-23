
<?php
    require_once("../functions.php");

    $P_UID   = $_POST["uid"];
    $P_CARID = $_POST["carid"];

    if ((isset($P_CARID) && !empty($P_CARID))) {
        echo json_encode(Array(
            "statusCode" => 69 ,
            "message" => "success!",
            "data" => company_car_details($P_UID,$P_CARID)
        ));
    }
    else {
        header("location: ./");
    }

?>
