<div class="col-md-4">
    <div style="margin-left: 40px">
    <img src="{{asset('/images/logo.png')}}" width="80">
    <h4>{{$ultimo->codigo}}</h4>
    </div>
    <strong>Cliente:</strong> {{$ultimo->nombre}} {{$ultimo->apellido}} <br>
    <strong>Servicio: </strong>{{$ultimo->servicios->nombre}} <br>
    <strong>Fecha: </strong> {{$ultimo->fecha}}/{{$ultimo->hora}} <br>
    <strong>Operador: </strong>{{$ultimo->operadores->nombre}}  <br>
       
</div>