import $ from 'jquery';
import Highcharts from "highcharts";

class HomeAppGap {

    constructor($wrapper) {

        this.$wrapper = $wrapper;

        this.loadSeries();

    }

    loadSeries() {

        let url = this.$wrapper.data('url');

        $.ajax({
            url: url,
            method: 'GET',
            success: (data) => {
                let series = this.buildSeries(data);
                this.buildChart(series);
            },
            error: () => {
                window.alert('An error has occured.');
            }
        });

    }

    buildSeries(data) {

        let series = [];

        data.forEach((serie, s) => {
            series[s] = {data: []};
            for (let date in serie.data) {
                if (!serie.data.hasOwnProperty(date)) {
                    continue;
                }
                series[s].data.push([Date.parse(date), serie.data[date]]);
            }
        });

        return series;

    }

    buildChart(series) {

        series[0].color = 'blue';
        series[0].name = this.$wrapper.data('title-serie0');

        Highcharts.chart(
            this.$wrapper.prop('id'),
            {
                chart: {
                    type: 'spline'
                },
                legend: {
                    enabled: false
                },
                title: false,
                xAxis: {
                    type: 'datetime',
                    dateTimeLabelFormats: {
                        year: '%d %b %Y'
                    },
                    title: {
                        text: this.$wrapper.data('title-xaxis')
                    }
                },
                yAxis: {
                    plotLines: [
                        {
                            color: 'red',
                            value: 0,
                            width: 3
                        }
                    ],
                    title: {
                        text: this.$wrapper.data('title-yaxis')
                    }
                },
                tooltip: {
                    headerFormat: '<b>{series.name}</b><br>',
                    pointFormat: '{point.x:%e. %b}: {point.y:.f} km'
                },
                plotOptions: {
                    series: {
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                series: series
            }
        );

    }

}

export default HomeAppGap;
