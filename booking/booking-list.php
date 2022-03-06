

<?php

    function emptyBooking() {
        $empty = "
            <div class='empty-booking-list'>
                <i class='empty-booking-icon fa fa-list'></i>
                <span class='empty-booking-label' role='text'>Empty list</span>
            </div>
        ";

        return $empty;
    }

    function bookingRow($id,$renter,$pickup_date,$return_date,$days,$action) {
        $row = "
            <span id='$id' class='booking-table-row' role='row' onclick='$action'>
                <!-- renter -->
                <span class='booking-table-row-cell-lg' role='cell'>
                    <span class='booking-table-row-cell-value' role='text'>
                        $renter
                    </span>
                </span>

                <!-- pickup date -->
                <span class='booking-table-row-cell-md' role='cell'>
                    <span class='booking-table-row-cell-value' role='text'>
                        $pickup_date
                    </span>
                </span>

                <!-- return date -->
                <span class='booking-table-row-cell-md' role='cell'>
                    <span class='booking-table-row-cell-value' role='text'>
                        $return_date
                    </span>
                </span>

                <!-- days -->
                <span class='booking-table-row-cell-md' role='cell'>
                    <span class='booking-table-row-cell-value' role='text'>
                        $days
                    </span>
                </span>
            </span>
        ";

        return $row;
    }

?>



<?php

    require_once("../functions.php");

    $P_UID  = $_POST["uid"];
    $P_BSID = $_POST["bsid"]; 

    if (
        (isset($P_UID)  && !empty($P_UID)) &&
        (isset($P_BSID) && !empty($P_BSID))
    ) {

        $booking_list = booking($P_UID,$P_BSID);
        if (count($booking_list) <= 0 ) {
            echo emptyBooking();
        }   
        else {
            $action = "";

            switch ($P_BSID) {
                case 1: // pending
                    $action = "approval_review($P_UID,this.id,1)";
                    break;
                case 2: // accepted
                    $action = "approval_review($P_UID,this.id,2)";
                    break;
                case 5: // picked
                    $action = "approval_review($P_UID,this.id,5)";
                    break;
                case 6: // returned
                    $action = "approval_review($P_UID,this.id,6)";
                    break;
                default:
                    $action = "approval_review($P_UID,this.id,3)";
                    break;
            }

            foreach ($booking_list as $booking) {
                $bid    = $booking["bid"];
                $lname  = $booking["rlname"];
                $fname  = $booking["rfname"];
                $mname  = $booking["rmname"];
                $renter = $lname.", ".$fname." ".$mname;
                $pickd  = $booking["pickup_date"];
                $retrd  = $booking["return_date"];
                $pickdd = date_create($pickd);
                $retrdd = date_create($retrd);
                $diff   = date_diff($pickdd,$retrdd);

                echo bookingRow($bid,$renter,$pickd,$retrd,print_r($diff->format("%a"),true),$action);
            }

        }

    }
    else {
        header("locaion: ./");
    }


    // echo emptyBooking();
?>