import $ from 'jquery';
import Highcharts from "highcharts";

class HomeApp {

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

        if (series[1]) {
            series[1].color = 'green';
            series[1].name = this.$wrapper.data('title-serie1');
            series[1].type = 'spline';
        }

        Highcharts.chart(
            this.$wrapper.prop('id'),
            {
                chart: {
                    type: 'column',
                    zoomType: 'x'
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
                    title: {
                        text: this.$wrapper.data('title-yaxis')
                    },
                    min: 0
                },
                tooltip: {
                    headerFormat: '<b>{series.name}</b><br>',
                    pointFormat: '{point.x:%e. %b}: {point.y:.f} km'
                },
                plotOptions: {
                    series: {
                        dataLabels: {
                            enabled: true
                        },
                        marker: {
                            enabled: true
                        }
                    }
                },
                series: series
            }
        );

    }

}

export default HomeApp;
