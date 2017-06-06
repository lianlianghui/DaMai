import Vue from 'vue'
import Router from 'vue-router'
import Hello from '@/components/Hello'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Hello',
      component: Hello
    },
    {
      path: '/category',
      name: 'category',
      component: require('../views/category')
    },
    {
      path: '/find',
      name: 'find',
      component: require('../views/find')
    },
    {
      path: '/mine',
      name: 'mine',
      component: require('../views/mine')
    }
  ]
})
