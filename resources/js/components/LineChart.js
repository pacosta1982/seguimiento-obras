import { Line } from 'vue-chartjs'

export default {
    extends: Line,
    props: {
        label: {
            type: Array
        }
    },
    data: () => ({
        chartdata: {
            labels: this.label,
            datasets: [
                {
                    label: 'Visitas',
                    borderColor: 'red',
                    //backgroundColor: Utils.transparentize(Utils.CHART_COLORS.red, 0.5),
                    fill: false,
                    data: [0, 20, 30, 55,65, 70, 75]
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            title: {
                display: true,
                text: '% De Avance por Visitas'
            },
            scales: {
                yAxes: [{
                    ticks: {
                        // Include a dollar sign in the ticks
                        callback: function(value, index, values) {
                            return  value + ' %';
                        }
                    }
                }],
                xAxes: [{
                    ticks: {
                        // Include a dollar sign in the ticks
                        callback: function(value, index, values) {
                            return  'v ' + value;
                        }
                    }
                }]
            }
        }
    }),

    mounted() {
        this.renderChart(this.chartdata, this.options)
    }
}
