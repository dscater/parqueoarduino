<template>
    <div>
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-primary">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a
                        href="#"
                        class="nav-link text-white"
                        data-widget="pushmenu"
                        role="button"
                        ><i class="fas fa-bars"></i
                    ></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <router-link
                        :to="{ name: 'inicio' }"
                        class="nav-link text-white"
                        >Inicio</router-link
                    >
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item" v-if="comprobacion_activa">
                    <a
                        href=""
                        class="nav-link bg-red font-weight-bold"
                        @click.prevent="desactivarCobros"
                        ><i class="fa fa-times"></i> Desactivar cobros</a
                    >
                </li>
                <li class="nav-item" v-if="!comprobacion_activa">
                    <a
                        href=""
                        class="nav-link bg-success font-weight-bold"
                        @click.prevent="reactivarCobros"
                        ><i class="fa fa-check"></i> Activar cobros</a
                    >
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link text-white"
                        href="#"
                        role="button"
                        @click.prevent="logout()"
                        v-loading.fullscreen.lock="fullscreenLoading"
                    >
                        <i class="fas fa-power-off"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link text-white"
                        data-widget="fullscreen"
                        href="#"
                        role="button"
                    >
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->
        <Nuevo
            :muestra_modal="muestra_modal"
            :accion="modal_accion"
            :cobro="oCobro"
            @close="cierreModal"
            @envioModal="detectaEnvioModal"
        ></Nuevo>
    </div>
</template>

<script>
import Nuevo from "../components/modulos/cobro/Nuevo.vue";
export default {
    components: {
        Nuevo,
    },
    data() {
        return {
            fullscreenLoading: false,
            user: JSON.parse(localStorage.getItem("user")),
            permisos: localStorage.getItem("permisos"),
            total_notificaciones: 0,
            sin_ver: 0,
            listNotificacions: [],
            muestra_modal: false,
            modal_accion: "nuevo",
            oCobro: {
                id: 0,
                ingreso_salida_id: "",
                tiempo: "",
                costo: "",
                fecha: "",
                hora: "",
                visto: 0,
            },
            setTimeIntervalCobro: null,
            comprobacion_activa: true,
        };
    },
    mounted() {
        if (!this.permisos) {
            this.$router.push({ name: "login" });
        }
        this.iniciaComprobacion();
    },
    methods: {
        iniciaComprobacion() {
            this.setTimeIntervalCobro = setInterval(() => {
                this.getCobro();
            }, 1500);
        },
        getCobro() {
            axios
                .get(main_url + "/admin/cobros/verifica_cobro", {
                    params: {
                        ultimo_id: this.oCobro.id,
                    },
                })
                .then((response) => {
                    if (response.data.sw) {
                        this.muestra_modal = true;
                        this.oCobro = response.data.cobro;
                        clearInterval(this.setTimeIntervalCobro);
                    }
                });
        },
        detectaEnvioModal() {
            this.muestra_modal = false;
            this.iniciaComprobacion();
        },
        logout() {
            this.fullscreenLoading = true;
            axios.post(main_url + "/logout").then((res) => {
                setTimeout(function () {
                    localStorage.clear();
                    location.reload();
                    this.$router.push({ name: "login" });
                }, 500);
            });
        },
        cierreModal() {
            this.comprobacion_activa = false;
            this.muestra_modal = false;
            this.oCobro = {
                id: 0,
                ingreso_salida_id: "",
                tiempo: "",
                costo: "",
                fecha: "",
                hora: "",
                visto: 0,
            };
        },
        reactivarCobros() {
            this.comprobacion_activa = true;
            this.iniciaComprobacion();
        },
        desactivarCobros() {
            this.comprobacion_activa = false;
            clearInterval(this.setTimeIntervalCobro);
        },
    },
};
</script>

<style>
.contenedor_notificacions {
    width: 100%;
    max-height: 40vh;
    overflow: auto;
}
</style>
