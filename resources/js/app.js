require('./bootstrap');

// import bootstrap from "bootstrap";
import "bootstrap/dist/css/bootstrap.css";
import { createApp } from 'vue'
import Welcome from './components/Welcome'
import info from './components/info'
import locations from './components/locations'
import customers from './components/customers'
import customer_price from './components/customer_price'
import milk_supply from './components/milk_supply'
import customer_money from './components/customer_money'
import customer_borrow from './components/customer_borrow'
import follow_suppliers from './components/follow_suppliers'
import pending_periods from './components/pending_periods'
import products from './components/products'
import sales from './components/sales'

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';


const app = createApp({})
app.use(VueSweetalert2);
app.component('welcome', Welcome)
app.component('info', info)
app.component('locations', locations)
app.component('customers', customers)
app.component('customer_price', customer_price)
app.component('milk_supply', milk_supply)
app.component('customer_money', customer_money)
app.component('customer_borrow', customer_borrow)
app.component('follow_suppliers', follow_suppliers)
app.component('pending_periods', pending_periods)
app.component('products', products)
app.component('sales', sales)

app.mount('#app')
