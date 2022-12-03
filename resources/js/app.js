require('./bootstrap');

// import bootstrap from "bootstrap";
import "bootstrap/dist/css/bootstrap.css";
import { createApp } from 'vue'
import Welcome from './components/Welcome'
import info from './components/info'
import locations from './components/locations'
import customers from './components/customers'

const app = createApp({})

app.component('welcome', Welcome)
app.component('info', info)
app.component('locations', locations)
app.component('customers', customers)

app.mount('#app')
