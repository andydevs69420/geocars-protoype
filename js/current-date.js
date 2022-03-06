const getDate = () => {

    let date = new Date(Date.now());
    let mm = date.getMonth();
    mm = ((mm+1) < 10)? `0${(mm+1)}` : mm;
    let dd = date.getDate();
    dd = (dd < 10)? `0${dd}` : dd;
    let yy = date.getFullYear();
    return `${yy}-${mm}-${dd}`;

}