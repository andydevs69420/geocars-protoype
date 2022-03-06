


const add_car_view = (_uid) => {
    const view = $(`
        <div class="add-car-view-overlay">

            <div class="cv-overlay-bg"></div>
            <div class="cv-overlay-fg"></div>

            <div class="add-car-view-panel">
                <button id="close-add-car" class="close-add-car-view fa fa-close"></button>
                
                <div class="add-car-content-wrapper">
                    <div class="add-car-content">
                        <!-- label -->
                        <span class="add-car-content-label" role="text">
                            <i class="add-car-content-label-icon fa fa-car"></i>
                            <span role="text">Add a new car</span>
                        </span>
                        <!-- input wrapper -->
                        <div class="add-car-input-wrapper">

                            <!-- Brand labeled input -->
                            <div class="add-car-labeled-input">
                                <span class="add-car-labeled-input-label" role="text">Brand</span>
                                <input id="brand-field" class="add-car-labeled-input-input" type="text" name="brand-input" placeholder="Brand" autofocus>
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
                                <span class="attach-image-on-add-subs-label" role="text">Attach</span>
                            </label>
                            <input id="attach-image-on-add" class="add-car-file-picker" type="file" name="file-picker" accept="image/jpeg" multiple>
                        </div>
                        <div class="attached-images-wrapper">
                            <div id="attached-images" class="attached-images-list">
                                <span id="on-empty-image" class="empty-attached-images">Attach Images</span>
                            </div>
                            <span id="attached-images-val" class="attached-images-validator"></span>
                        </div>
                        <button id="submit-add-request" class="add-new-car-submit">
                            Add car
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `);

    $("body").prepend(view);

    $("#close-add-car").click((e) => {
        view.remove();
    });

    const image_input = $("#attach-image-on-add");
    image_input.change((e) => {

        $("#on-empty-image")
        .remove();

        $("#attached-images")
        .empty();

        let files , limit;

        files = image_input.prop("files");

        limit = (files.length > 5)? 5 : files.length;
        
        for (let idx = 0 ;idx < limit; idx++) {

            let fread = new FileReader();
            
            fread.readAsDataURL(files[idx]);
            fread.onloadend = (data) => {
                $("#attached-images")
                .append(
                    $(`<photo class="attached-image" src="${data.currentTarget.result}"></photo>`)
                )
                drawPhotoTag();
            }
        }
    });

    let isaddClick = false;
    $("#submit-add-request").click(() => {

        if (isaddClick)
            return;

        isaddClick = true;
        let hasError = false;

        (function(){
            let b_f ,
                m_f ,
                p_f ,
                r_f ;

            let b_f_v ,
                m_f_v ,
                p_f_v ,
                r_f_v ,
                a_i_v ;

            b_f = $("#brand-field");
            m_f = $("#model-field");
            p_f = $("#plateno-field");
            r_f = $("#rate-field");

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

            let _l = image_input.prop("files").length;
            
            if (_l < 5 || _l > 5) {
                hasError = true;
                a_i_v.text(`Invalid images count ${_l}/5`);
            }
            else {
                a_i_v.text("");
            }

        })();

        if (hasError) {
            isaddClick = false;
            return;
        }


        let fd = new FormData();

        fd.append(
            "uid",
            _uid
        );
        fd.append(
            "brand",
            $("#brand-field").val()
        );
        fd.append(
            "model",
            $("#model-field").val()
        );
        fd.append(
            "plate",
            $("#plateno-field").val()
        );
        fd.append(
            "rate",
            $("#rate-field").val()
        );
        let files = image_input.prop("files");
        for (let idx = 0;idx < files.length;idx++) {
            fd.append(
                `image-${idx}`,
                files[idx]
            );
        }
       
        $.ajax({
            type : "POST" ,
            url  : "insert-new-car.php" ,
            data : fd ,
            enctype: 'multipart/form-data' ,
            dataType : "json"  ,
            processData: false , 
            contentType: false ,
            success  : (response) => {
                /*
                    69 := success
                    70 := insert error
                    71 := maximum no. of car reached
                    72 := invalid credential
                */
                console.log(response);
                switch (response.statusCode) {
                    case 72: {
                        isaddClick = false;
                        messageBox(response.message,(popup) => {
                            popup.remove();
                        });
                        break;
                    }
                    case 71: {
                        isaddClick = false;
                        messageBox(response.message,(popup) => {
                            popup.remove();
                        });
                        break;
                    }
                    case 70: {
                        isaddClick = false;
                        messageBox(response.message,(popup) => {
                            popup.remove();
                        });
                        break;
                    }
                    case 69: {
                        view.remove();
                        window.location.reload();
                        break;
                    }
                }
            } ,
            error    : (err) => {
                isaddClick = false
                console.log(err);
            }
        });
        
    });
};
