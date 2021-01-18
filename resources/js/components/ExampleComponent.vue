<template>
<div>
    <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-calendar"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Reservas para hoy</span>
                <span class="info-box-number">
                  {{reservasHoy().length}}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-clipboard"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Codigos este mes</span>
                <span class="info-box-number">{{trabajos.length}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Ventas este mes</span>
                <span class="info-box-number">{{ventasMes().length}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-eye"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Pestanias este mes</span>
                <span class="info-box-number">{{pestaniasMes().length}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
    </div>

     <div class="row">
        <!-- Left col -->
        <section class="col-lg-7">
        <!-- Custom tabs (Charts with tabs)-->
        <div class="card">
            <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-chart-pie mr-1"></i>
                Servicios mas requeridossss
            </h3>
            </div><!-- /.card-header -->
            <div class="card-body">
            <div class="tab-content p-0">
                <!-- Morris chart - Sales -->
                <canvas id="myChart"></canvas> 
            </div>
            </div><!-- /.card-body -->
        </div>
        </section>

        <section class="col-lg-5">
        <!-- Custom tabs (Charts with tabs)-->
        <div class="card">
            <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-tag mr-1"></i>
                Precio de los Servicios 
            </h3>
            </div><!-- /.card-header -->
            <div class="card-body">
            <div class="card-body table-responsive p-0">
        <table class="table table-striped">
            <thead>
            <tr>
                <th style="width: 20px">#</th>
                <th>Nombre</th>
                <th>Precio</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(servicio, index) in servicios" :key="servicio.id">
                <td>{{index+1}}</td>
                <td>{{servicio.nombre}}</td>
                <td>{{servicio.precio}} Bs</td>                
            </tr>
            </tbody>
        </table>
        </div>
            </div><!-- /.card-body -->
        </div>
        </section>
    </div>
</div>
    
</template>

<script>
import Chart from 'chart.js';
var moment = require('moment');
   

export default {
    data(){
        return{
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            trabajos: [],
            servicios: [],
            reservas: [],
            ventas: [],
            contadores: [],
            cantidades: [],
            repetidos: [],
        }
    },

    methods:{
        createChart(chartId) {
        const ctx = document.getElementById(chartId);
        const myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: this.repetidos.map(item => item.nombre),
            datasets: [
                {
                label: 'Codigos',
                data: this.repetidos.map(item => item.cant),
                backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
                }
            ]
        }
        });
        console.log(myChart.data)
        },
        listar(){
            let me = this;
            axios.get('/api/reporte/codigos')
            .then(function(response){
                me.trabajos = response.data.data
                console.log(response.data)
            })
            .catch(function(error){
                console.log(error)
            })
        },
        getServicios(){
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
        getReservas(){
            let me = this;
            axios.get('/api/reserva')
            .then(function(response){
                me.reservas = response.data.data
                console.log(response.data)
            })
            .catch(function(error){
                console.log(error)
            })
        },
        getVentas(){
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
        sumatorias(){
            let suma = 0
            
            this.trabajos.forEach(element => {
                this.cantidades.push(element.servicio_id)
                this.repetidos.push({id: element.servicio_id, nombre: element.servicio.nombre, cantidad: 0})

            })
            let set = new Set( this.repetidos.map(JSON.stringify))
            this.repetidos = Array.from(set).map(JSON.parse)
            //this.dobles = Array.from(new Set(this.trabajos))
            //this.dobles =   this.repetidos.filter((el, index)=> this.repetidos.indexOf(el) === index)
            //this.repetidos.nombre =     this.nombres.filter((el,index)=> this.nombres.indexOf(el) === index)
            
            
        },
        sumas(){           
            var cantidad = []
            let sum =0
            this.cantidades.forEach(function(numero){
                cantidad[numero] = (cantidad[numero] || 0) +1;
            });
            for(const property in cantidad){
                this.cantidades.push(parseInt(property,10))
            for(let i=0; i< this.repetidos.length;i++){
                if(this.repetidos[i].id === parseInt(property,10))
                {
                    sum++
                   this.repetidos[i].cant = cantidad[property]
                }
            }
            }
            console.log(sum)
            
            for(const property in cantidad){
                //this.cantidades.push(cantidad[property]);
                
            }
            
            console.log(cantidad)
        },
        reservasHoy(){
            var fecha = moment();
           return this.reservas.filter(reserva => reserva.fecha === fecha.format('YYYY-MM-DD'))
        },
        pestaniasMes(){
            var fecha = moment();
            return this.trabajos.filter(trabajo => trabajo.servicio.categoria_servicio_id === 7)
        },
        ventasMes(){
            var fecha = moment();
            return this.ventas.filter(venta => venta.mes === fecha.format('YYYY-MM'))
        }

    },
    mounted() {
        
        this.listar();
        this.getServicios();
        this.getReservas();
        this.getVentas();
        setTimeout(() => {
                  this.sumatorias()
                },1500)
        setTimeout(() => {
                  this.sumas()
                },1800)
        
        setTimeout(() => {
                  this.createChart('myChart');
                },2000)
    }
}
</script>
