<template>
    <div
        class="modal fade"
        :class="{ show: bModal }"
        id="modal-default"
        aria-modal="true"
        role="dialog"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                        @click="cierraModal"
                    >
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row" v-if="cobro && cobro.ingreso_salida">
                            <div class="col-12">
                                <p>
                                    <strong>Fecha y Hora de Ingreso: </strong>
                                    {{ cobro.ingreso_salida.fecha_ingreso_ft }}
                                </p>
                                <p>
                                    <strong>Fecha y Hora de Salida: </strong>
                                    {{ cobro.ingreso_salida.fecha_salida_ft }}
                                </p>
                                <p>
                                    <strong>Espacio: </strong>
                                    {{ cobro.ingreso_salida.espacio.nombre }}
                                </p>
                                <p>
                                    <strong>Tiempo transcurrido: </strong>
                                    {{ cobro.ingreso_salida.tiempo_t }}
                                </p>
                            </div>
                            <div class="col-12">
                                <p class="cobro_total">
                                    <strong>TOTAL COBRAR: </strong>
                                    {{ cobro.costo }}
                                </p>
                            </div>
                        </div>
                        <div class="row" v-else>
                            <p class="cobro_total w-100 text-center">
                                Cargando...
                            </p>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-end">
                    <el-button
                        type="primary"
                        class="bg-primary"
                        :loading="enviando"
                        @click="setRegistroModal()"
                        v-html="textoBoton"
                    ></el-button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        muestra_modal: {
            type: Boolean,
            default: false,
        },
        accion: {
            type: String,
            default: "nuevo",
        },
        cobro: {
            type: Object,
            default: {
                id: 0,
                ingreso_salida_id: "",
                tiempo: "",
                costo: "",
                fecha: "",
                hora: "",
                visto: 0,
            },
        },
    },
    watch: {
        muestra_modal: function (newVal, oldVal) {
            this.errors = [];
            if (newVal) {
                this.bModal = true;
            } else {
                this.bModal = false;
            }
        },
    },
    computed: {
        tituloModal() {
            return "INFORMACIÓN DE COBRO";
        },
        textoBoton() {
            if (this.accion == "nuevo") {
                return '<i class="fa fa-check"></i> CONFIRMAR COBRO';
            }
        },
    },
    data() {
        return {
            user: JSON.parse(localStorage.getItem("user")),
            bModal: this.muestra_modal,
            enviando: false,
            errors: [],
        };
    },
    mounted() {
        this.bModal = this.muestra_modal;
    },
    methods: {
        setRegistroModal() {
            axios
                .post(main_url + "/admin/cobros/guarda_visto/" + this.cobro.id)
                .then((response) => {
                    Swal.fire({
                        icon: "success",
                        title: "CORRECTO",
                        html: "Cobro realizado",
                        showConfirmButton: false,
                        timer: 2000,
                    });
                    this.$emit("envioModal");
                    this.errors = [];
                });
        },
        limpiaTarifario() {
            this.errors = [];
            this.cobro.ingreso_salida_id = "";
            this.cobro.tiempo = "";
            this.cobro.costo = "";
            this.cobro.fecha = "";
            this.cobro.hora = "";
            this.cobro.visto = 0;
        }, // Dialog/modal
        cierraModal() {
            this.bModal = false;
            this.$emit("close");
        },
    },
};
</script>

<style>
.cobro_total {
    font-size: 1.3em;
    font-weight: bold;
}
</style>
