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
                    <div class="col-12 text-center mb-3">
                        <button
                            class="btn btn-xs btn-danger"
                            v-if="comprobar"
                            @click="desactivaComprobacion"
                        >
                            <i class="fa fa-times"></i> Dejar de comprobar
                        </button>
                        <button
                            class="btn btn-xs btn-success"
                            v-if="!comprobar"
                            @click="activaComprobacion"
                        >
                            <i class="fa fa-check"></i> Comprobar
                        </button>
                    </div>
                    <div class="col-12" v-for="piso in listPisos">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h4>{{ piso.nombre }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div
                                        class="col-md-4"
                                        v-for="item in piso.espacios"
                                    >
                                        <div
                                            class="card espacio"
                                            :class="{
                                                libre: item.estado == 'LIBRE',
                                                ocupado:
                                                    item.estado == 'OCUPADO',
                                            }"
                                        >
                                            <div class="card-body">
                                                <!-- <div class="piso">
                                                    {{ piso.nombre }}
                                                </div> -->
                                                <div class="nombre">
                                                    {{ item.nombre }}
                                                </div>
                                                <div class="estado">
                                                    {{ item.estado }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
            comprobar: true,
            setIntervalComprobar: null,
            listPisos: [],
        };
    },
    mounted() {
        this.loadingWindow.close();
        this.getInfoBox();
        this.getEspacios();
        this.iniciaComprobacion();
    },
    methods: {
        getInfoBox() {
            axios.get(main_url + "/admin/usuarios/getInfoBox").then((res) => {
                this.listInfoBox = res.data;
            });
        },
        iniciaComprobacion() {
            this.setIntervalComprobar = setInterval(() => {
                this.getEspacios();
            }, 1000);
        },
        getEspacios() {
            axios
                .get(main_url + "/admin/pisos/conEspacios")
                .then((response) => {
                    this.listPisos = response.data.pisos;
                });
        },
        activaComprobacion() {
            this.comprobar = true;
            this.iniciaComprobacion();
        },
        desactivaComprobacion() {
            this.comprobar = false;
            clearInterval(this.setIntervalComprobar);
        },
    },
};
</script>

<style>
.espacio .piso {
    position: absolute;
    left: 0;
    top: 0;
    background-color: var(--principal);
    padding: 8px;
    color: white;
    font-weight: bold;
    border-bottom-right-radius: 10px;
}
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
