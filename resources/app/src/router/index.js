import Vue from 'vue'
import Router from 'vue-router'

import LoadingView from '@/components/Loading-view'

import AppView from '@/main/AppView'

import LoginView from '@/main/login/LoginComponent'
import ClientComponent from '@/main/clients/ClientsComponent'
import BrandsComponent from '@/main/brands/BrandsComponent'
import CampaignsComponent from '@/main/campaigns/CampaignsComponent'
import CampaignDetails from '@/main/campaigns/CampaignDetails'
import CampaignDetailsCall from '@/main/campaigns/details/call'
import CampaignDetailsSms from '@/main/campaigns/details/sms'
import CampaignDetailsEmail from '@/main/campaigns/details/email'
import CampaignDetailsData from '@/main/campaigns/details/detailsData'
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
          component: CampaignsComponent,
          children: [
            {
              path: '/campaigns/data',
              name: 'campaigns-data',
              component: CampaignDetailsData
            },
            {
              path: '/campaigns/sms',
              name: 'campaigns-sms',
              component: CampaignDetailsSms
            },
            {
              path: '/campaigns/call',
              name: 'campaigns-call',
              component: CampaignDetailsCall
            },
            {
              path: '/campaigns/email',
              name: 'campaigns-email',
              component: CampaignDetailsEmail
            }
          ]
        },
        {
          path: '/campaign/details',
          name: 'CampaignDetails',
          component: CampaignDetails
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
