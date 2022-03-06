<?php
    require_once("../config.php");
    // uses custom status code
    /*
        69 := success
        70 := update fail
    */

    $P_UID = $_POST["uid"];
    $P_BID = $_POST["bid"];
    $P_BSTATUS = $_POST["bstatus"];

    if (
        (isset($P_UID) && !empty($P_UID)) &&
        (isset($P_BSTATUS) && !empty($P_BSTATUS))
    ) {

        $stmnt = "UPDATE booking SET bsid = $P_BSTATUS WHERE bid = $P_BID;";
        
        $query = $CONN->query($stmnt);
        
        if (!$query) {
            echo json_encode(Array(
                "statusCode" => 70,
                "message" => "update fail!"
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