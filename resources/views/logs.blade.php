
@extends('gitdeploy::index')

@section('content')

<br>

 
    


<table class="table">
  <thead>
    <tr>
      <th scope="col">Commit</th>
      <th scope="col">Fecha despliegue</th>
      <th scope="col">Usuario</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($deploys as $deploy)
      <tr>
        <td>{{$deploy->commit}}</td>
        <td>{{$deploy->created_at}}</td>
        <td>{{$deploy->user->name}}</td>
      </tr>            
    @endforeach
  </tbody>
</table>


       

   


@endsection          