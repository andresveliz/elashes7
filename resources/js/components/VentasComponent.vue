<template>
<div>
    <div class="">
        <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#crear-modal">Nueva Venta <i class="fas fa-plus"></i></button>
    </div>
    <div class="card">
        <!-- /.card-header -->
        <div class="card-header">
            <h3 class="card-title">Ventas</h3>
        </div>
        <div class="card-body table-responsive p-0">
        <table class="table table-striped">
            <thead>
            <tr>
                <th style="width: 20px">#</th>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>Detalle</th>
                <th>Total</th>
                <th>Usuario</th>
                <th>Operador</th>
                <th>Accion</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(venta, index) in ventas" :key="venta.id">
                <td>{{index+1}}</td>
                <td>{{venta.nombre}} {{venta.apellido}}</td>
                <td>{{venta.fecha}}</td>
                <td>
                    <tr>
                        <th>Producto</th>
                        <th class="text-center" width="10%">Precio</th>
                        <th class="text-center" width="10%">Cantidad</th>
                        <th class="text-right" width="20%">Subtotal</th>
                    </tr>
                    <tr v-for="(detalle, index) in venta.detalle" :key="index">
                                <td class="text-inverse">{{ detalle.nombre }}</td>
                                <td class="text-center">{{ detalle.precio }}</td>
                                <td class="text-center">{{ detalle.pivot.cantidad }}</td>
                                <td class="text-right">{{ detalle.precio * detalle.pivot.cantidad }}</td>
                            </tr>
                </td>
                <td>{{venta.total}}</td>
                <td>{{venta.user_id}}</td>
                <td>{{venta.operador_id}}</td>
                <td>
                    <button type="button" class="btn btn-primary " @click="editar(venta)"><i class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-danger " @click="confirmar(venta)"><i class="fa fa-trash"></i></button>

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
              <p>Eliminar venta '{{venta.nombre}}'?</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal" @click="limpiar">Cancelar</button>
              <button type="button" class="btn btn-primary" @click="eliminar(venta.id)">Eliminar</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
        <!-- crear-modal-->
      <div class="modal fade" id="crear-modal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Nueva Venta</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body"> 
            <div class="row"> 
            <div class="col-md-5">
            <div class="row">
            <div class="col-sm-5">
                <!-- text input -->
                <div class="form-group">
                <label>Nombre</label>
                <input type="text" 
                v-model.trim="$v.venta.nombre.$model" 
                :class="{ 'is-invalid': $v.venta.nombre.$error, 'is-valid': !$v.venta.nombre.$invalid }" 
                class="form-control" 
                placeholder="Nombre">
                <div class="invalid-feedback" v-if="!$v.venta.nombre.required" >Campo Requerido</div>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="form-group">
                <label>Apellido</label>
                <input type="text" 
                v-model.trim="$v.venta.apellido.$model" 
                :class="{ 'is-invalid': $v.venta.apellido.$error, 'is-valid': !$v.venta.apellido.$invalid }"
                class="form-control" 
                placeholder="Apellido" >
                <div class="invalid-feedback" v-if="!$v.venta.apellido.required" >Campo Requerido</div>
                </div>
            </div>
            </div>
            <div class="row">
            <div class="col-sm-5">
                <div class="form-group">
                <label>Fecha</label>
                <datepicker :use-utc="true" :language="es" v-model="venta.fecha" input-class="form-control"></datepicker>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="form-group">
                <label>Operador</label>
                <select
                    class="form-control"
                    v-model="venta.operador_id"
                >
                <option disabled value="">Operador</option>
                <option v-for="operador in operadores" v-bind:value="operador.id" :key="operador.id">
                    {{ operador.nombre }}
                </option>
                </select>
                </div>
            </div>
            </div> 
            <div class="row">
                <div class="col-sm-5">
                <div class="form-group">
                <label>Total:</label>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="form-group">
                <input type="text" v-model="venta.total" class="form-control" placeholder="0" disabled>
                </div>
            </div>
            </div>

            </div>
            <div class="col-md-7">
            <div class="card">
            <div class="car-body">
            <div class="row">
            <div class="col-sm-5">
                <div class="form-group">
                <label>Producto</label>
                <select
                    class="form-control"
                    :class="{ 'is-invalid': $v.producto.id.$error, 'is-valid': !$v.producto.id.$invalid }"
                    v-model="$v.producto.id.$model"
                >
                <option disabled value="">Productos</option>
                <option v-for="producto in productos" v-bind:value="{id:producto.id, nombre: producto.nombre, precio: producto.precio}" :key="producto.id">
                    {{ producto.nombre }}
                </option>
                </select>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                <label>Cantidad</label>
                <input type="number" 
                v-model="$v.producto.cantidad.$model" 
                class="form-control" 
                :class="{ 'is-invalid': $v.producto.cantidad.$error, 'is-valid': !$v.producto.cantidad.$invalid }"
                placeholder="0" >
                <div class="invalid-feedback" v-if="!$v.venta.apellido.minValue" >Campo numero positivo</div>
                </div>
                
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Agregar</label><br>
                <button type="button" class="btn btn-default" @click="agregarProducto()" :disabled="$v.producto.$invalid"><i class="fas fa-plus"></i></button>
                </div>
            </div>
            </div>
            <div class="row">
                <div class="col-sm-10">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cant</th>
                            <th>Sub</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(pVenta, index) in pVentas" :key="index">
                            <td>{{pVenta[0].nombre}}</td>
                            <td>{{pVenta[1]}}</td>
                            <td>{{pVenta[0].precio * pVenta[1]}}</td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
            </div>
            </div>
        </div>
       
        </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal" @click="limpiar">Cancelar</button>
              <button type="button" class="btn btn-primary" @click="crear()" :disabled="$v.$invalid">Registrar Venta</button>
            </div>
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
var moment = require('moment');
export default {
    components:{
        Datepicker
    },
    data(){
        return {
            en: en,
            es: es,
            ventas: [],
            productos: [],
            operadores: [],
            pVentas:[],
            producto: {
                id:'',
                producto_id: '',
                nombre: '',
                venta_id: '',
                cantidad: '',
                subtotal: '',
            },
            venta: {
                id: '',
                nombre: '',
                apellido: '',
                fecha: '',
                total: 0,
                user_id: '',
                operador_id: '',
                productos:[]
            },
            boton: 'crear',
        }
    },
    validations: {
        venta: {
            nombre: {required},
            apellido: {required},
            fecha: {required},

        },
        producto: {
            id: {required},
            cantidad: {required, minValue: minValue(1)}
        }
    },
    methods: {
        listar(){
            let me = this;
            axios.get('/api/venta')
            .then(function(response){
                me.ventas = response.data.data
                console.log(response.data)
            })
            .catch(function(error){
                console.log(error)
            })
        },
        crear(){
            let me = this;
            axios.post('/api/venta/',{
                'nombre': me.venta.nombre,
                'apellido': me.venta.apellido,
                'fecha': me.venta.fecha,
                'total': me.venta.total,
                'operador_id': me.venta.operador_id,
                'productos': me.venta.productos
            })
            .then(function(response){
                me.limpiar();
                me.listar();
            })
            .catch(function(error){
                console.log(error)
            })
        },
        actualizar(){
            let me = this;
            axios.put('/api/venta/'+ me.venta.id,{
                'nombre': me.venta.nombre,
                'apellido': me.venta.apellido,
                'fecha': me.venta.fecha,
                'operador_id': me.venta.operador_id,
                'total': me.venta.total,
                
                
            })
            .then(function(response){
                me.limpiar();
                me.listar();
            })
            .catch(function(error){
                console.log(error)
            })
        },
        editar(venta){
            this.venta.id = venta.id;
            this.venta.nombre = venta.nombre;
            this.venta.apellido = venta.apellido;
            this.venta.fecha = venta.fecha;
            this.venta.operador_id = venta.operador_id;
            this.venta.total = venta.total;
            
        },
        confirmar(venta){
            this.venta.id = venta.id;
            this.venta.nombre = venta.nombre;
            $('#confirmar').modal({backdrop: 'static', keyboard: false, show: true});
        },
        eliminar(id){
            let me = this;
            axios.delete('/api/venta/'+id)
            .then(function(response){
                $('#confirmar').modal('hide');
                me.limpiar();
                me.listar();
            })
            .catch(function(error){
                console.log(error)
            })
        },
        agregarProducto(){
            this.pVentas.push([this.producto.id,this.producto.cantidad, (this.producto.id.precio * this.producto.cantidad)]);
            this.venta.productos.push([this.producto.id.id,this.producto.cantidad, (this.producto.id.precio * this.producto.cantidad)] )
            this.venta.total = this.pVentas.reduce(function(sum, col){ return sum  + col[2] },0);
            console.log(this.pVentas)
            console.log(this.venta.productos)
        },
        limpiar(){
            this.venta.nombre = '';
            this.venta.apellido = '';
            this.venta.fecha = '';
            this.venta.total = '';
            this.venta.operador_id = '';
            this.producto.id = '';
            this.producto.cantidad = '',
            this.$v.venta.$reset();
            this.$v.producto.$reset();
        },
        getProductos(){
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
        }

    },

    mounted(){
        this.listar();
        this.getProductos();
        this.getOperadores();
        console.log('categorias')
        
    }
}
</script>
