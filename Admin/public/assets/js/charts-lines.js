/**
 * For usage, visit Chart.js docs https://www.chartjs.org/docs/latest/
 */
const lineConfig = {
  type: 'line',
  data: {
    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
    datasets: [
      {
        label: '<$10000',
        /**
         * These colors come from Tailwind CSS palette
         * https://tailwindcss.com/docs/customizing-colors/#default-color-palette
         */
        backgroundColor: '#FF76CE',
        borderColor: '#FF76CE',
        data: [43, 48, 40, 54, 67, 73, 70, 62, 84, 89, 35, 73, 31],
        fill: false,
      },
      {
        label: '>$10000',
        fill: false,
        /**
         * These colors come from Tailwind CSS palette
         * https://tailwindcss.com/docs/customizing-colors/#default-color-palette
         */
        backgroundColor: '#40A2D8',
        borderColor: '#40A2D8',
        data: [24, 50, 64, 74, 52, 51, 65, 10, 45, 89, 25, 64, 77],
      },
    ],
  },
  options: {
    responsive: true,
    /**
     * Default legends are ugly and impossible to style.
     * See examples in charts.html to add your own legends
     *  */
    legend: {
      display: false,
    },
    tooltips: {
      mode: 'index',
      intersect: false,
    },
    hover: {
      mode: 'nearest',
      intersect: true,
    },
    scales: {
      x: {
        display: true,
        scaleLabel: {
          display: true,
          labelString: 'Month',
        },
      },
      y: {
        display: true,
        scaleLabel: {
          display: true,
          labelString: 'Value',
        },
      },
    },
  },
}

// change this to the id of your chart element in HMTL
const lineCtx = document.getElementById('line')
window.myLine = new Chart(lineCtx, lineConfig)
