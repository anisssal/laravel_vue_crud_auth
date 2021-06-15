import {createWebHistory, createRouter} from 'vue-router';

const routes = [
    {
        path: '/employees',
        name: 'employee.index',
        component: () => import("../views/employee/Index.vue"),
    },
    {
        path: '/employe/create',
        name: 'employee.create',
        component: () => import("../views/employee/CreateEdit.vue")
    },
    {
        path: '/employe/:id',
        name: 'employee.edit',
        component: () => import("../views/employee/CreateEdit.vue")
    },
    {   path: '/login',
        name: 'login',
        component: ()=>import("../views/Login.vue"),
        // props : {auth : auth}
    },
    {   path: '/',
        name: 'home',
            component: ()=>import("../views/Home.vue"),
        // props : {auth : auth}
    },
    {   path: '/:pathMatch(.*)*',
        name: 'notfound',
        component: ()=>import("../views/NotFound.vue")
    }

]

const router = createRouter(
    {
        history: createWebHistory(),
        routes
    })

export default router;