import Vue from "vue";
import VueRouter from "vue-router";
import store from '../store/store';
import PetugasLayout from "../views/Petugas/PetugasLayout.vue";
import DashboardPetugas from "../views/Petugas/DashboardPetugas.vue";


Vue.use(VueRouter);
const routes = [
    {
        path: "/admin/:petugas",
        component: PetugasLayout,
        children: [
            {
                path: "dashboard",
                name: "Dashboard Petugas",
                component: DashboardPetugas
            },
        ]
    }
];
const router = new VueRouter({
    mode: "history",
    // base: "/user/",
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition
        } else {
            return { x: 0, y: 0 }
        }
    },
    routes
});
export default router;