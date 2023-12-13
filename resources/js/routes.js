import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);

export default new Router({
    routes: [
        // INICIO
        {
            path: "/",
            name: "inicio",
            component: require("./components/Inicio.vue").default,
        },

        // LOGIN
        {
            path: "/login",
            name: "login",
            component: require("./Auth.vue").default,
        },

        // Usuarios
        {
            path: "/usuarios",
            name: "usuarios.index",
            component: require("./components/modulos/usuarios/index.vue")
                .default,
        },

        // tarifarios
        {
            path: "/tarifarios",
            name: "tarifarios.index",
            component: require("./components/modulos/tarifarios/index.vue")
                .default,
        },

        // ingreso_salidas
        {
            path: "/ingreso_salidas",
            name: "ingreso_salidas.index",
            component: require("./components/modulos/ingreso_salidas/index.vue")
                .default,
        },

        // Reportes
        {
            path: "/reportes/espacios_disponibles",
            name: "reportes.espacios_disponibles",
            component:
                require("./components/modulos/reportes/espacios_disponibles.vue")
                    .default,
            props: true,
        },
        {
            path: "/reportes/ingresos_salidas",
            name: "reportes.ingresos_salidas",
            component:
                require("./components/modulos/reportes/ingresos_salidas.vue")
                    .default,
            props: true,
        },

        // PÁGINA NO ENCONTRADA
        {
            path: "*",
            component: require("./components/modulos/errors/404.vue").default,
        },
    ],
    mode: "history",
    linkActiveClass: "active open",
});
