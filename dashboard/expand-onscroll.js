


$(document).ready((e) => {
    const dash_wrap = $("#dash-wrap");
    const tracking_section = $("#tracking-table-section");

    dash_wrap.scroll((e) => {

        // console.log(e);
        let top = parseInt(tracking_section.offset().top);
        if ((top - 96) <= 0) {
            tracking_section.addClass("expand-on-scroll");
        }
        else {
            tracking_section.removeClass("expand-on-scroll");
        }

    });

});