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
          type: 'bar',
        },
        plotOptions: {
          bar: {
            horizontal: true,
            endingShape: 'rounded',
            borderRadius: 4,
            distributed: true,
            dataLabels: {
              position: 'top',
            },
          },
        },
        dataLabels: {
          formatter: (val) => {
            return 'S/ ' +  val.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
          },
          offsetX: 40,
          style: {
            fontSize: '9px',
            colors: ['blue'],
          },
        },
        legend: {
          show: true,
          position: 'left',
          horizontalAlign: 'left',
          fontSize: '8px',
        },
        xaxis: {
          categories: this.categories,
        },
        yaxis: {
          labels: {
            show: false
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
