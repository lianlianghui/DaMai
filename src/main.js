// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import store from './store'
import Min from 'mint-ui'
import VueResource from 'vue-resource'
import 'mint-ui/lib/style.css'
import './assets/css/mui.min.css'
import './assets/css/style.css'

var APIUrl = 'http://localhost:99'
Vue.use(Min)
Vue.use(VueResource)

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  APIUrl,
  template: '<App/>',
  components: { App }
})
