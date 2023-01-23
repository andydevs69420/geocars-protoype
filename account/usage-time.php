

<?php

    require_once("../functions.php");

    $P_UID = $_POST["uid"];
    $P_TIME_DELTA = $_POST["time"];

    if (
        (isset($P_UID) && !empty($P_UID)) &&
        (isset($P_TIME_DELTA) && !empty($P_TIME_DELTA))
    ) {

        $details = json_decode(company_plan_details($P_UID),true)["data"];
        $ophours = $details["operation_hours"];
        $timein  = $details["csign_time"];

        $hours = floor(round(abs($timein - $P_TIME_DELTA) / 36e5));

        $percentage = floor(($hours / $ophours) * 100);

        $percentage = ($percentage > 100)? 100 : $percentage;

        echo json_encode(Array(
            "statusCode" => 69,
            "message" => "success!",
            "data" => $percentage
        ));

    }
    else {
        header("location: ./");
    }

?>

