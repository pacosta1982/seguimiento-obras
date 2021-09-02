<script>

import { Bar } from 'vue-chartjs'
import ChartDataLabels from 'chartjs-plugin-datalabels';

export default {
  extends: Bar,
  /*props: {
        label: {
            type: Array
        },
        values: {
            type: Array
        }
    },*/
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

      /*tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var label = data.datasets[tooltipItem.datasetIndex].label || '';
                    var value = tooltipItem.value;
                    console.log(tooltipItem.value);
                    /*if (label) {
                        label += ': ';
                    }
                    label += Math.round(tooltipItem.yLabel * 100) / 100;*
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
            }*/
    }
  }),

  mounted () {
      //console.log(this.label);
    this.renderChart({
      labels: ['CONCEPCION', 'SAN PEDRO', 'CORDILLERA', 'GUAIRA', 'CAAGUAZU', 'CAAZAPA', 'ITAPUA',
        'MISIONES', 'PARAGUARI', 'ALTO PARANA', 'CENTRAL', 'ÑEEMBUCU', 'AMAMBAY', 'CANINDEYU', 'PTE. HAYES'
        , 'BOQUERON', 'ALTO PARAGUAY'],
      datasets: [
    {
      label: 'A Iniciar',
      data: [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0],
      borderColor: '#F6F454',
      backgroundColor: '#F6F454',
    },
    {
      label: 'En Ejecución',
      data: [0,160,24,0,34,0,0,0,28,111,12,0,73,0,0,102,5],
      borderColor: '#1FDC61',
      backgroundColor: '#1FDC61',
    },
    {
      label: 'Paralizado',
      data: [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
      borderColor: '#F86F5F',
      backgroundColor: '#F86F5F',
    },
  ]
    }, this.options)
  }
}

</script>
