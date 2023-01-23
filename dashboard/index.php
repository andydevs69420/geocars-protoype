<?php
    require_once("../config.php");
  
    $_SESSION["page"] = "dashboard";

    if (!isset($_SESSION["uid"]) || empty($_SESSION["uid"]))
       header("location: ../signin/");

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GEOCARS | dashboard</title>
    <!-- ICON -->
    <link rel="icon" href="../assets/geocarsapp.png">
    <!-- CSS -->
    <link rel="stylesheet" href="../sidebar/sidebar.css">
    <link rel="stylesheet" href="dashboard.css">
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
            <div id="dash-wrap" class="dashboard-wrapper">
                <!-- chart layout styles -->
                <div class="chart-layout">
                    
                    <!-- medium tile wrapper -->
                    <div class="medium-tile-wrapper">

                        <!-- two col only 0  -->
                        <div class="two-column-only-wrapper">

                            <!-- medium tile 0 -->
                            <div class="medium-tile mt-0">
                                <div class="m-tile-content-wrapper">
                                    <i class="m-tile-icon fa fa-user-plus"></i>
                                    <span class="m-tile-label">New Booking</span>
                                    <span id="new-booking" class="m-tile-value">0</span>
                                </div>
                            </div>

                            <!-- medium tile 1 -->
                            <div class="medium-tile mt-1">
                                <div class="m-tile-content-wrapper">
                                    <i class="m-tile-icon fa fa-key"></i>
                                    <span class="m-tile-label">Pickup Today</span>
                                    <span id="pickup_today" class="m-tile-value">0</span>
                                </div>
                            </div>

                        </div>

                        <!-- two col only 1  -->
                        <div class="two-column-only-wrapper">

                            <!-- medium tile 2 -->
                            <div class="medium-tile mt-2">
                                <div class="m-tile-content-wrapper">
                                    <i class="m-tile-icon fa fa-undo-alt"></i>
                                    <span class="m-tile-label">Return Today</span>
                                    <span id="return_today" class="m-tile-value">0</span>
                                </div>
                            </div>

                            <!-- medium tile 3 -->
                            <div class="medium-tile mt-3">
                                <div class="m-tile-content-wrapper">
                                    <i class="m-tile-icon fa fa-warning"></i>
                                    <span class="m-tile-label">Alarming</span>
                                    <span id="alarming" class="m-tile-value">0</span>
                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- large tile -->
                    <div class="large-tile-wrapper">
                        
                        <!-- large tile 0  -->
                        <div class="l-tile large-tile-0">
                            <div class="chart-wrapper chart-override">
                                <i class="override-chart-icon fa fa-car"></i>
                                <canvas id="car-tally-chart" class="chart"></canvas>
                            </div>
                        </div>

                        <!-- large tile 1 -->
                        <div class="l-tile large-tile-1">
                            <div class="chart-wrapper">
                                <canvas id="profit-chart" class="chart"></canvas>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- tracking table wrapper-->
                <div id="tracking-table-section" class="tracking-table-wrapper">
                    <span class="dash-table-wrapper">
                        <span class="dash-table" role="table">
                            <span class="dash-table-row dash-table-header-row" role="row">

                                <!-- table header cell 0 -->
                                <span class="dash-table-cell lg-dash-table-cell header-cell" role="cell">
                                    <span class="cell-value" role="text">
                                        <i class="header-cell-icon fa fa-user"></i>
                                        <span class="header-cell-label" role="text">Renter</span>
                                    </span>
                                </span>

                                <!-- table header cell 1 -->
                                <span class="dash-table-cell header-cell" role="cell">
                                    <span class="cell-value" role="text">
                                        <i class="header-cell-icon fa fa-building"></i>
                                        <span class="header-cell-label" role="text">Model</span>
                                    </span>
                                </span>

                                <!-- table header cell 2 -->
                                <span class="dash-table-cell header-cell" role="cell">
                                    <span class="cell-value" role="text">
                                        <i class="header-cell-icon fa fa-car"></i>
                                        <span class="header-cell-label" role="text">Brand</span>
                                    </span>
                                </span>

                                <!-- table header cell 3 -->
                                <span class="dash-table-cell header-cell" role="cell">
                                    <span class="cell-value" role="text">
                                        <i class="header-cell-icon fa fa-id-card"></i>
                                        <span class="header-cell-label" role="text">Plate</span>
                                    </span>
                                </span>
                            </span>
                            <div id="list-of-rent" class="rent-list"></div>
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </div>
    

</body>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript" src="../js/jquery-3.6.0.js"></script>
<script type="text/javascript" src="../js/fill-space.js"></script>
<script type="text/javascript" src="../js/photo-tag.js"></script>
<script type="text/javascript" src="../js/current-date.js"></script>
<script type="text/javascript" src="../planchecker/check-plan.js"></script>
<script type="text/javascript" src="charts.js"></script>
<script type="text/javascript" src="expand-onscroll.js"></script>
<script defer>

    let uid = <?php echo $_SESSION["uid"]; ?>;


    function track(id,comp,carplate) {
        window.open(`../tracking/?user_id=${id}&comp=${comp}&car_plate=${carplate}`, '_blank').focus();
    }

    $(document).ready((e) => {

        const fetchDashData = function() {
            /********** check plan  ***********/
            monitor_plan(uid);

            /********** dash board data **********/ 
            
            $.ajax({
                url  : "dash-data.php",
                type : "POST",
                data : {
                    uid  : uid,
                    date : getDate()
                },
                dataType : "json" ,
                success  : (response) => {
                    
                    console.log(response);
                    
                    if (response.num_of_booking.statusCode == 69) 
                        $("#new-booking").text(response.num_of_booking.data);
                    

                    if (response.pickup_today.statusCode == 69) 
                        $("#pickup_today").text(response.pickup_today.data);
                

                    if (response.return_today.statusCode == 69)
                        $("#return_today").text(response.return_today.data);
                    

                    if (response.alarming.statusCode == 69)
                        $("#alarming").text(response.alarming.data);
                

                    if (response.car_status.statusCode == 69)
                        if ((
                            response.car_status.data.available   != 0 ||
                            response.car_status.data.unavailable != 0
                        ))
                            updateCarStatus(
                                response.car_status.data.available,
                                response.car_status.data.unavailable
                            );
                    if (response.mprofit.statusCode == 69)
                        updateMonthlyProfit(response.mprofit.data)

                },
                error    : (err) => {
                    console.log(err);
                }

            });
        };

        fetchDashData();

        setInterval(fetchDashData , 1000 * 10);


        /********** load rented **********/
        $("#list-of-rent").load(
            "renter-list.php",
            {
                uid : uid 
            },
            function(txt,status,xhr) {
                if (xhr.status == 200) {
                    fillSpace("#list-of-rent",4);
                    return;
                }
                else {
                    console.log(txt);
                }
            }
        );
    });


</script>
</html>

