import { createRouter, createWebHistory } from 'vue-router'
import NProgress from 'nprogress'
import 'nprogress/nprogress.css'

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    linkActiveClass: 'active',

    routes: [
        //public route
        {
            path: '/:catchAll(.*)',
            redirect: '/',
        },
        {
            path: '/',
            name: 'loginpage',
            component: () => import('../views/public/index.vue'),
            meta: {
                guest: true,
            }
        },

        //admin route
        {
            path:'/admin',
            component: () => import('../views/auth/admin/index.vue'),
            props: true,
            meta: {
                requiredAdmin: true
            },
            children: [
                {
                    path:'',
                    name: 'admindashboard',
                    component: () => import('../views/auth/admin/dashboard/index.vue'),
                    meta: { exact: true } 
                },
                {
                    path:'/admin/roles',
                    name: 'roleadmin',
                    component: () => import('../views/auth/admin/roles/index.vue'),
                    meta: { exact: true },
                    children: [
                        {
                            path:'/admin/roles/create',
                            name: 'roleadmincreate',
                            component: () => import('../components/auth/admin/create/createRoleComponent.vue'),
                        },
                        {
                            path:'/admin/roles/update/:id',
                            name: 'roleadminupdate',
                            component: () => import('../components/auth/admin/update/updateRoleComponent.vue'),
                        },
                    ]
                },
                {
                    path:'/admin/users',
                    name: 'useradmin',
                    component: () => import('../views/auth/admin/users/index.vue'),
                    meta: { exact: true },
                    children: [
                        {
                            path:'/admin/users/create',
                            name: 'useradmincreate',
                            component: () => import('../components/auth/admin/create/createUserComponent.vue'),
                        },
                        {
                            path:'/admin/users/update/:id',
                            name: 'useradminupdate',
                            component: () => import('../components/auth/admin/update/updateUserComponent.vue'),
                        },
                    ]
                },
                {
                    path:'/admin/category',
                    name: 'categoryadmin',
                    component: () => import('../views/auth/admin/category/index.vue'),
                    meta: { exact: true } ,
                    children: [
                        {
                            path:'/admin/category/create',
                            name: 'categoryadmincreate',
                            component: () => import('../components/auth/admin/create/createCategoryComponent.vue'),
                        },
                        {
                            path:'/admin/category/update/:id',
                            name: 'categoryadminupdate',
                            component: () => import('../components/auth/admin/update/updateCategoryComponent.vue'),
                        },
                    ]
                },
                {
                    path:'/admin/expenses',
                    name: 'expenseadmin',
                    component: () => import('../views/auth/admin/expenses/index.vue'),
                    meta: { exact: true } ,
                    children: [
                        {
                            path:'/admin/expenses/create',
                            name: 'expensesadmincreate',
                            component: () => import('../components/auth/admin/create/createExpensesComponent.vue'),
                        },
                        {
                            path:'/admin/expenses/update/:id',
                            name: 'expensesadminupdate',
                            component: () => import('../components/auth/admin/update/updateExpensesComponent.vue'),
                        },
                    ]
                },
                {
                    path:'/admin/profile',
                    name: 'profileadmin',
                    component: () => import('../views/auth/admin/profile/index.vue'),
                    children: [
                        {
                            path:'/admin/profile/password/update',
                            name: 'expenseadminupdatepassword',
                            component: () => import('../components/auth/admin/update/updatePasswordComponent.vue'),
                        },
                    ]
                  },
            ]
        },

        //user route
        {
            path: '/users',
            component: () => import('../views/auth/user/index.vue'),
            meta: {
                requiredUser: true
            },
            children: [
                {
                    path:'',
                    name: 'userdashboard',
                    component: () => import('../views/auth/user/dashboard/index.vue'),
                    meta: { exact: true } 
                },
                {
                    path:'/user/profile',
                    name: 'profileuser',
                    component: () => import('../views/auth/user/profile/index.vue'),
                    children: [
                        {
                            path:'/user/profile/password/update',
                            name: 'expenseuserupdatepassword',
                            component: () => import('../components/auth/user/update/updatePasswordComponent.vue'),
                        },
                    ]
                },
                {
                    path:'/user/expenses',
                    name: 'expenseuser',
                    component: () => import('../views/auth/user/expenses/index.vue'),
                    meta: { exact: true } ,
                    children: [
                        {
                            path:'/user/expenses/create',
                            name: 'expenseusercreate',
                            component: () => import('../components/auth/user/create/createExpensesComponent.vue'),
                        },
                        {
                            path:'/user/expenses/update/:id',
                            name: 'expensesuserupdate',
                            component: () => import('../components/auth/user/update/updateExpensesComponent.vue'),
                        },
                    ]
                }
            ]
        },
    ]
})
router.beforeEach((to, from, next) => {
    NProgress.start()
    const token = localStorage.getItem('token')
    const role = localStorage.getItem('role')
    if (to.matched.some(record => record.meta.requiredAdmin)) {
        token && role && role == 1 ? next() : next('/login')
    }
    else if(to.matched.some(record => record.meta.requiredUser)){
        token && role && role == 2 ? next() : next('/login')
    }
    else if (to.matched.some(record => record.meta.guest)) {
        if (token && role && role == 1) {
            next({ path: '/admin' })
        } 
        else if(token && role && role == 2){
            next({ path: '/users' })
        }
        else {
            next()
        }
    }
    else {
        next()
    }

})
router.afterEach(() => {
    NProgress.done()
})

export default router