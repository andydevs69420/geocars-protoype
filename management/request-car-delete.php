<?php
    require_once("../config.php");

    // uses custom status code
    /*
        69 := success
        70 := delete fail
    */ 

    $P_CARID = $_POST["carid"];

    if (
        (isset($P_CARID) && !empty($P_CARID))
    ) {
        $stmnt = "DELETE FROM company_car_details WHERE carid = $P_CARID;";
        $del   = $CONN->query($stmnt);
        if (!$del) {
            echo json_encode(Array(
                "statusCode" => 70,
                "message" => "delete fail!"
            ));
        }
        else {
            echo json_encode(Array(
                "statusCode" => 69,
                "message" => "success!"
            ));
        }
    }
    else {
        header("location: ./");
    }

?>