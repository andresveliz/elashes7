<template>
<div>
    
    <div class="row">
    <div class="col-lg-3 col-6" v-for="operador in operadores" :key="operador.id">
        <!-- small card -->
        <div class="small-box bg-info">
            <div class="inner">
            <h3>{{pagoOperador(operador.id)[2]}} Bs</h3>
            <p>Codigos: {{filtroOperador(operador.id).length}} </p>
            <p>Pestanias: {{pagoOperador(operador.id)[0]}}</p>
            <p>Comision Extra: {{pagoOperador(operador.id)[1]}} </p>
            <p>Ventas: </p>           
            </div>
            <div class="icon">
            <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="#" class="small-box-footer">
                
            {{operador.nombre}} {{operador.apellido}} <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    </div>
</div>
</template>

<script>
import Vue from 'vue';

export default {
    data(){
        return {
            operadores: [],
            trabajos: [],
            suma_pestanias: 0,
            suma_total: 0,
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
            axios.get('http://127.0.0.1:8012/api/operador')
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
            axios.get('http://127.0.0.1:8012/api/trabajo')
            .then(function(response){
                me.trabajos = response.data.data
                console.log(response.data)
            })
            .catch(function(error){
                console.log(error)
            })
        },
        filtroOperador($id)
        {
           return this.trabajos.filter(trabajo => (trabajo.operador_id === $id) )
            
            //this.trabajos.filter((trabajo) )
        },
        pagoOperador($id)
        {
            let suma = 0
            let pestanias = 0
            let extra = 0
            let total = 0
            let valores = []
            this.filtroOperador($id).forEach(element => {
                
                    suma = suma + element.servicio.comision
                    if(element.servicio.categoria_servicio_id == 8)
                    {
                        pestanias++
                    }

                   
            });
            if(pestanias>4)
            {
                extra = ((pestanias * 30) * 0.10)
            }
            total = suma+extra
            valores.push(pestanias, extra, total)
            return valores;
            console.log(suma)
            // to do: metodo para pago extra codigos>5, metodo para extra en productos vendidos, 
        }
      
    },

    mounted(){
        this.listar();
        this.getTrabajos()
        console.log('categorias'+ this.categorias)
    }
}
</script>
