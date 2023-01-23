
const new_booking_view = (uid) => {
    let view = $(`
        <div class="new-booking-view-overlay">

            <div class="nb-overlay-bg"></div>
            <div class="nb-overlay-fg"></div>


            <div class="new-booking-panel">
                <button id="close-new-booking-view" class="close-new-booking-btn fa fa-close"></button>
                <div class="new-booking-content-wrapper">
                    <div class="new-booking-content">
                        <!-- label -->
                        <span class="new-booking-content-label" role="text">
                            <i class="new-booking-content-icon fa fa-user"></i>
                            <span role="text">New booking</span>
                        </span>
                        <!-- name row -->
                        <div class="new-booking-input-wrapper">
                            <!-- lname -->
                            <div class="nb-input-user-group">
                                <i class="nb-input-icon fa fa-user"></i>
                                <input id="l-name-field" class="nb-input-field" type="text" name="lname-field" placeholder="Last name">
                                <span id="l-name-validator" class="nb-input-valdator"></span>
                            </div>
                            <!-- fname -->
                            <div class="nb-input-user-group">
                                <i class="nb-input-icon fa fa-user"></i>
                                <input id="f-name-field" class="nb-input-field" type="text" name="fname-field" placeholder="First name">
                                <span id="f-name-validator" class="nb-input-valdator"></span>
                            </div>
                            <!-- mname -->
                            <div class="nb-input-user-group">
                                <i class="nb-input-icon fa fa-user"></i>
                                <input id="m-name-field" class="nb-input-field" type="text" name="mname-field" placeholder="Middle name">
                                <span id="m-name-validator" class="nb-input-valdator"></span>
                            </div>
                        </div>
                        <!-- contact row -->
                        <div class="new-booking-input-wrapper nb-contact-wrapper">
                            <!-- contact -->
                            <div class="nb-input-contact-group">
                                <i class="nb-input-icon fa fa-phone"></i>
                                <input id="contact-field" class="nb-input-field" type="number" name="contact-field" placeholder="Contact no.">
                                <span id="contact-validator" class="nb-input-valdator"></span>
                            </div>
                            <!-- adress -->
                            <div class="nb-input-contact-group">
                                <i class="nb-input-icon fa fa-home"></i>
                                <input id="address-field" class="nb-input-field" type="text" name="address-field" placeholder="Address">
                                <span id="address-validator" class="nb-input-valdator"></span>
                            </div>
                        </div>
                        <!-- car list drop down -->
                        <label class="nb-label" for="select-avail-car" >Available vehicle(s):</label>
                        <select id="select-avail-car" class="select-available-cars"></select>
                        <!-- car images list -->
                        <div id="selected-car-images-list" class="images-list">
                            <span class="empty-images" role="text">No images available</span>
                        </div>
                        <!-- date selection -->
                        <label class="nb-label">Preferred dates:</label>
                        <div class="new-booking-input-wrapper nb-date-wrapper">
                            <!-- pickupdate picker -->
                            <div class="nb-input-date-group">
                                <label class="nb-date-label" for="pickupd-field">*Pickup date</label>
                                <input id="pickup-date-field" class="nb-input-field" name="pickup-date" type="date">
                                <span id="pickup-date-validator" class="nb-input-valdator"></span>
                            </div>
                            <!-- return picker -->
                            <div class="nb-input-date-group">
                                <label class="nb-date-label" for="return-date-field">*Return date</label>
                                <input id="return-date-field" class="nb-input-field" name="return-date" type="date">
                                <span id="return-date-validator" class="nb-input-valdator"></span>
                            </div>
                        </div>
                        <!-- book -->
                        <button id="btn-book" class="book-btn">
                            <span role="text">Book</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `);

    $("body")
    .prepend(view);

    $("#close-new-booking-view")
    .click((e) => {
        view.remove();
    });

    const on_car_select_changed = (uid,carid) => {
        let car_img = $("#selected-car-images-list");
        $.ajax({
            url  : "get-car-details.php",
            type : "POST",
            data : {
                uid   : uid,
                carid : carid
            },
            dataType : "json" ,
            success : (response) => {
                response.forEach((car) => {
                    car_img.empty();
                    car.images.forEach((link) => {
                        car_img.append(
                            $(`<photo class="car-image" src="${link.image_link}"></photo>`)
                        );
                    });
                    drawPhotoTag();
                });
            } , 
            error   : (err) => {
                console.log(err);
            }
        });
    };

    let select_car = $("#select-avail-car");

    select_car
    .load(
        "avail-car-list.php",
        {
            uid : uid
        },
        function(txt,status,xhr) {
            if (xhr.status == 200) {
                let selcar,ccdid,carid;
                selcar = select_car.val().split("-");
                ccdid  = selcar[0];
                carid  = selcar[1];
                on_car_select_changed(uid,carid);
            }
            else {
                console.log(txt);
            }
        }
    );

    select_car.change((e) => {
        selcar = select_car.val().split("-");
        ccdid  = selcar[0];
        carid  = selcar[1];
        on_car_select_changed(uid,carid);
    });

    let l_n_f ,
        f_n_f ,
        m_n_f ,
        c_f   ,
        a_f   ,
        p_d_f ,
        r_d_f ;

    let l_n_v ,
        f_n_v ,
        m_n_v ,
        c_v   ,
        a_v   ,
        p_d_v ,
        r_d_v ;

    l_n_f = $("#l-name-field");
    f_n_f = $("#f-name-field");
    m_n_f = $("#m-name-field");
    c_f = $("#contact-field");
    a_f = $("#address-field");
    p_d_f = $("#pickup-date-field");
    r_d_f = $("#return-date-field");

    l_n_v = $("#l-name-validator");
    f_n_v = $("#f-name-validator");
    m_n_v = $("#m-name-validator");
    c_v = $("#contact-validator");
    a_v = $("#address-validator");
    p_d_v = $("#pickup-date-validator");
    r_d_v = $("#return-date-validator");

    
    let book_click = false;
    $("#btn-book").click((e) => {


        if (book_click)
            return;
        
        book_click = true;

        let has_error = false;

        (function() {

            if (l_n_f.val().length <= 0) {
                has_error = true;
                l_n_v.text("*Empty lastname field");
            }
            else {
                l_n_v.text("");
            }
            if (f_n_f.val().length <= 0) {
                has_error = true;
                f_n_v.text("*Empty firstname field");
            }
            else {
                f_n_v.text("");
            }
            if (m_n_f.val().length <= 0) {
                has_error = true;
                m_n_v.text("*Empty middlename field");
            }
            else {
                m_n_v.text("");
            }
            if (c_f.val().length <= 0) {
                has_error = true;
                c_v.text("*Empty contact field");
            }
            else {
                c_v.text("");
            }
            if (a_f.val().length <= 0) {
                has_error = true;
                a_v.text("*Empty address field");
            }
            else {
                a_v.text("");
            }
            if (select_car.val() == -1) {
                has_error = true;
                messageBox("No available cars left!" , (popup) => {
                    popup.remove();
                });
            }
            if (p_d_f.val().length <= 0) {
                has_error = true;
                p_d_v.text("*Invalid date");
            }
            else {
                
                let day = 24 * 60 * 60 * 1000;

                let a = new Date(getDate());
                let b = new Date(p_d_f.val());

                if (b < a) {
                    has_error = true;
                    p_d_v.text("*Invalid pickup date");
                }
                else {
                    let diff = Math.round(Math.abs((a - b) / day));
                    if (diff > 7) {
                        has_error = true;
                        p_d_v.text("*Pickup date, to late");
                    }
                    else {
                        p_d_v.text("");
                    }
                }

            }
            if (r_d_f.val().length <= 0) {
                has_error = true;
                r_d_v.text("*Invalid date");
            }
            else {
                
                let day = 24 * 60 * 60 * 1000;

                let a = new Date(p_d_f.val());
                let b = new Date(r_d_f.val());

                if (b < a) {
                    has_error = true;
                    r_d_v.text("*Invalid return date");
                }
                else {
                    let diff = Math.round(Math.abs((a - b) / day));
                    if (diff > 31) {
                        has_error = true;
                        r_d_v.text("*maximum rental is 1 month");
                    }
                    else {
                        if (p_d_f.val() == r_d_f.val()) {
                            has_error = true;
                            r_d_v.text("*Minimum rental is 1 day");
                        }
                        else {
                            r_d_v.text("");
                        }
                    }
                }
            }

        })();

        if (has_error) {
            book_click = false;
            return;
        }
        
        console.log("TO INSERT");
        
        selcar = select_car.val().split("-");
        ccdid  = selcar[0];
        carid  = selcar[1];
        on_car_select_changed(uid,carid);
        
        $.ajax({
            url  : "insert-booking.php" ,
            type : "POST" ,
            data : {
                ccdid : ccdid,
                lname : l_n_f.val(),
                fname : f_n_f.val(),
                mname : m_n_f.val(),
                contact : c_f.val(),
                address : a_f.val(),
                bookedd : getDate(),
                pickupd : p_d_f.val(),
                returnd : r_d_f.val(), 
            } ,
            dataType : "json" ,
            success  : (response) => {
                /*
                    69 := success
                    70 := booking fail
                */
                console.log(response);
                switch (response.statusCode) {
                    case 70: {
                        messageBox(response.message , (popup) => {
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
            } ,
            error    : (err) => {
                book_click = false;
                console.log(err);
            }
        });

    });
};