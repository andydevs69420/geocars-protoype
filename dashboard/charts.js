Chart.defaults.font.size = 10;


var chart0 , mychart0;

var chart1 , mychart1;

$(document).ready((e) => {

    /********************** chart 0 **********************/
    chart0 = document.getElementById("car-tally-chart");
    mychart0 = new Chart(chart0, {
        type: "doughnut",
        data: {
            labels: ["available" , "unavailabel"],
            datasets: [{
                label: "Vehicle Status",
                data: [-1, -1],
                backgroundColor: [
                    "rgba(173, 53, 186, 1)",
                    "#72f7f3",
                ],
                borderColor: [
                    "rgba(173, 53, 186, 1)",
                    "#72f7f3",
                ],
                borderWidth: 1
            }]
        },
        options: {
            cutout: "85%",
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                } ,
            },
        }
    });

    chart1 = document.getElementById('profit-chart').getContext("2d");
    const gradientStroke = chart1.createLinearGradient(500, 0, 100, 0);
    gradientStroke.addColorStop(0, '#80b6f4');
    gradientStroke.addColorStop(1, '#f49080');

    const gradientFill = chart1.createLinearGradient(0,0,0,290);
    gradientFill.addColorStop(0, "rgba(173, 53, 186, 1)");
    gradientFill.addColorStop(1, "rgba(173, 53, 186, 0.1)");

    mychart1 = new Chart(chart1, {
        type: "line",
        data: {
            labels: getLastMonths(5),
            datasets: [{
                label: "Profit",
                fill: true,
                backgroundColor: gradientFill,
                borderWidth: 1,
                data: [0, 0, 0, 0, 0],
                
            }]
        },
        options: {
            tension: 0.4,
            responsive: true,
            maintainAspectRatio: false,
            plugins:{
                title: {
                    display: true,
                    text: "Monthly profit",
                    font: {
                        size: 14
                    }
                },
                legend: {
                    display: false,
                },
            }, 
            scales: {
                x : {
                    grid: {
                        display: false
                    }
                },
                y : {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });


});

/********************** chart 1 **********************/


let MONTHS = [
    "JAN","FEB","MAR",
    "APR","MAY","JUN",
    "JUL","AUG","SEP",
    "OCT","NOV","DEC",
];

function getLastMonths(prev) {

    let mIndex = new Date(Date.now()).getMonth();
    let start  = (MONTHS.length-1) - mIndex;
    let end    = (start - (prev-1));
    let lastmonths = [];

    for (let idx = start;idx > end ;idx--) {
        lastmonths.push(MONTHS[idx]);
    }

    lastmonths = lastmonths.reverse();

    for (let idx = 0; idx < (mIndex+1);idx++) {
        lastmonths.push(MONTHS[idx]);
    }

    return lastmonths;

}

function updateCarStatus(avail,unavail) {
    mychart0.data.datasets[0].data = [avail,unavail];
    mychart0.update();
}



function updateMonthlyProfit(data_map) {

    let date = new Date(getDate());
    let keys = Object.keys(data_map);
    let vals = [];
    let new_month = [];
    let old_month = [];

    for (let idx = 0; idx < keys.length;idx++) {
        if (keys[idx] <= date.getMonth()) {
            new_month.push(keys[idx]);
        }
        else {
            old_month.push(keys[idx]);
        }
    }

    old_month = old_month.concat(new_month);
    keys = old_month;
    

    for (let kidx = 0; kidx < keys.length;kidx++) {
        vals.push(data_map[keys[kidx]]);
        keys[kidx] = MONTHS[keys[kidx]];
    }



    mychart1.data.labels = keys;
    mychart1.data.datasets[0].data = vals;
    mychart1.update();
}