<?php

    require_once("../config.php");
    
    // uses custom status code
    /*
        69 := success
        70 := invalid user
    */

    $P_EMAIL = $_POST["email"];
    $P_PASS  = $_POST["password"];

    if (
        (isset($P_EMAIL) && !empty($P_EMAIL)) &&
        (isset($P_PASS)  && !empty($P_PASS))
    ) {
        $stmnt = "SELECT cid , cpassphrase FROM company WHERE cemail='$P_EMAIL';";
        $query = $CONN->query($stmnt);
        
        if ($query->num_rows <= 0) {
            echo json_encode(Array(
                "statusCode" => 70,
                "message" => "user does not exist!"
            ));
        }
        else {
           
            $matched = false;
            while ($row = $query->fetch_assoc()) {

                if (password_verify($P_PASS,$row["cpassphrase"])) {

                    $matched = true;
                    $_SESSION["uid"] = $row["cid"];

                    echo json_encode(Array(
                        "statusCode" => 69,
                        "message" => "success!"
                    ));
                    break;

                }
            }

            if (!$matched) {
                echo json_encode(Array(
                    "statusCode" => 70,
                    "message" => "user does not exist!"
                ));
            }

        }
    }
    else {
        header("location: ./");
    }

?>

