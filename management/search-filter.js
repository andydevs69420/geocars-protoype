
const startsWith = (basis0,basis1) => {
    return (
        basis0.substring(0,basis1.length).toLowerCase() == basis1.toLowerCase()
    );
}

const search_box = $("#search-input");
search_box.keyup((e) => {
    const search = search_box.val();
    let result = 0;
    $("#list-of-cars").children().each((idx,itm) => {
        let hasMatched = false;
        $(itm).children().each((idx0,field) => {
            const text = $($(field).children()[0]).text();
            if (/*text == search*/ startsWith(text,search)) {
                hasMatched = true;
            }
        });
        if (!hasMatched) {
            $(itm).css("display","none");
        }else {
            $(itm).css("display","flex");
            result++;
        }
    });
});
