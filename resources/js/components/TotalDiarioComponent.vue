<template>
<div>
    <div class="row">
    <div class="col-sm-2">
    <small class="f-s-12 text-grey-darker">Seleccione la fecha:</small>
    <datepicker  :language="es" :open-date="openDate" v-model="fecha" @selected="dia()" input-class="form-control bg-info"></datepicker>
    </div>
    <input type="button" onclick="print(toPrint)" value="print" />

    </div> <br>

    <div class="invoice p-3 mb-3" id="toPrint">
    <div class="row">
        <div class="col-12">
            <h4>
            <i class="fas fa-globe"></i> E-lashes Oruro.
            <small class="float-right">Reporte: {{fecha}}</small>
            </h4>
        </div>
    </div>    
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table table-striped" id="tabla">
                <thead>
                    <tr>
                        <th>Operador</th>
                        <th>Detalle</th>
                        <th>Comision</th>
                        <th>Total</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="operador in operadores" :key="operador.id">
                        <td width="50">{{operador.nombre}} {{operador.apellido}}</td>
                        <td>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Cod</th>
                                        <th>Trabajo</th>
                                        <th>Comision</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(codigo, index) in filtroOperador(operador.id)" :key="index">
                                        <td>{{codigo.codigo}}</td>
                                        <td>{{codigo.servicio.nombre}}</td>
                                        <td>{{codigo.servicio.comision}}</td>
                                        <td>{{codigo.servicio.precio - codigo.servicio.comision}}</td>

                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td class="codigo">{{pagoOperador(operador.id)[3]}}</td>
                        <td class="suma">{{pagoOperador(operador.id)[4]}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <p class="lead">Total Generado {{fecha}}</p>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th style="width:50%">Total Generado Codigos: </th>
                        <td>Bs.{{valores[0]}}</td>
                    </tr>
                    <tr>
                        <th>Total Comisiones: </th>
                        <td>Bs. {{valores[1]}}</td>
                    </tr>
                    <tr>
                        <th>Ventas: </th>
                        <td>Bs. {{valores[2]}}</td>
                    </tr>
                    <tr>
                        <th>Total:</th>
                        <td>Bs. {{valores[3]}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
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
            valores: [],
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
    computed:{
        
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
            
           this.$nextTick(()=> {this.getDiario(),this.getVentas()})
          // this.$nextTick(()=> {this.total()})
          this.valores = [];
           setTimeout(this.total,3000)
        
                  
        },
        getDiario()
        {
            let me = this;
            axios.get('/api/reporte/diario',{
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
            axios.get('/api/reporte/ventas',{
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
        total(){
            var bruto = 0;
            var comisiones = 0;
            //var valores = []
            var tventas = 0;
            var total;
            $(".suma").each(function(){
                bruto += parseFloat($(this).html())
            });
            
            $(".codigo").each(function(){
                comisiones += parseInt($(this).html()) || 0;
            });
            
            tventas= this.ventas.reduce((total, item)=>{
               return total + item.total;
            }, 0)
            total = ((bruto + tventas) - comisiones)
             this.valores.push(bruto, comisiones, tventas, total)
             
            //to do controlar las comisiones con setimeout
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
            let subtotal_caja = 0
            let total_caja = 0
            let tventas
            this.filtroOperador($id).forEach(element => {
                
                    suma = suma + element.servicio.comision
                    subtotal_caja = subtotal_caja + element.servicio.precio
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
            tventas = ((ventas) * 21)
            total = suma+extra+tventas
            //total_caja = subtotal_caja - total
            valores.push(pestanias, extra, ventas, total,subtotal_caja)
            return valores;
            console.log(valores)
            // to do: metodo para pago extra codigos>5, metodo para extra en productos vendidos, 
        },
        print(imp1)
        {
            var printContents = document.getElementById('.toPrint').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;

        }  
    },

    mounted(){
        this.listar();
        this.getVentas()
        this.getTrabajos()
        this.getDiario()
        setTimeout(this.total,3000);
        //this.total()
    }
}
</script>
