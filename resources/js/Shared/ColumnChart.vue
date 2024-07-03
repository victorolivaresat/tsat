<template>
  <apexchart :options="chartOptions" :series="series" />
</template>

<script>
import VueApexCharts from 'vue3-apexcharts'

export default {
  components: {
    apexchart: VueApexCharts,
  },
  props: {
    seriesData: {
      type: Array,
      required: true
    },
    categories: {
      type: Array,
      required: true
    },
  },
  data() {
    return {
      chartOptions: {
        chart: {
          height: 350,
          type: 'area'
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '50%',
            endingShape: 'rounded',
            borderRadius: 4,
            dataLabels: {
              position: 'top',
            },
          },
        },
        dataLabels: {
          enabled: false,
        },
        stroke: {
          curve: 'smooth',
        },
        xaxis: {
          categories: this.categories,
        },
        yaxis: {
          labels: {
            formatter: val => val.toFixed(2),
          }
        },
        fill: {
          opacity: 1,
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return "S/ " + val.toFixed(2);
            },
          },
        },
      },
      series: [
        {
          name: 'Amount',
          data: this.seriesData,
        },
      ],
    }
  },
  watch: {
    seriesData(newVal) {
      this.series[0].data = newVal;
    },
    categories(newVal) {
      this.chartOptions.xaxis.categories = newVal;
    }
  }
}
</script>
