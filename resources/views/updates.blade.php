
@extends('gitdeploy::index')

@section('content')

<br>

  @if ( count($files) == 0)
  
    <div class="alert alert-success" role="alert">
      El proyecto esta actualizado a la ultima versión
    </div>

  @else 

    <div class="alert alert-danger" role="alert">
      Los siguientes ficheros estan pendientes de actualizar
    </div>
    
        
    <div id="listado">
      <ul class="list-group">
        @foreach ($files as $file)
            <li class="list-group-item d-flex justify-content-between align-items-start"><label>{{$file['path']}}</label>
              <span class="badge bg-{{$file['status']}} rounded-pill">{{$file['status']}}</span>
            </li>
        @endforeach


      </ul>
    </div>
    <br>
    
      <button id="btn-actualizar" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal">
        Actualizar ficheros
      </button>            

    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="updateModalLabel"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            ¿Estas seguro de actualizar la web con los ficheros del repositorio?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Actualizar</button>
          </div>
        </div>
      </div>
    </div>


   

  @endif  


@endsection          