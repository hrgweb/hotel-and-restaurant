import './bootstrap'

import { createApp } from 'vue/dist/vue.esm-bundler'
import PrimeVue from 'primevue/config'
// import TheApp from '@/TheApp.vue'

import 'primevue/resources/themes/aura-light-green/theme.css'
import 'primeicons/primeicons.css'
import 'primeflex/primeflex.css'

import Button from 'primevue/button'

const app = createApp({
  methods: {
    dashboard() {
      alert('here from the parent')
    },
  },
})
app.use(PrimeVue)
app.component('Button', Button)
app.mount('#app')
