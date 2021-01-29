<template>
<div>
    <div class="row">
    <div class="col-sm-2">
    <small class="f-s-12 text-grey-darker">Seleccione la fecha:</small>
    <datepicker  :language="es" :open-date="openDate" v-model="fecha" @selected="dia()" input-class="form-control bg-info"></datepicker>
    </div>
    </div> <br>
    <div class="row">
    <div class="col-lg-3 col-6" v-for="operador in operadores" :key="operador.id">
        <!-- small card -->
        <div class="small-box bg-info">
            <div class="inner">
            <h3>{{pagoOperador(operador.id)[3]}} Bs</h3>
            <p>Codigos: {{filtroOperador(operador.id).length}} </p>
            <p>Pestanias: {{pagoOperador(operador.id)[0]}}</p>
            <p>Comision Extra: {{pagoOperador(operador.id)[1]}} </p>
            <p>Ventas: {{pagoOperador(operador.id)[2]}} </p>           
            </div>
            <div class="icon">
            <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="#" class="small-box-footer" @click="detalle(operador)">    
            {{operador.nombre}} {{operador.apellido}} <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    </div>

    <div class="modal fade" id="detalle">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Detalles {{operador.nombre}} {{operador.apellido}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body"> 
            <div class="row"> 
            
            <div class="col-md-12">
            <div class="card">
            <div class="car-body">
            
            <div class="row">
                <div class="col-sm-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Servicio</th>
                            <th>Comision</th>
                            <th>Cod</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(codigo, index) in filtroOperador(this.ope)" :key="index">
                            <td>{{index+1}}</td>
                            <td>{{codigo.nombre}} {{codigo.apellido}}</td>
                            <td>{{codigo.servicio.nombre}}</td>
                            <td>{{codigo.servicio.comision}}</td>
                            <td>{{codigo.codigo}}</td>
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
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
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
var moment = require('moment');

export default {
    components:{
        Datepicker
    },
    data(){
        return {
            en: en,
            es: es,
            operadores: [],
            trabajos: [],
            diario: [],
            ventas: [],
            ope: '',
            suma_pestanias: 0,
            suma_total: 0,
            fecha: moment().format("D MMM  YYYY"),
            openDate: new Date(),
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
        getTrabajos(){
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
        dia()
        {
           this.$nextTick(()=> {this.getDiario()})
           this.$nextTick(()=> {this.getVentas()})
                  
        },
        getDiario()
        {
            let me = this;
            axios.get('/api/reporte/diario/',{
                params: {
                'fecha': me.fecha
                }
            })
            .then(function(response){
                me.diario = response.data.data
                console.log(response.data)
                console.log(me.fecha)
            })
            .catch(function(error){
                console.log(error)
            })
        },
        getVentas()
        {
           let me = this;
            axios.get('/api/reporte/ventas/',{
                params: {
                'fecha': me.fecha
                }
            })
            .then(function(response){
                me.ventas = response.data.data
                console.log(response.data)
                console.log(me.fecha)
            })
            .catch(function(error){
                console.log(error)
            }) 
        },
        detalle(operador)
        {
            this.filtroOperador(operador.id);
            this.ope = operador.id;
            this.operador.nombre = operador.nombre;
            this.operador.apellido =operador.apellido;
            $('#detalle').modal({backdrop: 'static', keyboard: false, show: true});
        },
        filtroOperador($id)
        {
           return this.diario.filter(diario => (diario.operador_id === $id) )
            
            //this.trabajos.filter((trabajo) )
        },
        pagoOperador($id)
        {
            let suma = 0
            let pestanias = 0
            let sub_pestanias = 0
            let extra = 0
            let total = 0
            let ventas = 0
            let valores = []
            this.filtroOperador($id).forEach(element => {
                
                    suma = suma + element.servicio.comision
                    if(element.servicio.categoria_servicio_id == 1)
                    {
                        sub_pestanias = sub_pestanias + element.servicio.comision; 
                        if(element.servicio.descuento == 0){
                        pestanias++;
                        }
                    }
                   
            });
            this.ventas.forEach(element => {
                if(element.operador_id == $id)
                {
                ventas++
                }
            });
            if(pestanias>4)
            {
                extra = ((sub_pestanias) * 0.2)
            }
            
            total = suma+extra+(ventas * 21)
            valores.push(pestanias, extra, ventas, total)
            return valores;
            console.log(suma)
            // to do: metodo para pago extra codigos>5, metodo para extra en productos vendidos, 
        }
      
    },

    mounted(){
        this.listar();
        this.getTrabajos()
        this.getDiario()
        this.getVentas()
        console.log('categorias'+ this.categorias)
    }
}
</script>
