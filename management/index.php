<?php
   require_once("../config.php");

   $_SESSION["page"] = "management";

   if (!isset($_SESSION["uid"]) || empty($_SESSION["uid"]))
       header("location: ../signin/");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GEOCARS | management</title>
    <!-- ICON -->
    <link rel="icon" href="../assets/geocarsapp.png">
    <!-- CSS -->
    <link rel="stylesheet" href="../sidebar/sidebar.css">
    <link rel="stylesheet" href="management.css">
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
            <div class="management-wrapper">
                <div id="management-area" class="management-content">
                    
                    <!-- table area -->
                    <div id="table-wrap" class="table-wrapper">
                        <span id="car-table" class="car-table" role="table">
                            <span class="search-wrapper" role="row">
                                <div class="search-bar-group">
                                    <i class="search-icon fa fa-search"></i>
                                    <input id="search-input" class="search-box" list="search-result" type="search" name="search" placeholder="Search plate or car">
                                </div>
                                <button id="add-car-btn" class="add-new-car-btn">
                                    <i class="add-car-icon fa fa-plus-circle"></i>
                                    <span class="add-car-label" role="text">Add</span>
                                </button>
                            </span>
                            <span class="header-row car-table-row" role="row">
                               <!-- photo -->
                                <span class="car-table-cell car-table-header-cell" role="cell">
                                    <span class="header-col-val" role="text">
                                        <i class="fa fa-image"></i>
                                        <span class="col-label">Photo</span>
                                    </span>
                                </span>
                                <!-- brand -->
                                <span class="car-table-cell car-table-header-cell" role="cell">
                                    <span class="header-col-val" role="text">
                                        <i class="fa fa-building-o"></i>
                                        <span class="col-label">Brand</span>
                                    </span>
                                </span>
                                <!-- model -->
                                <span class="car-table-cell car-table-header-cell" role="cell">
                                    <span class="header-col-val" role="text">
                                        <i class="fa fa-car"></i>
                                        <span class="col-label">Model</span>
                                    </span>
                                </span>
                                <!-- plate -->
                                <span class="car-table-cell car-table-header-cell" role="cell">
                                    <span class="header-col-val" role="text">
                                        <i class="fa fa-id-card"></i>
                                        <span class="col-label">Plateno</span>
                                    </span>
                                </span>
                                <!-- rate -->
                                <span class="car-table-cell car-table-header-cell" role="cell">
                                    <span class="header-col-val" role="text">
                                        <i class="fa fa-money"></i>
                                        <span class="col-label">Rate</span>
                                    </span>
                                </span>
                            </span>
                            <!-- car list -->
                            <div id="list-of-cars" class="car-list"></div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

</body>
<script type="text/javascript" src="../js/jquery-3.6.0.js"></script>
<script type="text/javascript" src="../js/message-box.js"></script>
<script type="text/javascript" src="../js/ok-cancel-dialog.js"></script>
<script type="text/javascript" src="../js/is-number-only.js"></script>
<script type="text/javascript" src="../js/fill-space.js"></script>
<script type="text/javascript" src="../js/format-money.js"></script>
<script type="text/javascript" src="../js/photo-tag.js"></script>
<script type="text/javascript" src="search-filter.js"></script>
<script type="text/javascript" src="car-view.js"></script>
<script type="text/javascript" src="../js/qrcode.js"></script>
<script type="text/javascript" src="../js/current-date.js"></script>
<script type="text/javascript" src="../planchecker/check-plan.js"></script>
<script type="text/javascript" src="row-click.js"></script>
<script type="text/javascript" defer>

    $(document).ready((e) => {  

        let uid = <?php echo $_SESSION["uid"]?>;

        /********* check plan ***********/
        monitor_plan(uid);
        setInterval(() => monitor_plan(uid),1000* 10);

        /********* attach click event on add *********/ 
        $("#add-car-btn").click((e) => {
            add_car_view(uid);
        });

        /**************** load cars ******************/ 
        $("#list-of-cars").load(
            "car-list.php",
            {
                uid: uid
            } , 
            function(txt,status,xhr) {
                if (xhr.status == 200) {
                    $(".rate-col-val")
                    .each((idx,elem) => {
                        $(elem).text(formatMoney($(elem).text()));
                    });
                    fillSpace("#list-of-cars",5);
                    drawPhotoTag();
                }
                else {
                    console.log(txt);
                }
            }
        );
    });

</script>
</html>