
<?php
    require_once("../functions.php");


    $P_UID = $_POST["uid"];
    $P_BID = $_POST["bid"];

    if (
        (isset($P_UID) && !empty($P_UID)) &&
        (isset($P_BID) && !empty($P_BID))
    ) {
        $blist = getBooking($P_UID,$P_BID);
        return $blist;
    }
    else {
        header("location: ./");
    }

?>