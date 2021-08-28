<script>

import { Line } from 'vue-chartjs'
import ChartDataLabels from 'chartjs-plugin-datalabels';

export default {
  extends: Line,
  props: {
        label: {
            type: Array
        },
        values: {
            type: Array
        }
    },
  name: "grafico",
  data: () => ({
    options: {
      responsive: true,
      maintainAspectRatio: false,
      legend: {
                display:true,
                position: 'bottom',
                labels: {
                    fontColor:  '#000'
                }
            },
     /*tooltips: {
            callbacks: {
                labelColor: function(tooltipItem, chart) {
                    return {
                        borderColor: 'rgb(255, 0, 0)',
                        backgroundColor: 'rgb(255, 0, 0)'
                    };
                },
                labelTextColor: function(tooltipItem, chart) {
                    return '#543453';
                }
            }
        },*/
plugins: {
      datalabels: {
        backgroundColor: function(context) {
          return context.dataset.backgroundColor;
        },
        borderRadius: 4,
        color: 'white',
        font: {
          weight: 'bold'
        },
        formatter: Math.round,
        padding: 6
      }
    },
      tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var label = data.datasets[tooltipItem.datasetIndex].label || '';
                    var value = tooltipItem.value;
                    console.log(tooltipItem.value);
                    /*if (label) {
                        label += ': ';
                    }
                    label += Math.round(tooltipItem.yLabel * 100) / 100;*/
                    return label + ' ' + value + ' %';
                }
            }
        },
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
                            return  'visita ' + value;
                        }
                    }
                }]
            }
    }
  }),

  mounted () {
      //console.log(this.label);
    this.renderChart({
      labels: this.label,
      datasets: [
        {
          label: 'Avance',
          borderColor: 'red',
          backgroundColor: 'red',
          fill: false,
          data: this.values,
      datalabels: {
        align: 'start',
        anchor: 'start'
      }
        },

      ]
    }, this.options)
  }
}

</script>
