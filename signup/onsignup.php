<?php
    require_once("../config.php");

    // uses custom status code
    /*
        69 := success
        70 := fail
        71 := user exist
    */

    $P_EMAIL = $_POST["email"];
    $P_PASS  = $_POST["password"];
    $P_CPASS = $_POST["cpassword"];

    if (
        (isset($P_EMAIL) && !empty($P_EMAIL)) &&
        (isset($P_PASS)  && !empty($P_PASS))  &&
        (isset($P_CPASS) && !empty($P_CPASS))
    ) {
        // check if exist
        $qstmnt = "SELECT * FROM company WHERE cemail='$P_EMAIL';";
        $query  = $CONN->query($qstmnt);
        
        if ($query->num_rows > 0) {
            // user exist
            echo json_encode(Array(
                "statusCode" => 71 ,
                "message" => "user exist!"
            ));
        }
        else {
            $passphrase = password_hash($P_PASS,PASSWORD_DEFAULT);

            $istmnt = "INSERT INTO company(cemail,cpassphrase) ".
                      "VALUES('$P_EMAIL','$passphrase');";
            
            $ires = $CONN->query($istmnt);
            if (!$ires) {
                echo json_encode(Array(
                    "statusCode" => 70 ,
                    "message" => "fail!"
                ));
            }
            else {
                echo json_encode(Array(
                    "statusCode" => 69 ,
                    "message" => "success!"
                ));
            }
        }
    }
    else {
        header("location: ./");
    }
?>
