

function rowClick(uid,carid) {

    const info_view = $(`
        <div class="add-car-view-overlay">

            <div class="cv-overlay-bg"></div>
            <div class="cv-overlay-fg"></div>

            <div class="add-car-view-panel">
                <button id="close-add-car" class="close-add-car-view fa fa-close"></button>
                
                <div class="add-car-content-wrapper">
                    <div class="add-car-content add-car-content-on-update">
                        <!-- label -->
                        <span class="add-car-content-label" role="text">
                            <i class="add-car-content-label-icon fa fa-car"></i>
                            <span role="text">Car information</span>
                        </span>
                        <!-- qr code -->
                        <div class="qr-code-wrapper">
                            <div id="qr-code-data" class="qr-code"></div>
                        </div>
                        <!-- input wrapper -->
                        <div class="add-car-input-wrapper">

                            <!-- Brand labeled input -->
                            <div class="add-car-labeled-input">
                                <span class="add-car-labeled-input-label" role="text">Brand</span>
                                <input id="brand-field" class="add-car-labeled-input-input" type="text" name="brand-input" placeholder="Brand">
                                <span id="brand-field-val" class="add-car-labeled-input-validator"></span>
                            </div>

                            <!-- Model labeled input -->
                            <div class="add-car-labeled-input">
                                <span class="add-car-labeled-input-label" role="text">Model</span>
                                <input id="model-field" class="add-car-labeled-input-input" type="text" name="Model-input" placeholder="Model">
                                <span id="model-field-val" class="add-car-labeled-input-validator"></span>
                            </div>

                            <!-- Plateno labeled input -->
                            <div class="add-car-labeled-input">
                                <span class="add-car-labeled-input-label" role="text">Plateno</span>
                                <input id="plateno-field" class="add-car-labeled-input-input" type="text" name="plateno-input" placeholder="Plateno">
                                <span id="plateno-field-val" class="add-car-labeled-input-validator"></span>
                            </div>

                            <!-- Rate labeled input -->
                            <div class="add-car-labeled-input">
                                <span class="add-car-labeled-input-label" role="text">Rate</span>
                                <input id="rate-field" class="add-car-labeled-input-input" type="number" name="rate-input" placeholder="&#8369;RATE/day">
                                <span id="rate-field-val" class="add-car-labeled-input-validator"></span>
                            </div>
                        </div>
                        <div class="attach-image-group">
                            <label class="attach-image-on-add-subs ripple-effect" for="attach-image-on-add">
                                <i class="attach-image-on-add-subs-icon fa fa-image"></i>
                                <span class="attach-image-on-add-subs-label" role="text">Replace</span>
                            </label>
                            <input id="attach-image-on-add" class="add-car-file-picker" type="file" name="file-picker" accept="image/jpeg" multiple>
                        </div>
                        <div class="attached-images-wrapper">
                            <div id="attached-images" class="attached-images-list">
                                <span id="on-empty-image" class="empty-attached-images">Attach Images</span>
                            </div>
                            <span id="attached-images-val" class="attached-images-validator"></span>
                        </div>
                        <!-- control button group -->
                        <div class="control-button-group">
                            <!-- add -->
                            <button id="submit-add-request" class="add-new-car-submit">
                                Update
                            </button>
                            <!-- delete -->
                            <button id="btn-delete-request" class="delete-car-button">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `);

    $("body").prepend(info_view);

    let b_f ,
        m_f , 
        p_f ,
        r_f ,
        images ,
        imagesid ,
        hasImageChanged;
    
    b_f = $("#brand-field");
    m_f = $("#model-field");
    p_f = $("#plateno-field");
    r_f = $("#rate-field");
    images = $("#attached-images");
    imagesid = [];
    hasImageChanged = false;

    $.ajax({
        url  : "on-row-click.php",
        type : "POST",
        data : { 
            uid : uid ,
            carid : carid 
        },
        dataType : "json",
        success : (response) => {
            switch (response.statusCode) {
                case 69: {
                    b_f.val(response.data[0].brand);
                    m_f.val(response.data[0].model);
                    p_f.val(response.data[0].plateno);
                    r_f.val(response.data[0].rate_per_day);

                    if (response.data[0].images.length > 0) {
                        $("#on-empty-image").remove();
                    }

                    response.data[0].images.forEach((img) => {
                        let id = img["carimg_id"];
                        let ln = img["image_link"];

                        imagesid.push(id);
                        images.append(
                            $(`<photo class="attached-image" src='${ln}'></photo>`)
                        )
                        drawPhotoTag();
                    });

                    new QRCode(document.getElementById("qr-code-data"), {
                        text: `{"userid" : "${uid}" , "carplate" : "${response.data[0].plateno}"}`,
                        width: 120,
                        height: 120,
                        colorDark : "#000000",
                        colorLight : "#ffffff",
                        correctLevel : QRCode.CorrectLevel.H
                    });
                    break;
                }
            }

        },
        error: (err) => {
            console.log(err);
        }
    });

    $("#close-add-car").click((e) => {
        info_view.remove();
    });

    const image_input = $("#attach-image-on-add");
    image_input.change((e) => {

        hasImageChanged = true;

        $("#on-empty-image")
        .remove();

        images.empty();

        let files , limit;

        files = image_input.prop("files");

        limit = (files.length > 5)? 5 : files.length;
        
        for (let idx = 0 ;idx < limit; idx++) {

            let fread = new FileReader();
            
            fread.readAsDataURL(files[idx]);
            fread.onloadend = (data) => {
                $("#attached-images")
                .append(
                    $(`<photo class="attached-image"></photo>`)
                    .attr(
                        "src",
                        data.currentTarget.result
                    )
                )
                drawPhotoTag();
            }
        }
    });
    
    let isUpdateClick = false;
    $("#submit-add-request").click(() => {

        if (isUpdateClick)
            return;
        
        isUpdateClick = true;

        let hasError = false;

        (function(){

            let b_f_v ,
                m_f_v ,
                p_f_v ,
                r_f_v ,
                a_i_v ;

            /*** validator ***/
            b_f_v = $("#brand-field-val");
            m_f_v = $("#model-field-val");
            p_f_v = $("#plateno-field-val");
            r_f_v = $("#rate-field-val");
            a_i_v = $("#attached-images-val");

            if (b_f.val().length <= 0) {
                hasError = true;
                b_f_v.text("*Empty brand field");
            }
            else {
                b_f_v.text("");
            }

            if (m_f.val().length <= 0) {
                hasError = true;
                m_f_v.text("*Empty model field");
            }
            else {
                m_f_v.text("");
            }

            if (p_f.val().length <= 0) {
                hasError = true;
                p_f_v.text("*Empty plate field");
            }
            else {
                p_f_v.text("");
            }

            if (r_f.val().length <= 0) {
                hasError = true;
                r_f_v.text("*Empty rate field");
            }
            else {
                if (
                    !isNumber(r_f.val()) ||
                    parseInt(r_f.val()) <= 0
                ) {
                    hasError = true;
                    r_f_v.text("*Invalid rate value");
                }else {
                    r_f_v.text("");
                }
            }

            let _l = images.children().length;

            if (_l < 5 || _l > 5) {
                hasError = true;
                a_i_v.text(`Invalid images count ${_l}/5`);
            }
            else {
                a_i_v.text("");
            }

        })();

        if (hasError) {
            isUpdateClick = false;
            return;
        }

        let fd = new FormData();

        fd.append(
            "uid",
            uid
        );
        fd.append(
            "carid",
            carid
        );
        fd.append(
            "brand",
            b_f.val()
        );
        fd.append(
            "model",
            m_f.val()
        );
        fd.append(
            "plate",
            p_f.val()
        );
        fd.append(
            "rate",
            r_f.val()
        );
        fd.append(
            "hasImageChanged",
            hasImageChanged
        );
        fd.append(
            "imagesid",
            imagesid
        );
        if (hasImageChanged) {
            
            let files = image_input.prop("files");
        
            for (let idx = 0; idx < imagesid.length;idx ++) {
                fd.append(
                    `image-${imagesid[idx]}`,
                    files[idx]
                );
            }
        }

        $.ajax({
            url  : "request-car-update.php" ,
            type : "POST" ,
            data : fd ,
            enctype  : "multipart/form-data" ,
            dataType : "json"  ,
            processData : false , 
            contentType : false ,
            success     : (response) => {
                /*
                    69 := success
                    70 := upload fail
                    71 := update fail
                */ 

                switch (response.statusCode) {
                    case 71:
                    case 70: {
                        isUpdateClick = false;
                        messsageBox(response.messsage,(popup) => {
                            popup.remove();
                        });
                        break;
                    }
                    case 69: {
                        info_view.remove();
                        window.location.reload();
                        break;
                    }
                }
            } ,
            error       : (err) => {
                isUpdateClick = false;
                console.log(err);
            }
        });
        
    });

    $("#btn-delete-request").click((e) => {
        ok_cancel_dialog_Box(
            "Deleting this car will delete also its data. Continue?",
            (popup) => {
                popup.remove();
                $.ajax({
                    url  : "request-car-delete.php" ,
                    type : "POST" , 
                    data : {
                        carid : carid ,
                    } ,
                    dataType : "json" ,
                    success  : (response) => {
                        /*
                            69 := success
                            70 := delete fail
                        */ 
                        switch (response.statusCode) {
                            case 70: {
                                messsageBox(response.messsage,(popup) => {
                                    popup.remove();
                                });
                                break;
                            }
                            case 69: {
                                info_view.remove();
                                window.location.reload();
                                break;
                            }
                        }
                    } ,
                    error    : (err) => {
                        console.log(err);
                    }
                });
            },
            (popup) => {
                popup.remove();
            }
        );
    });
}

