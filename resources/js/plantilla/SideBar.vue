<template>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-light">
        <!-- Brand Logo -->
        <router-link
            exact
            :to="{ name: 'inicio' }"
            class="brand-link bg-primary"
        >
            <img
                :src="logo"
                alt="Logo"
                class="brand-image img-circle elevation-3"
                style="opacity: 0.8"
            />
            <span
                class="brand-text font-weight-light"
                v-text="'PARQUEO'"
            ></span>
        </router-link>

        <!-- Sidebar -->
        <div class="sidebar p-0">
            <!-- Sidebar user (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img
                        :src="user_sidebar.path_image"
                        class="img-circle elevation-2"
                        alt="User Image"
                    />
                </div>
                <div class="info">
                    <a
                        href=""
                        class="d-block"
                        v-text="user_sidebar.usuario"
                    ></a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2 pr-1 pl-1">
                <ul
                    class="nav nav-pills nav-sidebar flex-column text-xs nav-flat"
                    data-widget="treeview"
                    role="menu"
                    data-accordion="false"
                >
                    <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <router-link
                            exact
                            :to="{ name: 'inicio' }"
                            class="nav-link"
                        >
                            <i class="nav-icon fas fa-home"></i>
                            <p>Inicio</p>
                        </router-link>
                    </li>
                    <li
                        class="nav-header bg-navy"
                        v-if="
                            permisos.includes('usuarios.index') ||
                            permisos.includes('tarifarios.index') ||
                            permisos.includes('ingreso_salidas.index')
                        "
                    >
                        ADMINISTRACIÓN
                    </li>
                    <li
                        class="nav-item"
                        v-if="permisos.includes('usuarios.index')"
                    >
                        <router-link
                            exact
                            :to="{ name: 'usuarios.index' }"
                            class="nav-link"
                            v-loading.fullscreen.lock="fullscreenLoading"
                        >
                            <i class="nav-icon fas fa-users"></i>
                            <p>Usuarios</p>
                        </router-link>
                    </li>
                    <li
                        class="nav-item"
                        v-if="permisos.includes('tarifarios.index')"
                    >
                        <router-link
                            exact
                            :to="{ name: 'tarifarios.index' }"
                            class="nav-link"
                            v-loading.fullscreen.lock="fullscreenLoading"
                        >
                            <i class="nav-icon fas fa-list-alt"></i>
                            <p>Tarifario</p>
                        </router-link>
                    </li>
                    <li
                        class="nav-item"
                        v-if="permisos.includes('ingreso_salidas.index')"
                    >
                        <router-link
                            exact
                            :to="{ name: 'ingreso_salidas.index' }"
                            class="nav-link"
                            v-loading.fullscreen.lock="fullscreenLoading"
                        >
                            <i class="nav-icon fas fa-list-alt"></i>
                            <p>Ingresos y Salidas</p>
                        </router-link>
                    </li>
                    <li
                        class="nav-header bg-navy"
                        v-if="
                            permisos.includes(
                                'reportes.espacios_disponibles'
                            ) || permisos.includes('reportes.ingresos_salidas')
                        "
                    >
                        REPORTES
                    </li>
                    <li
                        class="nav-item"
                        v-if="
                            permisos.includes('reportes.espacios_disponibles')
                        "
                    >
                        <router-link
                            :to="{ name: 'reportes.espacios_disponibles' }"
                            class="nav-link"
                        >
                            <i class="fas fa-file-pdf nav-icon"></i>
                            <p>Espacios disponibles y ocupados</p>
                        </router-link>
                    </li>
                    <li
                        class="nav-item"
                        v-if="permisos.includes('reportes.ingresos_salidas')"
                    >
                        <router-link
                            :to="{ name: 'reportes.ingresos_salidas' }"
                            class="nav-link"
                        >
                            <i class="fas fa-file-pdf nav-icon"></i>
                            <p>Ingresos y tiempo por espacios ocupados</p>
                        </router-link>
                    </li>
                    <li class="nav-header bg-navy">OTRAS OPCIONES</li>
                    <li class="nav-item">
                        <a
                            href="#"
                            class="nav-link"
                            @click.prevent="logout()"
                            v-loading.fullscreen.lock="fullscreenLoading"
                        >
                            <i class="fas fa-power-off nav-icon"></i>
                            <p>Salir</p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</template>

<script>
export default {
    props: ["user_sidebar"],
    data() {
        return {
            user: JSON.parse(localStorage.getItem("user")),
            fullscreenLoading: false,
            permisos: localStorage.getItem("permisos"),
            timeoutId: null,
            logo: url_logo,
        };
    },
    mounted() {
        // Configurar el temporizador para llamar a logout después de 5 minutos de inactividad
        // this.resetLogoutTimer();
        // window.addEventListener("mousemove", this.resetLogoutTimer);
    },
    methods: {
        logout() {
            this.fullscreenLoading = true;
            axios.post("/logout").then((res) => {
                setTimeout(function () {
                    localStorage.clear();
                    location.reload();
                    this.$router.push({ name: "login" });
                }, 500);
            });
        },
        resetLogoutTimer() {
            // Reiniciar el temporizador cuando se detecta actividad
            clearTimeout(this.timeoutId);
            this.timeoutId = setTimeout(() => {
                this.logout();
            }, 5 * 60 * 1000); // 5 minutos en milisegundos
        },
    },
    beforeDestroy() {
        // Limpiar el temporizador y quitar el evento cuando se destruye el componente
        clearTimeout(this.timeoutId);
        window.removeEventListener("mousemove", this.resetLogoutTimer);
    },
};
</script>

<style>
.user-panel .info {
    display: flex;
    height: 100%;
    align-items: center;
}
.user-panel .info a {
    font-size: 0.8em;
}
</style>
