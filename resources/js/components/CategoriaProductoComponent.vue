<template>
<div>
<div class="row">
    <div class="col-md-12 col-xl-12 col-lg-12">
        <small class="f-s-12 text-grey-darker">Agregar una nueva categoria</small>
        <div class="input-group">
            <input type="text" v-model="categoria.nombre" class="form-control col-xl-4" placeholder="Nombre">
            <input type="text" v-model="categoria.descripcion" class="form-control" placeholder="Descripcion">
            <div class="input-group-append">
                <button v-if="this.boton == 'crear'" type="button" class="btn btn-primary form-control" @click="crear()"><i class="fa fa-plus"></i> Agregar Categoria</button>
                <button v-if="this.boton == 'editar'" type="button" class="btn btn-secondary  form-control" @click="actualizar()"><i class="fa fa-edit"></i> Guardar Cambios</button>
                <button v-if="this.boton == 'editar'" type="button" class="btn btn-danger " @click="boton = 'crear'; categoria.nombre=''; categoria.descripcion=''"><i class="fa fa-times"></i></button>
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
                <td>{{categoria.descripcion}}</td>
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
                descripcion: ''
            },
            boton: 'crear',
        }
    },
    methods: {
        listar(){
            let me = this;
            axios.get('http://127.0.0.1:8012/api/categoria-producto')
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
            axios.post('http://127.0.0.1:8012/api/categoria-producto/',{
                'nombre': me.categoria.nombre,
                'descripcion': me.categoria.descripcion
            })
            .then(function(response){
                me.categoria.nombre = '';
                me.categoria.descripcion = '';
                me.listar();
            })
            .catch(function(error){
                console.log(error)
            })
        },
        actualizar(){
            let me = this;
            axios.put('http://127.0.0.1:8012/api/categoria-producto/'+ me.categoria.id,{
                'nombre': me.categoria.nombre,
                'descripcion': me.categoria.descripcion
            })
            .then(function(response){
                me.categoria.nombre = '';
                me.categoria.descripcion = '';
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
            this.categoria.descripcion = categoria.descripcion;
            this.boton = 'editar';
        },
        confirmar(categoria){
            this.categoria.id = categoria.id;
            this.categoria.nombre = categoria.nombre;
            $('#confirmar').modal({backdrop: 'static', keyboard: false, show: true});
        },
        eliminar(id){
            let me = this;
            axios.delete('http://127.0.0.1:8012/api/categoria-producto/'+id)
            .then(function(response){
                $('#confirmar').modal('hide');
                me.categoria.nombre = '';
                me.categoria.descripcion = '';
                me.listar();
            })
            .catch(function(error){
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
