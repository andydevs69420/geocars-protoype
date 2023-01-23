<?php
    require_once("../functions.php");

    $P_UID   = $_POST["uid"];
    $P_CARID = $_POST["carid"];

    if (
        (isset($P_UID)   && !empty($P_UID)) &&
        (isset($P_CARID) && !empty($P_CARID))
    ) {
        $car = company_car_details($P_UID,$P_CARID);
        echo json_encode($car);
    }
    else {
        header("location: ./");
    }

?>