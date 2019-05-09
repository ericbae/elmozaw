import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/Home'
import BuildForms from '@/components/BuildForms'
import SubmitForms from '@/components/SubmitForms'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home,
    },
    {
      // Path to handle adding of form and its associated elements
      path: '/forms/add',
      name: 'BuildForms',
      component: BuildForms,
    },
    {
      // path to view the details for 1 specific form and submit the forms
      path: '/forms/view/:formId',
      name: 'SubmitForms',
      component: SubmitForms,
    }
  ]
})
