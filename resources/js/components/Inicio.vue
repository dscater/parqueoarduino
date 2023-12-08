<template>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h2
                                    style="
                                        font-weight: bold;
                                        text-align: center;
                                    "
                                ></h2>
                                <h3 style="text-align: center">
                                    ¡BIENVENID@ {{ user.usuario }}!
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="w-100 text-center">
                            VERIFICACIÓN DE ESPACIOS
                        </h4>
                    </div>
                    <div class="col-md-4" v-for="item in listEspacios">
                        <div
                            class="card espacio"
                            :class="{
                                libre: item.estado == 'LIBRE',
                                ocupado: item.estado == 'OCUPADO',
                            }"
                        >
                            <div class="card-body">
                                <div class="nombre">{{ item.nombre }}</div>
                                <div class="estado">{{ item.estado }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
    </div>
</template>

<script>
export default {
    data() {
        return {
            fullscreenLoading: true,
            loadingWindow: Loading.service({
                fullscreen: this.fullscreenLoading,
            }),
            usuarios: 10,
            user: JSON.parse(localStorage.getItem("user")),
            listEspacios: [
                {
                    id: 0,
                    nombre: "ESPACIO 1",
                    estado: "LIBRE",
                },
                {
                    id: 0,
                    nombre: "ESPACIO 2",
                    estado: "LIBRE",
                },
                {
                    id: 0,
                    nombre: "ESPACIO 3",
                    estado: "OCUPADO",
                },
            ],
        };
    },
    mounted() {
        this.loadingWindow.close();
        this.getInfoBox();
    },
    methods: {
        getInfoBox() {
            axios.get(main_url + "/admin/usuarios/getInfoBox").then((res) => {
                this.listInfoBox = res.data;
            });
        },
        getEspacios() {
            axios.get(main_url + "/admin/espacios").then((response) => {
                this.listEspacios = response.data.espacios;
            });
        },
    },
};
</script>

<style>
.espacio .nombre,
.espacio .estado {
    text-align: center;
}
.espacio .nombre {
    font-weight: bold;
    font-size: 1.3em;
}

.espacio.libre .estado {
    background-color: var(--success);
    color: white;
}
.espacio.ocupado {
    color: white;
    background-color: rgb(220, 29, 29);
}
</style>
