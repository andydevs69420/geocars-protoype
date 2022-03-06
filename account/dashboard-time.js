
var ctx;
var dash;

$(document).ready((e) => {
    ctx  = document.getElementById("dash-data");
    dash = new Chart(ctx, {
        type: "doughnut",
        data: {
            labels: ["Remaining" , "Consumed"],
            datasets: [{
                label: "Remaining dashboard time",
                data: [100 , 56],
                backgroundColor: [
                    "#72f7f3",
                    "rgba(173, 53, 186, 1)",
                ],
                borderColor: [
                    "#72f7f3",
                    "rgba(173, 53, 186, 1)",
                ],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false
                },
            },
            cutout: "85%",
            responsive: true,

        }
    });
});


function setUsage(percentage) {
    let consumed = 100 - percentage;
    dash.data.datasets[0].data = [consumed,percentage];
    dash.update();
}