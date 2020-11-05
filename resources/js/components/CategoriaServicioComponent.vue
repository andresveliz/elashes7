<template>
<div>
<div class="row">
    <div class="col-md-12 col-xl-12 col-lg-8">
        <small class="f-s-12 text-grey-darker">Agregar una nueva categoria</small>
        <div class="input-group">
            <input type="text" v-model="categoria.nombre" class="form-control" placeholder="Nombre">
            <select  :style="categoria.color !== '' ? { 'background-color': categoria.color, color: 'white'} : null" class="form-control" v-model="categoria.color">
                <option disabled value="">Seleccione un color</option>
                <option class="text-center bg-primary">#007bff</option>
                <option class="text-center bg-lightblue">#3c8dbc</option>
                <option class="text-center bg-navy">#001f3f</option>
                <option class="text-center bg-secondary">#6c757d</option>
                <option class="text-center bg-warning">#ffc107</option>
                <option class="text-center bg-pink">#e83e8c</option>
                <option class="text-center bg-success">#28a745</option>
                <option class="text-center bg-orange">#ff851b</option>
            </select>
            <div class="input-group-append">
                <button v-if="this.boton == 'crear'" type="button" class="btn btn-primary form-control" @click="crear()"><i class="fa fa-plus"></i> Agregar Categoria</button>
                <button v-if="this.boton == 'editar'" type="button" class="btn btn-secondary  form-control" @click="actualizar()"><i class="fa fa-edit"></i> Guardar Cambios</button>
                <button v-if="this.boton == 'editar'" type="button" class="btn btn-danger " @click="boton = 'crear'; categoria.nombre=''; categoria.color=''"><i class="fa fa-times"></i></button>
            </div>
        </div>
    </div>   
</div> <br>
    <div class="card">
        <!-- /.card-header -->
        <div class="card-header">
            <h3 class="card-title">Categorias</h3>
        </div>
        <div class="card-body table-responsive p-0">
        <table class="table table-striped">
            <thead>
            <tr>
                <th style="width: 20px">#</th>
                <th>Nombre</th>
                <th>Color</th>
                <th>Accion</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(categoria, index) in categorias" :key="index">
                <td>{{index+1}}</td>
                <td>{{categoria.nombre}}</td>
                <td>
                    <div class="color-palette-set">
                    <div  v-bind:style="{ 'background-color': categoria.color, color: 'white'}">{{categoria.color}}</div>
                    </div>
                </td>
                <td>
                    <button type="button" class="btn btn-primary " @click="editar(categoria)"><i class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-danger " @click="confirmar(categoria)"><i class="fa fa-trash"></i></button>

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
              <p>Eliminar la categoria '{{categoria.nombre}}'?</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary" @click="eliminar(categoria.id)">Eliminar</button>
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
            categorias: [],
            categoria: {
                id: '',
                nombre: '',
                color: ''
            },
            boton: 'crear',
            isClicked: false
        }
    },
    methods: {
        listar(){
            let me = this;
            axios.get('http://127.0.0.1:8012/api/categoria-servicio')
            .then(function(response){
                me.categorias = response.data.data
                console.log(response.data)
            })
            .catch(function(error){
                console.log(error)
            })
        },
        crear(){
            let me = this;
            axios.post('http://127.0.0.1:8012/api/categoria-servicio/',{
                'nombre': me.categoria.nombre,
                'color': me.categoria.color
            })
            .then(function(response){
                me.categoria.nombre = '';
                me.categoria.color = '';
                me.listar();
            })
            .catch(function(error){
                console.log(error)
            })
        },
        actualizar(){
            let me = this;
            axios.put('http://127.0.0.1:8012/api/categoria-servicio/'+ me.categoria.id,{
                'nombre': me.categoria.nombre,
                'color': me.categoria.color
            })
            .then(function(response){
                me.categoria.nombre = '';
                me.categoria.color = '';
                me.boton= 'crear'
                me.listar();
            })
            .catch(function(error){
                console.log(error)
            })
        },
        editar(categoria){
            this.categoria.id = categoria.id;
            this.categoria.nombre = categoria.nombre;
            this.categoria.color = categoria.color;
            this.boton = 'editar';
        },
        confirmar(categoria){
            this.categoria.id = categoria.id;
            this.categoria.nombre = categoria.nombre;
            $('#confirmar').modal({backdrop: 'static', keyboard: false, show: true});
        },
        eliminar(id){
            let me = this;
            axios.delete('http://127.0.0.1:8012/api/categoria-servicio/'+id)
            .then(function(response){
                $('#confirmar').modal('hide');
                me.categoria.nombre = '';
                me.categoria.color = '';
                me.listar();
            })
            .catch(function(eroor){
                console.log(error)
            })
        }
    },

    mounted(){
        this.listar();
        console.log('categorias'+ this.categorias)
    }
}
</script>
