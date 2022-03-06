<?php

    include "config.php";


    $CONN->close();
    unset($_SESSION["uid"]);
    unset($_SESSION["page"]);

    session_destroy();
    header("location: signin/");

?>