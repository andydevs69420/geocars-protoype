<?php

    function emptyCar() {
        $empty = "
            <div class='empty-car-list'>
                <i class='empty-icon fa fa-list'></i>
                <span class='empty-label' role='text'>Empty list</span>
            </div>
        ";
        return $empty;
    }

    function carRow ($uid,$cid,$image_link,$brand,$model,$plate,$rate) {
        $new_row = "
            <!-- row $cid -->
            <span id='$cid' class='car-table-row' role='row' onclick='rowClick($uid,$cid)'>
                <!-- photo -->
                <span class='car-table-cell' role='cell'>
                    <photo class='car-featured-photo' src='$image_link'></photo>
                </span>
                <!-- brand -->
                <span class='car-table-cell' role='cell'>
                    <span class='col-val' role='text'>$brand</span>
                </span>
                <!-- model -->
                <span class='car-table-cell' role='cell'>
                    <span class='col-val' role='text'>$model</span>
                </span>
                <!-- plateno -->
                <span class='car-table-cell' role='cell'>
                    <span class='col-val' role='text'>$plate</span>
                </span>
                <!-- rate -->
                <span class='car-table-cell' role='cell'>
                    <span class='col-val rate-col-val' role='text'>$rate</span>
                </span>
            </span>
        ";
        
        return $new_row;
    }

?>

<?php
    require_once("../functions.php");

    $P_UID = $_POST["uid"];

    if (isset($P_UID) && !empty($P_UID)) {
        $car_arr = company_car_details($P_UID);
        if (count($car_arr) <= 0) {
            echo emptyCar();
        }
        else {
            foreach ($car_arr as $car) {
                echo carRow($P_UID,$car["carid"],$car["images"][0]["image_link"],$car["brand"],$car["model"],$car["plateno"],$car["rate_per_day"]);
            }
        }
    }
    else {
        header("location: ./");
    }

?>