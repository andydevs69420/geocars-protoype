
<?php

    function carOptionRow($value,$text){
        return "<option value='$value'>$text</option>";
    } 

?>

<?php

    require_once("../functions.php");

    $P_UID = $_POST["uid"];

    if (
        (isset($P_UID) && !empty($P_UID))
    ) {
        $cars = company_car_details($P_UID);
        if (count($cars) <= 0) {
            echo carOptionRow(-1,"No available vehicle");
        }
        else {
            foreach($cars as $c) {
                $ccd_id = $c["ccd_id"];
                $carid  = $c["carid"];
                $brand  = $c["brand"];
                $model  = $c["model"];
                $plate  = $c["plateno"];
                $cname  = $brand."-".$model."-".$plate;
                echo carOptionRow($ccd_id."-".$carid,$cname);
            }
        }
    }
    else {
        header("location: ./");
    }

?>