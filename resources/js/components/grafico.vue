<script>

import { Line } from 'vue-chartjs'

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
      console.log(this.label);
    this.renderChart({
      labels: this.label,
      datasets: [
        {
          label: 'Avance',
          borderColor: 'red',
          backgroundColor: 'red',
          fill: false,
          data: this.values
        }
      ]
    }, this.options)
  }
}

</script>
