<?php
    require_once("../functions.php");

    $P_UID  = $_POST["uid"];
    $P_DATE = $_POST["date"];

    if (
        (isset($P_UID)  && !empty($P_UID)) &&
        (isset($P_DATE) && !empty($P_DATE))
    ) {
        echo json_encode(Array(
            "num_of_booking" => countNewBooking($P_UID) ,
            "pickup_today" => countBookDate($P_UID,"pickup_date",$P_DATE),
            "return_today" => countBookDate($P_UID,"return_date",$P_DATE),
            "alarming" => countAlarm($P_UID,$P_DATE),
            "car_status" => carStatus($P_UID),
            // 5 for last 5 months
            "mprofit" => getMonthlyProfit($P_UID,5,$P_DATE),
        ));
    }
    else {
        header("location: ./");
    }

?>