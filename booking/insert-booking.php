

<?php
    require_once("../config.php");
    // uses custom status code
    /*
        69 := success
        70 := booking fail
    */

    $P_CCDID = $_POST["ccdid"];
    $P_LNAME = $_POST["lname"];
    $P_FNAME = $_POST["fname"];
    $P_MNAME = $_POST["mname"];
    $P_CONTACT = $_POST["contact"];
    $P_ADDRESS = $_POST["address"];
    $P_BOOKEDD = $_POST["bookedd"];
    $P_PICKUPD = $_POST["pickupd"];
    $P_RETURND = $_POST["returnd"];

    if (
        (isset($P_CCDID) && !empty($P_CCDID)) &&
        (isset($P_LNAME) && !empty($P_LNAME)) &&
        (isset($P_FNAME) && !empty($P_FNAME)) &&
        (isset($P_MNAME) && !empty($P_MNAME)) &&
        (isset($P_CONTACT) && !empty($P_CONTACT)) &&
        (isset($P_ADDRESS) && !empty($P_ADDRESS)) &&
        (isset($P_BOOKEDD) && !empty($P_BOOKEDD)) &&
        (isset($P_PICKUPD) && !empty($P_PICKUPD)) &&
        (isset($P_RETURND) && !empty($P_RETURND))
    ) {
        
        $stmnt = "INSERT INTO renter(rlname,rfname,rmname,rcontactno,raddress)  
                  VALUES ('$P_LNAME','$P_FNAME','$P_MNAME','$P_CONTACT','$P_ADDRESS');
                 ";

        $query = $CONN->query($stmnt);

        if (!$query) {
            echo json_encode(Array(
                "statusCode" => 71,
                "message" => "insert fail!",
            ));
        }
        else {

            $rid = $CONN->insert_id;

            $stmnt0 = "
                INSERT INTO booking(
                    rid,
                    ccd_id,
                    booking_date,
                    pickup_date,
                    return_date,
                    bsid
                ) 
                VALUE(
                    $rid,
                    $P_CCDID,
                    '$P_BOOKEDD',
                    '$P_PICKUPD',
                    '$P_RETURND',
                    (SELECT bsid FROM booking_status WHERE bstatus = 'PENDING')
                );
            ";

            $new_book = $CONN->query($stmnt0);
            
            if (!$new_book) {
                echo json_encode(Array(
                    "statusCode" => 70,
                    "message" => "booking fail!"
                ));
            }
            else {
                echo json_encode(Array(
                    "statusCode" => 69,
                    "message" => "success!"
                ));
            }

        }
    }
    else {
        header("location: ./");
    }

?>