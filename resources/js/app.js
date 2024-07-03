import './bootstrap';
import '../css/app.css'

import { createApp, h } from 'vue'
import VueApexCharts from "vue3-apexcharts";
import { createInertiaApp } from '@inertiajs/vue3'


createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    return pages[`./Pages/${name}.vue`]
  },
  title: title => title ? `${title} - Teleservicios` : 'Teleservicios',
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(VueApexCharts)
      .mount(el)
  },
})
