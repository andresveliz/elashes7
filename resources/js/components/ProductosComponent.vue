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
                <input type="text" id="name"
                v-model.trim="$v.producto.nombre.$model" 
                class="form-control" 
                :class="{ 'is-invalid': $v.producto.nombre.$error, 'is-valid': !$v.producto.nombre.$invalid }"
                placeholder="Nombre">
                <div class="invalid-feedback" v-if="!$v.producto.nombre.required" >Campo Requerido</div>
                </div>
                
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                <label>Precio</label>
                <input type="text" 
                v-model.trim="$v.producto.precio.$model" 
                class="form-control" 
                :class="{ 'is-invalid': $v.producto.precio.$error, 'is-valid': !$v.producto.precio.$invalid }"
                placeholder="Precio" >
                <div class="invalid-feedback" v-if="!$v.producto.precio.required" >Campo Requerido</div>
                <div class="invalid-feedback" v-if="!$v.producto.precio.minValue" >El precio debe ser mayor a 0</div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                <label>Cantidad</label>
                <input type="number" 
                v-model.trim="$v.producto.cantidad.$model" 
                class="form-control"
                :class="{ 'is-invalid': $v.producto.cantidad.$error, 'is-valid': !$v.producto.cantidad.$invalid }" 
                placeholder="0" >
                <div class="invalid-feedback" v-if="!$v.producto.cantidad.required" >Campo Requerido</div>
                <div class="invalid-feedback" v-if="!$v.producto.cantidad.minValue" >El campo debe ser mayor a 0</div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                <label>Descuento</label>
                <input type="text" 
                v-model.trim="$v.producto.descuento.$model" 
                class="form-control" 
                :class="{ 'is-invalid': $v.producto.descuento.$error, 'is-valid': !$v.producto.descuento.$invalid }"
                placeholder="0" >
                <div class="invalid-feedback" v-if="!$v.producto.descuento.required" >Campo Requerido</div>
                <div class="invalid-feedback" v-if="!$v.producto.descuento.minValue" >El campo debe ser 0 o mayor</div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                <label>Categoria</label>
                <select
                    class="form-control"
                    v-model="$v.producto.categoria_producto_id.$model"
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
                <button v-if="this.boton == 'crear'" type="button" class="btn btn-primary form-control" @click="crear()" :disabled="$v.$invalid"><i class="fa fa-plus"></i> Agregar producto</button>
                <button v-if="this.boton == 'editar'" type="button" class="btn btn-secondary  form-control" @click="actualizar()" :disabled="$v.$invalid"><i class="fa fa-edit"></i> Guardar Cambios</button>
                <button v-if="this.boton == 'editar'" type="button" class="btn btn-danger " @click="boton = 'crear'; limpiar()"><i class="fa fa-times"></i></button>
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
                placeholder="Buscar producto..."
                class="form-control">
                <button class="btn btn-secondary" type="submit">
                    <i class="fa fa-search"></i>
                </button> 
            </div>
        </div>
        <paginate name="productosFilter" v-if="productosFilter.length" :list="productosFilter" class="container paginate-list" :per="10" :refreshCurrentPage="true">
        <div class="card-body table-responsive p-0">
        <table class="table table-striped">
            <thead>
            <tr>
                <th style="width: 20px">#</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Descuento</th>
                <th>Categoria</th>
                <th>Accion</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(producto, index) in paginated('productosFilter')" :key="producto.id">
                <td>{{index+1}}</td>
                <td>{{producto.nombre}}</td>
                <td>{{producto.precio}}</td>
                <td>{{producto.cantidad}}</td>
                <td>{{producto.descuento}}</td>
                <td>{{producto.categorias}}</td>
                <td>
                    <button type="button" class="btn btn-primary " @click="editar(producto)"><i class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-danger " @click="confirmar(producto)"><i class="fa fa-trash"></i></button>

                </td>
            </tr>
            
            </tbody>
        </table>
        </div>
        </paginate>
        <span v-if="productosFilter.length == 0" class="badge badge-danger">Sin resultados!</span>
        <!-- /.card-body -->
    </div>
    <paginate-links for="productosFilter" v-if="productosFilter.length" :show-step-links="true"></paginate-links>
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
              <p>Eliminar producto '{{producto.nombre}}'?</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary" @click="eliminar(producto.id)">Eliminar</button>
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
const Swal = require('sweetalert2');
import VuePaginate from 'vue-paginate'
Vue.use(VuePaginate)
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
            productos: [],
            categorias: [],
            buscar: '',
            paginate: ['productosFilter'],
            producto: {
                id: '',
                nombre: '',
                precio: '',
                cantidad: '',
                descuento: '',
                categoria_producto_id: ''
            },
            boton: 'crear',
        }
    },
    validations:{
        producto:{
            nombre: {required},
            precio: {required, minValue: minValue(1)},
            cantidad: {required, minValue:  minValue(1)},
            descuento: {required, minValue:  minValue(0)},
            categoria_producto_id: {required}

        }
    },
    computed: {
        productosFilter: function() {
            var textSearch = this.buscar;
            return this.productos.filter(function(el){
                return el.nombre.toLowerCase().indexOf(textSearch.toLowerCase()) !== -1;
            });
        }
    },
    methods: {
        listar(){
            let me = this;
            axios.get('/api/producto')
            .then(function(response){
                me.productos = response.data.data
                console.log(response.data)
            })
            .catch(function(error){
                console.log(error)
            })
        },
        crear(){
            let me = this;
            axios.post('/api/producto',{
                'nombre': me.producto.nombre,
                'precio': me.producto.precio,
                'cantidad': me.producto.cantidad,
                'descuento': me.producto.descuento,
                'categoria_producto_id': me.producto.categoria_producto_id
            })
            .then(function(response){
                me.limpiar();
                me.listar();
                Toast.fire({icon: 'success', title: 'Producto Registrado'});
            })
            .catch(function(error){
                console.log(error)
            })
        },
        actualizar(){
            let me = this;
            axios.put('/api/producto/'+ me.producto.id,{
                'nombre': me.producto.nombre,
                'precio': me.producto.precio,
                'cantidad': me.producto.cantidad,
                'descuento': me.producto.descuento,
                'categoria_producto_id': me.producto.categoria_producto_id,
                
            })
            .then(function(response){
                me.limpiar();
                me.boton= 'crear'
                me.listar();
                Toast.fire({icon: 'success', title: 'Producto Actualizado'});
            })
            .catch(function(error){
                console.log(error)
            })
        },
        editar(producto){
            this.producto.id = producto.id;
            this.producto.nombre = producto.nombre;
            this.producto.precio = producto.precio;
            this.producto.cantidad = producto.cantidad;
            this.producto.descuento = producto.descuento;
            this.producto.categoria_producto_id = producto.categoria_id;
            this.boton = 'editar';

            $("#name").focus();
        },
        confirmar(producto){
            this.producto.id = producto.id;
            this.producto.nombre = producto.nombre;
            $('#confirmar').modal({backdrop: 'static', keyboard: false, show: true});
        },
        eliminar(id){
            let me = this;
            axios.delete('/api/producto/'+id)
            .then(function(response){
                $('#confirmar').modal('hide');
                me.limpiar();
                me.listar();
                Toast.fire({icon: 'warning', title: 'Producto Eliminado'});
            })
            .catch(function(error){
                console.log(error)
            })
        },
        limpiar(){
            this.producto.nombre = '';
            this.producto.precio = '';
            this.producto.cantidad = '';
            this.producto.descuento = '';
            this.producto.categoria_producto_id = '';
            this.$v.producto.$reset();
        },
        getCategorias(){
            let me = this;
            axios.get('/api/categoria-producto')
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
