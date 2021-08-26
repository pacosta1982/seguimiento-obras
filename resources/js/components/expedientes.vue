<template>
    <div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Expedientes
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <div class="row justify-content-md-between">
                                <div class="col col-lg-7 col-xl-5 form-group">
                                    <div class="input-group">
                                        <input class="form-control" ref="search" v-model="inputSat" @keyup.enter="getPostulante()" placeholder="Ingrese Expediente"  />
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-primary" @click="getPostulante()"><i class="fa fa-search"></i>&nbsp; Buscar</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div v-if="error">
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <p><strong>{{ this.error }}</strong></p>
                                    </div>
                                </div>
                            </div>
            <div v-if="visible">
            <h4>
                    Registro de Expediente
            </h4>
            <div class="row">
                <div class="form-group col-sm-6">
                    <p class="card-text"><strong>N°:</strong> {{ this.Expediente }}  </p>
                </div>
                <div class="form-group col-sm-6">
                    <p class="card-text"><strong>Serie:</strong> {{ this.Serie }}  </p>
                </div>

            </div>
            <div class="row">
                <div class="form-group col-sm-6">
                    <p class="card-text"><strong>Fecha de Solicitud:</strong> {{ this.Fecha | moment("DD/MM/YYYY HH:mm") }} </p>
                </div>
                <div class="form-group col-sm-6">
                    <p class="card-text"><strong>Recibido por:</strong> {{ this.NUsuNombre }}  </p>
                </div>
            </div>
            <div class="row">

                <div class="form-group col-sm-6">
                    <p class="card-text"><strong>Solicitud:</strong> {{ this.Desc }}  </p>
                </div>
                <div class="form-group col-sm-6">
                    <p class="card-text"><strong>Tipo Expediente:</strong> {{ this.tipo_sol }} </p>
                </div>
            </div>
                    <h4>
                         Historial Expediente
                    </h4>
                    <table class="table table-hover table-listing">
                        <thead>
                            <tr>
                                <th>Dias</th>
                                <th>#</th>
                                <th>Fecha</th>
                                <th>Origen</th>
                                <th>Destino</th>
                                <th>Estado</th>
                                <th>Recepcionado</th>
                                <th>Usuario</th>
                                <th>Observacion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr :key="index" v-for="(m, index) in arrrayHistorial" v-bind:class="{ 'font-bold': index === (arrrayHistorial.length-1) }">
                                <td>{{ m.dias }}</td>
                                <td>{{ m.nro }}</td>
                                <td>{{ m.fecha }}</td>
                                <td>{{ m.origen }}</td>
                                <td>{{ m.destino }}</td>
                                <td>{{ m.estado }}</td>
                                <td>{{ m.fecha_rec }}</td>
                                <td>{{ m.recepcionado }}</td>
                                <td>{{ m.observacion }}</td>
                            </tr>
                            <tr>
                                <td>{{ this.total }}</td>
                                <td>Total Dias</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>

</template>

<script>
// Import component
//import Loading from "vue-loading-overlay";
// Import stylesheet
//import "vue-loading-overlay/dist/vue-loading.css";
//import { mask } from "vue-the-mask";
//import VModal from "vue-js-modal/dist/index.nocss.js";
import "vue-js-modal/dist/styles.css";
//import fab from "vue-fab";
//Vue.use(VModal);

export default {
    props: ["data"],
    data() {
        return {
            isLoading: false,
            fullPage: true,
            arrayPostulante: [],
            arrayCabecera: [],
            arrrayHistorial: [],
            arrayProyecto: [],
            sat: "",
            proyecto: "",
            FullName: "",
            Cedula: "",
            ConyugeName: "",
            Conyugecedula: "",
            Programa: "",
            Certificado: "",
            ErrorCedula: "",
            Expediente: "",
            tipo_sol: "",
            NUsuNombre: "",
            Serie: "",
            Nivel: "",
            Fecha: "",
            Desc: "",
            error: "",
            total: "",
            Pdf: "",
            infoBeneficiario: null,
            inputSat: "",
            visible: false,
            bgColor: "#3B82F6",
            position: "bottom-right",
            fabActions: [
                {
                    name: "cache",
                    icon: "keyboard_backspace",
                    tooltip: "Volver al Inicio"
                }
            ]
        };
    },
    //directives: { mask },
    components: {
        //Loading,
        //fab
    },
    methods: {
        cache() {
            window.location = "/";
        },
        alert() {
            alert("Clicked on alert icon");
        },
        getPostulante() {
            //let me = this;

            if (!this.inputSat) {
                //alert('Ingrese Cedula')
                this.$modal.show(
                    {
                        template: `
                                                    <div class="fixed z-10 inset-0 overflow-y-auto">
                                                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                                                        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                                                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                                        </div>

                                                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                            <div class="sm:flex sm:items-start">
                                                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                                <!-- Heroicon name: exclamation -->
                                                                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                                </svg>
                                                            </div>
                                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                                                Expediente Requerido
                                                                </h3>
                                                                <div class="mt-2">
                                                                <p class="text-sm text-gray-500">
                                                                    Ingrese el número del expediente a verificar
                                                                </p>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                            <button type="button" @click="$emit('close')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                            Cancelar
                                                            </button>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                        `,
                        props: ["text"]
                    },
                    { text: "This text is passed as a property" },
                    { height: "auto" },
                    {
                        "before-close": event => {
                            this.$refs.search.focus();
                        }
                    }
                );
            } else {
                let me = this;
                var url = "/files/" + this.inputSat;
                this.isLoading = true;
                this.clearData();

                //me.isLoading = true;
                axios
                    .get(url)
                    .then(function(response) {
                        var respuesta = response.data;
                        console.log(respuesta);

                        if (!respuesta.error) {
                            me.arrayPostulante = respuesta.cabecera;
                            me.tipo_sol = respuesta.tipo_sol;
                            me.NUsuNombre = me.arrayPostulante.NUsuNombre;
                            me.Expediente = me.arrayPostulante.NroExp;
                            me.Serie = me.arrayPostulante.NroExpS;
                            me.Fecha = me.arrayPostulante.NroExpFch;
                            me.Desc = me.arrayPostulante.NroExpCon;
                            me.arrrayHistorial = respuesta.historial;
                            me.total = respuesta.total;

                            /*me.FullName = me.arrayPostulante.ExpDPerNom;
                            me.Cedula = me.arrayPostulante.ExpDPerCod;
                            me.Expediente = me.arrayPostulante.ExpDNro;
                            me.Nivel = me.arrayPostulante.ExpDNivel;
                            me.Serie = me.arrayPostulante.NroExpS;

                            me.arrayCabecera = respuesta.cabecera;
                            me.Fecha = me.arrayCabecera.NroExpFch;
                            me.Desc = me.arrayCabecera.NroExpCon;

                            me.arrayProyecto = respuesta.proyecto
                            me.sat = me.arrayProyecto.NroExpsol;
                            me.arrrayHistorial = respuesta.historial;
                            //console.log(me.arrrayHistorial);
                            /*me.ConyugeName = me.arrayBeneficiario.CerCoNo;
                            me.Conyugecedula = me.arrayBeneficiario.CerCoCI;
                            me.Programa = respuesta.programa;
                            me.Certificado = respuesta.certificado;
                            me.Pdf = me.arrayBeneficiario.CerNro;*/
                            me.visible = true;
                            me.error = "";
                            //console.log(me.arrayBeneficiario);
                            me.isLoading = false;
                        } else {
                            //console.log('vacio');
                            me.visible = false;
                            me.error = respuesta.error;
                            me.ErrorCedula = me.inputSat;
                            me.isLoading = false;
                        }
                    })
                    .catch(function(error) {
                        console.log(error);
                        me.isLoading = false;
                    });
            }
        },
        clearData() {
            let me = this;
            me.arrayBeneficiario = [];
            me.FullName = "";
            me.Cedula = "";
            me.ConyugeName = "";
            me.Conyugecedula = "";
            me.Programa = "";
            me.Certificado = "";
            me.Pdf = "";
        },
        doAjax() {
            this.isLoading = true;
            // simulate AJAX
            setTimeout(() => {
                this.isLoading = false;
            }, 5000);
        },
        onCancel() {
            console.log("User cancelled the loader.");
        }
    },
    mounted() {
        //console.log('Component mounted.')
        this.$refs.search.focus();
    }
};
</script>
