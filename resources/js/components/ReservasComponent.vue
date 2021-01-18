<template>
<div class="container">
    <div v-for="prueba in pruebas" :key="prueba.id">
     {{calendarOptions.events}}
    </div>
    <FullCalendar :options="calendarOptions"  />

     <div class="modal fade" id="crear-modal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Registrar Reserva</h4>
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
                v-model.trim="$v.reserva.nombre.$model"
                :class="{ 'is-invalid': $v.reserva.nombre.$error, 'is-valid': !$v.reserva.nombre.$invalid }" 
                class="form-control" 
                placeholder="Nombre">
                <div class="invalid-feedback" v-if="!$v.reserva.nombre.required" >Campo Requerido</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Apellido</label>
                <input type="text" 
                v-model.trim="$v.reserva.apellido.$model" 
                class="form-control" 
                :class="{ 'is-invalid': $v.reserva.apellido.$error, 'is-valid': !$v.reserva.apellido.$invalid }"
                placeholder="Apellido" >
                <div class="invalid-feedback" v-if="!$v.reserva.apellido.required" >Campo Requerido</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Celular</label>
                <input type="text" 
                v-model="$v.reserva.celular.$model"
                :class="{ 'is-invalid': $v.reserva.celular.$error, 'is-valid': !$v.reserva.celular.$invalid }" 
                class="form-control" 
                placeholder="Celular" >
                <div class="invalid-feedback" v-if="!$v.reserva.celular.required" >Campo Requerido</div>
                <div class="invalid-feedback" v-if="!$v.reserva.celular.numeric" >Campo Numerico</div>
                </div>
            </div>
            </div>
            <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                <label>Fecha</label>
                <datepicker :use-utc="true" :language="es" v-model="reserva.fecha" input-class="form-control"></datepicker>
                </div>
            </div>
            <div class="col-sm-2.5">
                <div class="form-group">
                <label>Hora</label>
                <input type="time" 
                v-model="$v.reserva.hora.$model"
                :class="{ 'is-invalid': $v.reserva.hora.$error, 'is-valid': !$v.reserva.hora.$invalid }" 
                class="form-control">
                <div class="invalid-feedback" v-if="!$v.reserva.hora.required" >Campo Requerido</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Servicio</label>
                <select
                    class="form-control"
                    v-model="$v.reserva.servicio_id.$model"
                >
                <option disabled value="">Servicios</option>
                <option v-for="servicio in servicios" v-bind:value="servicio.id" :key="servicio.id">
                    {{ servicio.nombre }}
                </option>
                </select>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Detalle</label>
                <textarea v-model="reserva.detalle" class="form-control" placeholder="Detalle"> </textarea>
                </div>
            </div>
            
            </div>
        </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary" @click="crear()" :disabled="$v.$invalid">Guardar</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <div class="modal fade" id="editar-modal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Reserva</h4>
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
                v-model.trim="$v.reserva.nombre.$model" 
                class="form-control" 
                :class="{ 'is-invalid': $v.reserva.nombre.$error, 'is-valid': !$v.reserva.nombre.$invalid }"
                placeholder="Nombre">
                <div class="invalid-feedback" v-if="!$v.reserva.nombre.required" >Campo Requerido</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Apellido</label>
                <input type="text" 
                v-model.trim="$v.reserva.apellido.$model" 
                class="form-control"
                :class="{ 'is-invalid': $v.reserva.apellido.$error, 'is-valid': !$v.reserva.apellido.$invalid }" 
                placeholder="Apellido" >
                <div class="invalid-feedback" v-if="!$v.reserva.apellido.required" >Campo Requerido</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Celular</label>
                <input type="text" 
                v-model.trim="$v.reserva.celular.$model" 
                class="form-control" 
                :class="{ 'is-invalid': $v.reserva.celular.$error, 'is-valid': !$v.reserva.celular.$invalid }"
                placeholder="Celular" >
                <div class="invalid-feedback" v-if="!$v.reserva.celular.required" >Campo Requerido</div>
                <div class="invalid-feedback" v-if="!$v.reserva.celular.numeric" >Campo Numerico</div>
                </div>
            </div>
            </div>
            <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                <label>Fecha</label>
                <datepicker :use-utc="true" :language="es" v-model="reserva.fecha" input-class="form-control"></datepicker>
                </div>
            </div>
            <div class="col-sm-2.5">
                <div class="form-group">
                <label>Hora</label>
                <input type="time" 
                v-model="$v.reserva.hora.$model" 
                :class="{ 'is-invalid': $v.reserva.hora.$error, 'is-valid': !$v.reserva.hora.$invalid }"
                class="form-control">
                <div class="invalid-feedback" v-if="!$v.reserva.hora.required" >Campo Requerido</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Servicio</label>
                <select
                    class="form-control"
                    v-model="$v.reserva.servicio_id.$model"
                >
                <option disabled value="">Servicios</option>
                <option v-for="servicio in servicios" v-bind:value="servicio.id" :key="servicio.id">
                    {{ servicio.nombre }}
                </option>
                </select>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Detalle</label>
                <textarea v-model="reserva.detalle" class="form-control" placeholder="Detalle"> </textarea>
                </div>
            </div>
            
            </div>
        </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <div v-if="reserva.estado == 'pendiente' ">
              <button type="button" class="btn btn-success"  @click="modalConfirmar(reserva)" :disabled="$v.$invalid">Confirmar Reserva</button>
              <button type="button" class="btn btn-secondary" @click="actualizar(reserva)" :disabled="$v.$invalid">Guardar</button>
              <button type="button" class="btn btn-danger" @click="confirmar(reserva)"><i class="fa fa-trash"></i></button>
              </div>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
        <!-- /.modal-confirmarReserva -->
      <div class="modal fade" id="confirmarReserva-modal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Confirmar Reserva</h4>
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
                v-model.trim="$v.reserva.nombre.$model" 
                class="form-control"
                :class="{ 'is-invalid': $v.reserva.nombre.$error, 'is-valid': !$v.reserva.nombre.$invalid }" 
                placeholder="Nombre">
                <div class="invalid-feedback" v-if="!$v.reserva.nombre.required" >Campo Requerido</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Apellido</label>
                <input type="text" 
                v-model.trim="$v.reserva.apellido.$model" 
                :class="{ 'is-invalid': $v.reserva.apellido.$error, 'is-valid': !$v.reserva.apellido.$invalid }" 
                class="form-control" 
                placeholder="Apellido" >
                <div class="invalid-feedback" v-if="!$v.reserva.apellido.required" >Campo Requerido</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Celular</label>
                <input type="text" 
                v-model.trim="$v.reserva.celular.$model" 
                :class="{ 'is-invalid': $v.reserva.celular.$error, 'is-valid': !$v.reserva.celular.$invalid }"
                class="form-control" 
                placeholder="Celular" >
                <div class="invalid-feedback" v-if="!$v.reserva.celular.required" >Campo Requerido</div>
                <div class="invalid-feedback" v-if="!$v.reserva.celular.numeric" >Campo Numerico</div>
                </div>
            </div>
            </div>
            <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                <label>Fecha</label>
                <datepicker :use-utc="true" :language="es" v-model="reserva.fecha" input-class="form-control"></datepicker>
                </div>
            </div>
            <div class="col-sm-2.5">
                <div class="form-group">
                <label>Hora</label>
                <input type="time" 
                v-model="$v.reserva.hora.$model"
                :class="{ 'is-invalid': $v.reserva.hora.$error, 'is-valid': !$v.reserva.hora.$invalid }" 
                class="form-control">
                <div class="invalid-feedback" v-if="!$v.reserva.celular.required" >Campo Requerido</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Servicio</label>
                <select
                    class="form-control"
                    v-model="$v.reserva.servicio_id.$model"
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
                    v-model="$v.reserva.operador_id.$model"
                >
                <option disabled value="">Operador</option>
                <option v-for="operador in operadores" v-bind:value="operador.id" :key="operador.id">
                    {{ operador.nombre }}
                </option>
                </select>
                <div class="invalid-feedback" v-if="!$v.reserva.operador_id.required" >Campo Requerido</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                <label>Detalle</label>
                <textarea v-model="reserva.detalle" class="form-control" placeholder="Detalle"> </textarea>
                </div>
            </div>
            
            </div>
        </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal" @click="cerrar()">Cancelar</button>
              <button type="button" class="btn btn-primary" @click="confirmarReserva" :disabled="$v.$invalid">Guardar</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
        <!--modal-confirmar la eliminacion -->
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
              <p>Eliminar reserva del cliente: '{{reserva.nombre}}'?</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal" @click="limpiar">Cancelar</button>
              <button type="button" class="btn btn-primary" @click="eliminar(reserva.id)">Eliminar</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
</div>
</template>

<script>
import Vue from 'vue'
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
import { Calendar } from '@fullcalendar/core';
import esLocale from '@fullcalendar/core/locales/es';
import { formatDate } from '@fullcalendar/core';
import Datepicker from 'vuejs-datepicker';
import {en, es} from 'vuejs-datepicker/dist/locale';
import { required, numeric, minValue } from 'vuelidate/lib/validators'
export default {
  components: {
    FullCalendar,// make the <FullCalendar> tag available
    Datepicker
  },
  data() {
    return {
        en: en,
        es: es,
        reservas: [],
        servicios: [],
        pruebas: [],
        operadores: [],
        hasOperador: false,
        reserva: {
            id: '',
            nombre: '',
            apellido: '',
            celular: '',
            fecha: '',
            hora: '',
            detalle: '',
            estado: '',
            user_id: '',
            servicio_id: '',
            operador_id: '',
            estado: ''
        },
        calendarOptions: {
        plugins: [ dayGridPlugin, interactionPlugin, timeGridPlugin],
        initialView: 'timeGridWeek',
        locale: esLocale,
        selectable: true,
        timeZone: 'UTC-4',
        allDaySlot: false,
        slotDuration: '00:30:00',
        slotLabelInterval: '01:00',
        slotMinTime: '05:00:00',
        dateClick: this.handleDateClick,
        slotLabelFormat: {
            hour: 'numeric',
            minute: '2-digit',
            omitZeroMinute: false,
            meridiem: 'short'
            },
        headerToolbar:{
				left: 'dayGridMonth,timeGridWeek,timeGridDay',
                center: 'title',
                right: 'prevYear,prev,next,nextYear'
            },
        events: '',
        eventClick: this.eventClick
        
        
      }
    } 
  },
  validations(){
      if(!this.hasOperador){
          return{
            reserva: {
                nombre: {required},
                apellido: {required},
                celular: {required,numeric},
                hora: {required},
                servicio_id: {required},
                operador_id: {}
            }
            }
      }else{
           return{
            reserva: {
                nombre: {required},
                apellido: {required},
                celular: {required,numeric},
                hora: {required},
                servicio_id: {required},
                operador_id: {required}
            }
            }
      }
  },
  methods: {

      handleDateClick: function(arg, calendar) {
          this.limpiar();
        this.reserva.fecha = formatDate(arg.date, {
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric',         
                                })
        
        this.reserva.hora = formatDate(arg.date, {
                        hour: '2-digit',
                        minute: '2-digit',
                                //timeZoneName: 'short',
                                timeZone: 'UTC',
                                locale: 'es',
                                
                                }) 
        $('#crear-modal').modal({backdrop: 'static', keyboard: false, show: true});
        console.log(this.reserva.fecha)
    },
    eventClick(info,event) {
         console.log('Event: ' + info.event.extendedProps.celular);
         this.reserva.id = info.event.id;
         this.reserva.nombre = info.event.title;
         this.reserva.apellido = info.event.extendedProps.apellido;
         this.reserva.celular = info.event.extendedProps.celular;
         this.reserva.fecha = info.event.start;
         this.reserva.hora = info.event.extendedProps.hora;
         this.reserva.servicio_id = info.event.extendedProps.servicio_id;
         this.reserva.detalle = info.event.extendedProps.detalle;
         this.reserva.estado = info.event.extendedProps.estado;
         this.reserva.user_id = info.event.extendedProps.user_id;
         $('#editar-modal').modal({backdrop: 'static', keyboard: false, show: true});
         
         },
    listar(){
        let me = this;
        axios.get('/api/reserva')
        .then(function(response){
            //me.pruebas = response.data.data;
            me.calendarOptions.events = response.data.data.map(event =>{
                return {
                    title: event.title+' '+event.apellido,
                    start: event.start,
                    color: event.servicios.color,
                    id: event.id,
                    celular: event.celular,
                    servicio: event.servicios.nombre,
                    detalle: event.detalle,
                    apellido: event.apellido,
                    hora: event.hora,
                    servicio_id: event.servicio_id,
                    estado: event.estado
                }
            });
            console.log(response.data.data)
            
        })
        .catch(function(error){
            console.log(error);
        })
        },
        crear(){
            let me = this;
            axios.post('/api/reserva/',{
                'nombre': me.reserva.nombre,
                'apellido': me.reserva.apellido,
                'celular': me.reserva.celular,
                'fecha': me.reserva.fecha,
                'hora': me.reserva.hora,
                'detalle': me.reserva.detalle,
                'servicio_id': me.reserva.servicio_id,
                'user_id': me.reserva.user_id,
            })
            .then(function(response){
                me.limpiar();
                me.listar();
                $('#crear-modal').modal('hide');
                console.log(this.reserva)
            })
            .catch(function(error){
                console.log(error)
            })
        },
        limpiar(){
            this.reserva.nombre = '';
            this.reserva.apellido = '';
            this.reserva.fecha = '';
            this.reserva.celular = '';
            this.reserva.hora = '';
            this.reserva.detalle = '';
            this.reserva.servicio_id= '';
            this.reserva.operador_id= '';
            this.$v.reserva.$reset();
            this.hasOperador = false
        },
        listarServicios(){
        let me = this;
        axios.get('/api/servicio')
        .then(function(response){
            me.servicios = response.data.data
            console.log(response.data.data)
            
        })
        .catch(function(error){
            console.log(error);
        })
        },
        cerrar(){
            //this.reserva.celular = info.celular;
            $('#confirmarReserva-modal-modal').modal('hide');
            $('#editar-modal').modal('hide');
            this.limpiar();
        },
        actualizar(){
            let me = this;
            axios.put('/api/reserva/'+ me.reserva.id,{
                'nombre': me.reserva.nombre,
                'apellido': me.reserva.apellido,
                'celular': me.reserva.celular,
                'fecha': me.reserva.fecha,
                'hora': me.reserva.hora,
                'detalle': me.reserva.detalle,
                //'user_id': 
                'servicio_id': me.reserva.servicio_id,
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
        modalConfirmar(){
            $('#confirmarReserva-modal').modal({backdrop: 'static', keyboard: false, show: true});
            this.hasOperador = true;
        },
        confirmarReserva(){
            let me = this;
            axios.post('/api/trabajo/',{
                'nombre': me.reserva.nombre,
                'apellido': me.reserva.apellido,
                'celular': me.reserva.celular,
                'fecha': me.reserva.fecha,
                'hora': me.reserva.hora,
                'detalle': me.reserva.detalle,
                'servicio_id': me.reserva.servicio_id,
                'operador_id': me.reserva.operador_id,
            })
            .then(function(response){
                me.cambioEstado(me.reserva.id);
                $('#confirmarReserva-modal').modal('hide');
                $('#editar-modal').modal('hide');
                me.limpiar();
                me.listar();
            })
            .catch(function(error){
                console.log(error)
            })
        },
        cambioEstado($id){
            let me = this;
            axios.patch('/api/reserva/cambiar-estado/'+ $id,{
                'estado': 'confirmado'
            })
            .then(function(response){
                console.log('estado cambiado')
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
        confirmar(reserva){
            this.reserva.id = reserva.id;
            this.reserva.nombre = reserva.nombre;
            this.reserva.apellido = reserva.apellido;
            $('#confirmar').modal({backdrop: 'static', keyboard: false, show: true});
            $('#editar-modal').modal('hide');
        },
        eliminar(id){
            let me = this;
            axios.delete('/api/reserva/'+id)
            .then(function(response){
                $('#confirmar').modal('hide');
                me.limpiar();
                me.listar();
            })
            .catch(function(error){
                console.log(error)
            })
        },
        
        
    },    
    
    created() {
        this.listar();      
        this.eventos;
        this.listarServicios();
        this.getOperadores();
        
    
    }    

}

</script>
