import { createRouter, createWebHistory } from 'vue-router';
import Main from '../views/Main.vue';
import footerFix from '../components/footerFix.vue';
import Category from '../views/Category.vue';
import Login from '../views/Login.vue';
import Qna from '../views/Qna.vue';
import Mypage from '../views/Mypage.vue';

const routes = [
    {
        path: '/',
        name: 'Main',
        component: Main
    },
    {
        path: '/about',
        name: 'about',
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () => import(/* webpackChunkName: "about" */ '../views/AboutView.vue')
    },
    {
        path: '/event',
        name: 'Event',
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () => import(/* webpackChunkName: "about" */ '../views/Event.vue')
    },
    {
        path: '/footerfix',
        name: 'footerFix',
        component: footerFix
    },
    {
        path: '/category',
        name: 'Category',
        component: Category
    },
    {
        path: '/login',
        name: 'Login',
        component: Login
    },
    {
        path: '/qna',
        name: 'Qna',
        component: Qna
    },
    {
        path: '/mypage',
        name: 'Mypage',
        component: Mypage
    }
];

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
});

export default router;
