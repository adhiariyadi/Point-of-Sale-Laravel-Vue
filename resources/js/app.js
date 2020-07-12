/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");
import VueRouter from "vue-router";
window.Vue = require("vue");
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

import "es6-promise/auto";
import moment from "moment";
import auth from "./auth";
import VueAuth from "@websanova/vue-auth";
import VueAxios from "vue-axios";

import KasirTransactionIndex from "./pages/Kasir/Index.vue";
import KasirTransactionHistory from "./pages/Kasir/History.vue";
import TransactionInvoice from "./pages/Kasir/Invoice.vue";

import AdminHome from "./pages/Admin/Home.vue";
import AdminTransaction from "./pages/Admin/Transaction/Index.vue";
import AdminUsers from "./pages/Admin/Users/Index.vue";
import AdminCustomer from "./pages/Admin/Customer/Index.vue";
import AdminDiscount from "./pages/Admin/Discount/Index.vue";
import AdminCategory from "./pages/Admin/Category/Index.vue";
import AdminProduct from "./pages/Admin/Product/Index.vue";
import AdminReport from "./pages/Admin/Report/Index.vue";

import AuthLogin from "./pages/Auth.vue";

Vue.component("app", require("./pages/App.vue").default);
Vue.component("auth-page", require("./pages/Auth.vue").default);
Vue.use(VueRouter);
Vue.use(VueAxios, axios);
moment.locale("id");
let numberFormat = function(value) {
    let val = (value / 1).toFixed(0).replace(".", ",");
    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
};
Vue.prototype.moment = moment;
Vue.prototype.numberFormat = numberFormat;

const router = new VueRouter({
    mode: "history",
    routes: [
        { path: "/", component: AdminHome, meta: { auth: true } },
        {
            path: "/transaksi",
            component: KasirTransactionIndex,
            meta: { auth: true }
        },
        {
            path: "/transaksi/riwayat",
            component: KasirTransactionHistory,
            meta: { auth: true }
        },
        {
            path: "/transaksi/invoice/:invoice_id",
            component: TransactionInvoice,
            meta: { auth: true }
        },
        {
            path: "/admin",
            component: AdminHome,
            meta: { auth: true },
            name: "admin.dashboard"
        },
        {
            path: "/admin/transaksi",
            component: AdminTransaction,
            meta: { auth: true }
        },
        {
            path: "/admin/users",
            component: AdminUsers,
            meta: { auth: true }
        },
        {
            path: "/admin/customer",
            component: AdminCustomer,
            meta: { auth: true }
        },
        {
            path: "/admin/discount",
            component: AdminDiscount,
            meta: { auth: true }
        },
        {
            path: "/admin/category",
            component: AdminCategory,
            meta: { auth: true }
        },
        {
            path: "/admin/product",
            component: AdminProduct,
            meta: { auth: true }
        },
        {
            path: "/admin/report",
            component: AdminReport,
            meta: { auth: true }
        },
        {
            path: "/login",
            component: AuthLogin,
            meta: { auth: false, pageType: "auth" }
        }
    ]
});

Vue.router = router;

Vue.use(VueAuth, auth);

const app = new Vue({
    el: "#app",
    router
});
