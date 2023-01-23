
function mapToInlineStyle(map) {
    let inline = "";
    Object.keys(map).forEach((k) => {
        inline += `${k}:${map[k]};`;
    });
    return inline;
}

const overlay_style = Object.freeze({
        "display"  : "block"    ,
        "position" : "absolute" ,
        "inset"    : "0"        ,
        "width"    : "100%"     ,
        "height"   : "100%"     ,
        "z-index"  : "1002"     ,
        "background-color": "rgba(0,0,0,0.96)"
});

const close_btn_style = Object.freeze({
    "display"  : "block"    ,
    "position" : "absolute" ,
    "top"      : "15px"     ,
    "left"     : "15px"     ,
    "width"    : "35px"     ,
    "height"   : "35px"     ,
    "outline"  : "none"     ,
    "border"   : "none"     ,
    "border-radius" : "100%"
});

const image_style = Object.freeze({
    "display"    : "block"    ,
    "position"   : "absolute" ,
    "top"        : "50%"      ,
    "left"       : "50%"      ,
    "transform"  : "translate(-50%,-50%)" ,
    "max-width"  : "50%"      ,
    "max-height" : "100%"
});


const photo_view = (img_src) => {
    
    let view = $(`
        <div style="${mapToInlineStyle(overlay_style)}">
            <button id="close-image-view" class="fa fa-close" style="${mapToInlineStyle(close_btn_style)}"></button>
            <img src="${img_src}" alt="${img_src}" style="${mapToInlineStyle(image_style)}">
        </div>
    `);

    $("body").prepend(view);

    $("#close-image-view")
    .click((e) => {
        view.remove();
    });

};




function drawPhotoTag () {
    let photo_tags = $("photo");
    photo_tags.each((idx,elem) => {
        const src = elem.getAttribute("src");
        elem.style.backgroundImage = `url("${src}")`;
        elem.onclick = (e) => {
            e.stopPropagation();
            photo_view(src);
        };
    });
}

drawPhotoTag();

