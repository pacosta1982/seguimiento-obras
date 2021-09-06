<template>
    <div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Beneficiarios
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <div class="row justify-content-md-between">
                                <div class="col col-lg-7 col-xl-5 form-group">
                                    <div class="input-group">
                                        <input class="form-control" ref="search" v-model="inputSat" @keyup.enter="getPostulante()" placeholder="Ingrese Documento del Beneficiario"  />
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
                    Titular
            </h4>
            <div class="row">
                <div class="form-group col-sm-6">
                    <p class="card-text"><strong>Nombre:</strong> {{ this.FullName }}  </p>
                </div>
                <div class="form-group col-sm-6">
                    <p class="card-text"><strong>Cedula:</strong> {{ this.Cedula }}  </p>
                </div>
            </div>
            <h4>
                    Conyuge
            </h4>
            <div class="row">
                <div class="form-group col-sm-6">
                    <p class="card-text"><strong>Nombre:</strong> {{ this.ConyugeName }}  </p>
                </div>
                <div class="form-group col-sm-6">
                    <p class="card-text"><strong>Cedula:</strong> {{ this.Conyugecedula }}  </p>
                </div>
            </div>
            <h4>
                    Información del subsidio
            </h4>
            <div class="row">

                <div class="form-group col-sm-4">
                    <p class="card-text"><strong>Programa:</strong> {{ this.Programa }}  </p>
                </div>
                <div class="form-group col-sm-4">
                    <p class="card-text"><strong>Certificado:</strong> {{ this.NroCer }}  </p>
                </div>
                <div class="form-group col-sm-4">
                    <p class="card-text"><strong>Proyecto:</strong> {{ this.proy }} </p>
                </div>

            </div>
            <div class="row">

                <div class="form-group col-sm-4">
                    <p class="card-text"><strong>Nro Resolución:</strong> {{ this.resolucion }}  </p>
                </div>
                <div class="form-group col-sm-4">
                    <p class="card-text"><strong>Estado:</strong> {{ this.Certificado }}  </p>
                </div>
                <div class="form-group col-sm-4">
                    <p class="card-text"><strong>Departamento:</strong> {{ this.dpto }} </p>
                </div>

            </div>
            <div class="row">

                <div class="form-group col-sm-4">
                    <p class="card-text"><strong>Fecha Resolución:</strong> {{ this.fecha_res | moment("DD/MM/YYYY") }}  </p>
                </div>
                <div class="form-group col-sm-4">
                    <p class="card-text"><strong>Modalidad:</strong> {{ this.modalidad }}  </p>
                </div>
                <div class="form-group col-sm-4">
                    <p class="card-text"><strong>Distrito:</strong> {{ this.distrito }} </p>
                </div>

            </div>

                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary"><strong>Error!</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-primary">
                <p><strong>El numero de documento del beneficiario es requerido.</strong></p>
            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-secondary bg-primary text-white" data-dismiss="modal">Salir</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
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
                $('#myModal').modal('show');
            } else {
                let me = this;
                var url = "/beneficiaries/" + this.inputSat;
                this.isLoading = true;
                this.clearData();

                //me.isLoading = true;
                axios
                    .get(url)
                    .then(function(response) {
                        var respuesta = response.data;
                        console.log(respuesta);

                        if (!respuesta.error) {
                            me.arrayPostulante = respuesta.beneficiario;
                            me.FullName = me.arrayPostulante.CerposNom;
                            me.Cedula = me.arrayPostulante.CerPosCod;
                            me.ConyugeName = me.arrayPostulante.CerCoNo;
                            me.Conyugecedula = me.arrayPostulante.CerCoCI;
                            me.Programa = respuesta.programa;
                            me.Certificado = respuesta.certificado;

                            me.Pdf = me.arrayPostulante.CerNro;
                            me.NroCer = me.arrayPostulante.CerNro;
                            me.resolucion = me.arrayPostulante.CerResNro;
                            me.fecha_res = me.arrayPostulante.CerFeRe;
                            me.proy = me.arrayPostulante.CerIdent;
                            me.dpto = respuesta.departamento;
                            me.distrito = respuesta.ciudad;
                            me.modalidad = respuesta.modalidad
                            //me.arrayPostulante = respuesta.postulante;
                            //me.FullName = me.arrayPostulante.ExpDPerNom;
                            //me.Cedula = me.arrayPostulante.ExpDPerCod;
                            /*me.Expediente = me.arrayPostulante.ExpDNro;
                            me.Nivel = me.arrayPostulante.ExpDNivel;
                            me.Serie = me.arrayPostulante.NroExpS;

                            me.arrayCabecera = respuesta.cabecera;
                            me.Fecha = me.arrayCabecera.NroExpFch;
                            me.Desc = me.arrayCabecera.NroExpCon;
                            me.Fecha = me.arrayCabecera.NroExpFch;
                            me.NUsuNombre = me.arrayCabecera.NUsuNombre;
                            me.tipo_sol = respuesta.tipo_sol;
                            me.total = respuesta.total;

                            me.arrayProyecto = respuesta.proyecto
                            me.sat = me.arrayProyecto.NroExpsol;
                            me.proyecto = me.arrayProyecto.NroExpCon;

                            me.arrrayHistorial = respuesta.historial;*/

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
                            console.log('vacio');
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
