import Chart from 'chart.js';
import $ from 'jquery';

import '../scss/home.scss';

$(function () {

});

const ctx = document.getElementById('primaryChart').getContext('2d');

new Chart(
    ctx,
    {
        type: 'line',
        data: {
            datasets: [
                {
                    label: 'Real values',
                    data: [
                        1000, 2000, 12000, 13000, 14000, 24000, 25000, 26000, 36000, 37000, 38000, 48000,
                        49000, 50000, 60000, 61000, 62000, 72000
                    ],
                    backgroundColor: 'transparent',
                    borderColor: 'green',
                    borderWidth: 1,
                    lineTension: 0
                },
                {
                    label: 'Forecast values',
                    data: [
                        50, null, null, null, null, null, null, null, null, null, null, null,
                        null, null, null, null, null, null, null, null, null, null, null, 120000
                    ],
                    backgroundColor: 'transparent',
                    borderColor: 'red',
                    borderWidth: 1,
                    spanGaps: true
                }
            ],
            labels: [
                'Jan 18', 'Feb 18', 'Mar 18', 'Apr 18', 'May 18', 'Jun 18', 'Jul 18', 'Aug 18', 'Sep 18', 'Oct 18', 'Nov 18', 'Dec 18',
                'Jan 19', 'Feb 19', 'Mar 19', 'Apr 19', 'May 19', 'Jun 19', 'Jul 19', 'Aug 19', 'Sep 19', 'Oct 19', 'Nov 19', 'Dec 19'
            ]
        },
        options: {
            scales: {
                yAxes: [
                    {
                        ticks: {
                            beginAtZero: true
                        }
                    }
                ]
            }
        }
    }
);
