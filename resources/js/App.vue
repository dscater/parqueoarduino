<template>
    <div class="wrapper">
        <NavBar :ruta="ruta"></NavBar>
        <SideBar :ruta="ruta" :user_sidebar="oUser"></SideBar>
        <transition name="fade" mode="out-in">
            <router-view></router-view>
        </transition>
        <Footer></Footer>
        <!-- <Control></Control> -->
    </div>
</template>

<script>
import NavBar from "./plantilla/NavBar.vue";
import SideBar from "./plantilla/SideBar.vue";
import Content from "./plantilla/Content.vue";
import Footer from "./plantilla/Footer.vue";
import Control from "./plantilla/Control.vue";
export default {
    components: {
        NavBar,
        SideBar,
        Footer,
        Control,
        Content,
    },
    props: ["user", "ruta"],
    data() {
        return {
            oUser: this.user,
        };
    },
    mounted() {
        EventBus.$on("usuario_actualizado", (data) => {
            this.oUser = data;
        });
        this.convierteProps();
    },
    methods: {
        convierteProps() {
            this.oUser = JSON.parse(this.oUser);
        },
    },
};
</script>
