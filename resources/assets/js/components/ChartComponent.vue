<template>
  <div>
    <highcharts :options="chartOptions"></highcharts>
  </div>
</template>

<script>
import {Chart} from 'highcharts-vue'
export default {
  props: ['title', 'label', 'source', 'cumulative', 'translation'],
  components: {
    highcharts: Chart
  },
  data() {
    return {
      chartOptions: {
        chart: {
          events: {
            load() {
              setTimeout(this.reflow.bind(this))
            }
          }
        },
        title: {
          text: this.title
        },
        subtitle: {
          text: 'Source: DIGIRARE.com'
        },
        xAxis: {
          type: 'datetime'
        },
        yAxis: this.cumulative === 'true' ? [{
          title: {
            text: this.label
          },
        },{
          title: {
            text: this.translation
          },
          opposite: true
        }] : {
          title: {
            text: this.label
          },
        },
        tooltip: {
          shared: true
        },
        credits: {
          enabled: false
        },
        series: []
      }
    }
  },
  mounted() {
    this.$_chart_update()
  },
  methods: {
    $_chart_update() {
      var api = this.source
      var self = this
      $.get(api, function (data) {
        self.chartOptions.series.push({
          name: self.label,
          data: data.data,
          yAxis: 0,
          zIndex: 2,
        })
        if (self.cumulative === 'true') {
          self.chartOptions.series.push({
            name: self.translation,
            yAxis: 1,
            zIndex: 1,
            data: self.$_chart_accumulate(data.data),
          })
        }
      })
    },
    $_chart_accumulate(data) {
      var accumulation = new Array()
      var runningTotal = 0
      var i = 0
      for (i = 0; i < data.length; i++) {
        runningTotal += data[i][1]
        accumulation.push([data[i][0], runningTotal])
      }
      return accumulation
    }
  },
}
</script>