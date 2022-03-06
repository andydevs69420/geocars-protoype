<?php

    function emptyRent() {
        $empty = "
            <div class='empty-rent-list'>
                <i class='empty-icon fa fa-list'></i>
                <span class='empty-label' role='text'>Empty list</span>
            </div>
        ";
        return $empty;
    }

    function renterRow ($uid,$compname,$renter,$model,$brand,$plate) {
        $row = "
            <!-- row 0 -->
            <span class='dash-table-row' onclick='track($uid,\"$compname\",\"$plate\")'>
                <!-- table row cell 0 -->
                <span class='dash-table-cell lg-dash-table-cell' role='cell'>
                    <span class='cell-value' role='text'>
                        $renter
                    </span>
                </span>
                <!-- table row cell 1 -->
                <span class='dash-table-cell' role='cell'>
                    <span class='cell-value' role='text'>
                       $model
                    </span>
                </span>
                <!-- table row cell 2 -->
                <span class='dash-table-cell' role='cell'>
                    <span class='cell-value' role='text'>
                        $brand
                    </span>
                </span>
                <!-- table row cell 3 -->
                <span class='dash-table-cell' role='cell'>
                    <span class='cell-value' role='text'>
                        $plate
                    </span>
                </span>
            </span>
        ";
        return $row;
    }
?>

<?php

    require_once("../functions.php");

    $P_UID = $_POST["uid"];

    if (
        (isset($P_UID) && !empty($P_UID))
    ) {
        $tdatalist = getOngoingTransactions($P_UID);
        if (count($tdatalist) <= 0) {
            echo emptyRent();
        }
        else {
            foreach ($tdatalist as $tdata) {
                $COMPNAME = $tdata["cname"];
                $lname = $tdata["rlname"];
                $fname = $tdata["rfname"];
                $mname = $tdata["rmname"];

                $fullname = $lname.", ".$fname." ".$mname;

                $brand = $tdata["brand"];
                $model = $tdata["model"];
                $plateno = $tdata["plateno"];
                echo renterRow($P_UID,$COMPNAME,$fullname,$brand,$model,$plateno);
            }
        }
    }
    else {
        header("location: ./");
    }

?>