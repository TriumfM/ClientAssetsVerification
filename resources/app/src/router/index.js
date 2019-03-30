import Vue from 'vue'
import Router from 'vue-router'

import LoadingView from '@/components/Loading-view'
import HelloWorld from '@/components/HelloWorld'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'HelloWorld',
      component: LoadingView
    }
  ]
})
