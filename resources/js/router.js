import Vue from 'vue';
import VueRouter from 'vue-router';
import store from './store';

Vue.use(VueRouter);

import Layout from './layout';
const isManager = store.state.user.auth.isManager;
const defaulPayslip = isManager ? '/payslip/index' : '/payslip/detail';
export const constantRoutes = [
    {
        path: '/redirect',
        component: Layout,
        redirect: { name: 'redirect' },
        hidden: true,
        children: [
            {
                path: '/redirect/:path*',
                component: () => import('./views/Redirect/index.vue'),
                name: 'redirect',
            },
        ],
    },
    {
        path: '/change-password',
        name: 'ChangePassword',
        component: () => import('./views/Auth/change-password'),
        hidden: true,
    },
    {
        path: '/login',
        name: 'Login',
        component: () => import('./views/Auth/login'),
        hidden: true,
        children: [

        ],
    },
    {
        path: '/admin',
        name: 'LoginAdmin',
        component: () => import('./views/Auth/login'),
        hidden: true,
        meta: {
            title: 'routes.login_admin',
            icon: 'icofont-learn',
        },
    },
    {
        path: '/recovery',
        name: 'Recovery',
        component: () => import('./views/Auth/recovery'),
        hidden: true,
    },
    {
        path: '/notification',
        name: 'Notification',
        component: () => import('./views/Auth/notify'),
        hidden: true,
    },
    {
        path: '',
        redirect: '/payslip',
        meta: {
            title: 'routes.payslip',
            icon: 'icofont-calendar',
        },
        hidden: true,

    },
    {
        path: '/payslip',
        name: 'Payslip',
        redirect: defaulPayslip,
        component: Layout,
        // hidden: isManager,
        meta: {
            title: 'routes.payslip',
            icon: 'icofont-contacts',
        },
        children: [
            {
                path: 'index',
                name: 'PayslipIndex',
                component: () => import('./views/Payslip/index'),
                meta: {
                    title: 'routes.payslip',
                    icon: 'icofont-contacts',
                },
            },
            {
                path: 'detail/:emp_code/:month',
                name: 'PayslipDetail',
                component: () => import('./views/Payslip/detail'),
                meta: {
                    title: 'routes.payslip',
                    icon: 'icofont-contacts',
                },
            },
            {
                path: 'detail',
                name: 'PayslipMe',
                component: () => import('./views/Payslip/detail'),
                meta: {
                    title: 'routes.payslip',
                    icon: 'icofont-contacts',
                },
            },
            {
                path: 'import',
                name: 'PayslipImport',
                component: () => import('./views/Payslip/import'),
                meta: {
                    title: 'routes.csv-import',
                    icon: 'icofont-attachment',
                },
            },
        ],
    },
    {
        path: '/employee',
        name: 'Employee',
        redirect: '/employee/index',
        component: Layout,
        // hidden: isManager,
        meta: {
            title: 'routes.employee',
            icon: 'icofont-contacts',
        },
        children: [
            {
                path: 'index',
                component: () => import('./views/Employee/index'),
                meta: {
                    title: 'routes.employee',
                    icon: 'icofont-lens',
                },
            },
            {
                path: 'edit/:emp_code',
                component: () => import('./views/Employee/edit'),
                meta: {
                    title: 'routes.employee',
                    icon: 'icofont-lens',
                    hidden: true,
                },
            },
            {
                path: 'show',
                name: 'EmpShow',
                component: () => import('./views/Employee/show'),
                meta: {
                    title: 'routes.employee',
                    icon: 'icofont-lens',
                    hidden: true,
                },
            },
        ],
    },
    // {
    //     path: '/import-csv',
    //     redirect: '/import-csv',
    //     component: Layout,
    //     hidden: !isManager,
    //     meta: {
    //         title: 'routes.csv-import',
    //         icon: 'icofont-attachment',
    //     },
    //     children: [
    //         {
    //             path: 'index',
    //             component: () => import('./views/Payslip/import'),
    //             meta: {
    //                 title: 'routes.csv-import',
    //                 icon: 'icofont-attachment',
    //             },
    //         },
    //     ],
    // },
];

export const asyncRoutes = [];

const createRouter = () => new VueRouter({
    mode: 'history',
    hash: false,
    scrollBehavior: () => ({ y: 0 }),
    // base: process.env.MIX_LARAVEL_PATH,
    base: '',
    routes: constantRoutes,
});

const router = createRouter();

export function resetRouter() {
    const newRouter = createRouter();
    router.matcher = newRouter.matcher;
}

export default router;
