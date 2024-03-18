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
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import IconField from 'primevue/iconfield'
import InputIcon from 'primevue/inputicon'
import ConfirmPopup from 'primevue/confirmpopup'
import ConfirmationService from 'primevue/confirmationservice'
import Toast from 'primevue/toast'
import ToastService from 'primevue/toastservice'

import CategoryPage from '@/domain/category/index.vue'
import ProductPage from '@/domain/product/index.vue'

const pinia = createPinia()
const app = createApp({
  components: {
    CategoryPage,
    ProductPage,
  },
})
app.use(pinia)
app.use(PrimeVue)
app.use(ConfirmationService)
app.use(ToastService)
app.component('Button', Button)
app.component('InputText', InputText)
app.component('FileUpload', FileUpload)
app.component('Message', Message)
app.component('Dialog', Dialog)
app.component('DataTable', DataTable)
app.component('Column', Column)
app.component('IconField', IconField)
app.component('InputIcon', InputIcon)
app.component('ConfirmPopup', ConfirmPopup)
app.component('Toast', Toast)
app.mount('#app')
