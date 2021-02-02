<div class="col-4">
    <div style="margin-left: 100px; margin-top: -3%; margin-bottom: -3%">
    <img src="{{asset('/images/logo.png')}}" width="100">
    <h3 style="margin-top: -3%"> {{$ultimo->codigo}}</h3>
    </div>
    <strong align="center">{{$ultimo->servicios->nombre}}</strong> <br>
    <strong>Cliente:</strong> {{$ultimo->nombre}} {{$ultimo->apellido}} <br>
    <strong>Fecha: </strong> {{$ultimo->fecha}}/{{$ultimo->hora}} <br>
    <strong>Operador: </strong>{{$ultimo->operadores->nombre}}  <br>
       
</div>

<script>
window.addEventListener("load", window.print());
</script>