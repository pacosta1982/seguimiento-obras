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
        <p><strong>El numero de expediente es requerido.</strong></p>
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
                $('#myModal').modal('show');
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
