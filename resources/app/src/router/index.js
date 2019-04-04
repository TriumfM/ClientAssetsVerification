import Vue from 'vue'
import Router from 'vue-router'


import LoadingView from '@/components/Loading-view'

import AppView from '@/main/AppView'

import LoginView from '@/main/login/LoginComponent'
import ClientComponent from '@/main/clients/ClientsComponent'
import BrandsComponent from '@/main/brands/BrandsComponent'
import CampaignsComponent from '@/main/campaigns/CampaignsComponent'
import UsersComponent from '@/main/users/UsersComponent'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'loading',
      component: LoadingView
    },
    {
      path: '/app',
      name: 'app-view',
      component: AppView,
      children: [
        {
          path: '/clients',
          name: 'clients',
          component: ClientComponent
        },
        {
          path: '/brands',
          name: 'brands',
          component: BrandsComponent
        },
        {
          path: '/users',
          name: 'users',
          component: UsersComponent
        },
        {
          path: '/campaigns',
          name: 'campaigns',
          component: CampaignsComponent
        }
      ]
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView
    },
    {
      path: '*',
      redirect: '/app',

    },
  ]
})
