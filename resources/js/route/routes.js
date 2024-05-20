import Vue from 'vue'
import VueRouter from 'vue-router'

// mengaktifkan vue router
Vue.use(VueRouter);

import dashboard from '../pages/dashboard.vue'
// vehicle
import index_vehicle from '../pages/vehicle/index.vue'
import create_vehicle from '../pages/vehicle/create.vue'
import edit_vehicle from '../pages/vehicle/edit.vue'
// user
import index_user from '../pages/user/index.vue'
import create_user from '../pages/user/create.vue'
import edit_user from '../pages/user/edit.vue'

const routes = [

    {
        name: 'Usuario',
        path: '/user',
        meta: 'Usuario',
        component: index_user,
        beforeEnter: (to, from, next) => {
            document.title = "ReBits - " + to.meta //sebelum masuk ubah title + meta di route
            next() // lanjutkan
        },
    },
    {
        name: 'create_user',
        path: '/user/create',
        meta: 'Crear Usuario',
        component: create_user,
        beforeEnter: (to, from, next) => {
            document.title = "ReBits - " + to.meta
            next()
        },
    },
    {
        name: 'edit_user',
        path: '/user/edit/:id',
        meta: 'Editar Usuario',
        component: edit_user,
        props: true,
        beforeEnter: (to, from, next) => {
            document.title = "ReBits - " + to.meta
            next()
        },
    },
    {
        name: 'vehicle',
        path: '/vehicle',
        meta: 'Vehículos',
        component: index_vehicle,
        beforeEnter: (to, from, next) => {
            document.title = "ReBits - " + to.meta
            next()
        },
    },
    {
        name: 'create_vehicle',
        path: '/vehicle/create',
        meta: ' Crear Vehículos',
        component: create_vehicle,
        beforeEnter: (to, from, next) => {
            document.title = "ReBits - " + to.meta
            next()
        },
    },
    {
        name: 'edit_vehicle',
        path: '/vehicle/edit/:id',
        meta: 'Editar Vehículos',
        component: edit_vehicle,
        props: true,
        beforeEnter: (to, from, next) => {
            document.title = "ReBits - " + to.meta
            next()
        },
    },
    {
        name: 'dashboard',
        path: '*',
        meta: 'Dashboard',
        component: dashboard,
        beforeEnter: (to, from, next) => {
            document.title = "ReBits - " + to.meta
            next()
        }
    },
]

const router = new VueRouter({
    LinkaAtiveClass: 'active',
    mode: 'history',
    routes
})


export default router
