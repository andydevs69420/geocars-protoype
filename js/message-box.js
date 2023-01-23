

/*
    Requires jquery!!
*/ 

const messageBox = (message,callback) => {

    let genStyle = (map_style) => {
        let style = "";
        Object.keys(map_style).forEach((k) => {
            style += `${k}:${map_style[k]};`;
        });
        return style;
    };

    let ov_style = {
        "display"  : "block"    ,
        "position" : "absolute" ,
        "inset"    : "0"        ,
        "width"    : "100%"     ,
        "height"   : "100%"     ,
        "z-index"  : "10000"    ,
    };

    let mb_style = {
        "display"   : "block"    ,
        "position"  : "absolute" ,
        "top"       : "50%"      ,
        "left"      : "50%"      ,
        "transform" : "translate(-50%,-50%)" ,
        "width"     : "270px"    ,
        "height"    : "170px"    ,
        "overflow"  : "hidden"   ,
        "border-radius" : "2px" ,
        "box-shadow"    : "0px 4px 25px -2px rgba(0,0,0,0.4)" ,
        "background-color" : "#FFFFFF"
    };

    let msg_group_style = {
        "display" : "flex" ,
        "align-items"     : "center" ,
        "justify-content" : "center" ,
        "position"  : "absolute",
        "inset"     : "0"       ,
        "width"     : "100%"    ,
        "height"    : "100%"    ,
        "overflow"  : "hidden"  ,
        "z-index"   : "1"
    };

    let msg = {
        "display" : "block" ,
        "max-width"   : "95%"  ,
        "max-height"  : "95%"  ,
        "font-size"   : "15px" ,
        "white-space" : "normal" ,
        "word-wrap"   : "break-word" ,
        "text-align"  : "center" ,
        "overflow" : "hidden",
    };

    let btn_group_style = {
        "display" : "flex" ,
        "align-items"     : "center" ,
        "justify-content" : "center" ,
        "position" : "absolute"      ,
        "bottom"   : "0"    ,
        "width"    : "100%" ,
        "height"   : "25%"  ,
        "z-index"  : "2"    ,
        // "background-color" : "yellow"
    };

    let btn_style = {
        "display" : "block" ,
        "width"   : "70px"  ,
        "height"  : "65%"   ,
        "outline" : "none"  ,
        "border"  : "none"  ,
        "font-weight"   : "bold" ,
        "border-radius" : "2px"  ,
        "color" : "#FFFFFF"      ,
        "background-color" : "#a5c02e",
        "box-shadow" : "0px 2px 4px -2px rgba(0,0,0,0.4)" ,
    };

    let messagebox = $(`
        <div style="${genStyle(ov_style)}">
            <div style="${genStyle(mb_style)}">
                <span style="${genStyle(msg_group_style)}">
                    <span style="${genStyle(msg)}" role="text">${message}</span>
                </span>
                <span style="${genStyle(btn_group_style )}">
                    <button id="ok-btn" style="${genStyle(btn_style)}">Ok</button>
                </span>
            </div>
        </div>
    `);

    $("body").prepend(messagebox);

    $("#ok-btn").click((e) => {

        if (typeof(callback) != "function") {
            throw "callback is not a type of function";
        }

        callback(messagebox);

    });
}; 



