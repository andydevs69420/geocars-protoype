<?php

    require_once("../config.php");

    $_SESSION["page"] = "account";

    if (!isset($_SESSION["uid"]) || empty($_SESSION["uid"]))
        header("location: ../signin/");

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GEOCARS | account</title>
    <!-- ICON -->
    <link rel="icon" href="../assets/geocarsapp.png">
    <!-- CSS -->
    <link rel="stylesheet" href="../sidebar/sidebar.css">
    <link rel="stylesheet" href="account.css">
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
            <div class="account-wrapper">

                <!-- cover picture -->
                <span class="profile-cover-wrapper">
                    <photo id="cover-image" class="profile-cover"></photo>
                    <label class="btn-pick-cover" for="pick-cover">
                        <i class="pick-cover-icon fa fa-camera"></i>
                    </label>
                    <input id="pick-cover" class="cover-file" type="file" name="cover-picker" multiple accept="image/jpeg">
                </span>
                

                <!-- display picture -->
                <span class="profile-dp-wrapper">
                    <photo id="dp-image" class="profile-dp"></photo>
                    <label class="btn-pick-dp" for="pick-dp">
                        <i class="pick-dp-icon fa fa-camera"></i>
                    </label>
                    <input id="pick-dp" class="dp-file" type="file" name="dp-picker" multiple accept="image/jpeg">
                </span>

                <!-- company name -->
                <span class="account-company-wrapper">
                    <span id="company-name" class="account-company" role="text"></span>
                </span>

                <!-- transformable column -->
                <div class="transformable-column">

                    <!-- col 1 -->
                    <span class="t-col-1">
                        <div class="info-container">

                            <div class="information">

                                <!-- label -->
                                <span class="label-action-group">
                                    <span class="info-label" role="text">INFO</span>
                                    <button id="edit-profile-btn" class="edit-user-btn fa fa-user-edit"></button>
                                </span>

                                <div class="row-wrapper">
                                    
                                    <!-- email row -->
                                    <span class="icon-value-group">
                                        <i class="info-icon fa fa-envelope"></i>
                                        <span id="email-value" class="info-value" role="text"></span>
                                    </span>

                                    <!-- plan row -->
                                    <span class="icon-value-group">
                                        <i class="info-icon fa fa-rocket"></i>
                                        <span id="plan-value" class="info-value" role="text"></span>
                                    </span>

                                    <!-- company row -->
                                    <span class="icon-value-group">
                                        <i class="info-icon fa fa-building"></i>
                                        <span id="company-value" class="info-value" role="text"></span>
                                    </span>

                                    <!-- address row -->
                                    <span class="icon-value-group">
                                        <i class="info-icon fa fa-home"></i>
                                        <span id="address-value" class="info-value" role="text"></span>
                                    </span>

                                    <!-- contact row -->
                                    <span class="icon-value-group">
                                        <i class="info-icon fa fa-phone"></i>
                                        <span id="contact-value" class="info-value" role="text"></span>
                                    </span>
                                    
                                </div>

                            </div>
                        </div>
                    </span>

                    <!-- col 2 -->
                    <span class="t-col-2">
                        <div class="chart-wrapper-0">
                            <div class="chart-container-0">
                                <span class="dash-label" role="text">Dashboard usage</span>
                                <canvas id="dash-data" class="dashboard-remaining"></canvas>
                            </div>
                        </div>
                    </span>

                </div>

            </div>
        </div>
    
    </div>
</body>
<script type="text/javascript" src="../js/jquery-3.6.0.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript" src="../js/message-box.js"></script>
<script type="text/javascript" src="../js/photo-tag.js"></script>
<script type="text/javascript" src="../js/current-date.js"></script>
<script type="text/javascript" src="../planchecker/check-plan.js"></script>
<script type="text/javascript" src="update-info-view.js"></script>
<script type="text/javascript" src="dashboard-time.js"></script>
<script type="text/javascript" defer>
   
    $(document).ready((e) => {
        /*
            LEGENDS:


                e_val = > email_value
                n_val = > name_value
                a_val = > address_value
                c_val = > contact_value

        */

        let isloaded;

        let uid , 
            cpic_id;
       
        let dp_ptag , 
            cover_ptag;

        // stores input fields initial value
        let e_val  ,
            p_val  ,
            cn_val ,
            n_val  ,
            a_val  ,
            v_val  ;


        isloaded = false;

        uid = <?php echo $_SESSION['uid']; ?>;

        dp_ptag = $("#dp-image");
        cover_ptag = $("#cover-image");
        
        e_val  = $("#email-value");
        p_val  = $("#plan-value");
        cn_val = $("#company-name");
        n_val  = $("#company-value");
        a_val  = $("#address-value");
        c_val  = $("#contact-value");

        /****************** heck plan *************/ 
        monitor_plan(uid);
        setInterval(() => monitor_plan(uid),1000* 10);

        /****************** dp pick ***************/ 
        $("#pick-dp").change((e) => {
            
            if (!isloaded)
                return;

            let fdata = new FormData();
            let files = $("#pick-dp").prop("files");

            fdata.append(
                "uid" , 
                uid
            );
            fdata.append(
                "col" , 
                "dp_link"
            );
            fdata.append(
                "cpic_id" , 
                cpic_id
            );
            fdata.append(
                "image" , 
                files[0]
            );

            $.ajax({
                url  : "upload-single-image.php" ,
                type : "POST" ,
                data : fdata  ,
                enctype: 'multipart/form-data',
                dataType : "json"  ,
                processData: false , 
                contentType: false ,
                success  : (response) => {

                    /*
                        69 := success
                        70 := upload failed
                        71 := update failed
                    */

                    switch (response.statusCode) {
                        case 71:
                        case 70: {
                            messageBox(response.message,(popup) => {
                                popup.remove();
                            });
                            break;
                        }
                        case 69: {
                            $("#sidebar-avatar")
                            .attr("src",response.data);
                            $("#dp-image")
                            .attr("src",response.data);
                            drawPhotoTag();
                            break;
                        }
                    }
                } ,
                error    : (err) => {
                    console.log(err.responseText);
                }
            });
            
        });

        /****************** cover pick ***************/ 
        $("#pick-cover").change((e) => {
            
            if (!isloaded)
                return;

            let fdata = new FormData();
            let files = $("#pick-cover").prop("files");

            fdata.append(
                "uid" , 
                uid
            );
            fdata.append(
                "col" , 
                "cover_link"
            );
            fdata.append(
                "cpic_id" , 
                cpic_id
            );
            fdata.append(
                "image" , 
                files[0]
            );

            $.ajax({
                url  : "upload-single-image.php" ,
                type : "POST" ,
                data : fdata  ,
                enctype: 'multipart/form-data',
                dataType : "json"  ,
                processData: false , 
                contentType: false ,
                success  : (response) => {

                    /*
                        69 := success
                        70 := upload failed
                        71 := update failed
                    */

                    switch (response.statusCode) {
                        case 71:
                        case 70: {
                            messageBox(response.message,(popup) => {
                                popup.remove();
                            });
                            break;
                        }
                        case 69: {
                            $("#cover-image")
                            .attr("src",response.data);
                            drawPhotoTag();
                            break;
                        }
                    }
                } ,
                error    : (err) => {
                    console.log(err);
                }
            });
            
        });

        /*************** fill info ***************/ 
        $.ajax({
            url  : "onaccount.php" ,
            type : "POST" ,
            data : {
                uid: uid
            } ,
            dataType : "json" ,
            success  : (response) => {

                /*
                    69 := success
                    70 := no record found
                */
                
                switch (response.statusCode) {
                    case 70: {
                        messageBox(response.message,(popup) => {
                            window.location.href = "../signin/";
                            popup.remove();
                        });
                        break;
                    }
                    case 69: {
                        cpic_id  = response.data.cpic_id;
                        isloaded = true;

                        let no_image = "../assets/no-image.png";

                        let imgDp = response.data.dp_link;
                        let imgCv = response.data.cover_link;

                        if (imgDp == "N/A") {
                            imgDp = no_image;
                        }

                        if (imgCv == "N/A") {
                            imgCv = no_image;
                        }

                        dp_ptag.attr(
                            "src" ,
                            imgDp
                        );

                        cover_ptag.attr(
                            "src" ,
                            imgCv
                        );

                        e_val.text(response.data.cemail);
                        p_val.text(response.data.pname);
                        cn_val.text(response.data.cname)
                        n_val.text(response.data.cname);
                        a_val.text(response.data.caddress);
                        c_val.text(response.data.ccontactno);
                        drawPhotoTag();
                        break;
                    }
                }
                
            } ,
            error    : (err) => {
                console.log(err);
            }

        });
        /*************** fill dashboard time ***************/

        const fetchUsage = function() {
            $.ajax({
                url  : "usage-time.php",
                type : "POST",
                data : {
                    uid  : uid,
                    time : new Date(Date.now()).getTime()
                },
                dataType : "json",
                success  : (response) => {
                    console.log(response);
                    if (response.statusCode == 69) {
                        setUsage(response.data)
                    }
                },
                error    : (err) => {
                    console.log(err);
                }
            });
        }

        fetchUsage();

        setInterval(fetchUsage,1000 * 10);

        /*************** edit profile button ***************/ 
        // update_info_view(uid);

        $("#edit-profile-btn").click((e) => {

            update_info_view(uid);

        });

    });
</script>
</html>



