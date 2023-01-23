

<?php
   
    if (
        !(
            (isset($_GET["docid"]) && !empty($_GET["docid"])) &&
            (isset($_GET["lat"])   && !empty($_GET["lat"]))   &&
            (isset($_GET["lng"])   && !empty($_GET["lng"]))
    )) {

        http_response_code(403);
        die('<h1 style="text-align:center;">403 Forbidden</h1>');
    }

    $G_DOCID = $_GET["docid"];
    $G_LAT   = $_GET["lat"];
    $G_LNG   = $_GET["lng"];

?>


<script type="module">

    import {transmitInBackground} from "./connection.js";

    transmitInBackground("<?php echo $G_DOCID;?>",<?php echo $G_LAT;?>,<?php echo $G_LNG;?>);
    
</script>