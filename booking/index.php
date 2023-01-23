<?php
    require_once("../config.php");
  
    $_SESSION["page"] = "booking";

    if (!isset($_SESSION["uid"]) || empty($_SESSION["uid"]))
       header("location: ../signin/");

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GEOCARS | booking</title>
    <!-- ICON -->
    <link rel="icon" href="../assets/geocarsapp.png">
    <!-- CSS -->
    <link rel="stylesheet" href="../sidebar/sidebar.css">
    <link rel="stylesheet" href="booking.css">
    <link rel="stylesheet" href="../planchecker/planchecker.css">
    <!-- JS -->
    <script src="https://kit.fontawesome.com/0ad786b032.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="central-wrapper">

        <?php
            include "../sidebar/sidebar.php";
        ?>

        <div class="safe-area">

            <div class="booking-wrapper">

                <div class="booking-table">
                    <!-- switch drop down -->
                    <div class="switch-mode-header">
                        <span class="drop-down-status-wrapper">
                            <label class="lbl-for-bstatus" for="list-of-booking-status">Status:</label>
                            <select id="list-of-booking-status" class="booking-status-list" name="booking-status"></select>
                        </span>
                        <button id="new-booking" class="new-rent-button">
                            <i class="new-rent-icon fa fa-plus-circle"></i>
                            <span class="new-rent-label" role="text">New</span>
                        </button>
                    </div>
                    <!-- row header -->
                    <span class="booking-table-row booking-table-header-row" role="row">
                        <!-- col 0 -->
                        <span class="booking-table-row-cell-lg header-row-cell" role="cell">
                            <span class="booking-table-row-cell-value header-cell" role="text">
                                <i class="fa fa-user"></i>
                                <span class="booking-table-header-lbl" role="text">Renter</span>
                            </span>
                        </span>

                        <!-- col 1 -->
                        <span class="booking-table-row-cell-md header-row-cell" role="cell">
                            <span class="booking-table-row-cell-value header-cell" role="text">
                                <i class="fa fa-calendar-plus"></i>
                                <span class="booking-table-header-lbl" role="text">Pickup date</span>
                            </span>
                        </span>

                        <!-- col 2 -->
                        <span class="booking-table-row-cell-md header-row-cell" role="cell">
                            <span class="booking-table-row-cell-value header-cell" role="text">
                                <i class="fa fa-calendar-minus"></i>
                                <span class="booking-table-header-lbl" role="text">Return date</span>
                            </span>
                        </span>

                        <!-- col 3 -->
                        <span class="booking-table-row-cell-md header-row-cell" role="cell">
                            <span class="booking-table-row-cell-value header-cell" role="text">
                                <i class="fa fa-calendar"></i>
                                <span class="booking-table-header-lbl" role="text">Days</span>
                            </span>
                        </span>
                    </span>
                    <!-- booking list -->
                    <div id="list-of-booking" class="booking-list"></div>
                </div>
            </div>

        </div>
        
    </div>
</body>
<script type="text/javascript" src="../js/jquery-3.6.0.js"></script>
<script type="text/javascript" src="../js/message-box.js"></script>
<script type="text/javascript" src="../js/fill-space.js"></script>
<script type="text/javascript" src="../js/photo-tag.js"></script>
<script type="text/javascript" src="../js/current-date.js"></script>
<script type="text/javascript" src="../js/format-money.js"></script>
<script type="text/javascript" src="../planchecker/check-plan.js"></script>
<script type="text/javascript" src="new-booking.js"></script>
<script type="text/javascript" src="approval-review.js"></script>
<script type="text/javascript" defer>

    const on_get_booking = (uid,bs) => {
        $("#list-of-booking").load(
            "booking-list.php",
            { 
                uid  : uid ,
                bsid : bs  ,
            } ,
            function(txt,status,xhr) {
                if (xhr.status == 200) {
                    fillSpace("#list-of-booking",4);
                    drawPhotoTag();
                }
                else {
                    console.log(txt);
                }
            }
        );
    };

    $(document).ready((e) => {

        let uid = <?php echo $_SESSION["uid"]; ?> ;

        /****************** check plan *******************/
        monitor_plan(uid);
        setInterval(() => monitor_plan(uid),1000* 10);
        
        /****************** new booking ******************/
        let new_booking_btn = $("#new-booking");

        // new_booking_view(uid);

        new_booking_btn.click((e) => {
            
            new_booking_view(uid);

        });

        /****************** drop down table filter ******************/ 
        let booking_stat_dropdown = $("#list-of-booking-status");

        booking_stat_dropdown
        .change((e) => {
            on_get_booking(uid,booking_stat_dropdown.val());
        });

        booking_stat_dropdown
        .load(
            "booking-status.php",
            null,
            function(txt,status,xhr) {
                if (xhr.status == 200) {
                    on_get_booking(uid,booking_stat_dropdown.val());
                }
                else {
                    console.log(txt);
                }
            },
        );
    });
</script>
</html>