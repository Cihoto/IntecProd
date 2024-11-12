// using chart.js to render the chart
// This file is used to render the chart on the page
// The chart is rendered using the chart.js library




// Get the context of the canvas element we want to select
const ctx = document.getElementById('myChart').getContext('2d');

// window.onload = function () {
//     renderChart();

// }


function setChartData(chartData) {

    let labels = [];
    let data = [];
    let data2 = [];

    chartData.forEach(({ month, totalEventCount, totalMonthIncome }) => {
        labels.push(month);
        data.push(totalEventCount);
        data2.push(totalMonthIncome);
    });

    return {
        labels: labels,
        data: data,
        data2: data2
    };

}



// Function to render the chart
// renderChart function is used to render the chart on the page
// using the chart.js library
// The chart is rendered using the data passed to the function
// and formatted on setChartData function
function renderChart(data) {

    console.log('data', data);

    // data.data2 = [100, 12, 32, 43, 54, 65, 76, 87, 98, 109, 120, 131]


    const labels = data.labels;
    const dataConfig = {
        labels: labels,
        datasets: [
            {
                label: 'Eventos',
                data: data.data,
                stack: 'combined',
                type: 'bar',
                yAxisID: 'events',
                backgroundColor: 'white',
                order: 1
            },
            {
                label: 'Ingresos',
                data: data.data2,
                stack: 'combined',
                yAxisID: 'y',
                yAxisID: 'income',
                tension: 0.4,
                borderColor: 'purple',
                order:0
            }
        ]
    };


    let delayed;
    var myChart = new Chart(ctx, {
        type: 'line',
        data: dataConfig,
        options: {
            barThickness: 15,
            responsive: false,
            maintainAspectRatio: false,
            elements:{
                bar:{
                    borderRadius: 100,
                    borderSkipped: false,
                }
            },
            animation: {
                onComplete: () => {
                    delayed = true;
                },
                delay: (context) => {
                    let delay = 0;
                    if (context.type === 'data' && context.mode === 'default' && !delayed) {
                        delay = context.dataIndex * 220 + context.datasetIndex * 75;
                    }
                    return delay;
                },
            },

            plugins: {
                title: {
                    display: true,
                    text: 'Eventos e Ingresos por mes',
                    color: 'white',
                }
            },
            scales: {
                x:{
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: 'white',
                    }
                },
                events: {
                    type: 'linear',
                    position: 'left',
                    grid:{
                        display: false
                    },
                    ticks: {
                        color: 'white',
                    },
                },
                income: {
                    type: 'linear',
                    position: 'right',
                    grid: {
                        drawOnChartArea: false, // only want the grid lines for one axis to show up
                        display: false
                    },
                    ticks: {
                        // Include a dollar sign in the ticks
                        callback: function(value, index, ticks) {
                            return formatExes(value);
                        },
                        color:'white'
                    },
                }
            }
        }
    });

}



function formatExes(value) {
    value /= 1000_000;
    return `${Math.floor(value)}M`;
}
