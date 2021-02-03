<template>
<div>
    <div class="card card-warning">
        
        <!-- /.card-header -->
        <div class="card-body">
        <form role="form">
            <div class="row">
            <div class="col-sm-2">
                <!-- text input -->
                <div class="form-group">
                <label>Nombre</label>
                <input type="text" 
                v-model.trim="$v.servicio.nombre.$model" 
                class="form-control" 
                :class="{ 'is-invalid': $v.servicio.nombre.$error, 'is-valid': !$v.servicio.nombre.$invalid }"
                placeholder="Nombre">
                <div class="invalid-feedback" v-if="!$v.servicio.nombre.required" >Campo Requerido</div>
                </div>
            </div>
            <div class="col-sm-1">
                <div class="form-group">
                <label>Precio</label>
                <input type="text" 
                v-model.trim="$v.servicio.precio.$model" 
                class="form-control" 
                :class="{ 'is-invalid': $v.servicio.precio.$error, 'is-valid': !$v.servicio.precio.$invalid }"
                placeholder="0" >
                <div class="invalid-feedback" v-if="!$v.servicio.precio.required" >Campo Requerido</div>
                <div class="invalid-feedback" v-if="!$v.servicio.precio.minValue" >El precio debe ser mayor a 0</div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                <label>Descripcion</label>
                <textarea type="text" v-model="servicio.descripcion" class="form-control" placeholder="Descripcion" > </textarea>
                </div>
            </div>
            <div class="col-sm-1">
                <div class="form-group">
                <label>Comision</label>
                <input type="text" 
                v-model.trim="$v.servicio.comision.$model" 
                class="form-control"
                :class="{ 'is-invalid': $v.servicio.comision.$error, 'is-valid': !$v.servicio.comision.$invalid }" 
                placeholder="0" >
                <div class="invalid-feedback" v-if="!$v.servicio.comision.required" >Campo Requerido</div>
                <div class="invalid-feedback" v-if="!$v.servicio.comision.minValue" >El campo debe ser mayor a 0</div>
                </div>
            </div>
            <div class="col-sm-1">
                <div class="form-group">
                <label>Descuento</label>
                <input type="text" v-model="servicio.descuento" class="form-control" placeholder="0,0" >
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                <label>Categoria</label>
                <select
                    class="form-control"
                    v-model="$v.servicio.categoria_servicio_id.$model"
                >
                <option disabled value="">Categorias</option>
                <option v-for="categoria in categorias" v-bind:value="categoria.id" :key="categoria.id">
                    {{ categoria.nombre }}
                </option>
                </select>
                </div>
            </div>
            
            <div class="col-sm-2">
                <div class="form-group">
                <label><i class="fa fa-arrow-down"></i></label>
                <div class="input-group-append">
                <button v-if="this.boton == 'crear'" type="button" class="btn btn-primary form-control" @click="crear()" :disabled="$v.$invalid"><i class="fa fa-plus"></i> Agregar servicio</button>
                <button v-if="this.boton == 'editar'" type="button" class="btn btn-secondary  form-control" @click="actualizar()" :disabled="$v.$invalid"><i class="fa fa-edit"></i> Guardar Cambios</button>
                <button v-if="this.boton == 'editar'" type="button" class="btn btn-danger " @click="boton = 'crear'; limpiar()" ><i class="fa fa-times"></i></button>
                </div>
                </div>
            </div>
            </div>
        </form>
        </div>
        <!-- /.card-body -->
    </div>
    
    <div class="card">
        <!-- /.card-header -->
        <div class="card-header">
            <div class="input-group">
                <input type="text"
                v-model="buscar"
                placeholder="Buscar servicio..."
                class="form-control">
                <button class="btn btn-secondary" type="submit">
                    <i class="fa fa-search"></i>
                </button> 
            </div>
        </div>
        <paginate name="serviciosFilter" v-if="serviciosFilter.length" :list="serviciosFilter" class="container paginate-list" :per="10" :refreshCurrentPage="true">
        <div class="card-body table-responsive p-0">
        <table class="table table-striped">
            <thead>
            <tr>
                <th style="width: 20px">#</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Descripcion</th>
                <th>Comision</th>
                <th>Descuento</th>
                <th>Categoria</th>
                <th>Accion</th>
            </tr>
            </thead>
            <tbody>
                 
            <tr v-for="(servicio, index) in paginated('serviciosFilter')" :key="servicio.id">
                <td>{{index+1}}</td>
                <td>{{servicio.nombre}}</td>
                <td>{{servicio.precio}}</td>
                <td>{{servicio.descripcion}}</td>
                <td>{{servicio.comision}}</td>
                <td>{{servicio.descuento}}</td>
                <td>{{servicio.categorias}}</td>
                <td>
                    <button type="button" class="btn btn-primary " @click="editar(servicio)"><i class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-danger " @click="confirmar(servicio)"><i class="fa fa-trash"></i></button>

                </td>
            </tr>
            
            </tbody>
        </table>
        </div>
        </paginate>
        <span v-if="serviciosFilter.length == 0" class="badge badge-danger">Sin resultados!</span>
        <!-- /.card-body -->
    </div>
    
    <paginate-links for="serviciosFilter" v-if="serviciosFilter.length" :show-step-links="true"></paginate-links>
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
              <p>Eliminar servicio '{{servicio.nombre}}'?</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary" @click="eliminar(servicio.id)">Eliminar</button>
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
import { required, minValue } from 'vuelidate/lib/validators'
import VuePaginate from 'vue-paginate'
Vue.use(VuePaginate)
const Swal = require('sweetalert2');
const Toast =  Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: false,
                    didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
})
export default {
    data(){
        return {
            servicios: [],
            categorias: [],
            buscar: '',
            paginate: ['serviciosFilter'],
            servicio: {
                id: '',
                nombre: '',
                precio: '',
                descripcion: '',
                comision: '',
                descuento: '',
                categoria_servicio_id: ''
            },
            boton: 'crear',
        }
    },
    validations:{
        servicio:{
            nombre: {required},
            precio: {required, minValue: minValue(1)},
            comision: {required, minValue :minValue(1)},
            categoria_servicio_id: {required}
        }
    },
    computed: {
        serviciosFilter: function() {
            var textSearch = this.buscar;
            return this.servicios.filter(function(el){
                return el.nombre.toLowerCase().indexOf(textSearch.toLowerCase()) !== -1;
            });
        }
    },
    methods: {
        listar(){
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
        crear(){
            let me = this;
            axios.post('/api/servicio',{
                'nombre': me.servicio.nombre,
                'precio': me.servicio.precio,
                'descripcion': me.servicio.descripcion,
                'comision': me.servicio.comision,
                'descuento': me.servicio.descuento,
                'categoria_servicio_id': me.servicio.categoria_servicio_id
            })
            .then(function(response){
                me.limpiar();
                me.listar();
                Toast.fire({icon: 'success', title: 'Servicio Registrado'});
            })
            .catch(function(error){
                console.log(error)
            })
        },
        actualizar(){
            let me = this;
            axios.put('/api/servicio/'+ me.servicio.id,{
                'nombre': me.servicio.nombre,
                'precio': me.servicio.precio,
                'descripcion': me.servicio.descripcion,
                'comision': me.servicio.comision,
                'descuento': me.servicio.descuento,
                'categoria_servicio_id': me.servicio.categoria_servicio_id
                
            })
            .then(function(response){
                me.limpiar();
                me.boton= 'crear'
                me.listar();
                Toast.fire({icon: 'success', title: 'Servicio Actualizado'});
            })
            .catch(function(error){
                console.log(error)
            })
        },
        editar(servicio){
            this.servicio.id = servicio.id;
            this.servicio.nombre = servicio.nombre;
            this.servicio.precio = servicio.precio;
            this.servicio.descripcion = servicio.descripcion;
            this.servicio.comision = servicio.comision;
            this.servicio.descuento = servicio.descuento;
            this.servicio.categoria_servicio_id = servicio.categoria_id;
            this.boton = 'editar';
        },
        confirmar(servicio){
            this.servicio.id = servicio.id;
            this.servicio.nombre = servicio.nombre;
            $('#confirmar').modal({backdrop: 'static', keyboard: false, show: true});
        },
        eliminar(id){
            let me = this;
            axios.delete('/api/servicio/'+id)
            .then(function(response){
                $('#confirmar').modal('hide');
                me.limpiar();
                me.listar();
                Toast.fire({icon: 'warning', title: 'Servicio Eliminado'});
            })
            .catch(function(error){
                console.log(error)
            })
        },
        limpiar(){
            this.servicio.nombre = '';
            this.servicio.precio = '';
            this.servicio.descripcion = '';
            this.servicio.comision = '';
            this.servicio.descuento = '';
            this.servicio.categoria_servicio_id = '';
            this.$v.servicio.$reset();
        },
        getCategorias(){
            let me = this;
            axios.get('/api/categoria-servicio')
            .then(function(response){
                me.categorias = response.data.data
                console.log(response.data)
            })
            .catch(function(error){
                console.log(error)
            })
        }

    },

    mounted(){
        this.listar();
        this.getCategorias()
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
    background-color:#343a40;
    color:#ffc612;
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