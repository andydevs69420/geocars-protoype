
<?php

    $G_UID      = $_GET["user_id"];
    $G_COMP     = $_GET["comp"];
    $G_CARPLATE = $_GET["car_plate"];

    if (!(
        (isset($G_UID)  && !empty($G_UID))  &&
        (isset($G_COMP) && !empty($G_COMP)) &&
        (isset($G_CARPLATE) && !empty($G_CARPLATE))
    )) {
        header("location: ../dashboard/");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GEOCARS | tracking</title>
    <!-- ICON -->
    <link rel="icon" href="../assets/geocarsapp.png">
    <!-- CSS -->
    <link rel="stylesheet" href="tracking.css">
    <link rel="stylesheet" href="../planchecker/planchecker.css">
    <!-- THIRD PARTY CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <!-- THIRD PARTY JS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <script src="https://kit.fontawesome.com/0ad786b032.js" crossorigin="anonymous"></script>
</head>
<body>
    <div id="tracking-map" class="map-wrapper"></div>
    <button id="msg-btn" class="message-btn fa fa-envelope"></button>
</body>

<script type="text/javascript" src="../js/jquery-3.6.0.js"></script>
<script type="text/javascript" src="../js/message-box.js"></script>
<script type="text/javascript" src="../js/current-date.js"></script>
<script type="text/javascript" src="../planchecker/check-plan.js"></script>
<script type="text/javascript" defer>
    monitor_plan(<?php echo $G_UID;?>);
</script>
<script type="module" defer>

    import "../js/jquery-3.6.0.js";
    import {getLocationData} from "./connection.js";
    import {onMapUpdate}     from "./map-config.js";
    import {on_message}      from "./on-message.js";

    const calcDistance = (lat0,lng0,lat1,lng1) => {
        // Haversine formula
        let R  = 6371e3;
        let PI = Math.PI;
        let lat0R = lat0 * PI / 180;
        let lat1R = lat0 * PI / 180;

        let lat1_lat0_diff = (lat1 - lat0) * PI/180;
        let lng1_lng0_diff = (lng1 - lng0) * PI/180;

        let a = Math.sin(lat1_lat0_diff/2) * Math.sin(lat1_lat0_diff/2) +
                Math.cos(lat0R) * Math.cos(lat1R) *
                Math.sin(lng1_lng0_diff) * Math.sin(lng1_lng0_diff);
        let c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));

        let dist = c * R;
        return dist;
    }

    let plat = 0 ,plng = 0;
    getLocationData("<?php echo $G_UID.$G_CARPLATE; ?>",(docdata) => {


        let data = docdata.data();

        if  (data === null || data === undefined) {
            messageBox(
                "Car is not yet binded!",
                (popup) => {
                    popup.remove();
                    window.close();
                }
            );
            throw "NOTBINDEDERROR: car not binded!";
        }

        let loc  = data.currentLoc;
        let his  = data.locationHistory;

        let dist = calcDistance(
            plat,plng,
            loc.lat,loc.lng
        );

        console.log(`Disatnce: ${dist}`);
        console.log(`Latitude: ${loc.lat} , Longitude: ${loc.lng}`);

        if (((dist >= 1) && !(plat == 0 && plng == 0)) || (plat == 0 && plng == 0)) {
            plat = loc.lat;
            plng = loc.lng;
            onMapUpdate(loc.lat, loc.lng,his);
        }
    });

    $("#msg-btn").click((e) => {

        on_message("<?php echo $G_COMP; ?>","<?php echo $G_UID.$G_CARPLATE; ?>");

    });
  
</script>
</html>