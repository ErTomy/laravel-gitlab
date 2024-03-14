
@extends('gitdeploy::index')

@section('content')

<br>

    @if(Session::has('message'))
        <div class="alert alert-success">
            {{ Session::get('message') }}
        </div>
    @endif


<table class="table">
  <thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">Migracion</th>
      <th scope="col">Ejecución</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($migrations as $migration)
      <tr>
        <td>{{$migration->id}}</td>
        <td>{{$migration->migration}}</td>
        <td>{{$migration->batch}}</td>
      </tr>            
    @endforeach
  </tbody>
</table>
       

<button id="btn-migrate" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#migrateModal">
Ejecutar posibles migraciones
</button>            

<div class="modal fade" id="migrateModal" tabindex="-1" aria-labelledby="migrateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="migrateModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        Esto ejecutará las posibles migraciones que esten pendientes de ejecutar
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="document.getElementById('form-migrate').submit();">Ejecutar</button>
        </div>
    </div>
    </div>
</div>

<form action="{{route('gitdeploy.migrate.execute')}}" method="POST" id="form-migrate">
    @csrf            
</form>



@endsection          