<template>
    <div class="col-md-4">
        <div style="margin-left: 40px">
        <img :src="('/images/logo.png')" width="80">
        <h4>{{trabajos.codigo}}</h4>
        </div>
        <ul class="list-inline">
        <li><strong>Cliente:</strong> {{trabajos.nombre}} {{trabajos.apellido}}</li>
        <li><strong>Servicio: </strong>{{trabajos.servicio.nombre}}</li>
        <li><strong>Fecha/hora: </strong> {{trabajos.fecha}}/{{trabajos.hora}}</li>   
        <li><strong>Operador: </strong> {{trabajos.operador.nombre}}</li> 
        </ul>  
         
    </div>
 
</template>

<script>
import Vue from 'vue';
export default {
    data(){
        return {
            trabajos: [],  
        }
    },
    
    methods: {
        listar(){
            let me = this;
            axios.get('api/trabajo')
            .then(function(response){
                me.trabajos = response.data.data[0]
                console.log(response.data)
            })
            .catch(function(error){
                console.log(error)
            })
        },
    },

    mounted(){
        this.listar();
        
    }
}
</script>
