<template>
<div>
    <div class="">
        <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#crear-modal" @click="abrirModal()">Nuevo Codigo  <i class="fas fa-plus"></i></button>
    </div>
    <div class="card">
        <!-- /.card-header -->
        <div class="card-header">
            <h3 class="card-title">Trabajos Realizados</h3>
        </div>
        <div class="card-body table-responsive p-0">
        <table class="table table-striped">
            <thead>
            <tr>
                <th style="width: 20px">#</th>
                <th>Nombre</th>
                <th>Celular</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Servicio</th>
                <th>Operador</th>
                <th>Codigo</th>
                <th>Accion</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(trabajo, index) in trabajos" :key="trabajo.id">
                <td>{{index+1}}</td>
                <td>{{trabajo.nombre}} {{trabajo.apellido}}</td>
                <td>{{trabajo.celular}}</td>
                <td>{{trabajo.fecha}}</td>
                <td>{{trabajo.hora}}</td>
                <td>{{trabajo.servicio.nombre}}</td>
                <td>{{trabajo.operador.nombre}} {{trabajo.operador.apellido}}</td>
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
        <!-- /.card-body -->
    </div>
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
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
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
                <input type="text" v-model="trabajo.nombre" class="form-control" placeholder="Nombre">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Apellido</label>
                <input type="text" v-model="trabajo.apellido" class="form-control" placeholder="Apellido" >
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Celular</label>
                <input type="text" v-model="trabajo.celular" class="form-control" placeholder="Celular" >
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
            <div class="col-sm-2">
                <div class="form-group">
                <label>Hora</label>
                <input type="time" v-model="trabajo.hora" class="form-control">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Servicio</label>
                <select
                    class="form-control"
                    v-model="trabajo.servicio_id"
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
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary" @click="crear()">Guardar</button>
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
                <input type="text" v-model="trabajo.nombre" class="form-control" placeholder="Nombre">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Apellido</label>
                <input type="text" v-model="trabajo.apellido" class="form-control" placeholder="Apellido" >
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Celular</label>
                <input type="text" v-model="trabajo.celular" class="form-control" placeholder="Celular" >
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
            <div class="col-sm-2">
                <div class="form-group">
                <label>Hora</label>
                <input type="time" v-model="trabajo.hora" class="form-control">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Servicio</label>
                <select
                    class="form-control"
                    v-model="trabajo.servicio_id"
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
              <button type="button" class="btn btn-primary" @click="actualizar(trabajo)">Guardar</button>
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
var moment = require('moment');
export default {
    components:{
        Datepicker
    },
    data(){
        return {
            en: en,
            es: es,
            trabajos: [],
            servicios: [],
            operadores: [],
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
    methods: {
        listar(){
            let me = this;
            axios.get('http://127.0.0.1:8012/api/trabajo')
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
            axios.post('http://127.0.0.1:8012/api/trabajo/',{
                'nombre': me.trabajo.nombre,
                'apellido': me.trabajo.apellido,
                'celular': me.trabajo.celular,
                'fecha': me.trabajo.fecha,
                'hora': me.trabajo.hora,
                'detalle': me.trabajo.detalle,
                'servicio_id': me.trabajo.servicio_id,
                'operador_id': me.trabajo.operador_id,
            })
            .then(function(response){
                $('#crear-modal').modal('hide');
                me.limpiar();
                me.listar();
            })
            .catch(function(error){
                console.log(error)
            })
        },
        actualizar(){
            let me = this;
            axios.put('http://127.0.0.1:8012/api/trabajo/'+ me.trabajo.id,{
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
            axios.delete('http://127.0.0.1:8012/api/trabajo/'+id)
            .then(function(response){
                $('#confirmar').modal('hide');
                me.limpiar();
                me.listar();
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
        },
        getServicios(){
            let me = this;
            axios.get('http://127.0.0.1:8012/api/servicio')
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
            axios.get('http://127.0.0.1:8012/api/operador')
            .then(function(response){
                me.operadores = response.data.data
                console.log(response.data)
            })
            .catch(function(error){
                console.log(error)
            })
        }

    },

    mounted(){
        this.listar();
        this.getServicios();
        this.getOperadores();
        console.log('categorias')
    }
}
</script>
