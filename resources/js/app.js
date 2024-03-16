import './bootstrap'

import { createApp } from 'vue/dist/vue.esm-bundler'
import { createPinia } from 'pinia'
import PrimeVue from 'primevue/config'

import 'primevue/resources/themes/aura-light-green/theme.css'
import 'primeicons/primeicons.css'
import 'primeflex/primeflex.css'

import Button from 'primevue/button'
import InputText from 'primevue/inputtext'
import FileUpload from 'primevue/fileupload'
import Message from 'primevue/message'
import Dialog from 'primevue/dialog'

import CategoryPage from '@/domain/category/index.vue'

const pinia = createPinia()
const app = createApp({
  components: {
    CategoryPage,
  },
})
app.use(pinia)
app.use(PrimeVue)
app.component('Button', Button)
app.component('InputText', InputText)
app.component('FileUpload', FileUpload)
app.component('Message', Message)
app.component('Dialog', Dialog)
app.mount('#app')
