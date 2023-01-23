
<?php

    function optionRow($value,$text) {
        $row = "
            <option class='booking-status-option' value='$value'>$text</option>
        ";
        return $row;
    }
?>


<?php
    require_once("../config.php");

    $stmnt = "SELECT * FROM booking_status;";

    $query = $CONN->query($stmnt);

    if ($query->num_rows > 0) {
        while ($row = $query->fetch_assoc()) {
            echo optionRow($row["bsid"],$row["bstatus"]);
        }
    }
?>