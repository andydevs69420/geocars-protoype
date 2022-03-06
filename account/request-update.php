

<?php
    require_once("../config.php");

    // uses custm status code
    /*
        69 := success
        70 := update fail
        71 := invalid password
    */ 

    $P_UID   = $_POST["uid"];
    $P_EMAIL = $_POST["email"];
    $P_COMPA = $_POST["company"];
    $P_ADDRS = $_POST["address"];
    $P_CONTN = $_POST["contact"];
    $P_OPASS = $_POST["password"];
    $P_NPASS = $_POST["npassword"];
    $P_CPASS = $_POST["cpassword"];

    if (
        (isset($P_EMAIL) && !empty($P_EMAIL)) &&
        (isset($P_COMPA) && !empty($P_COMPA)) &&
        (isset($P_ADDRS) && !empty($P_ADDRS)) &&
        (isset($P_CONTN) && !empty($P_CONTN)) && 
        (isset($P_OPASS)) && 
        (isset($P_NPASS)) && 
        (isset($P_CPASS)) 
    ) {
        $stmnt = null;
        if (!empty($P_OPASS)) {
            $newpass = password_hash($P_NPASS,PASSWORD_DEFAULT);
            $stmnt = "UPDATE company SET ".
                     "cemail = '$P_EMAIL',".
                     "cname  = '$P_COMPA',".
                     "caddress = '$P_ADDRS',".
                     "ccontactno = '$P_CONTN',".
                     "cpassphrase = '$newpass' ".
                     "WHERE cid = $P_UID;";
        }
        else {
            $stmnt = "UPDATE company SET ".
                     "cemail = '$P_EMAIL',".
                     "cname  = '$P_COMPA',".
                     "caddress = '$P_ADDRS',".
                     "ccontactno = '$P_CONTN' ".
                     "WHERE cid = $P_UID;";
        }

        if (!empty($P_OPASS)) {

            $result = $CONN->query("SELECT cpassphrase FROM company WHERE cid = $P_UID;");
            $ok = false;
            if ($result->num_rows > 0) {

                $row = $result->fetch_assoc();
                $passphrase = $row["cpassphrase"];

                if (password_verify($P_OPASS,$passphrase))
                    $ok = true;

            }

            if (!$ok) {
                die(json_encode(Array(
                    "statusCode" => 71 ,
                    "message" => "invalid password!",
                )));
            }
        }
        
        $updt = $CONN->query($stmnt);
        if (!$updt) {
            echo json_encode(Array(
                "statusCode" => 70 ,
                "message" => "update fail!",
                "query" => $stmnt
            ));
        }else {
            echo json_encode(Array(
                "statusCode" => 69 ,
                "message" => "success!",
            ));
        }
    }
    else {
        header("location: ./");
    }

?>