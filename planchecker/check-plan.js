
let isViewed = false;

const plan_popup = () => {

    let view = $(`
        <div class="plan-overlay">

            <div class="overlay-bg"></div>
            <div class="overlay-fg"></div>

            <div class="center-panel">
                <div class="content-wrapper">
                    <i class="plan-icon fa fa-rocket"></i>
                    <span class="plan-label">Ooops! time's up.</span>
                    <button id="id-force-signout" class="on-plan-logout-btn">Signout</button>
                </div>
            </div>

        </div>
    `);
    
    if (!isViewed) {

        isViewed = true;

        $("body").prepend(view);

        $("#id-force-signout").click((e) => {

            view.remove();
            
            window.location.href = "../logout.php";

        });

    }
};


const monitor_plan = (uid) => {

    // let time = "Wed Jan 19 2022 15:12:02 GMT+0800 (China Standard Time)";

    $.ajax({
        url  : "../planchecker/check-plan-time.php",
        type : "POST",
        data : {
            uid  : uid,
            date : getDate(),
            time : new Date(Date.now()).getTime()
        },
        dataType: "json",
        success: (response) => {
            /*
                69 := valid session
                70 := time exceeded
                71 := sucess timein
                72 := error timein
            */
            console.log(response);
            switch (response.statusCode) {
                case 72: 
                case 71: {
                    console.log(response.message);
                    break;
                }
                case 70: {
                    plan_popup();
                    console.log(response.message);
                    break;
                }
                case 69: {
                    console.log(response.message);
                    break;
                }
            }
        },
        error : (err) => {
            console.log(err);
        }
    });

};