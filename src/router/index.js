import Vue from 'vue'
import VueRouter from 'vue-router'

import HomePage from '../pages/homepage.vue'
import DetailPage from '../pages/detailpage.vue'
import SearchPage from '../pages/searchpage.vue'
import About  from '../pages/about.vue'
Vue.use(VueRouter);

const routes = [
    {path:'/',component:HomePage},
    {
        name:'DetailPage',
        path: '/detail/:id/:title/:dept/:pubtime/:viewer',
        component: DetailPage
    },
    {
        path:'/search',
        component:SearchPage
    },
    {
        path:'/about',
        component: About
    }
];
const router = new VueRouter({routes});
export default router;