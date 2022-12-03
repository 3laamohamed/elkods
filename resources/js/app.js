require('./bootstrap');

// import bootstrap from "bootstrap";
import "bootstrap/dist/css/bootstrap.css";
import { createApp } from 'vue'
import Welcome from './components/Welcome'
import info from './components/info'
import locations from './components/locations'
import customers from './components/customers'
import customer_price from './components/customer_price'

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';


const app = createApp({})
app.use(VueSweetalert2);
app.component('welcome', Welcome)
app.component('info', info)
app.component('locations', locations)
app.component('customers', customers)
app.component('customer_price', customer_price)

app.mount('#app')
