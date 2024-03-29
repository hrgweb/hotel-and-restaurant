import './bootstrap'

import { createApp } from 'vue/dist/vue.esm-bundler.js'
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
import Dropdown from 'primevue/dropdown'
import InputSwitch from 'primevue/inputswitch'
import Badge from 'primevue/badge'
import RadioButton from 'primevue/radiobutton'
import Calendar from 'primevue/calendar'
import Card from 'primevue/card'
import TabView from 'primevue/tabview'
import TabPanel from 'primevue/tabpanel'
import Avatar from 'primevue/avatar'
import InputNumber from 'primevue/inputnumber'
import ButtonGroup from 'primevue/buttongroup'

// Pages
import CategoryPage from './domain/category/index.vue'
import ProductPage from './domain/product/index.vue'
import TablePage from './domain/table/index.vue'
import UserRolePage from './domain/role/index.vue'
import StaffPage from './domain/staff/index.vue'
import AppHeader from './domain/AppHeader.vue'
import AppNavbar from './domain/AppNavbar.vue'
import PosPage from './domain/pos/index.vue'

const pinia = createPinia()
const app = createApp({})

app.component('AppHeader', AppHeader)
app.component('AppNavbar', AppNavbar)
app.component('CategoryPage', CategoryPage)
app.component('ProductPage', ProductPage)
app.component('TablePage', TablePage)
app.component('StaffPage', StaffPage)
app.component('UserRolePage', UserRolePage)
app.component('PosPage', PosPage)

app.use(pinia)
app.use(PrimeVue, { ripple: true })
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
app.component('Dropdown', Dropdown)
app.component('InputSwitch', InputSwitch)
app.component('Badge', Badge)
app.component('RadioButton', RadioButton)
app.component('Calendar', Calendar)
app.component('Card', Card)
app.component('TabView', TabView)
app.component('TabPanel', TabPanel)
app.component('Avatar', Avatar)
app.component('InputNumber', InputNumber)
app.component('ButtonGroup', ButtonGroup)
app.mount('#app')
