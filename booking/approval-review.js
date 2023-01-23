

const approval_review = (uid,bid,status) => {

    let view = $(`
        <div class="approval-review-overlay">

            <div class="ar-overlay-bg"></div>
            <div class="ar-overlay-fg"></div>


            <div class="approval-review-panel">
                <button id="close-approval-review" class="close-approval-review fa fa-close"></button>
                <div class="approval-review-wrapper">
                    <div class="approval-review-content">
                        <!-- label -->
                        <span class="aproval-review-content-label" role="text">
                            <i class="approval-review-content-icon fa fa-user"></i>
                            <span role="text">Review</span>
                        </span>
                        <label class="ar-external-lbl">Renter</label>
                        <!-- name row -->
                        <div class="approval-review-input-wrapper">
                            <!-- lname -->
                            <div class="ar-input-user-group">
                                <i class="ar-input-icon fa fa-user"></i>
                                <input id="l-name-field" class="ar-input-field" type="text" name="lname-field" placeholder="Last name" disabled>
                            </div>
                            <!-- fname -->
                            <div class="ar-input-user-group">
                                <i class="ar-input-icon fa fa-user"></i>
                                <input id="f-name-field" class="ar-input-field" type="text" name="fname-field" placeholder="First name" disabled>
                            </div>
                            <!-- mname -->
                            <div class="ar-input-user-group">
                                <i class="ar-input-icon fa fa-user"></i>
                                <input id="m-name-field" class="ar-input-field" type="text" name="mname-field" placeholder="Middle name" disabled>
                            </div>
                        </div>
                        <!-- contact row -->
                        <div class="approval-review-input-wrapper ar-contact-wrapper">
                            <!-- contact -->
                            <div class="ar-input-contact-group">
                                <i class="ar-input-icon fa fa-phone"></i>
                                <input id="contact-field" class="ar-input-field" type="number" name="contact-field" placeholder="Contact no." disabled>
                            </div>
                            <!-- adress -->
                            <div class="ar-input-contact-group">
                                <i class="ar-input-icon fa fa-home"></i>
                                <input id="address-field" class="ar-input-field" type="text" name="address-field" placeholder="Address" disabled>
                            </div>
                        </div>
                        <label class="ar-external-lbl">Vehicle</label>
                        <!-- car row -->
                        <div class="approval-review-input-wrapper">
                            <!-- brand -->
                            <div class="ar-input-car-group">
                                <i class="ar-input-icon fa fa-building"></i>
                                <input id="car-brand-field" class="ar-input-field" type="text" name="cbrand-field" placeholder="Brand" disabled>
                            </div>
                            <!-- model -->
                            <div class="ar-input-car-group">
                                <i class="ar-input-icon fa fa-car"></i>
                                <input id="car-model-field" class="ar-input-field" type="text" name="cmodel-field" placeholder="Model" disabled>
                            </div>
                            <!-- plate -->
                            <div class="ar-input-car-group">
                                <i class="ar-input-icon fa fa-id-card"></i>
                                <input id="car-plate-field" class="ar-input-field" type="text" name="cplate-field" placeholder="Plateno" disabled>
                            </div>
                            <!-- rate -->
                            <div class="ar-input-car-group">
                                <i class="ar-input-icon fa fa-money"></i>
                                <input id="car-rate-field" class="ar-input-field" type="text" name="crate-field" placeholder="&#8369;Rate/day" disabled>
                            </div>
                        </div>
                        <!-- car images list -->
                        <div id="ar-car-images" class="ar-images-list">
                            <span class="ar-empty-images" role="text">No images available</span>
                        </div>
                        <!-- date -->
                        <label class="ar-external-lbl">Prefferred date</label>
                        <div class="approval-review-input-wrapper ar-date-wrapper">
                            <!-- pickupdate picker -->
                            <div class="ar-input-date-group">
                                <label class="ar-date-label" for="pickupd-field">Pickup date</label>
                                <input id="pickup-date-field" class="ar-input-field" name="pickup-date" type="date" disabled>
                            </div>
                            <!-- return picker -->
                            <div class="ar-input-date-group">
                                <label class="ar-date-label" for="return-date-field">Return date</label>
                                <input id="return-date-field" class="ar-input-field" name="return-date" type="date" disabled>
                            </div>
                        </div>
                        ${
                            (status == 5 || status == 6)?
                            `
                                <label class="ar-external-lbl">Total payable (&#8369;Rate/day x days)</label>
                                <span class="tally-table" role="table">
                                    <!-- row 0 -->
                                    <span class="tally-table-row" role="row">
                                        <span class="tally-header-cell" role="cell">Day</span>
                                        <span id="day-used" class="tally-value-cell" role="cell"></span>
                                    </span>
                                    <!-- row 1 -->
                                    <span class="tally-table-row" role="row">
                                        <span class="tally-header-cell" role="cell">Rate</span>
                                        <span id="car-rate-per-day" class="tally-value-cell" role="cell"></span>
                                    </span>
                                    <!-- row 2 -->
                                    <span class="tally-table-row" role="row">
                                        <span class="tally-header-cell" role="cell">Exceeded</span>
                                        <span id="day-exceeded" class="tally-value-cell" role="cell"></span>
                                    </span>
                                    <!-- row 3 -->
                                    <span class="tally-table-row" role="row">
                                        <span class="tally-header-cell" role="cell">Total</span>
                                        <span id="total" class="tally-value-cell" role="cell"></span>
                                    </span>
                                </span>
                                
                            `
                            :
                            ""
                        }
                        ${
                            (status == 5 || status == 6)? 
                            `
                                <hr style="margin: 10px 0;">
                            `
                            :
                            ""
                        }
                        <!-- control button  -->
                        <div class="ar-control-button-group">
                            <!-- conditional -->
                            ${
                                (status == 1)?
                                `
                                    <button id="ar-accept-btn" class="ar-accept-btn">Accept</button>
                                    <button id="ar-decline-btn" class="ar-decline-btn">Decline</button>
                                `
                                :
                                (status == 2)?
                                `
                                    <button id="ar-pick-btn" class="ar-pickup-btn">Pickup</button>
                                    <button id="ar-cancel-btn" class="ar-cancel-btn">Cancel</button>
                                `
                                :
                                (status == 5)?
                                `
                                    <button id="ar-return-btn" class="ar-return-btn">Return</button>
                                `
                                :
                                ""
                            }
                        </div>
                    </div>
                </div>
            </div>
        </div>

    `);

    $("body").prepend(view);

    $("#close-approval-review").click((e) => view.remove());
    let l_n_f , 
        f_n_f ,
        m_n_f ,
        c_f ,
        a_f ,
        c_b_f ,
        c_m_f ,
        c_p_f ,
        c_r_f ,
        p_d_f , p_d_f_raw ,
        r_d_f , r_d_f_raw ,
        total_raw ;
    
    l_n_f = $("#l-name-field");
    f_n_f = $("#f-name-field");
    m_n_f = $("#m-name-field");
    c_f = $("#contact-field");
    a_f = $("#address-field");
    c_b_f = $("#car-brand-field");
    c_m_f = $("#car-model-field");
    c_p_f = $("#car-plate-field");
    c_r_f = $("#car-rate-field");
    p_d_f = $("#pickup-date-field");
    r_d_f = $("#return-date-field");

    let car_img = $("#ar-car-images");

    $.ajax({
        url  : "get-booking.php",
        type : "POST" ,
        data : {
            uid : uid,
            bid : bid
        } ,
        dataType : "json" ,
        success  :  (response) => {
            
            switch (response.statusCode) {
                case 69: {

                    
                    l_n_f.val(response.data.rlname);
                    f_n_f.val(response.data.rfname);
                    m_n_f.val(response.data.rmname);
                    c_f.val(response.data.rcontactno);
                    a_f.val(response.data.raddress);
                    c_b_f.val(response.data.brand);
                    c_m_f.val(response.data.model);
                    c_p_f.val(response.data.plateno);
                   
                    c_r_f.val(formatMoney(response.data.rate_per_day));

                    p_d_f.val(response.data.pickup_date);
                    p_d_f_raw = response.data.pickup_date;
                    r_d_f.val(response.data.return_date);
                    r_d_f_raw = response.data.return_date;
                
                    if (response.data.images.length > 0) 
                        car_img.empty();
                    
                    response.data.images.forEach((link) => {
                        
                        car_img.append(
                            $(`<photo class="car-image" src="${link}"></photo>`)
                        );
                    });

                    drawPhotoTag();
                    
                    if (status == 5 || status == 6) {
                        let day = 25 * 60 * 60 * 1000;
                        let a , b;

                        a = new Date(response.data.pickup_date);
                        b = new Date(response.data.return_date);
                        c = new Date(getDate());

                        let diff0 = Math.round(Math.abs((a-c)/day));
                        let diff1 = Math.round(Math.abs((a-b)/day));
                        let diff2 = ((diff0 - diff1) < 0)? 0 : (diff0 - diff1);

                        $("#day-used").text(`${diff0} of ${diff1}`);
                        $("#car-rate-per-day").text(formatMoney(response.data.rate_per_day));
                        $("#day-exceeded").text(diff2);
                        let total = diff0  * response.data.rate_per_day;
                        total = (total <= 0)? response.data.rate_per_day : total;
                        total_raw = total;
                        $("#total").text(formatMoney(total));
                    }

                    break;
                }
                default: {
                    messageBox(response.message,(popup) => {
                        popup.remove();
                    });
                    break;
                }
            }
        },
        error    : (err) => {
            console.log(err);
        }
    });

    const update_booking = (_uid,_bstatus) => {
        $.ajax({
            url  : "update-booking.php",
            type : "POST",
            data : {
                uid : _uid,
                bid : bid ,
                bstatus : _bstatus
            },
            dataType : "json",
            success  : (response) => {
                /*
                    69 := success
                    70 := update fail
                */
                switch (response.statusCode) {
                    case 70: {
                        messageBox(response.message,(popup) => {
                            popup.remove();
                        });
                        break;
                    }
                    case 69: {
                        view.remove();
                        on_get_booking(uid,$("#list-of-booking-status").val());
                        // window.location.reload();
                        break;
                    }
                }
            },
            error    : (err) => {
                console.log(err);
            }
        });
    };

    if (status == 1) { // pending
        $("#ar-accept-btn").click((e) => {
            update_booking(uid,2); // 2 accepted
        });

        $("#ar-decline-btn").click((e) => {
            update_booking(uid,4); // 4 declined
        });
    }
    else if(status == 2) { //accepted
        $("#ar-pick-btn").click((e) => {
            if (p_d_f_raw != getDate()) {
                messageBox("Pickup date is not yet arrived!",(popup) => {
                    popup.remove();
                });
                return;
            }

            let now  = new Date(getDate());
            let pick = new Date(p_d_f_raw);
            if (pick < now) {
                messageBox("Missed pickup date!",(popup) => {
                    popup.remove();
                });
                return;
            }
            update_booking(uid,5); // 5 picked
        });

        $("#ar-cancel-btn").click((e) => {
            update_booking(uid,3); // 3 canceled
        });
    }
    else if (status == 5) { // return
        $("#ar-return-btn").click((e) => {
            update_booking(uid,6); // 6 returned
            $.ajax({
                url  : "update-transaction.php" ,
                type : "POST" ,
                data : {
                    uid  : uid , 
                    bid  : bid ,
                    tend : getDate(),
                    tammount : total_raw
                } ,
                dataType : "json",
                success  : (response) => {
                    /*
                        69 := success
                        70 := update fail
                    */
                    switch (response.statusCode) {
                        case 70 : {
                            messageBox(response.message,(popup) => {
                                popup.remove();
                            });
                            break;
                        }
                        case 69: {
                            on_get_booking(uid,$("#list-of-booking-status").val());
                            // window.location.reload();
                            break;
                        }
                    }
                },
                error    : (err) => {
                    console.log(err);
                }
            });
        });
    }

};

