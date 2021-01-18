<template>
<div>
    <div class="card card-warning">
        
        <!-- /.card-header -->
        <div class="card-body">
        <form role="form">
            <div class="row">
            <div class="col-sm-4">
                <!-- text input -->
                <div class="form-group">
                <label>Nombre</label>
                <input type="text" 
                v-model.trim="$v.operador.nombre.$model" 
                class="form-control" 
                :class="{ 'is-invalid': $v.operador.nombre.$error, 'is-valid': !$v.operador.nombre.$invalid }"
                placeholder="Nombre">
                <div class="invalid-feedback" v-if="!$v.operador.nombre.required" >Campo Requerido</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Apellido</label>
                <input type="text" 
                v-model.trim="$v.operador.apellido.$model" 
                class="form-control" 
                :class="{ 'is-invalid': $v.operador.apellido.$error, 'is-valid': !$v.operador.apellido.$invalid }"
                placeholder="Apellido" >
                <div class="invalid-feedback" v-if="!$v.operador.apellido.required" >Campo Requerido</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Celular</label>
                <input type="text" 
                v-model.trim="$v.operador.celular.$model" 
                class="form-control"
                :class="{ 'is-invalid': $v.operador.celular.$error, 'is-valid': !$v.operador.celular.$invalid }" 
                placeholder="Celular" >
                <div class="invalid-feedback" v-if="!$v.operador.celular.required" >Campo Requerido</div>
                <div class="invalid-feedback" v-if="!$v.operador.celular.numeric" >Campo numerico</div>
                </div>
            </div>
            </div>
            <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                <label>Cedula Identidad</label>
                <input type="text" 
                v-model="$v.operador.ci.$model" 
                class="form-control" 
                :class="{ 'is-invalid': $v.operador.ci.$error, 'is-valid': !$v.operador.ci.$invalid }"
                placeholder="Cedula Id.">
                <div class="invalid-feedback" v-if="!$v.operador.ci.required" >Campo Requerido</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Direccion</label>
                <input type="text" 
                v-model="operador.direccion" 
                class="form-control"
                :class="{ 'is-invalid': $v.operador.ci.$error, 'is-valid': !$v.operador.ci.$invalid }" 
                placeholder="Direccion">
                <div class="invalid-feedback" v-if="!$v.operador.direccion.required" >Campo Requerido</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label><i class="fa fa-arrow-down"></i></label>
                <div class="input-group-append">
                <button v-if="this.boton == 'crear'" type="button" class="btn btn-primary form-control" @click="crear()" :disabled="$v.$invalid"><i class="fa fa-plus"></i> Agregar operador</button>
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
            <h3 class="card-title">Operadores</h3>
        </div>
        <div class="card-body table-responsive p-0">
        <table class="table table-striped">
            <thead>
            <tr>
                <th style="width: 20px">#</th>
                <th>Nombre</th>
                <th>C.I.</th>
                <th>Celular</th>
                <th>Direccion</th>
                <th>Accion</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(operador, index) in operadores" :key="index">
                <td>{{index+1}}</td>
                <td>{{operador.nombre}} {{operador.apellido}}</td>
                <td>{{operador.ci}}</td>
                <td>{{operador.celular}}</td>
                <td>{{operador.direccion}}</td>
                <td>
                    <button type="button" class="btn btn-primary " @click="editar(operador)"><i class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-danger " @click="confirmar(operador)"><i class="fa fa-trash"></i></button>

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
              <p>Eliminar operador '{{operador.nombre}} {{operador.apellido}}'?</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal" @click="limpiar">Cancelar</button>
              <button type="button" class="btn btn-primary" @click="eliminar(operador.id)">Eliminar</button>
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
import { required, numeric, minValue } from 'vuelidate/lib/validators'
export default {
    data(){
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            operadores: [],
            operador: {
                id: '',
                nombre: '',
                apellido: '',
                ci: '',
                celular: '',
                direccion: ''
            },
            boton: 'crear',
        }
    },
    validations: {
        operador: {
            nombre: {required},
            apellido: {required},
            ci: {required},
            celular: {required, numeric},
            direccion: {required}
        }
    },
    methods: {
        listar(){
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
        crear(){
            let me = this;
            axios.post('/api/operador/',{
                'nombre': me.operador.nombre,
                'apellido': me.operador.apellido,
                'ci': me.operador.ci,
                'celular': me.operador.celular,
                'direccion': me.operador.direccion
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
            axios.put('/api/operador/'+ me.operador.id,{
                'nombre': me.operador.nombre,
                'apellido': me.operador.apellido,
                'ci': me.operador.ci,
                'celular': me.operador.celular,
                'direccion': me.operador.direccion,
                
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
        editar(operador){
            this.operador.id = operador.id;
            this.operador.nombre = operador.nombre;
            this.operador.apellido = operador.apellido;
            this.operador.ci = operador.ci;
            this.operador.celular = operador.celular;
            this.operador.direccion = operador.direccion;
            this.boton = 'editar';
        },
        confirmar(operador){
            this.operador.id = operador.id;
            this.operador.nombre = operador.nombre;
            this.operador.apellido = operador.apellido;
            $('#confirmar').modal({backdrop: 'static', keyboard: false, show: true});
        },
        eliminar(id){
            let me = this;
            axios.delete('/api/operador/'+id)
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
            this.operador.nombre = '';
            this.operador.apellido = '';
            this.operador.ci = '';
            this.operador.celular = '';
            this.operador.direccion = '';
            this.$v.operador.$reset();
        },
        getUser(){
            axios.get('/api/user')
            .then(response => {
            console.log(response.data);
            });
        },
        getTokens(){
            axios.get('/oauth/personal-access-tokens')
            .then(response => {
                console.log(response.data);
        });
        }
    },

    mounted(){
        console.log('token '+this.csrf)
        this.listar();
        this.getUser();
        this.getTokens();
        console.log('categorias'+ this.categorias)
    }
}
</script>
