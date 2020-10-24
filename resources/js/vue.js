import Hello from './components/Hello'
import Payment from './components/Payment'

const Vue = require('vue')

Vue.component('hello', Hello)
Vue.component('payment', Payment)

new Vue({
  el: '#app'
})
