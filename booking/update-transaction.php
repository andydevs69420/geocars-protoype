

<?php
    require_once("../config.php");

    // uses custom status code
    /*
        69 := success
        70 := update fail
    */

    $P_UID  = $_POST["uid"];
    $P_BID  = $_POST["bid"];
    $P_TEND = $_POST["tend"];
    $P_TAMMOUNT = $_POST["tammount"];

    if (
        (isset($P_UID) && !empty($P_UID)) &&
        (isset($P_UID) && !empty($P_UID)) &&
        (isset($P_UID) && !empty($P_UID)) &&
        (isset($P_UID) && !empty($P_UID))
    ) {
        $stmnt = "UPDATE transaction SET tend = '$P_TEND' , tammount = $P_TAMMOUNT , tsid = 2 WHERE bid = $P_BID;";
        
        $updquer = $CONN->query($stmnt);

        if (!$updquer) {
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

