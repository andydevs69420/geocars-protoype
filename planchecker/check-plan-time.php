

<?php

    include_once("../config.php");
    include_once("../functions.php");

    // uses custom status code
    /*
        69 := valid session
        70 := time exceeded
        71 := sucess timein
        72 := error timein
    */

    $P_UID  = $_POST["uid"];
    $P_DATE = $_POST["date"];
    $P_TIME_DELTA = $_POST["time"];

    if (
        (isset($P_UID)  && !empty($P_UID))  &&
        (isset($P_DATE) && !empty($P_DATE)) &&
        (isset($P_TIME_DELTA) && !empty($P_TIME_DELTA))
    ) {

        $details = json_decode(company_plan_details($P_UID),true)["data"];

        
        $lastlogind = $details["clast_logind"];
        $signintime = $details["csign_time"];

        $ophours = abs($details["operation_hours"]);
    

        if (
            (empty($lastlogind) || $lastlogind == null) ||
            (strcmp($lastlogind,$P_DATE)      != 0      ||
            strcmp($signintime,$P_TIME_DELTA) != 0)
        ) {
            if (
                (empty($lastlogind) || $lastlogind == null) ||
                (strcmp($lastlogind,$P_DATE) != 0)
            ) {

                $stmnt = "UPDATE company SET clast_logind = '$P_DATE' , csign_time = $P_TIME_DELTA WHERE cid = $P_UID;";

                $query = $CONN->query($stmnt);

                if (!$query) {
                    // error timein
                    echo json_encode(Array(
                        "statusCode" => 72,
                        "message" => "error time-in!",
                    ));
                }
                else {
                    echo json_encode(Array(
                        "statusCode" => 71,
                        "message" => "success time-in!",
                    ));
                }
            }
            else {

                // same day session
                $hours = floor(round(abs($signintime - $P_TIME_DELTA) / 36e5));
                
                if ($hours >= $ophours) {
                    // time exceeded!
                    echo json_encode(Array(
                        "statusCode" => 70,
                        "message" => "time exceeded!",
                        "hours" => $hours,
                        "ophours" => $ophours
                    ));
                }
                else {
                    // valid session
                    echo json_encode(Array(
                        "statusCode" => 69,
                        "message" => "valid session!",
                        "hours" => $hours,
                        "ophours" => $ophours
                    ));
                }
            }
        }
        else {
            // valid session
            echo json_encode(Array(
                "statusCode" => 69,
                "message" => "valid session!",
                "hours" => $hours,
                "ophours" => $ophours
            ));
        }
    }
    else {
        header("location: ../signin/");
    }

?>


