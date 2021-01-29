<div class="col-md-4">
    <div style="margin-left: 40px">
    <img src="{{asset('/images/logo.png')}}" width="80">
    <h4>{{$ultimo->codigo}}</h4>
    </div>
    <strong align="center">{{$ultimo->servicios->nombre}}</strong> <br>
    <strong>Cliente:</strong> {{$ultimo->nombre}} {{$ultimo->apellido}} <br>
    <strong>Fecha: </strong> {{$ultimo->fecha}}/{{$ultimo->hora}} <br>
    <strong>Operador: </strong>{{$ultimo->operadores->nombre}}  <br>
       
</div>

<script>
window.addEventListener("load", window.print());
</script>