
function $_ (str) {
    return document.querySelectorAll(str);
}

function is_medium_dev () {
    return (
        window.innerWidth >= 280 &&
        window.innerWidth <= 768
    );
}


/** navigation bar **/
let nav = $_("#nav") [0];

/** collapse button **/

let collapse_btn = $_("#collapse-btn")     [0];
let collapse_wrp = $_("#collapse-wrapper") [0];
let is_collapsed = false;



function on_collapse () {
    if (!is_medium_dev())
        return;
    if (!is_collapsed) {
        collapse_btn.classList.remove("rot-0");
        collapse_btn.classList.add("rot-360");
        collapse_btn.children[0].classList.remove("fa-bars");
        collapse_btn.children[0].classList.add("fa-close");

        collapse_wrp.classList.remove("status-hide");
        collapse_wrp.classList.add("status-shown");
    }
    else {
        collapse_btn.classList.remove("rot-360");
        collapse_btn.classList.add("rot-0");
        collapse_btn.children[0].classList.remove("fa-close");
        collapse_btn.children[0].classList.add("fa-bars");

        collapse_wrp.classList.remove("status-shown");
        collapse_wrp.classList.add("status-hide");
    }
    is_collapsed = !is_collapsed;
    on_scroll();
}

collapse_btn.onclick = (e) => on_collapse();

/** navigation links **/

let nav_links = $_(".nav-link");

nav_links.forEach((link) => {
    link.onclick = (e) => {
        nav_links.forEach((self) => {
            self.classList.remove("active-link");
        })
        // FIXME: watchout!! maybe causes error!!
        // code isolated by Philipp Andrew
        // link.classList.add("active-link");
    }
});


/** home tab **/
let home_tab = $_("#home") [0];


function on_scroll () {
    if(
        home_tab.getBoundingClientRect().top < -56
    )
        nav.classList.add("reveal");
    else 
        nav.classList.remove("reveal");
    
}

$_("body")[0].addEventListener("scroll",(e) => {
   

    on_scroll();
    let active = null;

    if (
         ($_("#home")[0].getBoundingClientRect().top
        >= 0
        &&
        $_("#home")[0].getBoundingClientRect().top
        <= (window.innerHeight / 2))
        ||
        $_("#home")[0].getBoundingClientRect().top === 0
    ) {
        active = "Home";
    }
    else if (
        $_("#about")[0].getBoundingClientRect().top
        >= 0
        &&
        $_("#about")[0].getBoundingClientRect().top
        <= (window.innerHeight / 2) 
    ) {
        active = "About";
    }
    else if (
        $_("#pricing")[0].getBoundingClientRect().top
        >= 0
        &&
        $_("#pricing")[0].getBoundingClientRect().top
        <= (window.innerHeight / 2) 
    ) {
        active = "Pricing";
    }
    else if (
        $_("#contact")[0].getBoundingClientRect().top
        >= 0
        &&
        $_("#contact")[0].getBoundingClientRect().top
        <= (window.innerHeight / 2) 
    ) {
        active = "Contact us";
    }
    
    if (!(active === null)) {
        nav_links.forEach ((e) => {
            if (active === e.innerText)
                e.classList.add("active-link")
            else
                e.classList.remove("active-link")
        });
    }
});









