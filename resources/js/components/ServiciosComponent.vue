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
                <input type="text" v-model="servicio.nombre" class="form-control" placeholder="Nombre">
                </div>
            </div>
            <div class="col-sm-1">
                <div class="form-group">
                <label>Precio</label>
                <input type="text" v-model="servicio.precio" class="form-control" placeholder="Precio" >
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
                <input type="text" v-model="servicio.comision" class="form-control" placeholder="Comision" >
                </div>
            </div>
            <div class="col-sm-1">
                <div class="form-group">
                <label>Descuento</label>
                <input type="text" v-model="servicio.descuento" class="form-control" placeholder="Descuento" >
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                <label>Categoria</label>
                <select
                    class="form-control"
                    v-model="servicio.categoria_servicio_id"
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
                <button v-if="this.boton == 'crear'" type="button" class="btn btn-primary form-control" @click="crear()"><i class="fa fa-plus"></i> Agregar servicio</button>
                <button v-if="this.boton == 'editar'" type="button" class="btn btn-secondary  form-control" @click="actualizar()"><i class="fa fa-edit"></i> Guardar Cambios</button>
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
            <h3 class="card-title">servicios</h3>
        </div>
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
            <tr v-for="(servicio, index) in servicios" :key="servicio.id">
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

export default {
    data(){
        return {
            servicios: [],
            categorias: [],
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
    methods: {
        listar(){
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
        crear(){
            let me = this;
            axios.post('http://127.0.0.1:8012/api/servicio/',{
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
            })
            .catch(function(error){
                console.log(error)
            })
        },
        actualizar(){
            let me = this;
            axios.put('http://127.0.0.1:8012/api/servicio/'+ me.servicio.id,{
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
            axios.delete('http://127.0.0.1:8012/api/servicio/'+id)
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
            this.servicio.nombre = '';
            this.servicio.precio = '';
            this.servicio.descripcion = '';
            this.servicio.comision = '';
            this.servicio.descuento = '';
            this.servicio.categoria_servicio_id = '';
        },
        getCategorias(){
            let me = this;
            axios.get('http://127.0.0.1:8012/api/categoria-servicio')
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
        console.log('categorias')
    }
}
</script>
