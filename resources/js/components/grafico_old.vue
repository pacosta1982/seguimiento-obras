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
  plugins: [ChartDataLabels],
  data: () => ({
    options: {
options: {
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

    // Core options
    aspectRatio: 5 / 3,
    layout: {
      padding: {
        top: 32,
        right: 16,
        bottom: 16,
        left: 8
      }
    },
    elements: {
      line: {
        fill: false
      }
    },
    scales: {
      yAxes: [{
        stacked: true
      }]
    }
  }
      }
  }),

  mounted () {
      //console.log(this.label);
    this.renderChart({
      labels: this.label,
      datasets: [{
      backgroundColor: 'red',
      borderColor: 'red',
      data: this.values,
      datalabels: {
        align: 'start',
        anchor: 'start'
      }
    }]
    }, this.options)
  }
}

</script>
