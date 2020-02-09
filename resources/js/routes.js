import VueRouter from 'vue-router'
// Pages
import Home from './pages/Home'
import Vue from 'vue'
import Register from './pages/Register'
import Login from './pages/Login'
import Dashboard from './pages/Dashboard'
import Export from "./pages/Export";
import Content from "./pages/Content"
//Tabs
import Product from "./components/Product";
import Category from "./components/Category";
import Domain from "./components/Domain";
// Routes
const routes = [
    {
        path: '/',
        name: 'home',
        component: Vue.component('home', require('./pages/Home').default),
        meta: {
            auth: undefined
        }
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
        meta: {
            auth: false
        }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            auth: false
        }
    },
    {
        path: '/export',
        name: 'export',
        component: Export,
        meta: {
            auth: true
        }
    },
    {
        path: '/content',
        name: 'content',
        component: Content,
        meta: {
            auth: true
        }
    },
    // ADMIN ROUTES
    {
        path: '/admin',
        name: 'admin.dashboard',
        component: Dashboard,
        meta: {
            // auth: {redirect: {name: 'login'}, forbiddenRedirect: '/403'}
            auth: true
        },
        children: [
            {
                path: '',
                name: 'admin.product',
                component: Product
            },
            {
                path: 'category',
                name: 'admin.category',
                component: Category
            },
            {
                path: 'domain',
                name: 'admin.domain',
                component: Domain
            },
        ]
    },
];
const router = new VueRouter({
    history: true,
    mode: 'history',
    routes: routes,
});
export default router
