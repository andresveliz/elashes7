<template>
<div>
    <div class="">
        <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#crear-modal" @click="abrirModal()">Nuevo Codigo  <i class="fas fa-plus"></i></button>
    </div>
    
    <div class="card">
        <!-- /.card-header -->
        <div class="card-header">
            <div class="input-group">
                <input type="text"
                v-model="buscar"
                placeholder="Buscar trabajo..."
                class="form-control">
                <button class="btn btn-secondary" type="submit">
                    <i class="fa fa-search"></i>
                </button> 
            </div>
        </div>
        <paginate name="trabajosFilter" v-if="trabajosFilter.length"  :list="trabajosFilter" tag="tbody" :per="10" :refreshCurrentPage="true">
        <div class="card-body table-responsive p-0">   
        
        <table class="table table-striped">
            <thead>
            <tr>
                <th style="width: 20px">#</th>
                <th>Nombre</th>
                <th>Celular</th>
                <th>Fecha</th>
                <th>Servicio</th>
                <th>Operador</th>
                <th>Codigo</th>
                <th>Accion</th>
            </tr>
            </thead>
            <tbody>
                
            <tr v-for="(trabajo, index) in paginated('trabajosFilter')" :key="trabajo.id">
                <td>{{index+1}}</td>
                <td>{{trabajo.nombre}} {{trabajo.apellido}}</td>
                <td>{{trabajo.celular}}</td>
                <td>{{trabajo.fecha}}</td>
                <td>{{trabajo.servicio.nombre.substr(0,27)}}</td>
                <td>{{trabajo.operador.nombre}}</td>
                <td>{{trabajo.codigo}}</td>
                <td>
                    <button type="button" class="btn btn-info " @click="info(trabajo)" ><i class="fa fa-info"></i></button>
                    <button type="button" class="btn btn-primary " @click="editar(trabajo)"><i class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-danger " @click="confirmar(trabajo)"><i class="fa fa-trash"></i></button>

                </td>
            </tr>
                
            </tbody>
        </table>
        
        </div>
        </paginate>
        <span v-if="trabajosFilter.length == 0" class="badge badge-danger">Sin resultados!</span>
        <!-- /.card-body -->
    </div>
    <paginate-links for="trabajosFilter" v-if="trabajosFilter.length" :show-step-links="true"></paginate-links>
    <div class="modal fade" id="confirmar">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Peligro!!</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Eliminar trabajo del cliente: '{{trabajo.nombre}} {{trabajo.apellido}}'?</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal" @click="limpiar">Cancelar</button>
              <button type="button" class="btn btn-primary" @click="eliminar(trabajo.id)">Eliminar</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <div class="modal fade" id="crear-modal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Registrar Codigo</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
             <form role="form">
            <div class="row">
            <div class="col-sm-4">
                <!-- text input -->
                <div class="form-group">
                <label>Nombre</label>
                <input type="text" 
                v-model.trim="$v.trabajo.nombre.$model" 
                :class="{ 'is-invalid': $v.trabajo.nombre.$error, 'is-valid': !$v.trabajo.nombre.$invalid }"
                class="form-control" 
                placeholder="Nombre">
                <div class="invalid-feedback" v-if="!$v.trabajo.nombre.required" >Campo Requerido</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Apellido</label>
                <input type="text" 
                v-model.trim="$v.trabajo.apellido.$model" 
                :class="{ 'is-invalid': $v.trabajo.apellido.$error, 'is-valid': !$v.trabajo.apellido.$invalid }"
                class="form-control" 
                placeholder="Apellido" >
                <div class="invalid-feedback" v-if="!$v.trabajo.apellido.required" >Campo Requerido</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Celular</label>
                <input type="text" 
                v-model="$v.trabajo.celular.$model" 
                :class="{ 'is-invalid': $v.trabajo.celular.$error, 'is-valid': !$v.trabajo.celular.$invalid }"
                class="form-control" 
                placeholder="Celular" >
                <div class="invalid-feedback" v-if="!$v.trabajo.celular.required" >Campo Requerido</div>
                <div class="invalid-feedback" v-if="!$v.trabajo.celular.numeric" >Campo Numerico</div>
                </div>
            </div>
            </div>
            <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                <label>Fecha</label>
                <datepicker :use-utc="true" :language="es" v-model="trabajo.fecha" input-class="form-control"></datepicker>
                </div>
            </div>
            <div class="col-sm-2.5">
                <div class="form-group">
                <label>Hora</label>
                <input type="time" 
                v-model="$v.trabajo.hora.$model" 
                :class="{ 'is-invalid': $v.trabajo.hora.$error, 'is-valid': !$v.trabajo.hora.$invalid }"
                class="form-control">
                <div class="invalid-feedback" v-if="!$v.trabajo.hora.required" >Campo Requerido</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Servicio</label>
                <select
                    class="form-control"
                    v-model="$v.trabajo.servicio_id.$model"
                >
                <option disabled value="">Servicio</option>
                <option v-for="servicio in servicios" v-bind:value="servicio.id" :key="servicio.id">
                    {{ servicio.nombre }}
                </option>
                </select>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Operador</label>
                <select
                    class="form-control"
                    v-model="$v.trabajo.operador_id.$model"
                >
                <option disabled value="">Operador</option>
                <option v-for="operador in operadores" v-bind:value="operador.id" :key="operador.id">
                    {{ operador.nombre }}
                </option>
                </select>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Detalle</label>
                <textarea v-model="trabajo.detalle" class="form-control" placeholder="Detalle"> </textarea>
                </div>
            </div>
            
            </div>
        </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal" @click="limpiar">Cancelar</button>
              <button type="button" class="btn btn-primary" @click="crear()" :disabled="$v.$invalid">Guardar</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
        <!-- modal editar-->
      <div class="modal fade" id="editar-modal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Editar Codigo</h4>
              <button type="button" class="close" data-dismiss="modal" @click="limpiar()" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
             <form role="form">
            <div class="row">
            <div class="col-sm-4">
                <!-- text input -->
                <div class="form-group">
                <label>Nombre</label>
                <input type="text" 
                v-model.trim="$v.trabajo.nombre.$model" 
                :class="{ 'is-invalid': $v.trabajo.nombre.$error, 'is-valid': !$v.trabajo.nombre.$invalid }"
                class="form-control" 
                placeholder="Nombre">
                <div class="invalid-feedback" v-if="!$v.trabajo.nombre.required" >Campo Requerido</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Apellido</label>
                <input type="text" 
                v-model.trim="$v.trabajo.apellido.$model" 
                :class="{ 'is-invalid': $v.trabajo.apellido.$error, 'is-valid': !$v.trabajo.apellido.$invalid }"
                class="form-control" 
                placeholder="Apellido" >
                <div class="invalid-feedback" v-if="!$v.trabajo.apellido.required" >Campo Requerido</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Celular</label>
                <input type="text" 
                v-model.trim="$v.trabajo.celular.$model"
                :class="{ 'is-invalid': $v.trabajo.celular.$error, 'is-valid': !$v.trabajo.celular.$invalid }" 
                class="form-control" 
                placeholder="Celular" >
                <div class="invalid-feedback" v-if="!$v.trabajo.celular.required" >Campo Requerido</div>
                <div class="invalid-feedback" v-if="!$v.trabajo.celular.numeric" >Campo Numerico</div>
                </div>
            </div>
            </div>
            <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                <label>Fecha</label>
                <datepicker :use-utc="true" :language="es" v-model="trabajo.fecha" input-class="form-control"></datepicker>
                </div>
            </div>
            <div class="col-sm-2.5">
                <div class="form-group">
                <label>Hora</label>
                <input type="time" 
                v-model="$v.trabajo.hora.$model" 
                :class="{ 'is-invalid': $v.trabajo.hora.$error, 'is-valid': !$v.trabajo.hora.$invalid }" 
                class="form-control">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Servicio</label>
                <select
                    class="form-control"
                    v-model="$v.trabajo.servicio_id.$model"
                >
                <option disabled value="">Servicio</option>
                <option v-for="servicio in servicios" v-bind:value="servicio.id" :key="servicio.id">
                    {{ servicio.nombre }}
                </option>
                </select>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Operador</label>
                <select
                    class="form-control"
                    v-model="$v.trabajo.operador_id.$model"
                >
                <option disabled value="">Operador</option>
                <option v-for="operador in operadores" v-bind:value="operador.id" :key="operador.id">
                    {{ operador.nombre }}
                </option>
                </select>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Detalle</label>
                <textarea v-model="trabajo.detalle" class="form-control" placeholder="Detalle"> </textarea>
                </div>
            </div>
            
            </div>
        </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal" @click="limpiar()">Cancelar</button>
              <button type="button" class="btn btn-primary" @click="actualizar(trabajo)" :disabled="$v.$invalid">Guardar</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

    <!-- modal info-->
    <div class="modal fade" id="info-modal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Detalle Codigo</h4>
              <button type="button" class="close" data-dismiss="modal" @click="limpiar()" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
             <form role="form">
            <div class="row">
            <div class="col-sm-4">
                <!-- text input -->
                <div class="form-group">
                <label>Nombre</label>
                <input type="text" v-model="trabajo.nombre" class="form-control" placeholder="Nombre" readonly>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Apellido</label>
                <input type="text" v-model="trabajo.apellido" class="form-control" placeholder="Apellido" readonly>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Celular</label>
                <input type="text" v-model="trabajo.celular" class="form-control" placeholder="Celular" readonly>
                </div>
            </div>
            </div>
            <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                <label>Fecha</label>
                <input type="text" v-model="trabajo.fecha" class="form-control" readonly>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                <label>Hora</label>
                <input type="time" v-model="trabajo.hora" class="form-control" readonly>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Servicio</label>
                <select
                    class="form-control"
                    v-model="trabajo.servicio_id"
                    disabled
                >
                <option disabled value="">Servicio</option>
                <option v-for="servicio in servicios" v-bind:value="servicio.id" :key="servicio.id">
                    {{ servicio.nombre }}
                </option>
                </select>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Operador</label>
                <select
                    class="form-control"
                    v-model="trabajo.operador_id"
                    disabled
                >
                <option disabled value="">Operador</option>
                <option v-for="operador in operadores" v-bind:value="operador.id" :key="operador.id">
                    {{ operador.nombre }}
                </option>
                </select>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Detalle</label>
                <textarea v-model="trabajo.detalle" class="form-control" placeholder="Detalle" readonly> </textarea>
                </div>
            </div>
            
            </div>
        </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal" @click="limpiar()">Cancelar</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

</div>
</template>

<script>
import Vue from 'vue';
import Datepicker from 'vuejs-datepicker';
import {en, es} from 'vuejs-datepicker/dist/locale';
import { required, numeric, minValue } from 'vuelidate/lib/validators'
import VueSweetalert2 from 'vue-sweetalert2';
import VuePaginate from 'vue-paginate'
Vue.use(VuePaginate)
var moment = require('moment');
const Swal = require('sweetalert2');
Vue.use(VueSweetalert2);
export default {
    components:{
        Datepicker
    },
    data(){
        return {
            paginate: ['trabajosFilter'],
            en: en,
            es: es,
            trabajos: [],
            servicios: [],
            operadores: [],
            user:'',
            buscar: '',
            ultimo: [],
            trabajo: {
                id: '',
                nombre: '',
                apellido: '',
                celular: '',
                fecha: '',
                hora: '',
                detalle: '',
                codigo: '',
                user_id:'',
                servicio_id: '',
                operador_id: ''
            },
            boton: 'crear',
        }
    },
    validations:{
        trabajo:{
            nombre: {required},
            apellido: {required},
            celular: {required, numeric},
            hora: {required},
            servicio_id: {required},
            operador_id: {required} 
        }
    },
    computed: {
        trabajosFilter: function() {
            var textSearch = this.buscar;
            return this.trabajos.filter(function(el){
                return (el.nombre.toLowerCase().indexOf(textSearch.toLowerCase()) !== -1 || el.apellido.toLowerCase().indexOf(textSearch.toLowerCase()) !== -1);
            });
        }
    },
    methods: {
        listar(){
            let me = this;
            axios.get('/api/trabajo')
            .then(function(response){
                me.trabajos = response.data.data
                console.log(response.data)
            })
            .catch(function(error){
                console.log(error)
            })
        },
        crear(){
            let me = this;
            axios.post('/api/trabajo',{
                'nombre': me.trabajo.nombre,
                'apellido': me.trabajo.apellido,
                'celular': me.trabajo.celular,
                'fecha': me.trabajo.fecha,
                'hora': me.trabajo.hora,
                'detalle': me.trabajo.detalle,
                'servicio_id': me.trabajo.servicio_id,
                'operador_id': me.trabajo.operador_id,
                'user_id': me.user
            })
            .then(function(response){
                Swal.fire(
                        'Registrado',
                        'El codigo se registró exitosamente',
                        'success'
                        );
                $('#crear-modal').modal('hide');
                me.limpiar();
                me.getUltimo();
                me.listar();
                setTimeout(me.ticket,2000);
                
            })
            .catch(function(error){
                console.log(error)
            })
        },
        actualizar(){
            let me = this;
            axios.put('/api/trabajo/'+ me.trabajo.id,{
                'nombre': me.trabajo.nombre,
                'apellido': me.trabajo.apellido,
                'celular': me.trabajo.celular,
                'fecha': me.trabajo.fecha,
                'hora': me.trabajo.hora,
                'detalle': me.trabajo.detalle,
                //'user_id': 
                'servicio_id': me.trabajo.servicio_id,
                'operador_id': me.trabajo.operador_id
            })
            .then(function(response){
                $('#editar-modal').modal('hide');
                me.limpiar();
                me.boton= 'crear'
                me.listar();
                Swal.fire(
                        'Modificado',
                        'El codigo se modificó exitosamente',
                        'success'
                        );
            })
            .catch(function(error){
                console.log(error)
            })
        },
        editar(trabajo){
            this.trabajo.id = trabajo.id;
            this.trabajo.nombre = trabajo.nombre;
            this.trabajo.apellido = trabajo.apellido;
            this.trabajo.celular = trabajo.celular;
            this.trabajo.fecha = trabajo.fecha;
            this.trabajo.hora = trabajo.hora;
            this.trabajo.detalle = trabajo.detalle;
            this.trabajo.servicio_id = trabajo.servicio_id;
            this.trabajo.operador_id = trabajo.operador_id;
            this.boton = 'editar';
            $('#editar-modal').modal({backdrop: 'static', keyboard: false, show: true});
        },
        info(trabajo){
            this.trabajo.id = trabajo.id;
            this.trabajo.nombre = trabajo.nombre;
            this.trabajo.apellido = trabajo.apellido;
            this.trabajo.celular = trabajo.celular;
            this.trabajo.fecha = trabajo.fecha;
            this.trabajo.hora = trabajo.hora;
            this.trabajo.detalle = trabajo.detalle;
            this.trabajo.servicio_id = trabajo.servicio_id;
            this.trabajo.operador_id = trabajo.operador_id;
            this.boton = 'editar';
            $('#info-modal').modal({backdrop: 'static', keyboard: false, show: true});
        },
        confirmar(trabajo){
            this.trabajo.id = trabajo.id;
            this.trabajo.nombre = trabajo.nombre;
            this.trabajo.apellido = trabajo.apellido;
            $('#confirmar').modal({backdrop: 'static', keyboard: false, show: true});
        },
        abrirModal(){
            this.trabajo.fecha = moment().format("D MMM  YYYY"),
            this.trabajo.hora = moment().format("HH:mm"),
            $('#crear-modal').modal({backdrop: 'static', keyboard: false, show: true});
        },
        eliminar(id){
            let me = this;
            axios.delete('/api/trabajo/'+id)
            .then(function(response){
                $('#confirmar').modal('hide');
                me.limpiar();
                me.listar();
                Swal.fire(
                        'Eliminado',
                        'El codigo se eliminó',
                        'warning'
                        );
            })
            .catch(function(error){
                console.log(error)
            })
        },
        limpiar(){
            this.trabajo.nombre = '';
            this.trabajo.apellido = '';
            this.trabajo.celular = '';
            this.trabajo.fecha = '';
            this.trabajo.hora = '';
            this.trabajo.detalle = '';
            this.trabajo.servicio_id = '';
            this.trabajo.operador_id = '';
            this.$v.trabajo.$reset()
        },
        getServicios(){
            let me = this;
            axios.get('/api/servicio')
            .then(function(response){
                me.servicios = response.data.data
                console.log(response.data)
            })
            .catch(function(error){
                console.log(error)
            })
        },
        getOperadores(){
            let me = this;
            axios.get('/api/operador')
            .then(function(response){
                me.operadores = response.data.data
                console.log(response.data)
            })
            .catch(function(error){
                console.log(error)
            })
        },
        getUser(){
            let me = this;
            axios.get('/api/user')
            .then(function(response){
                me.user = response.data.id
                console.log(response.data.id)
            })
            .catch(function(error){
                console.log(error)
            })
        },
        getUltimo(){
            let me = this;
            axios.get('/api/trabajos/ultimo')
            .then(function(response){
                me.ultimo = response.data.data
                console.log(response.data)
            })
            .catch(function(error){
                console.log(error)
            })
        },
        ticket(){
            let me = this;
            axios.post('http://127.0.0.1:8000/api/trabajos/ticket',{
                'codigo': me.ultimo.codigo,
                'servicio': me.ultimo.servicio.nombre,
                'cliente': me.ultimo.nombre +' '+me.ultimo.apellido,
                'fecha': me.ultimo.fecha +'/'+me.ultimo.hora,
                'operador': me.ultimo.operador.nombre
            })
            .then(function(response){
                console.log('ok')
            })
            .catch(function(error){
                console.log(error)
            })
        },

    },

    mounted(){
        this.listar();
        this.getServicios();
        this.getOperadores();
        this.getUser();
       // this.getUltimo();
        console.log(this.user)
    }
}
</script>
<style>
  .paginate-links{
    width:100%;
    list-style: none;
    text-align: center;
}
.paginate-links li {
      
    display: inline;
    background-color:#428bca;
    color:#42b983;
    padding:0.5rem;
    margin-left:0.3rem;
    margin-right: 0.3rem;
    cursor:pointer;
    border-radius: 3px;
}
.paginate-links li.active a{
font-weight: bold;
}
.paginate-result{
    width: 100%;
    text-align:center;
    margin-bottom: 1rem;
}
.paginate-links a {
  color: #fff;
}
</style>