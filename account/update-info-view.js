


const update_info_view = (_uid) => {

    let update_view = $(`
        <div class="update-info-view-overlay">

            <div class="ui-overlay-bg"></div>
            <div class="ui-overlay-fg"></div>

            <div class="update-info-panel">
                <button id="close-update-modal" class="close-update-info fa fa-close"></button>
                <div class="update-info-content-wrapper">
                    <div class="update-info-content">
                        <span class="update-info-label" role="text">
                            <i class="update-info-label-icon fa fa-user"></i>
                            <span role="text">Update info</span>
                        </span>
                        <ul class="update-tab-bar">
                            <!-- info tab -->
                            <li class="tab-header">
                                <a id="info-tab-link" class="tab-header-link active-tab" href="#info-tab">Info</a>
                            </li>
                            <!-- password tab -->
                            <li class="tab-header">
                                <a id="passwd-tab-link" class="tab-header-link" href="#passwd-tab">Password</a>
                            </li>
                        </ul>
                        <!-- tab wrap -->
                        <div class="tab-wrap">
                            <!-- info tab -->
                            <div id="info-tab" class="update-tab-container">

                                <!-- email -->
                                <div class="update-input-wrapper info-prop">
                                    <i class="update-input-icon fa fa-envelope"></i>
                                    <input id="email-input-field" class="update-input-field" name="email-update" type="email" placeholder="email">
                                    <span id="email-input-validate" class="validate-update-field" role="text"></span>
                                </div>

                                <!-- company -->
                                <div class="update-input-wrapper info-prop">
                                    <i class="update-input-icon fa fa-building"></i>
                                    <input id="company-input-field" class="update-input-field" name="company-update" type="text" placeholder="company">
                                    <span id="company-input-validate" class="validate-update-field" role="text"></span>
                                </div>

                                <!-- address -->
                                <div class="update-input-wrapper info-prop">
                                    <i class="update-input-icon fa fa-home"></i>
                                    <input id="address-input-field" class="update-input-field" name="address-update" type="text" placeholder="address">
                                    <span id="address-input-validate" class="validate-update-field" role="text"></span>
                                </div>

                                <!-- contact -->
                                <div class="update-input-wrapper info-prop">
                                    <i class="update-input-icon fa fa-phone"></i>
                                    <input id="contact-input-field" class="update-input-field" name="contact-update" type="number" placeholder="contactno">
                                    <span id="contact-input-validate" class="validate-update-field" role="text"></span>
                                </div>
                            
                            </div>
                            <!-- password tab -->
                            <div id="passwd-tab" class="update-tab-container">

                                <!-- old password -->
                                <div class="update-input-wrapper pass-prop">
                                    <i class="update-input-icon fa fa-lock"></i>
                                    <input id="password-input-field" class="update-input-field" name="password-reenter-update" type="password" placeholder="password">
                                    <span id="password-input-validate" class="validate-update-field" role="text"></span>
                                </div>

                                <!-- new password -->
                                <div class="update-input-wrapper pass-prop">
                                    <i class="update-input-icon fa fa-lock"></i>
                                    <input id="new-password-input-field" class="update-input-field" name="new-password-reenter-update" type="password" placeholder="new password">
                                    <span id="new-password-input-validate" class="validate-update-field" role="text"></span>
                                </div>

                                <!-- confirm password -->
                                <div class="update-input-wrapper pass-prop">
                                    <i class="update-input-icon fa fa-check-circle"></i>
                                    <input id="confirm-password-input-field" class="update-input-field" name="confirm-password-reenter-update" type="password" placeholder="confirm password">
                                    <span id="confirm-password-input-validate" class="validate-update-field" role="text"></span>
                                </div>
                            </div>
                        </div>
                        <!-- update btton -->
                        <button id="update-user-trigger" class="update-user-info">
                            Update
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `);

    $("body").prepend(update_view);

    $("#close-update-modal").click((e) => {
        update_view.remove();
    });

    $("#info-tab-link").click((e) => {
        $("#info-tab-link").addClass("active-tab");
        $("#passwd-tab-link").removeClass("active-tab");
    });

    $("#passwd-tab-link").click((e) => {
        $("#passwd-tab-link").addClass("active-tab");
        $("#info-tab-link").removeClass("active-tab");
    });

    let e_i_f , 
        c_i_f ,
        a_i_f ,
        con_i_f ,
        
        p_i_f  ,
        np_i_f ,
        cp_i_f ;

    
    let e_i_v ,
        c_i_v ,
        a_i_v ,
        con_i_v ,
        
        p_i_v  ,
        np_i_v ,
        cp_i_v ;

    // info field
    e_i_f = $("#email-input-field");
    c_i_f = $("#company-input-field");
    a_i_f = $("#address-input-field");
    con_i_f = $("#contact-input-field");
    // password field
    p_i_f  = $("#password-input-field");
    np_i_f = $("#new-password-input-field");
    cp_i_f = $("#confirm-password-input-field");

    // info validate
    e_i_v = $("#email-input-validate")
    c_i_v = $("#company-input-validate");
    a_i_v = $("#address-input-validate");
    con_i_v = $("#contact-input-validate");
    // password validate
    p_i_v  = $("#password-input-validate");
    np_i_v = $("#new-password-input-validate");
    cp_i_v = $("#confirm-password-input-validate");

    $.ajax({
        url  : "onaccount.php" ,
        type : "POST" ,
        data : {
            uid: _uid
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
                    e_i_f.val(response.data.cemail);
                    c_i_f.val(response.data.cname);
                    a_i_f.val(response.data.caddress);
                    con_i_f.val(response.data.ccontactno);
                    break;
                }
            }
        } ,
        error    : (err) => {
            console.log(err);
        }
    });



    $("#update-user-trigger").click((e) => {
        let hasError = false;
        (function(){

            if (e_i_f.val().length <= 0) {
                hasError = true;
                e_i_v.text("*Empty email field");
            }
            else {
                e_i_v.text("");
            }

            if (c_i_f.val().length <= 0) {
                hasError = true;
                c_i_v.text("*Empty company field");
            }
            else {
                c_i_v.text("");
            }

            if (a_i_f.val().length <= 0) {
                hasError = true;
                a_i_v.text("*Empty address field");
            }
            else {
                a_i_v.text("");
            }

            if (con_i_f.val().length <= 0) {
                hasError = true;
                con_i_v.text("*Empty contactno field");
            }
            else {
                con_i_v.text("");
            }

            if (hasError) {
                window.location.href = "./#info-tab";
                $("#info-tab-link").addClass("active-tab");
                $("#passwd-tab-link").removeClass("active-tab");
            }

            if (p_i_f.val().length > 0) {
                let hasPasswordError = false;
                // password change trigger
                if (np_i_f.val().length <= 0 ) {
                    hasError = true;
                    hasPasswordError = true;
                    np_i_v.text("*Empty new password field");
                }
                else {
                    if (np_i_f.val().length > 8) {
                        np_i_v.text("");
                    }
                    else {
                        hasError = true;
                        hasPasswordError = true;
                        np_i_v.text("*weak password!");
                    }
                }

                if (cp_i_f.val().length <= 0 ) {
                    hasError = true;
                    hasPasswordError = true;
                    cp_i_v.text("*Empty confirm password field");
                }
                else {
                    cp_i_v.text("");
                }

                if (!hasPasswordError) {
                    if (np_i_f.val() != cp_i_f.val()) {
                        hasError = true;
                        hasPasswordError = true;
                        cp_i_v.text("*Password does not match!");
                    }
                    else {
                        cp_i_v.text("");
                    }
                }

                if (hasPasswordError) {
                    window.location.href = "./#passwd-tab";
                    $("#passwd-tab-link").addClass("active-tab");
                    $("#info-tab-link").removeClass("active-tab");
                }
            }
        })();

        if (hasError)
            return;
        
        $.ajax({
            url  : "request-update.php" , 
            type : "POST" ,
            data : {
                uid       : _uid,
                email     : e_i_f.val() ,
                company   : c_i_f.val() ,
                address   : a_i_f.val() ,
                contact   : con_i_f.val() ,
                password  : p_i_f.val()   ,
                npassword : np_i_f.val()  ,
                cpassword : cp_i_f.val()  ,
            } ,
            dataType : "json" ,
            success  : (response) => {
                /*
                    69 := success
                    70 := update fail
                    71 := invalid password
                */ 
                console.log(response);
                switch (response.statusCode) {
                    case 71: {
                        window.location.href = "./#passwd-tab";
                        $("#passwd-tab-link").addClass("active-tab");
                        $("#info-tab-link").removeClass("active-tab");

                        p_i_v.text(response.message);
                        break;
                    } 
                    case 70: {
                        messageBox(response.message,(popup) => {
                            popup.remove();
                        });
                        break;
                    }
                    case 69: {
                        update_view.remove();
                        window.location.reload();
                        break;
                    }
                }
            } ,
            error    : (err) => {
                console.log(err);
            }
        });

    });

};