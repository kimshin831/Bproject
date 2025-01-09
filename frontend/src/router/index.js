import { createRouter, createWebHistory } from 'vue-router';
import Main from '../views/Main.vue';
import Category from '../views/Category.vue';
import Login from '../views/Login.vue';
import Qna from '../views/Qna.vue';
import Event from '../views/Event.vue';
import ShoppingCart from '../views/ShoppingCart.vue';
import Ingredient from '../views/Ingredient.vue';
import OrderComplete from '../views/OrderComplete.vue';
import ProductPage from '../views/ProductPage.vue';
import Checkout from '../views/Checkout.vue';
import Mypage from '../views/Mypage.vue';
import CompanyProfile from '../views/CompanyProfile.vue';
const routes = [
    {
        path: '/',
        name: 'Main',
        component: Main
    },
    {
        path: '/event',
        name: 'Event',
        component: Event
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
        path: '/shoppingcart',
        name: 'ShoppingCart',
        component: ShoppingCart
    },
    {
        path: '/ingredient',
        name: 'Ingredient',
        component: Ingredient
    },
    {
        path: '/ordercomplete',
        name: 'OrderComplete',
        component: OrderComplete
    },
    {
        path: '/product/:id',
        name: 'ProductPage',
        component: ProductPage
    },
    {
        path: '/checkout',
        name: 'Checkout',
        component: Checkout
    },
    {
        path: '/mypage',
        name: 'Mypage',
        component: Mypage
    },
    {
        path: '/companyprofile',
        name: 'CompanyProfile',
        component: CompanyProfile
    }
];

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
});

export default router;
