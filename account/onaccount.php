<?php
    require_once("../functions.php");

    // uses custom status code
    /*
        69 := success
        70 := no record found
    */

    $P_UID = $_POST["uid"];

    if (isset( $P_UID) && !empty($P_UID)) {

        echo company_plan_details($P_UID);
    }
    else {

        header("locaton: ./");

    }
?>