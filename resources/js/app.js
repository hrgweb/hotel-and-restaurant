import './bootstrap'

import { createApp } from 'vue/dist/vue.esm-bundler'
import PrimeVue from 'primevue/config'
// import TheApp from '@/TheApp.vue'

import 'primevue/resources/themes/aura-light-green/theme.css'
import 'primeicons/primeicons.css'
import 'primeflex/primeflex.css'

import Button from 'primevue/button'
import InputText from 'primevue/inputtext'
import FileUpload from 'primevue/fileupload'
import Message from 'primevue/message'

import CategoryPage from '@/category/index.vue'

const app = createApp({
  components: {
    CategoryPage,
  },
})
app.use(PrimeVue)
app.component('Button', Button)
app.component('InputText', InputText)
app.component('FileUpload', FileUpload)
app.component('Message', Message)
app.mount('#app')
